<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthCOntroller extends Controller
{
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function register(RegisterRequest $request){

    }
}
