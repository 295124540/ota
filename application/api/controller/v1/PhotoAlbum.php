<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\Collect;
use common\model\Users;
use think\Db;


class Book extends ActiveController
{
    protected $modelClass = 'common\model\Book';
    protected $loginAuth =  ['except'=>'index,read,category'];

    /**
     * 书列表（最新、最热）
     */
    public function index(){
        $type = paramFromGet('type');
        if($type=='hot'){
            $this->order = 'read_num desc';
        }else{
            $this->order = 'create_time desc';
        }

        $list = $this->prepareDataProvider();
        foreach ($list as $model){
            $model->model;
        }
        success($list);
    }

    /**
     * 详情
     * @param $id
     * @return mixed
     */
    public function read($id){
        $model = $this->findModel($id); // TODO: Change the autogenerated stub
        $model->read_num = $model->read_num +1;//阅读量+1
        $model->save();
        $model->model;
        foreach ($model->comment as $comment){
            $comment->reply;
        }

        $model['is_collect'] = false;
        $model->book_house;
        $model->book_donate; //捐书者
        foreach ( $model->book_rent as $rent){ //借阅者
            $user = Users::get($rent->user_id)->toArray();
            if($user){
                $rent['head_img'] = $user['head_img_url'];
            }

        }

        if($this->userId){
            if(Collect::get(['type'=>2,'source_id'=>$id,'user_id'=>$this->userId])){
                $model['is_collect'] = true;
            }
        }
        success($model);
    }

    /**
     * 分类书籍
     */
    public function category(){
        $categoryId = paramFromPost('category_id',true);
        $list = Db::query("SELECT b.id,m.name,m.cover_img FROM ot_book_model m,ot_book b WHERE b.model_id=m.id AND m.category_id =".$categoryId." LIMIT 50");
        success($list);
    }

}