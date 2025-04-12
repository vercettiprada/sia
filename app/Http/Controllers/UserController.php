<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use App\Models\User;
use App\Traits\ApiResponser; // Use to standardize our code for API response
use Illuminate\Http\Request; // Handling HTTP requests in Lumen
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash; // <-- Import Hash facade

class UserController extends Controller
{
    use ApiResponser;

    // Constructor removed - Request injected directly into methods

    /**
     * Return the list of users.
     * Consider pagination for large datasets: User::paginate()
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all(); // Or User::paginate(15);
        return $this->successResponse($users);
    }

    /**
     * Create a new user record. (Renamed from add to store)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) // Renamed, Request injected here
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20', // Consider adding complexity rules (min length etc.)
            'gender'   => 'required|in:Male,Female',
            'jobid'    => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rules);

        // Validate related UserJob exists
        UserJob::findOrFail($request->jobid);

        // Prepare data, ensuring password is hashed
        $data = $request->all();
        $data['password'] = Hash::make($request->input('password')); // <-- Hash the password

        $user = User::create($data);

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Obtain and show one user by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // Handles not found via Handler
        return $this->successResponse($user);
    }

    /**
     * Update an existing user record.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) // Request injected here
    {
        $rules = [
            'username' => 'sometimes|max:20', // 'sometimes' means validate only if present
            'password' => 'sometimes|max:20', // Add complexity rules if needed
            'gender'   => 'sometimes|in:Male,Female',
            'jobid'    => 'sometimes|required|numeric|min:1|not_in:0', // Fixed formatting, ensure logic is correct
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($id); // Find user or fail (404)

        // Validate related UserJob exists IF jobid is being updated
        if ($request->has('jobid')) {
            UserJob::findOrFail($request->jobid);
        }

        // Prepare data for update, hashing password if provided
        $updateData = $request->all();
        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->input('password')); // <-- Hash password if updating
        }

        $user->fill($updateData);

        // Check if anything actually changed
        if ($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->successResponse($user);
    }


    /**
     * Remove an existing user.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $user = User::findOrFail($id); // Find user or fail (404)
        $user->delete();

        // You can return just a 204 No Content, or a confirmation message with 200 OK
        // return $this->successResponse(null, Response::HTTP_NO_CONTENT);
        return $this->successResponse('User successfully deleted', Response::HTTP_OK);
    }
}