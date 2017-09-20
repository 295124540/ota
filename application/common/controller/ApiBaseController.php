<?php
namespace app\common\controller;

use think\Cache;
use think\Controller;
use think\Request;
use think\Validate;
use tools\HttpClient;


class ApiBaseController extends Controller
{
    protected $authenticate; // 身份验证
    protected $accessToken;  // token
    protected $user;         // 用户信息
    protected $userId;       // 用户ID

    protected function _initialize()
    {
        $this->accessToken = Request::instance()->header('access-token');

        if ($this->accessToken) { //有token时
            $this->authenticate(); //只要接口带了token就去验证身份，此时$loginAuth定义就失效了
        } else { //无token时，
            if ($this->authenticate) { //有指定权限
                $this->beforeActionList['authenticate'] = $this->authenticate; // 选定自定义权限
            } else { // 无指定权限
                // 不验证
            }
        }
    }

    /**
     *  鉴定身份
     */
    protected function authenticate()
    {
        if ($this->accessToken == null) {
            api(101, "该接口需要登录权限！");
        }
        if (strlen($this->accessToken) < 24) {
            api(102, "access-token无效！");
        }
        $loginUser = Cache::get($this->accessToken);
        //当本系统无登录时，去总用户系统认证(实现单点登录) token过期在用户系统中验证提示，过期代码103
        if ($loginUser == null) {
            $params = config('thirdaccount.users_sys');
            $loginUser = $this->requestUserServer("/api/user/identityAuth", $params, false);
            $this->login($loginUser);
        }

        if ($loginUser) {
            $this->user = $loginUser;
            $this->userId = $loginUser['yunsu_id'];
        }
    }

    /**
     * 登录
     * @param $user
     * @return bool
     */
    protected function login($user)
    {
        $this->accessToken = $user['access_token'];
        $this->user = $user;
        $this->userId = $user['yunsu_id'];
        $rt = Cache::set($this->accessToken, $user, 10 * 24 * 60 * 60);//token有效期两个小时 调试时间为10天有效
        if (!$rt) die($rt);
        return true;
    }

    /**
     * 重写 表单验证
     */
    protected function validate($data, $validate, $message = [], $batch = false, $callback = null)
    {
        $result = parent::validate($data, $validate, $message, $batch, $callback); // TODO: Change the autogenerated stub
        if (true !== $result) {
            error($result);
        }
    }

    /**
     * 按场景验证
     * @param $data 验证数据
     * @param null $name 场景名
     */
    protected function validateByScene1($data,$name)
    {
        $validate = new Validate($this->rule);
        $validate->scene($name, $this->scene[$name]);
        $validate->message($this->msg);
        $result = $validate->scene($name)->check($data);
        if (true !== $result) {
            error($validate->getError());
        }
    }

    /**
     * 请求用户系统
     * @param $path 服务器资源路径 例如：/api/user/login
     * @param null $params 参数
     * @param bool $isVerify 是否严格验证
     * @return mixed
     */
    protected function requestUserServer($path, $params = null, $isVerify = true)
    {
        $url = 'http://users.icloudinn.com' . $path;
        if ($this->accessToken) {
            if (strpos($url, '?')) {
                $url = $url.'&';
            } else {
                $url = $url.'?';
            }
            $url = $url.'access-token=' . $this->accessToken;
        }

        if ($params) {
            $rt = HttpClient::post($url, $params);
        } else {
            $rt = HttpClient::get($url);
        }

        $info = json_decode($rt, true);
        if ($info) {
            if ($info['code'] == 100) {
                return $info['data'];
            } else {
                if ($isVerify) {
                    api($info['code'], "From Users System. " . $info['msg'], $info['data']);
                }
            }
        }
        die($rt);
    }
}