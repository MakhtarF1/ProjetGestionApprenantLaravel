<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
     

        if (!$this->canCreateUser($user->role, $data['role'])) {
        
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result = $this->userService->createUser($data);
        return response()->json($result, 201);
    }

    public function storeMany(Request $request)
    {
        $data = $request->validate([
            'users' => 'required|array',
            'users.*.role' => 'required|string',
        ]);

        $user = Auth::user();

        foreach ($data['users'] as $userData) {
            if (!$this->canCreateUser($user->role, $userData['role'])) {
                Log::info('Unauthorized access attempt', [
                    'role' => $userData['role'],
                    'user_role' => $user->role
                ]);
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $result = $this->userService->createManyUsers($data['users']);
        return response()->json($result, 201);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $user = Auth::user();

        if (!$this->canUpdateUser($user->role)) {
            Log::info('Unauthorized access attempt to update', [
                'role' => $data['role'],
                'user_role' => $user->role
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $result = $this->userService->updateUser($id, $data);
        return response()->json($result);
    }

    public function export(Request $request)
    {
        $format = $request->input('format', 'excel');
        $role = $request->input('role');

        return $this->userService->exportUsers($format, $role);
    }

    private function canCreateUser($userRole, $requestedRole)
    {
        if ($userRole === 'admin') {
            return in_array($requestedRole, ['admin', 'coach', 'manager', 'cem']);
        }

        if ($userRole === 'manager') {
            return in_array($requestedRole, ['coach', 'manager', 'cem']);
        }

        if ($userRole === 'cem') {
            return $requestedRole === 'apprenant';
        }

        return false;
    }

    private function canUpdateUser($userRole)
    {
        return in_array($userRole, ['admin', 'manager']);
    }
}
