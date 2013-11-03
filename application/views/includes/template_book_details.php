<?php
/*
================================================================
template_book_details.php

The template_book_details page.( It's a fool page........)

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 
?>
<?php $this->load->view('includes/header') ?>

<script type="text/javascript">
  $("#phoneInfo").modal('show');
</script>
<script type="text/javascript">
	if ($("#phoneInfo").size()<=0) 
		$("#shareInfo").modal('show');
</script>

<script type="text/javascript">
	$("#ticketInput").modal('show');
</script>
<script type="text/javascript">
  $("#do_not_use_phone").click(function() {
  	$("#shareInfo").modal('show');
  });
</script>

<?php $this->load->view($page, $info) ?>