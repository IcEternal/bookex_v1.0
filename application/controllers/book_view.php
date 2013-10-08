<?php

class Book_view extends CI_Controller {
 
  function __construct()
  {
  parent::__construct();
  $this->load->helper(array('form', 'url'));
  }

  function book($class="所有书本", $page=1)
  { 
    $this->load->model('search_model');
    $data = $this->search_model->getBookByClass(urldecode($class), $page);
    $this->load->view('book_view', $data);
  }

  function discount($page=1) {
    $this->load->model('search_model');
    $_GET['scope'] = 'discount';
    $data = $this->search_model->getResult();
    $this->load->view('act_book_view', $data);
  }

  function free($page=1) {
    $this->load->model('search_model');
    $_GET['scope'] = 'free';
    $data = $this->search_model->getResult();
    $this->load->view('act_book_view', $data);
  }

}