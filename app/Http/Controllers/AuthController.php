<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;
        $user->token = $token;

        $resource = new UserResource($user);
        return $resource->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->user->where('email', $request->email)->first();

        if (!$user) return response(['error' => 'e-mail informado nao esta cadastrado']);

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth-token')->plainTextToken;
            $user->token = $token;

            $resource = new UserResource($user);

            return $resource->response()->setStatusCode(200);
        }

        return response(['error'=>'senha informada esta incorreta']);
    }

    public function validateToken(Request $request) {
        if($token = $request->bearerToken()){
            $user = auth('sanctum')->user();
            $user->token = $token;

            return new UserResource($user);
        }
    }

    public function logout() {
        $user = Auth()->user;
        $user->tokens()->delete();

        return response(['message'=>'logout realizado com sucesso'], 200);
    }

    public function destroy(DeleteRequest $request) {
        $user = $this->user->find($request->id);

        if(!$user) return response(['error' => 'usuario nao existe'], 404);

        $user->tokens()->delete();

        $userDeleted = $user->delete();

        if($userDeleted > 0) return response(['message' => 'usuario excluído com sucesso'], 200);

        return response(['error' => 'usuario nao excluído'], 403);
    }
}
