<?php
class Pagination_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	private $total;
	private $offset;
	private $search_data;
	private $pre_url;

	private $num_page;
	private $limit;


//创建一个页码导航
//需要，
	// 1.总的记录数 total
	// 2.每页显示数 limit 默认为 10
	// 3.当前页码数 offset
	// 4.搜索内容 array data

	// 5.当前页前后显示页码数 num_page 默认为 4
	// 6.页码所在页
	
	public function initialize($config) {
		//必填参数
		$this->total = $config['total'];
		$this->offset = $config['offset'];
		$this->search_data = $config['search_data'];
		$this->pre_url = $config['pre_url'];
		//可选参数
		$this->limit = isset($config['limit'])?$config['limit']:10;
		$this->num_page = isset($config['limit'])?$config['limit']:4;
	}

	public function create_link()
	{
		$total_page = ceil($this->total/$this->limit);
		$current_page = $this->offset/$this->limit + 1;
		$links = array();

		//如果总页数为1或者0，则不显示页码导航
		if($total_page > 1)
		{
			//设置 首页
			if($current_page != 1)
			{
				$links['首页'] = '<li>'.anchor($this->url_maker(0),'首页').'</li>';
				$links['上一页'] = '<li>'.anchor($this->url_maker($this->offset - $this->limit),'上一页').'</li>';
			}

			//设置每一页
			$i = (($current_page - $this->num_page) < 0)?0:($current_page - $this->num_page);
			$end = 	(($current_page + $this->num_page) > $total_page)?$total_page:($current_page + $this->num_page);
			//如果当前页前面的页数多余 num_page 设定的页数，那么$i将不从0开始
			//同样的，当前页后面的页数太多，$end 也不会是 $total_page
			for(;$i < $end;++$i)
			{
				if(($i+1) == $current_page)
				{
					$links[$i+1] = '<li class="active">'.anchor($this->url_maker($this->limit*$i),$i+1).'</li>';
				}
				else
				{
					$links[$i+1] = '<li>'.anchor($this->url_maker($this->limit*$i),$i+1).'</li>';
				}
			}
			//设置 末页
			if($current_page != $total_page)//总页数为0也不显示
			{
				$links['末页'] = '<li>'.anchor($this->url_maker($this->limit*($total_page-1)),'末页').'</li>';
				$links['下一页'] = '<li>'.anchor($this->url_maker($this->offset+$this->limit),'下一页').'</li>';
			}
		}
		
		return $links;
	}


	private function url_maker($offset)
	{
		$data = $this->search_data;
		$data['offset']=$offset;
		$url = $this->pre_url.'?'.http_build_query($data);
		return $url;
	}
}