<?php

namespace App\Http\Controllers;

use App\Models\LywRegistrationModel2;
use Illuminate\Http\Request;

//use http\Env\Request;
class LywAdministratorController2 extends Controller
{
    public function LywAdminInquire(Request $request)
    {
        $userdata = [
            'student_ID' => $request['student_ID'],
            'name' => $request['name'],
            'project_type' => $request['project_type'],
            'project_name' => $request['project_name']
        ];

        $result = LywRegistrationModel2::LywAddAdmin($userdata);
        $count=LywRegistrationModel2::where('student_ID',$userdata['student_ID'])->count();

        if (strpos($result, '成功') !== false) {
            var_dump('添加成功');
            var_dump('当前注册人数：' . $count);
        } else {
            var_dump('添加失败');
            var_dump('原因：' . $result);
            var_dump('当前注册人数：' . $count);
        }
    }
}
