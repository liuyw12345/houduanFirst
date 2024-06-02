<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DemoModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class DemoController extends Controller
{
    public function register(Request $request)
    {
        $credentials = [
            'name' => $request->name,
            'password' => $request->password
        ];

        $dm = DemoModel::create($credentials);
        if ($dm) {
            // 生成 token
            $token = JWTAuth::fromSubject($dm);
            return var_dump($token);
        }
    }

    public function login(Request $request)
    {
        // 验证 token
        return var_dump((JWTAuth::parseToken()->check()));
    }
}
