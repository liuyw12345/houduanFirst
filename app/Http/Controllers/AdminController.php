<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Services\Oss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OSS\OssClient;

class AdminController extends Controller
{
    /**
     * 加密数据（值得注意的是，本方法因为无需密码登录，故而获取的psw和account一致）
     * @param $request
     * @return array
     */
    protected function userHandle($request)   //对密码进行哈希256加密
    {
        $registeredInfo['account'] = $request['account'];
        $registeredInfo['quanxian'] = $request['quanxian'];
        $registeredInfo['password'] = $request['password'];
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);
        return $registeredInfo;
    }

    /**
     * 注册录入数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $registeredInfo = self::userHandle($request);
        $count = Admin::checknumber($registeredInfo['account']);   //检测账号密码是否存在
        if (is_error($count) == true){
            return json_fail('注册失败!检测是否存在的时候出错啦',$count,100  ) ;
        }
        if ($count == 0){
            $student_id = Admin::createUser($registeredInfo);
            if (is_error($student_id) == true){
                return json_fail('注册失败!添加数据的时候有问题',$student_id,100  ) ;
            }
            return json_success('注册成功!',$student_id,200  ) ;
        }
        return json_fail('注册失败!该用户信息已经被注册过了',null,101 ) ;
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $credentials['account'] = $request['account'];
        $credentials['password'] = $request['password'];
        $token = auth('admin')->attempt($credentials);

        if (!$token) {
            return json_fail('登录失败!账号或密码错误', null, 100);
        }

        $user = auth('admin')->user();

        if ($user) {
            $data['token'] = $token;
            $data['quanxian'] = $user->quanxian;
            return json_success('登录成功!', $data, 200);
        } else {
            return json_fail('登录失败!用户信息获取失败', null, 100);
        }
    }


    /**
     * 退出登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('admin')->logout();

        return  json_success('用户退出登录成功!',null,  200);
    }

    /**
     * 刷新token
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = auth('admin')->refresh();
        return  json_success('token刷新成功!',$token, 200);
    }

    /**
     * 验证验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function decrypt(Request $request){
        $code = $request['code'];
        $hascode = $request['hascode'];
        $res = Hash::check($code,$hascode);
        if ($res == true){
            return  json_success('验证码对比成功!',$res,  200);
        }else{
            return  json_fail('验证码输入错误',$res, 100 ) ;
        }
    }
    public function OssUpdate(Request $request)
    {

        $file = $request->file('file');

        if ($file->isValid()) {
            $ossClient = new OssClient(
//                'LTAI5tLxDZzVYf1okTssx4nY',
//                'n73YnfSJAR8IHAd3pNEaVkloiAKMn6',
                'oss-cn-beijing.aliyuncs.com'
            );
            $filePath = $file->getRealPath();
            $fileName = uniqid() . '.' . $file->geetClintOriginalExtension();

            $bucketName = 'yyh';

            $objectName = 'files/' . $fileName; // Change to the appropriate directory for files
            $objectUrl = ''; // Used to store the preview link

            try {
                // Upload the file to OSS
                $ossClient->uploadFile($bucketName, $objectName, $filePath, ['Content-Type' => $file->getClientMimeType()]);
                $url = OSS::getPublicObjectURL($bucketName, $objectName);

                // Return the status and URL to the frontend
                return response()->json([
                    'code' => 200,
                    'msg' => 'Upload successful',
                    'data' => $url
                ]);
            } catch (\Exception $e) {
                // Upload failed, return error message to the frontend
                return response()->json([
                    'code' => -1,
                    'msg' => 'Upload failed',
                    'data' => $e->getMessage()
                ]);
            }
        } else {
            // Invalid file, return error message to the frontend
            return response()->json([
                'code' => -1,
                'msg' => 'Invalid file',
                'data' => null
            ]);
        }
    }

}
