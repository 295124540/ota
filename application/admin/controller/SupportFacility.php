<?php
namespace app\admin\controller;

use common\controller\AdminController;

use common\model\Book as BookModel;
use common\model\BookHouse as BookHouseModel;
use common\model\BookModel as BookModelModel;
use common\model\Category as CategoryModel;

class SupportFacility extends AdminController
{

    protected $modelClass = 'common\model\SupportFacility';


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
        if($file==null)$this->error("没有上传设施图片！");
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//移动保存图片
        if($info==null)$this->error("文件目录没有写入权限！");
        $filePath =$info->getSaveName();
        $coverImg = "/uploads/".str_replace('\\','/',$filePath);

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
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');//移动保存图片
            if($info==null)$this->error("文件目录没有写入权限！");
            $filePath =$info->getSaveName();
            $coverImg = "/uploads/".str_replace('\\','/',$filePath);
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
