<?php
namespace app\admin\controller;
use think\Controller;
class Echart extends Controller
{
    /**
     * @author liuqin
     * @function 数据可视化
     * @time 2017-04-14
    */
    public function echart()
    {
        return $this->fetch();
    }
 }