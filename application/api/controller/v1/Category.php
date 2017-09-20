<?php
namespace app\api\controller\v1;

use app\common\controller\ActiveController;


class Category extends ActiveController
{
    protected $modelClass = 'common\model\Category';
    protected $authenticate =  ['only'=>''];
    protected $beforeActionList = ['condition'=>['only'=>'index']];

    protected function condition()
    {
        $this->condition = ['resource_type'=>paramFromGet('resource_type',true)];
    }

}
