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
}
