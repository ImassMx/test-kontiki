<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->only('name','email','password'));

        $token = $user->createToken('token')->accessToken;

        return response()->json([ 'user' => $user, 'access_token' => $token])->setStatusCode(Response::HTTP_CREATED);
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Incorrect Credentials.
            Please try again'])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        $token = auth()->user()->createToken('token')->accessToken;

        return response()->json(['user' => auth()->user(), 'access_token' => $token])->setStatusCode(Response::HTTP_OK);

    }
}
