<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $role = $request->input('role'); // Filter by role if provided
        $users = $this->userService->getAllUsers($role);
        return response()->json($users);
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        
        // Check for admin role
        if (Auth::user()->role !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result = $this->userService->createUser($data);
        return response()->json($result, 201);
    }

    public function show($id)
    {
        $user = $this->userService->findUser($id);
        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();

        // Check if the user has permission to update
        if (!in_array(Auth::user()->role, ['Admin', 'Manager'])) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result = $this->userService->updateUser($id, $data);
        return response()->json($result);
    }

    public function destroy($id)
    {
        // Check for admin role
        if (Auth::user()->role !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result = $this->userService->deleteUser($id);
        return response()->json($result);
    }
}
