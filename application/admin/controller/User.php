<?php
namespace app\admin\controller;

use common\controller\AdminController;
use common\model\Admin as AdminModel;

class User extends AdminController
{
    protected $modelClass = 'common\model\Admin';
    protected $authenticate =  ['except'=>'login'];
    /**
     * 首页
     */
    public function index()
    {
       $this->redirect('user/login');
    }

    /**
     * 书童
     */
    public function child(){
        $list = AdminModel::all(['role'=>3]);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 添加书童
     */
    public function addChild(){
        return $this->fetch();
    }

    /**
     * 修改书童信息
     */
    public function updChild($id){
        $model = AdminModel::get(['id'=>$id,'role'=>3]);
        if($model==null){
            $this->error("你没权限获取者该记录已删除!");
        }
        if($_POST){
            $rt = $model->allowField(true)->save(request()->param());
            if($rt){
                $this->success("更新成功！","child");
            }else{
                $this->error("更新失败!");
            }
        }

        $this->assign('model',$model);
        return $this->fetch();
    }

    /**
     * 管理员登录
     * @return mixed
     */
    public function login()
    {
        if($this->isLogin()){
            $this->success('你已经登录过了！','/admin');
        }
        if($_POST){
            $model = new AdminModel();
            $email= $_POST['email'];
            $password= $_POST['password'];
            $role = $_POST['role'];

            $admin = $model ->get(['email'=>$email,'role'=>$role]);
            if ($admin) {
                if($admin->pwd==md5($password.$admin->auth_key)){
                    $this->doLogin($admin);
                    $this->success('欢迎回来！','/admin');
                }else{
                    $this->error('密码错误！');
                }

            } else {
                if($role==1){
                    $this->error('不存在该管理员！');
                }elseif($role==2){
                    $this->error('不存在该民宿商家！');
                }elseif($role==3){
                    $this->error('不存在该书童！');
                }else{
                    $this->error('该管理者不存在！');
                }

            }
        }

        $this->view->engine->layout(false);
        return $this->fetch();
    }

    /**
     * 退出登录
     */
    public function logout(){
        $this->doLogout();
        $this->redirect('/admin/user/login');
    }

    /**
     * 添加管理员
     * @return mixed
     */
    public function addAdmin(){
        return $this->fetch();
    }

    /**
     * 管理员列表
     * @return mixed
     */
    public function getList(){
        $manager = AdminModel::all();
        $this->assign('manager',$manager);
        return $this->fetch('list');
    }

    /**
     * 添加管理员
     * @return bool
     */
    public function doAddAdmin(){

        $admin = new AdminModel();

        $len = $admin ->where('email',$_POST['email'])->count();

        if($len>0){
            $this->error('该账号已存在');
            return false;
        }

        $authKey = getRandChar(10);

        $admin->role = $_POST['role'];
        $admin->email = $_POST['email'];
        $admin->pwd = md5($_POST['password'].$authKey);
        $admin->auth_key = $authKey;
        $admin->create_time = time();
        $result = $admin ->save();
        if($result){
            $this->success('添加成功','/admin/user/getList');
        }else{
            $this->error('添加失败');
        }
        
    }

}
