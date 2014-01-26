<?php
	$this->includes->use_stylesheet('app.css');
	$this->includes->use_javascript(array('lib/jquery.js', 'lib/jquery.validate.js', 'app.js', 'common.js'));
	
	$data['title'] = "Login - " . SITE_TITLE;
	$this->load->view('web/_header', $data);
?>


  <!-- Your HTML Goes here -->



<script language="javascript">	
	// This is variable which is used by keydown event ( written in app.js ).
	// If we set it, its click event will be fired on Enter key
	var ControlToTriggeronEnter = ''; //$('#btnLogin');
	
	// This is variable which is used by document.ready event ( written in app.js ).
	// If we set it, it will be focussed on page load
	var ControlToFocus = ''; //$('#txtUsername');
	
	// This is variable which is used by document.ready event ( written in app.js ).
	// If we set it, it will be used to call the function on page startup
	var FunctionToCallOnStartup = ''; load_my_data;
</script>

<?php
	$this->load->view('web/_footer');
?>