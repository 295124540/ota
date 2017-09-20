<?php
namespace app\api\controller\v1;;

use app\common\controller\ActiveController;
use common\model\BookDonate as BookDonateModel;

class BookDonate extends ActiveController
{

    protected $modelClass = 'common\model\BookDonate';
    protected $authenticate = ['except'=>'index'];
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
        success($params);

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
            $user = $this->user;
            if(isset($user['nickname'])){
                $params['list'][$k]['user_name']=$user['nickname'];
            }else{
                $params['list'][$k]['user_name']='无昵称';
            }
            $params['list'][$k]['donate_time']=time();
        }
        $model = new BookDonateModel();
        $rt = $model->saveAll($params['list']);
        if($rt){
            success($rt);
        }else{
            error($model->getError());
        }
    }

}
