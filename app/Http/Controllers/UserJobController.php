<?php

namespace App\Http\Controllers;

use App\Models\UserJob;  // Your Eloquent Model

use Illuminate\Http\Response; // Standard Response Handling
use App\Traits\ApiResponser;  // Standardized API Responses
use Illuminate\Http\Request;  // Handles HTTP Requests

class UserJobController extends Controller {

    use ApiResponser;

    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

            /**
             * Return the list of user jobs
             * @return \Illuminate\Http\Response
             */
    public function index()
    {
        $usersjob = UserJob::all();
        return $this->successResponse($usersjob);
    }

            /**
             * Obtain and show one user job
             * @param int $id
             * @return \Illuminate\Http\Response
             */
    public function show($id)
    {
        $usersjob = UserJob::findOrFail($id);
        return $this->successResponse($usersjob);   
    }
}
