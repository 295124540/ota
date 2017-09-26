<?php
namespace app\admin\controller;
use app\common\controller\AdminController;

class Index extends AdminController{

    protected $modelClass = 'no';

    public function index(){
        return $this->fetch();
    }

    public function infor(){
        return $this->fetch();
    }
}