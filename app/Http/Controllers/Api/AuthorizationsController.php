<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\InvalidRequestException;

class AuthorizationsController extends Controller
{
    public function login(Request $request)
    {
        $verifyData = \Cache::get($request->captcha_key);

        if (!$verifyData) {
            throw new InvalidRequestException('无效的验证码', Response::HTTP_BAD_REQUEST);
        }

        if (!hash_equals($verifyData['code'], $request->captcha)) {
            throw new InvalidRequestException('验证码不匹配', Response::HTTP_BAD_REQUEST);
        }

        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        $credentials['password'] = $request->password;

        if (!$token = \Auth::guard('api')->attempt($credentials)) {
            throw new InvalidRequestException('账号或密码错误', Response::HTTP_BAD_REQUEST);
        }

        $user = \Auth::guard('api')->user();

        if ($user['status'] !== 1) {
            \Auth::guard('api')->logout(); // 退出登陆态
            throw new InvalidRequestException('账号已被冻结，请联系管理员。', Response::HTTP_BAD_REQUEST);
        }
        // 记录登入日志
        // event(new LoginEvent(\Auth::guard('api')->user(), new Agent(), $request->getClientIp()));


        // 使用 Auth 登录用户
        return (new UserResource($user))
            ->additional(['meta' => [
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'expires_in'   => \Auth::guard('api')->factory()->getTTL() * 60
            ]])
            ->response()
            ->setStatusCode(201);
    }

    public function logout()
    {
        \Auth::guard('api')->logout();

        return response()->json(['msg' => '退出成功'], 204);
    }
}
