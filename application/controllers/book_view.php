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
    $userId = $this->user_model->getIdByUsername();
    if ($userId == 0) 
      $data['never_show_activity'] = 0;
    else {
      $data['never_show_activity'] = $this->user_model->get_user()->never_show_activity;
    }
    $this->load->view('book_view', $data);
  }

  function discount($page=1) {
    $this->load->model('search_model');
    $_GET['scope'] = 'discount';
    $_GET['page'] = $page;
    $data = $this->search_model->getResult();
    $this->load->view('act_book_view', $data);
  }

  function free($page=1) {
    $this->load->model('search_model');
    $_GET['scope'] = 'free';
    $_GET['page'] = $page;
    $data = $this->search_model->getResult();
    $this->load->view('act_book_view', $data);
  }

}
