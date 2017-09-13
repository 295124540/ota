<?php
namespace app\admin\controller;

use common\controller\AdminController;

use common\model\Admin as AdminModel;
use common\model\BookHouse as BookHouseModel;
use common\model\Category as CategoryModel;

class BookHouse extends AdminController
{
    protected $with = 'admin';

    public function create(){
        $list = AdminModel::all(['role'=>3]);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function edit($id)
    {
        $list = AdminModel::all(['role'=>3]);
        $this->assign('list',$list);
        return parent::edit($id);
    }

}
