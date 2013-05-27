<?php header('Cache-Control: max-age=8'); ?>

<?php $this->load->view('includes/header') ?>

<?php $this->load->view($main_content, $data) ?>

<?php $this->load->view('includes/footer') ?>
