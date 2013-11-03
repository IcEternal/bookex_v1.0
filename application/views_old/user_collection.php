<?php include("includes/header.php"); ?>


<div class="container">
<legend>
  书本收藏夹
</legend>

<?php
  if (count($result) > 0) {
?>



<?php $first = true; ?>
      <div style = "font-family: verdana">
        <?php foreach ($result as $item): ?>

          <?php if ($first == false) {?>
          <div class = "row-fluid">
            <br />
          </div>
          <?php } ?>
          <?php $first = false; ?>

          <div class = "row-fluid">
            <div id = "left" class = "span3 text-center">
              <div class="thumbnail">
                <a href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" >
                  <div class="image" style = "width:100%">

                   <img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "width:70%" />

                  </div>
                </a>
              </div>
            </div>

            <div id = "right" class = "span7 offset1">
              <div class = "row-fluid">
                <p class = "span2"> <strong> 图书名 </strong> </p>
                <p class = "span10"> <?php echo $item->name; ?> </p>
              </div>

              <div class = "row-fluid">
                <p class = "span2">  <strong> 价格 </strong> </p>
                <p class = "span9" style = "font-size: 17px; color: #ff0000;">
                  <strong> ￥<?php echo $item->price; ?> </strong>
                  <span style = "text-decoration: line-through; font-size: 12px; color: #999">
                    ￥<?php echo $item->originprice; ?>
                  </span>
                </p>
              </div>

              <div class = "row-fluid">
                <p class = "span2"> <strong> 作者 </strong> </p>
                <p class = "span10"> <?php echo $item->author; ?> </p>
              </div>

              <div class = "row-fluid">
                <p class = "span2"> <strong> 出版社 </strong> </p>
                <p class = "span10"> <?php echo $item->publisher; ?> </p>
              </div>

              <div class = "row-fluid">
                <p class = "span2"> <strong> 简介 </strong> </p>
                <p class = "span10">
                  <?php
                    $text = $item->description;
                    $this->load->model("search_model");
                    if (strlen($text) > 300)
                      $text = $this->search_model->getstr($text, 300).' ...';
                    echo $text;
                  ?>
                </p>
              </div>
            </div>
            <p>
              <a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>">
                详细页面
              </a>
            </p>
            <p>
              <a href="<?php echo site_url('book_details/user_cancel_collect') ?>/<?php echo $item->id ?>">
                取消收藏
              </a>
            </p>
          </div>
        <?php endforeach;?>
      </div>



<?php
  }
  else {
?>

      <div class = "row-fluid"> 
        <div class = "image" style = "width:100%;">
  <a href="<?php echo site_url('welcome/act_detail') ?>">
  <img src = "<?php echo base_url('public/img/notFound.jpg'); ?>" style = "width:100%;" />
  </a>          
        </div>
      </div>

<?php
  }
?>
</div><!-- container -->

<!-- 51.la script -->
<div class="container" style="display:none">
<script language="javascript" type="text/javascript" src="http://js.users.51.la/15806741.js"></script>
</div>
<?php include("includes/footer.php"); ?>
