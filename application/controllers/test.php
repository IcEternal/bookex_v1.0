<?php

class Test extends CI_Controller {
 public function index() {
 	$url = 'http://img3.douban.com/lpic/s26261183.jpg';
ob_start(); 
readfile($url); 
$img = ob_get_contents(); 
ob_end_clean(); 
// $size = strlen($img); 
//echo $filename;
// $fp2=fopen($filename, 'w+b');
$data = array(
               'name' => 'My title' ,
               'author' => 'My Name' ,
               'price' => '16' ,
               'publisher' => 'My Name' ,
               'ISBN' => '161616561516' ,
               'description' => 'My Name' ,
               'uploader' => 'alice' ,
               'originprice' => '16' ,
               'img' => $img,
               'hasimg' => 1
            );


$this->db->insert('book',$data);
 }


}
 
