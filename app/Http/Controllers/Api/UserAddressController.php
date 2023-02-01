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

}
