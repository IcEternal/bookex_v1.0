

<?php $this->load->view('includes/header') ?>

<?php $this->load->view($page, $info) ?>


<script src="<?php echo base_url() ?>public/js/jquery-1.9.1.min.js"></script>
<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
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
</body>
</html>
