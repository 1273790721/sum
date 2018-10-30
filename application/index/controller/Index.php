<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
    public function index()
    {
        // $users = db('user','admin_db')->select();
        // $this->assign('users',$users);
        return $this->fetch();
    }

}
