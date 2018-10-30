<?php
//phpinfo();exit;
//$root = dirname(__FILE__);
//$filename = $root.'/test.pdf';
 $path1 = dirname(__FILE__);
$fileName1 = $path1.'/xxq.pdf';
  // var_dump($fileName1);exit();
 chmod($path1.'/'.$fileName1, '-rwxrwxrwx' );//赋给文件权限(777)
 $data_i =  pdf2png($fileName1, $path1);
 die('{"status" s: "success", "result": {"imgpath" : "' . $data_i . '"}}');//返回参数
function pdf2png($pdf,$path1,$page=-1)
{
   if(!extension_loaded('imagick'))
   {
       return 4;
   }
   if(!file_exists($pdf))
   {
       return 5;
   }
   $im = new Imagick();
   $im->setResolution(60,60); //设置分辨率
   $im->setCompressionQuality(10);//设置图片压缩的质量
   if($page==-1)  {
    $ss =   $im->readImage($pdf);
   }
   else{
      $im->readImage($pdf."[".$page."]");//从文件名读取图像
       return 7;
   }
       $im->setImageFormat('png'); //为图片设置指定的格式
       $filename1 = $path1."/". md5(time()).'.png';
       $dd = $im->writeImage($filename1);
       // return '阻住';
       if($dd == true)//把图片写入指定的文件
       {
          // return 'yes';
           $return = $filename1;
       } else{
            return '失败';
       }
   return $return;
}


