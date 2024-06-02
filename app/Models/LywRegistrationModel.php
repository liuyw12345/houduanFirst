<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

//引用Authenticatable类使得DemoModel具有用户认证功能

class LywRegistrationModel extends Authenticatable implements JWTSubject {//
    protected $table = "registration";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $guarded = [];

    //不知道有什么用
    use HasFactory;//使用模型工厂来创建模型实例
//    protected $fillable = [
//        'name',
//        'password',
//    ];

    public function getJWTIdentifier()
    {
        //getKey() 方法用于获取模型的主键值
        return $this->getKey();
    }

    //返回一个包含自定义声明的关联数组。
    public function getJWTCustomClaims()
    {
        return ['role => LywRegistrationModel'];
    }


    public static function FindDate($major)
    {
        try {
            $data=LywRegistrationModel::where("major",$major)
                ->get()
            ->count();
            return $data;

        }catch (Exception $e ){
            return  'error'.$e->getMessage();
        }
    }
}
