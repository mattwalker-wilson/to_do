<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('toDoLists')
        ->get();
        return response()->json($users);
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        try {
            $user->save();
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'User registeration failed',
                'error' => $e->getMessage()
            ], 500);      
        }
        return response()->json(['message' => 'Something went wrong with User registration.' ], 500);        
    }

    /**
     * Display the specified resource.
     *  
     * @param  \App\Models\User  $user 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id != $user->id) {
            // If the authenticated user is not the user being accessed, return an unauthorized error
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        // return response()->json($user->with('toDoLists')->find($user->id));
        // use more effcient "lazy eager loading" instead of "eager loading"
        return response()->json($user->load('toDoLists'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');
    
        if (!$token = auth()->claims(['role' => 'user'])->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'=> 'sometimes|max:40',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:8|confirmed',
        ]);

        if ($request->has('password')) {
            // Check if the new password is different from the current one
            if (Hash::check($request->password, $user->password)) {
                return response()->json(['error' => 'New password must be different from the current one'], 400);
            }
    
            // Hash and set the new password
            $user->password = Hash::make($request->password);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }
    
        if ($request->has('email')) {
            $user->email = $request->email;
        }

        try {
            $user->save();
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'User update failed',
                'error' => $e->getMessage()
            ], 500);      
        }
        return response()->json(['message' => 'Something went wrong with User update.' ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return response()->json([
                    'message' => 'User deleted successfully',
                ], 204);
            } catch (Exception $e) {
                return response()->json([
                    'message' => 'User deletion failed',
                    'error' => $e->getMessage()
                ], 500);      
            }
            return response()->json(['message' => 'Something went wrong with User deletion.' ], 500);
    }
}
