<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use function Symfony\Component\Translation\t;

//引用Authenticatable类使得DemoModel具有用户认证功能

class LywAddProjectModel extends Authenticatable implements JWTSubject
{//
    protected $table = "project";
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
        return ['role => LywAddProjectModel'];
    }

    public static function LywAddProject($project)
    {
        try {
            $data = LywAddProjectModel::insert(
                [
                    'project_type' => $project['project_type'],
                    'project_name' => $project['project_name'],]

            );
            return $data;

        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

}
