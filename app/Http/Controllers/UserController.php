<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;

    private $users = [];

    public function __construct()
    {
        // Initialize with some predefined users
        $this->users = [
            new User(['username' => 'bershka', 'password' => Hash::make('password123')]),
            new User(['username' => 'anotheruser', 'password' => Hash::make('anotherpassword')]),
        ];
    }

    public function index()
    {
        return $this->successResponse($this->users);
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender'   => 'required|in:Male,Female',
            'jobid'    => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = Hash::make($request->input('password'));

        $user = new User($data);
        $this->users[] = $user;

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show($username)
    {
        foreach ($this->users as $user) {
            if ($user->username === $username) {
                return $this->successResponse($user);
            }
        }

        return $this->errorResponse('User not found', Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $username)
    {
        $rules = [
            'username' => 'sometimes|max:20',
            'password' => 'sometimes|max:20',
            'gender'   => 'sometimes|in:Male,Female',
            'jobid'    => 'sometimes|required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rules);

        foreach ($this->users as $user) {
            if ($user->username === $username) {
                $updateData = $request->all();
                if ($request->has('password')) {
                    $updateData['password'] = Hash::make($request->input('password'));
                }

                $user->fill($updateData);

                return $this->successResponse($user);
            }
        }

        return $this->errorResponse('User not found', Response::HTTP_NOT_FOUND);
    }

    public function delete($username)
    {
        foreach ($this->users as $key => $user) {
            if ($user->username === $username) {
                unset($this->users[$key]);
                return $this->successResponse('User successfully deleted', Response::HTTP_OK);
            }
        }

        return $this->errorResponse('User not found', Response::HTTP_NOT_FOUND);
    }
}