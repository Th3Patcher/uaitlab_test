<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Users', [
            'users' => UserResource::collection(
                User::first()->paginate(10)
            ),
        ]);
    }

    public function create()
    {
        return Inertia::render('Users');
    }
}
