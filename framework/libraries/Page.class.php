<?php
//分页类，完成分页信息的输出
//共有 3 条记录,每页显示 2 条记录， 当前为 1/2 [首页] [上一页] [下一页] [末页]
//index.php?p=admin&c=brand&a=index&page=2
class Page{
	//属性
	private $total;       //总的记录数
	private $pagesize;    //每页显示的记录数
	private $currernt;    //当前页数
	private $pagenum;     //总的页数
	private $first;       //首页超链接
	private $last;        //末页超链接
	private $prev;        //上一页超链接
	private $next;        //下一页超链接
	private $url;         //超链接的地址

	//构造方法
	/**
	 *@param script string 超链接地址的文件名，不带任何参数
	 *@param params array 超链接地址的参数
	 */
	function __construct($total,$pagesize,$current,$script,$params=array()){
		$this->total = $total;
		$this->pagesize = $pagesize;
		$this->current = $current;
		$this->pagenum = ceil( $total / $pagesize );
		//index.php?p=admin&c=brand&a=index&page=2
		//new分页类 new Page(10,3,2,'index.php',array('p'=>'admin','c'=>'brand','a'=>'index'))
		$temp = array();
		foreach ($params as $k =>$v){
			//首先要形成 p=admin c=brand a=index 的内容，以数组的形式保存
			$temp[] = "$k=$v";
		}
		$str = implode("&", $temp); // p=admin&c=brand&a=index
		$this->url = "$script?{$str}&page="; //由于上页，下页，首页，末页的page是不同的，不能指定
		$this->first = $this->getFirst(); //得到首页超链接
		$this->last = $this->getLast();
		$this->prev = $this->getPrev();
		$this->next = $this->getNext();
	}

	//获得首页超链接
	private function getFirst(){
		//判断当前页是否为第一页
		if ($this->current == 1) {
			// 当前页是第一页
			return "[首页]";
		}else {
			//不是第一页
			return "<a href='{$this->url}1'>[首页]</a>";
		}
	}
	//获得末页超链接
	private function getLast(){
		//判断是否为最后一页
		if ($this->current == $this->pagenum ){
			return "[末页]";
		} else {
			return "<a href='{$this->url}{$this->pagenum}'>[末页]</a>";
		}
	}
	//获得上一页超链接
	private function getPrev(){
		//判断是否为第一页
		if ($this->current == 1){
			return "[上一页]";
		} else {
			return "<a href='{$this->url}".($this->current - 1)."'>[上一页]</a>";
		}
	}
	//获得下一页超链接
	private function getNext(){
		//判断是否为末页
		if ($this->current == $this->pagenum){
			return "[下一页]";
		} else {
			return "<a href='{$this->url}".($this->current + 1)."'>[下一页]</a>";
		}
	}
	//主方法，输出分页信息
	public function showPage(){
		if ($this->pagenum >= 1){
			return "共有 {$this->total} 条记录,每页显示 {$this->pagesize} 条记录，
			当前为 {$this->current}/{$this->pagenum} {$this->first} {$this->prev} 
			{$this->next} {$this->last}";
		} else {
			return "";
		}
	}
}