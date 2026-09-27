<?php

namespace App\Http\Controllers;

use App\Http\Resources\LicenseResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    public function licenses(User $user): AnonymousResourceCollection
    {
        $licenses = $user->licenses()->with('product')->get();

        return LicenseResource::collection($licenses);
    }
}
