<?php
namespace app\admin\controller;
use think\Controller;
class Editer extends Controller
{
    /**
     * @author liuqin
     * @function 文本编辑器
     * @time 2017-04-14
    */
    public function editer()
    {
        return $this->fetch();
    }
 }