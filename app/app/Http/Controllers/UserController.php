<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request, UserRepository $repository)
    {
        $query = $repository->applySearch(User::query(), $request->search);

        return Inertia::render('Admin/Users/Users', [
            'users' => UserResource::collection($query->paginate(10)),
            'search' => $request->search ?? '',
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(UserStoreRequest $request, UserRepository $repository)
    {
        $repository->store($request->validated());
        return Redirect::route('users.list');
    }
}
