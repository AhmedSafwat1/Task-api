<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }
    public function getUsers(Request $request)
    {

        return response()->json(["status"=>"success", "data"=>$this->repo->getUsers($request)]);
    }
}
