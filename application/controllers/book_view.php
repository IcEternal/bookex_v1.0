<?php

class Book_view extends CI_Controller {
 
  function __construct()
  {
  parent::__construct();
  $this->load->helper(array('form', 'url'));
  }

  function book($class="", $page=1)
  { 
    $this->load->model('search_model');
    $data = $this->search_model->getBookByClass(urldecode($class), $page);
    $this->load->view('book_view', $data);
  }

}