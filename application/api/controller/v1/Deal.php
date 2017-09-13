<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/23
 * Time: 16:08
 */

namespace app\api\controller\v1;

use think\Controller;
use think\Cache;
use think\Db;
use think\Config;

class Deal extends Controller
{
    /**
     * 获取数据字典
     */
    public function dataDictionary(){
        //先从缓存里取数据
        $dictInfor = Cache::get('data_dictionary');

        if (!$dictInfor) {
            $sql = "show table status";
            $tables = Db::query($sql);
            $dbName = Config::get('database.database');

            foreach ($tables as $k=>$table){
                $tableName=$table['Name'];
                $sql = "select COLUMN_NAME,COLUMN_TYPE,COLUMN_COMMENT,COLUMN_DEFAULT,COLUMN_KEY from information_schema.columns where TABLE_SCHEMA='$dbName' and TABLE_NAME='$tableName'";
                $dict = Db::query($sql);
                $dictInfor[$k]['table']=$table;
                $dictInfor[$k]['dictionary']=$dict;
            }
            //存入缓存小时钟
            Cache::set('data_dictionary', $dictInfor, 60*60);
        }

        api(100,"",$dictInfor);
    }

}