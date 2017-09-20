<?php
namespace app\api\controller\v1;

use app\common\controller\ActiveController;

class BookWrite extends ActiveController
{

    public $modelClass = 'common\model\BookWrite';
    protected $authenticate = ['except'=>'index,read'];


    protected function findModel($id)
    {
        $model= parent::findModel($id); // TODO: Change the autogenerated stub
        $model->chapter;
        return $model;
    }

    protected function prepareDataProvider()
    {
        $list = parent::prepareDataProvider(); // TODO: Change the autogenerated stub
        foreach ($list as $m){
            $m->new_chapter;
        }
        return $list;
    }

}
