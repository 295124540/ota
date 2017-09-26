<?php
namespace app\admin\controller;

use app\common\controller\AdminController;


class SupportFacility extends AdminController
{

    protected $modelClass = 'app\common\model\HotelSupportFacility';


    /**
     * 增设施信息
     * @return string
     */
    public function save()
    {
        $params = paramFromPost();
        $validate = [
            ['name|设施名称','require|max:20'],
        ];

        //验证
        $result = $this->validate($params,$validate);

        if (true !== $result) {
            return $this->error($result);
        }

        $file = request()->file('img');
        $coverImg = $this->uploadToAlyun($file);
        $params['img'] = $coverImg;

        $modelClass = $this->modelClass;
        $model = new $modelClass($params);
        // 过滤post数组中的非数据表字段数据
        $rt = $model->allowField(true)->save();

        if($rt){
            $this->success("新增成功！",'index');
        }else{
            $this->error("新增失败！");
        }
    }

    /**
     * 修改
     */
    public function update($id)
    {
        $params = paramFromPost();
        $file = request()->file('img');
        if($file){
            $coverImg = $this->uploadToAlyun($file);
            $params['img']= $coverImg;
        }

        $modelClass = $this->modelClass;
        $model = new $modelClass();
        $rt = $model->allowField(true)->save($params,['id' => $id]);
        if($rt){
            $this->success("修改成功！",'index');
        }else{
            $this->error("修改失败");
        }
    }

}
