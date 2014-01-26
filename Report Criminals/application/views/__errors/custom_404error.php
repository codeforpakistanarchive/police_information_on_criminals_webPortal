<?php
	$this->includes->use_stylesheet('app.css');
	$this->includes->use_javascript('lib/jquery.js');
	
	$data['title'] = "Page not found";
	$this->load->view('web/_header', $data);
?>
<div id="content">
	<h1><?php echo "Page not found"; ?></h1>
</div>
<?php $this->load->view('web/_footer'); ?>
