<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\Collect;
use think\Request;
use common\model\BookDonate;
use common\model\BookRent;

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
