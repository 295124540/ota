<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use think\Request;
use common\model\BookWriteChapter as BookWriteChapterModel;


class BookWriteChapter extends ActiveController
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

    function find(){
        $rules = [
            'book_write_id'=>'require',
            'sequence'=>'require|number'
        ];
        $params = Request::instance()->get();
        $this->validate($params,$rules);
        $m = BookWriteChapterModel::get($params);
        if($m){
            success($m);
        }else{
            error('该章节不存在！');
        }
    }
}
