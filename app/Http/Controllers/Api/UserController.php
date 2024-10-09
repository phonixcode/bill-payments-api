<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;
use App\Traits\HandlesTransactions;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    use ApiResponseTrait, HandlesTransactions;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        return $this->handleTransaction(function () use ($request) {
            $user = $this->userService->createUser($request->validated());
            return $this->successResponse(new UserResource($user), 'User created successfully', 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->successResponse(new UserResource($user), 'User retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        return $this->handleTransaction(function () use ($request, $user) {
            $updatedUser = $this->userService->updateUser($user, $request->validated());
            return $this->successResponse(new UserResource($updatedUser), 'User updated successfully');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return $this->handleTransaction(function () use ($user) {
            $this->userService->deleteUser($user);
            return $this->successResponse(null, 'User deleted successfully', 204);
        });
    }
}
