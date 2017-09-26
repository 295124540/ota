<?php
namespace app\admin\controller;

use app\common\controller\AdminController;

use app\common\model\Admin as AdminModel;

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
