<?php
namespace app\admin\controller;
use think\Controller;
class Linux extends Controller
{
    /**
     * @author liuqin
     * @function 负载均衡
     * @time 2017-04-06
    */
    public function fuzai()
    {
        return $this->fetch();
    }
    /**
     * @author liuqin
     * @function 文件同步
     * @time 2017-04-06
    */
     public function unison()
    {
        return $this->fetch();
    }
    /**
     * @author liuqin
     * @function 数据表同步
     * @time 2017-04-06
    */
     public function datalist()
    {
        return $this->fetch();
    }
     /**
     * @author liuqin
     * @function 主从复制
     * @time 2017-04-06
    */
    public function zhucong()
    {
        return $this->fetch();
    }
     /**
     * @author liuqin
     * @function 服务器配置优化
     * @time 2017-04-06
    */
    public function youhua()
    {
        return $this->fetch();
    }
     /**
     * @author liuqin
     * @function 数据库优化
     * @time 2017-04-06
    */
    public function mysql()
    {
        return $this->fetch();
    }
     /**
     * @author liuqin
     * @function 读写分离
     * @time 2017-04-06
    */
      public function duxie()
    {
        return $this->fetch();
    }
     /**
     * @author xiaxoue
     * @function 缓存处理
     * @time 2017-04-06
    */
       public function memcache()
    {
        return $this->fetch();
    }
}
