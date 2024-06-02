<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

//引用Authenticatable类使得DemoModel具有用户认证功能

class LywRegistrationModel2 extends Authenticatable implements JWTSubject
{//
    protected $table = "registration";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $guarded = [];

    //不知道有什么用
    use HasFactory;

    //使用模型工厂来创建模型实例

    public function getJWTIdentifier()
    {
        //getKey() 方法用于获取模型的主键值
        return $this->getKey();
    }

    //返回一个包含自定义声明的关联数组。
    public function getJWTCustomClaims()
    {
        return ['role => LywRegistrationModel2'];
    }

    public static function LywAddAdmin($userdata)
    {
        try {
            // 检查是否已存在该用户的报名记录
            $existingRecord = LywRegistrationModel2::where('student_ID', $userdata['student_ID'])
                ->where('project_name', $userdata['project_name'])
                ->first();
            if ($existingRecord) {
                return 'error: 该用户已报名此项目';
            }

            // 检查报名记录是否已经达到最大数量（4条）
            $count = LywRegistrationModel2::where('student_ID', $userdata['student_ID'])->count();
            if ($count >= 4) {
                return 'error: 报名不能超过4个';
            }

            // 插入数据
            $data =LywRegistrationModel2::insert([
                'student_ID' => $userdata['student_ID'],
                'name' => $userdata['name'],
                'project_type' => $userdata['project_type'],
                'project_name' => $userdata['project_name'],
            ]);

            return $data ? 'success: 添加成功' : 'error: 数据插入失败';

        } catch (Exception $e) {
            return 'error: ' . $e->getMessage();
        }
    }
}


