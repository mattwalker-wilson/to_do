<?php

namespace App\Http\Controllers;

use \Exception;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $users = User::with('toDoLists')
        ->where('id', $user->id)
        ->get();
        return response()->json($users);
    }

    public function register(UserRequest $request): JsonResponse
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

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


    public function registerWeb(UserRequest $request): RedirectResponse
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            $user->save();
            Auth::login($user);
            return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
        } catch (Exception $e) {
            return back()->withErrors([
                'error' => 'User registration failed: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
//        $authUser = Auth::user();
        $authUser = User::findOrFail(4);

        if ($authUser->id != $user->id) {
            // If the authenticated user is not the user being accessed, return an unauthorized error
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // return response()->json($user->with('toDoLists')->find($user->id));
        // use more effcient "lazy eager loading" instead of "eager loading"
        return response()->json($user->load('toDoLists'));
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        Log::info($request->email . ' is trying to login');
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
            Log::error('Unauthorized login attempt for email: ' . $request->email);
        }


        return $this->respondWithToken($token);
    }

    public function loginWeb(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/lists'); // Adjust to your desired route
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.'
        ])->withInput();
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
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


    public function destroy(User $user): JsonResponse
    {
            try {
                // $user = User::findOrFail($id);
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


     /**
     * Delete the token which logs out the current user
     *
     * @return JsonResponse
      */
    public function logout(): JsonResponse
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function logoutWeb(): RedirectResponse
    {
        Auth::logout();
        return redirect()->intended('/');
    }

}
