<?php

namespace App\Http\Controllers;

use App\Models\LywRegistrationModel;
use App\Models\Registration;
use Illuminate\Http\Request;

class LywAdministratorController extends Controller
{
    public function inquire(Request $request)//参数名，数组
    {
        $major=$request['major'];
        $res=LywRegistrationModel::FindDate($major);
        if($res){
            var_dump('查询成功');
            return $res;
        }else{
            var_dump('本专业并无学生报名项目');
        }
    }

}
