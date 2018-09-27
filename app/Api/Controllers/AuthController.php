<?php

namespace App\Api\Controllers;

use Exception;
use App\Api\Models\User;
use App\Api\Traits\Restriction;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class AuthController extends Controller
{
    use Helpers, Restriction;

    public function __construct()
    {
        $this->restrict(['logout', 'refresh', 'me']);
    }

    /**
     * Log the user in with the given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!User::canLogin($credentials['email'])->first()) {
            return abort(403, 'User is not activated or confirmed');
        }

        if (!$token = auth()->attempt($credentials, true)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response(null, 204);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function identity()
    {
        try {
            $id = auth()->user()->id;
            return User::findOrFail($id)->with('roles')->first();
        } catch (Exception $e) {
            return abort(403, 'Forbidden');
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'type' => 'bearer',
            'token' => $token,
            'expires' => auth()->factory()->getTTL() * 60
        ]);
    }
}
