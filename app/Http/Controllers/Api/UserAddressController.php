<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserAddressRequest;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\JsonResponse;

class UserAddressController extends Controller
{
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

    public function update(UserAddressRequest $request, UserAddress $userAddress): JsonResponse
    {
        if ($request->filled('default_address')) {
            $defaultAddress = UserAddress::query()->where('default_address', true)
                ->whereNot('id', $userAddress->id)
                ->first();

            if ($defaultAddress) {
                $defaultAddress->default_address = false;
                $defaultAddress->save();
            }
        }

        $userAddress->update($request->validated());

        return response()->json([
            'message' => __('messages.user_address.updated'),
        ]);
    }

    public function destroy(UserAddress $userAddress): JsonResponse
    {
        if ($userAddress->default_address) {
            return response()->json([
                'message' => __('errors.user_address.default_address')
            ]);
        }

        if ($userAddress->delete()) {
            return response()->json([
                'message' => __('messages.user_address.deleted')
            ]);
        }

        return  response()->json([
            'message' => 'Some errors occurred when trying to perform this action. Try again later.'
        ]);
    }

}