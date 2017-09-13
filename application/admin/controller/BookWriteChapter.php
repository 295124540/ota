<?php
namespace app\admin\controller;

use common\controller\AdminController;

use common\model\Admin as AdminModel;
use common\model\BookHouse as BookHouseModel;

class BookWriteChapter extends AdminController
{
    function read($id)
    {
        return $this->findModel($id);
    }

    function update($id)
    {
        $model = $this->findModel($id);
        if(request()->param('sequence')){
            if($model->sequence==request()->param('sequence')){
                api(-1,"改章节已经存在！");
            }
        }
        $rt = $model->allowField(true)->save(request()->param());
        if ($rt) {
            $this->success("更新成功！", "index");
        } else {
            $this->error("更新失败!");
        }
    }
}
