<?php
namespace app\api\controller\v1;

use app\common\controller\ActiveController;

class BookRent extends ActiveController
{

    protected $modelClass = 'common\model\BookRent';
    protected $beforeActionList = [
        'setCondition' =>  ['only'=>'index'],
    ];

    protected function setCondition(){
        $userId = paramFromGet('user_id');
        if($userId){
            $this->condition['user_id']=$userId;
            $this->condition['status']=1;
        }
    }

    protected function prepareDataProvider()
    {
        $list = parent::prepareDataProvider();
        foreach ($list as $m){
            $m->book;
            if($m->book){
                $m->book->model;
            }
            $m['rent_user']=$this->user['nickname'];
            $m['rent_num']="1";
        }
        return $list;
    }


    /**
     * 租书
     */
    public function save(){
        $bookModelClass = 'common\model\Book';
        $bookId = paramFromPost('book_id',true);
        $m = $bookModelClass::get($bookId);
        if($m==null){
            error("该书不存在！");
        }
        $m->model;
        $param = [
            'book_id'=>$bookId,
            'user_id'=>$this->userId,
            'user_name'=>$this->user['nickname'],
            'guaranty_money'=>$m->price,
            'rent_time'=>time()
        ];

        $modelClass = $this->modelClass;
        $m2 = $modelClass::create($param);
        if($m2){
            success($m2);
        }else{
            error($m2->getError());
        }
    }
}
