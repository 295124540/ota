<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/17
 * Time: 10:01
 */

namespace app\common\controller;

use think\Controller;
use think\Cookie;
use think\Request;

class AdminController extends Controller
{

    protected $authenticate;//登录身份鉴定
    protected $modelClass;//模型类，在子控制器中必须申明并赋值
    protected $condition; //查询条件
    protected $order;// 排序
    protected $with;// 关联预载入
    protected $admin;//管理员

    /**
     * 初始方法
     */
    public function _initialize()
    {
        if ($this->modelClass == null) {
            $this->modelClass = 'common\model\\'.Request::instance()->controller();//默认model
        }
        if ($this->authenticate) {
            $this->beforeActionList['authenticate'] = $this->authenticate; //（自定义）哪些方法是否需要登录身份鉴定
        } else {
            $this->beforeActionList['authenticate'] = null;//（默认）都需要登录身份鉴定
        }
    }

    /**
     * 登录身份鉴定
     */
    protected function authenticate(){
        $loginInfo = Cookie::get('login_admin');
        if ($loginInfo) {
            $admin = json_decode($loginInfo);
            $this->admin = $admin;
            $this->assign('admin',$admin);
            $this->assign('role', $admin->role);//后台角色
            $this->assign('menu', config('menu'));//后台菜单
        }else{
            $this->redirect('admin/user/login');
        }
    }

    /**
     * 是否登录
     */
    protected function isLogin()
    {
        if (Cookie::get('login_admin')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 管理员登录
     * @param $admin
     */
    protected function doLogin($admin)
    {
        Cookie::set('login_admin', $admin);
    }

    /**
     * 退出
     */
    protected function doLogout()
    {
        Cookie::clear('login_admin');
    }

    /**
     * find model
     * @param $id
     * @return mixed
     */
    protected function findModel($id)
    {

        $modelClass = $this->modelClass;
        $m = new $modelClass();
        $this->condition[$m->getPk()] = $id;
        $model = $m->get($this->condition);
        if (!$model) {
            $this->error("你没权限操作或该记录已经被删除！");
        }
        return $model;
    }

    /**
     * find list
     * @return mixed
     */
    protected function prepareDataProvider()
    {
        $modelClass = $this->modelClass;
        if ($this->condition) {
            $query = $modelClass::where($this->condition);
        }

        if ($this->order) {
            if (isset($query)) {
                $query = $query->order($this->order);
            } else {
                $query = $modelClass::order($this->order);
            }
        }

        // 关联预载入
        if($this->with){
            if(isset($query)){
                $query = $query->with($this->with);
            }else{
                $query = $modelClass::with($this->with);
            }
        }

        if (isset($query)) {
            $list = $query->paginate(20);
        } else {
            $list = $modelClass::paginate(20);
        }
        return $list;
    }

    /**
     * 模板变量赋值
     */
    protected function setAssign($signArr = [])
    {

        foreach ($signArr as $k => $v) {
            $this->assign($k, $v);
        }
    }

    /**
     * 查- 列表
     * @return string
     */
    public function index()
    {
        $list = $this->prepareDataProvider();
        $p = $list->toArray();
        $this->assign('total', $p['total']);
        $this->assign('perPage', $p['per_page']);
        $this->assign('currentPage', $p['current_page']);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 查- 详情
     * @return string
     */
    public function read($id)
    {
        $model = $this->findModel($id);
        $this->assign('model', $model);
        return $this->fetch();
    }

    /**
     * 增- 表单
     * @return string
     */
    public function create()
    {
        return $this->fetch();
    }

    /**
     * 增 - 确认保存
     * @return string
     */
    public function save()
    {
        $modelClass = $this->modelClass;
        $model = new $modelClass($_POST);
        // 过滤post数组中的非数据表字段数据
        $model->allowField(true)->save();
        if ($model) {
            if (isset($model->create_time)) {
                $model->create_time = time();
                $model->save();
            }
            $this->success("新增成功！", 'index');
        } else {
            $this->error("新增失败！");
        }


    }

    /**
     * 改 - 表单
     * @param $id
     * @return string
     */
    public function edit($id)
    {

        $model = $this->findModel($id);
        $this->assign('model', $model);
        return $this->fetch();
    }

    /**
     * 改 - 确认修改
     * @param $id
     * @return string
     */
    public function update($id)
    {
        $model = $this->findModel($id);
        $rt = $model->allowField(true)->save(request()->param());
        if ($rt) {
            $this->success("更新成功！", "index");
        } else {
            $this->error("更新失败!");
        }
    }

    /**
     * 删
     * @param $id
     * @return string
     */
    public function delete($id)
    {

        $model = $this->findModel($id);
        $rt = $model->delete();
        if ($rt) {
            $this->success("删除成功！", "index");
        } else {
            $this->error("删除失败！");
        }

    }


}