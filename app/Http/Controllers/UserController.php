<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponser;

Class UserController extends Controller {

    use ApiResponser;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }

    public function add(Request $request){ //ADD USER
        
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return response()->json($user, 200);
    }
    
    public function updateUser(Request $request, $id) { //UPDATE USER
        $rules = [
            'username' => 'required | max:20',
            'password' => 'required | max:20'
        ];
    
        $this->validate($request, $rules);
    
        $user = User::findOrFail($id);
    
        $user->fill($request->all());
    
        if ($user->isClean()) {
            return response()->json("At least one value must
            change", 403);
        } else {
            $user->save();
            return response()->json($user, 200);
        }
    }

    public function deleteUser($id) { // DELETE USER
        $user = User::findOrFail($id);
    
        $user->delete();
    
        return response()->json($user, 200);
    }

    public function show($id){
 
    $user = User::where('id', $id)->first();
    if($user){
        return $this->successResponse($user);
    }
    {
        return response()->json('User ID Does Not Exists');
    }
    
    }

    
}


