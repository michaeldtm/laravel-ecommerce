<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserAddressRequest;
use App\Http\Resources\User\UserAddressResource;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserAddressController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $addresses = UserAddress::forUser(request()->user())->get();

        return UserAddressResource::collection($addresses);
    }

    public function store(UserAddressRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $isDefaultAddress = $user->hasDefaultAddress();

        $user->addresses()->saveMany([
            new UserAddress([...$request->validated(), 'default_address' => !$isDefaultAddress])
        ]);

        return response()->json([
            'message' => __('messages.user_address.created'),
        ]);
    }

    public function show(UserAddress $address): UserAddressResource
    {
        return UserAddressResource::make($address);
    }

    public function update(UserAddressRequest $request, UserAddress $address): JsonResponse
    {
        if ($request->filled('default_address')) {
            $defaultAddress = UserAddress::query()->where('default_address', true)
                ->whereNot('id', $address->id)
                ->first();

            if ($defaultAddress) {
                $defaultAddress->default_address = false;
                $defaultAddress->save();
            }
        }

        $address->update($request->validated());

        return response()->json([
            'message' => __('messages.user_address.updated'),
        ]);
    }

    public function destroy(UserAddress $address): JsonResponse
    {
        if ($address->default_address) {
            return response()->json([
                'message' => __('errors.user_address.default_address')
            ]);
        }

        if ($address->delete()) {
            return response()->json([
                'message' => __('messages.user_address.deleted')
            ]);
        }

        return  response()->json([
            'message' => __('errors.occurred')
        ]);
    }
}
