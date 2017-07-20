<?php
namespace app\api\controller\v1;;

use common\controller\ActiveController;
use common\model\BookDonate as BookDonateModel;

class BookDonate extends ActiveController
{

    public $modelClass = 'common\model\BookDonate';
    protected $loginAuth = ['except'=>'index'];
    protected $order = 'donate_time DESC';

    protected $beforeActionList = [
        'setCondition' =>  ['only'=>'index'],
    ];


    protected function prepareDataProvider()
    {
        $list = parent::prepareDataProvider(); // TODO: Change the autogenerated stub
        foreach ($list as $m){
            if($m->book){
                $m->book->book_model;
            }
        }
        return $list;
    }

    protected function setCondition(){
        $userId = paramFromGet('user_id');
        if($userId){
            $this->condition = ['user_id'=>$userId];
        }
    }

    /**
     * 捐书
     */
    public function save(){

        $params = paramFromPost();

        $rule = [
            ['phone|phone,电话号码','require|max:11'],
            ['list|list,书本信息列表','require'],
        ];
        $this->validate($params,$rule);
        foreach ($params['list'] as $k=>$book){
            $rule = [
                ['book_name|book_name,第'.($k+1).'本书，书名','require|max:30'],
                ['cover|cover,第'.($k+1).'本书，封面','require'],
            ];
            $this->validate($book,$rule);
            $params['list'][$k]['user_phone']=$params['phone'];
            $params['list'][$k]['user_id']=$this->userId;
            $params['list'][$k]['user_name']=$this->user['nickname'];
            $params['list'][$k]['donate_time']=time();
        }
        $model = new BookDonateModel();
        $rt = $model->saveAll($params['list']);
        if($rt){
            foreach ($rt as $item){
                $this->saveDynamic($item->id,4,"捐了一本书：《".$item->book_name."》");
            }
            success($rt);
        }else{
            error($model->getError());
        }
    }

}