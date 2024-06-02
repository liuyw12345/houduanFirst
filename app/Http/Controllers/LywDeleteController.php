<?php

namespace App\Http\Controllers;

use App\Models\LywDeleteModel;
use http\Env\Request;

class LywDeleteController extends Controller
{
public function LywDelete(Request $request)
{
    $userdata['student_ID']=$request['student_ID'];
    $userdata['name']=$request['name'];
    $userdata['major']=$request['major'];
    $userdata['project_type']=$request['project_type'];
    $userdata['project_name']=$request['project_name'];
    $dm=LywDeleteModel::LywAddAdmin($userdata);
    if($dm){
        var_dump('删除成功');
    }else{
        var_dump('删除失败');
    }
}
}
