<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\Collect;
use common\model\Users;
use think\Db;


class ErrorLog extends ActiveController
{
    protected $modelClass = 'common\model\ErrorLog';
    protected $loginAuth =  ['only'=>''];

}
