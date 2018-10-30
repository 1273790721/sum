<?php

namespace app\admin\controller;

use think\Controller;

class Word extends Controller
{
	/**
	* @author liuqin
	* @function pdf转图片
	* @time 2017-04-27
	*/
	public function index()
	{
		return $this->fetch();
	}
	/*word模版替换相关代码*/
	public function test(){
		$url='ww.htm';
		$contents = file_get_contents($url);
		$data = date('Y',time()).'年'.date('m',time()).'月'.date('d',time()).'日';
		$tab = '<table style="width:100%;font-size:14px;" cellspacing="0" cellpadding="2" bordercolor="#000000" border="1" ><thead> <tr><th >主持人</th><th >议程标题</th><th>开始时间</th><th>结束时间</th><th >议程附件</th></tr></thead><tbody id="mytd"><tr><td >ce试</td><td >哈哈</td><td >2016-12-11</td><td>2017-08-12</td><td >文件</td></tr></tbody></table>'; 
		$table_change += array('{$name}'=>iconv( "utf-8", "GB2312" , '测试1'));
		$table_change += array('{$time}'=>iconv( "utf-8", "GB2312" , $data));
		$table_change += array('{$ceshi1}'=>iconv( "utf-8", "GB2312" , '12'));
		$table_change += array('{$tab}'=>iconv( "utf-8", "GB2312" , $tab));
		$html=strtr($contents,$table_change);
		$map=explode('url(',$html);
		/*去除html关联文件信息开始*/
		$map=explode('url(',$html);
		if(count($map)>1){
			$html=$map[0];
			for($i=1;$i<count($map);$i++){
				$myems = explode(')',$map[$i]);
				for($j=1;$j<count($myems);$j++){
					$html=$html.')'.$myems[$j];
				}
			}
		}
		$map1=explode('<link',$html);
		if(count($map1)>1){
			for($i=1;$i<count($map1);$i++){
				$myems = explode('>',$map1[$i]);
				$links = '<link'.$myems[0].'>';
				$table_change = array($links=>' ');
				$html=strtr($html,$table_change);	
			}
		}
		/*去除html关联文件信息结束*/
		echo $html;
		$html = getWordDocument($html,"http://test.360guanggu.com/word/");//将html格式转mht格式（即doc格式）
		$title = "test";
		echo (cword($html,iconv("UTF-8","GB2312//IGNORE",$title))); //转换中文并忽视错误

	}
	
	
function cword($data,$fileName=''){
    if(empty($data)) return '';
  
    $data = $data.'</html>';
    $dir  = "./docfile/".date("Ymd")."/";
  
    if(!file_exists($dir)) mkdir($dir,777,true);
  
    if(empty($fileName))
    {
        $fileName=$dir.date('His').'.doc';
    }
    else
    {
        $fileName =$dir.$fileName.'.doc';
    }
  
    $writefile = fopen($fileName,'wb') or die("创建文件失败"); //wb以二进制写入
    fwrite($writefile,$data);
    fclose($writefile);
    return $fileName;
}
/**
 * 根据HTML代码获取word文档内容
 * 创建一个本质为mht的文档，该函数会分析文件内容并从远程下载页面中的图片资源
 * 该函数依赖于类MhtFileMaker
 * 该函数会分析img标签，提取src的属性值。但是，src的属性值必须被引号包围，否则不能提取
 *
 * @param string $content HTML内容
 * @param string $absolutePath 网页的绝对路径。如果HTML内容里的图片路径为相对路径，那么就需要填写这个参数，来让该函数自动填补成绝对路径。这个参数最后需要以/结束
 * @param bool $isEraseLink 是否去掉HTML内容中的链接
 */
function getWordDocument( $content , $absolutePath = "" , $isEraseLink = true )
{
    $mht = new MhtFileMaker();
	/*
    if ($isEraseLink)
        $content = preg_replace('/<a\s*.*?\s*>(\s*.*?\s*)<\/a>/i' , '$1' , $content);   //去掉链接

    $images = array();
    $files = array();
    $matches = array();
    //这个算法要求src后的属性值必须使用引号括起来
    if ( preg_match_all('/<img[.\n]*?src\s*?=\s*?[\"\'](.*?)[\"\'](.*?)\/>/i',$content ,$matches ) )
    {
        $arrPath = $matches[1];
        for ( $i=0;$i<count($arrPath);$i++)
        {
            $path = $arrPath[$i];
            $imgPath = trim( $path );
            if ( $imgPath != "" )
            {
                $files[] = $imgPath;
                if( substr($imgPath,0,7) == 'http://')
                {
                    //绝对链接，不加前缀
                }
                else
                {
                    $imgPath = $absolutePath.$imgPath;
                }
                $images[] = $imgPath;
            }
        }
    }*/
    $mht->AddContents("tmp.html",$mht->GetMimeType("tmp.html"),$content);
    return $mht->GetFile();
}
}