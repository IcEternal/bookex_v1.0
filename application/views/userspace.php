<?php
/*
================================================================
userspace.php

include: includes/header.php
         includes/footer.php

The page of user space.

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php include("includes/header.php"); ?>
<?php
    if ($err != "") {
        if ($is_success == true) {
?>
            <div class="main-alert">
                <button type="button" class="close" data-dismiss="main-alert">&times;</button>
                <strong></strong> <?php echo $err; ?>
            </div>
<?php
        } else {
?>
            <div class="main-alert">
                <button type="button" class="close" data-dismiss="main-alert">&times;</button>
                <strong></strong> <?php echo $err; ?>
            </div>
<?php
        }
    }
?>
    <div class="content-full"><!-- structure -->
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li><a href="#tab1" data-toggle="tab">已预订的书</a></li>
                <li><a href="#tab2" data-toggle="tab">被预订的书</a></li>
                <li class="active"><a href="#tab3" data-toggle="tab">已上传的书</a></li>
                <li><a href="#tab4" data-toggle="tab">已交易的书</a></li>
            </ul>
            <div class="tab-content" style="padding-bottom:9px; border-bottom:1px solid #ddd;">
                <div class="tab-pane fade" id="tab1">
<?php
                    if (count($result1) > 0) {
                        function get_status_string($status){
                            if ($status == 0) return "未取书";
                            elseif ($status == 1) return "正在取书";
                            elseif ($status == 2) return "书本已到达BookEx";
                            elseif ($status == 3) return "正在送书";
                            elseif ($status == 4) return "交易成功";
                            elseif ($status == 5) return "卖家找不到该书本";
                        }
                        $first = true; 
?>
                        <div style = "font-family: verdana">
<?php 
                            foreach ($result1 as $item):
                                if ($first == false) {
?>
                                    <div class = "row-fluid"> <br />
                                    </div>
<?php 
                                } 
                                $first = false; 
?>
                                <div class = "row-fluid">
                                    <div id = "left" class = "span3 text-center">
                                        <div class="thumbnail">
                                            <div class="image" style = "width:100%"> <img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "width:70%" /> </div>
                                        </div>
                                    </div>
                                    <div id = "right" class = "span6 offset1" style="margin-right: 30px;">
                                        <div class = "row-fluid">
                                            <p class = "span2"> <strong> 图书名 </strong> </p>
                                            <p class = "span10"> <?php echo $item->name; ?> </p>
                                        </div>
                                        <div class = "row-fluid">
                                            <p class = "span2"> <strong> 价格 </strong> </p>
                                            <p class = "span9" style = "font-size: 17px; color: #ff0000;"> <strong> ￥<?php echo $item->price; ?> </strong> <span style = "text-decoration: line-through; font-size: 12px; color: #999"> ￥<?php echo $item->originprice; ?> </span> </p>
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
                                    <p> <a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>"> 详细页面 </a> </p>
                                    <p> <?php echo get_status_string($item->status); ?> </p>
                                    <p> <a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>"> 详细页面 </a> </p>
                                    <?php 
                                        if (isOfService($item->class, 'Service')){
                                    ?>
                                            <p><a href="#myModal2<?php echo $item->id ?>" role="button" data-toggle="modal">完成交易</a></p>
                                    <?php } ?>
                                    <div id="myModal2<?php echo $item->id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal2Label" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModal2Label">确认信息</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>您确认将本服务登记为完成交易吗？</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                                            <a href="<?php echo site_url('book_upload/book_finish') ?>/<?php echo $item->id ?>" class="btn btn-primary">确认完成交易</a> 
                                        </div>
                                    </div>
                                </div>
<?php                           
                            endforeach;
?>
                        </div>
<?php
                    } else {
?>
                        <div class = "row-fluid">
                            <div class = "image" style = "width:100%;"> <a href="<?php echo site_url('welcome/act_detail') ?>"> <img src = "<?php echo base_url('public/img/notFound.png'); ?>" style = "width:100%;" /> </a> </div>
                        </div>
<?php
                    }
?>
                </div><!-- tab1 -->

                <div class="tab-pane fade" id="tab2">
<?php
                    if (count($result2) > 0) {
                        $first = true; 
?>
                        <div style = "font-family: verdana">
<?php 
                            foreach ($result2 as $item): 
                                if ($first == false) {
?>
                                    <div class = "row-fluid"> <br />
                                    </div>
<?php 
                                } 
                                $first = false; 
?>
                                <div class = "row-fluid">
                                    <div id = "left" class = "span3 text-center">
                                        <div class="thumbnail">
                                            <div class="image" style = "width:100%"> <img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "width:70%" /> </div>
                                        </div>
                                    </div>
                                    <div id = "right" class = "span7 offset1">
                                        <div class = "row-fluid">
                                            <p class = "span2"> <strong> 图书名 </strong> </p>
                                            <p class = "span10"> <?php echo $item->name; ?> </p>
                                        </div>
                                        <div class = "row-fluid">
                                            <p class = "span2"> <strong> 价格 </strong> </p>
                                            <p class = "span9" style = "font-size: 17px; color: #ff0000;"> <strong> ￥<?php echo $item->price; ?> </strong> <span style = "text-decoration: line-through; font-size: 12px; color: #999"> ￥<?php echo $item->originprice; ?> </span> </p>
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
                                            <p class = "span2"> <strong> <?php echo "交易类型:"; ?></strong></p>
                                            <p class = "span10">
                                                <?php
                                                if (isOfService($item->class)) {
                                                    echo "暂时不提供买家手机号，如有急切需求，请发邮件至bookex@163.com";
                                                }
                                                else {
                                                    if ($item->use_phone == 1){
                                                        $subscriber_phone = $user_phone["$item->id"][0]->phone;
                                                        echo "自行交易（买家手机：$subscriber_phone ）";
                                                    }
                                                    else {
                                                        echo "委托交易";
                                                    }
                                                }
                                                ?>
                                            </p>
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
                                    <p> <a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>"> 详细页面 </a> </p>
                                    <?php 
                                        if ($item->use_phone == 1 && (!isOfService($item->class, 'Service'))){
                                    ?>
                                            <p><a href="#myModal1<?php echo $item->id ?>" role="button" data-toggle="modal">完成交易</a></p>
                                    <?php } ?>
                                    <div id="myModal1<?php echo $item->id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModal1Label">确认信息</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>您确认将本书登记为完成交易吗？<br/>
                                            此操作不可撤销，操作完成后此书将不再会被搜索到。</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                                            <a href="<?php echo site_url('book_upload/book_finish') ?>/<?php echo $item->id ?>" class="btn btn-primary">确认完成交易</a> 
                                        </div>
                                    </div>
                                </div>
<?php 
                            endforeach;
?>
                        </div>
<?php 
                    } else {
?>
                        <div class = "row-fluid">
                            <div class = "image" style = "width:100%;"> <a href="<?php echo site_url('welcome/act_detail') ?>"> <img src = "<?php echo base_url('public/img/notFound.png'); ?>" style = "width:100%;" /> </a> </div>
                        </div>
<?php
                    }
?>
                </div><!-- tab2 -->
                <div class="tab-pane fade active in" id="tab3">
<?php
                    if (count($result3) > 0) {
                        $first = true; 
?>
                        <div style = "font-family: verdana">
<?php 
                            foreach ($result3 as $item):
                                if ($first == false) {
?>
                                    <div class = "row-fluid"> <br />
                                        <br />
                                    </div>
<?php 
                                } 
                                $first = false; 
?>
                                <div class = "row-fluid">
                                    <div id = "left" class = "span3 text-center">
                                        <div class="thumbnail"> <a href = "<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>" >
                                            <div class="image" style = "width:100%"> <img src = "<?php echo base_url('get_data.php?id='.$item->id); ?>" style = "width:70%" /> </div>
                                        </a> </div>
                                    </div>
                                    <div id = "right" class = "span7 offset1">
                                        <div class = "row-fluid">
                                            <p class = "span2"> <strong> 图书名 </strong> </p>
                                            <p class = "span10"> <?php echo $item->name; ?> </p>
                                        </div>
                                        <div class = "row-fluid">
                                            <p class = "span2"> <strong> 价格 </strong> </p>
                                            <p class = "span9" style = "font-size: 17px; color: #ff0000;"> <strong> ￥<?php echo $item->price; ?> </strong> <span style = "text-decoration: line-through; font-size: 12px; color: #999"> ￥<?php echo $item->originprice; ?> </span> </p>
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
                                                if (strlen($text) > 300)
                                                  $text = $this->search_model->getstr($text, 300).' ...';
                                                echo $text;
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Button to trigger modal -->
                                    <p> <a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>"> 详细页面 </a> </p>
                                    <?php if ($item->subscriber == 'N') { ?>
                                    <p><a href="#myModal<?php echo $item->id ?>" role="button" data-toggle="modal">删除本书</a></p>
                                    <?php } ?>
                                    <p><a href="<?php echo site_url('book_upload/modify') ?>/<?php echo $item->id ?>">修改信息</a></p>
                                    <!-- <p><a href="#myModal1<?php echo $item->id ?>" role="button" data-toggle="modal">完成交易</a></p> --> 
                                    <!-- Modal -->
                                    <div id="myModal<?php echo $item->id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModalLabel">确认信息</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>真的要删除本书吗？</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                                            <a href="<?php echo site_url('book_upload/book_delete') ?>/<?php echo $item->id ?>" class="btn btn-primary">确认删除</a> 
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div id="myModal1<?php echo $item->id ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h3 id="myModal1Label">确认信息</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>您确认将本书登记为完成交易吗？<br/>
                                            此操作不可撤销，操作完成后此书将不再会被搜索到。</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
                                            <a href="<?php echo site_url('book_upload/book_finish') ?>/<?php echo $item->id ?>" class="btn btn-primary">确认完成交易</a> 
                                        </div>
                                    </div>
                                </div>
<?php                           
                            endforeach;
?>
                        </div>
<?php
                    } else {
?>
                        <div class = "row-fluid">
                            <div class = "image" style = "width:100%;"> <img src = "<?php echo base_url('public/img/notFound.png'); ?>" style = "width:100%;" /> </div>
                        </div>
<?php
                    }
?>
                </div><!-- tab3 -->
                <div class="tab-pane fade" id="tab4">
<?php
                    if (count($result4) > 0) {
                        $first = true; ?>
                        <div style = "font-family: verdana">
<?php 
                            foreach ($result4 as $item): 
                                if ($first == false) {
?>
                                    <div class = "row-fluid"> <br />
                                    </div>
<?php 
                                } 
                                $first = false; 
?>
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
                                        <p class = "span2"> <strong> 价格 </strong> </p>
                                        <p class = "span9" style = "font-size: 17px; color: #ff0000;"> <strong> ￥<?php echo $item->price; ?> </strong> <span style = "text-decoration: line-through; font-size: 12px; color: #999"> ￥<?php echo $item->originprice; ?> </span> </p>
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
                                <p> <a href="<?php echo site_url('book_details/book') ?>/<?php echo $item->id ?>"> 详细页面 </a> </p>
                                </div>
<?php 
                            endforeach;
?>
                        </div>
<?php
                    } else {
?>
                        <div class = "row-fluid">
                            <div class = "image" style = "width:100%;"> <img src = "<?php echo base_url('public/img/notFound.png'); ?>" style = "width:100%;" /> </div>
                        </div>
<?php
                    }
?>
                </div> <!-- tab4 --> 
            </div> <!-- tabcontent --> 
        </div><!-- tabbable -->
    </div><!-- content-full -->
<?php include( "includes/footer.php"); ?>
