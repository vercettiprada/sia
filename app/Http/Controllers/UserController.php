<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser;
use DB;

class UserController extends Controller
{
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUsers()
    {
        $users = \Illuminate\Support\Facades\DB::connection('mysql')->select("SELECT * FROM tbl_user");
        return $this->successResponse($users);
    }

    public function index()
    {
        $users = User::all();
        return $this->successResponse($users);
    }

    public function add(Request $request)
    {
        $rules = [
            'username' => 'required|max:20',
                'password' => 'required|max:20',
                    'gender' => 'required|in:Male,Female',
                        'jobid' => 'required|numeric|min:1|not_in:0',

        ];

        $this->validate($request, $rules);

        
        
        $userjob = UserJob::findOrFail($request->jobid);
        $user = User::create($request->all());
                


        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function show($id)
    {
    $user = User::findOrFail($id);
    return $this->successResponse($user); 
           /*
            $user = User::where('id', $id)->first();

               if ($user) {
                return $this->successResponse($user);
            } else {
        return $this->errorResponse('User Id Does Not Exist', Response::HTTP_NOT_FOUND);
        }
        */
    }
    public function delete($id)
    {
        // Attempt to find the user by ID.
        $user = User::findOrFail($id);
        
        // Delete the user.
        $user->delete();

        // Return success message after deletion.
        return $this->successResponse('User successfully deleted', Response::HTTP_OK);
    

    }
    
        public function update(Request $request,$id){
        $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        'gender' => 'in:Male,Female',
        'jobid' => 'required|numeric|min:1|
       not_in:0',
        ];
        $this->validate($request, $rules);


        // validate if Jobid is found in the table tbluserjob
        $userjob = UserJob::findOrFail($request->jobid);
        $user = User::findOrFail($id);
       
        $user->fill($request->all());


        // if no changes happen
        if ($user->isClean()) {

        return $this->errorResponse('At least one value must change',Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        
        $user->save();
        return $this->successResponse($user);
       
        }
}