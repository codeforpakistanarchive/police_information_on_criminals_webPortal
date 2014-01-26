<?php
	$this->includes->use_stylesheet('app.css');
    
	$this->includes->use_javascript(array('lib/jquery.js', 'app.js', 'common.js'));
	
	$data['title'] = "Landro - Home";
	$this->load->view('web/_header', $data);

?>

<div class="row-fluid">

    <div class="offset2 span8">
        <h1 class="titles">Welcom!</h1>
    </div>
    
</div>

<div style="clear: both;"></div>



<?php
	$this->load->view('web/_footer');
?>
