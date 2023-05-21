<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        // Retrieve all users from the repository
        $users = $this->userRepository->getAll();

        // Return the response
        return response()->json($users);
    }

    public function show($id)
    {
        // Retrieve a specific user by ID from the repository
        $user = $this->userRepository->getById($id);

        if (!$user) {
            // Return a not found response if the user doesn't exist
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return the response
        return response()->json($user);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // Create a new user using the repository
        $user = $this->userRepository->create($validatedData);

        // Return the response
        return response()->json($user, 201);
    }

    // Other controller methods for update, delete, etc.
}
