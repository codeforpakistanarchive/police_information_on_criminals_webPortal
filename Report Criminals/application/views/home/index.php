<?php
	$this->includes->use_stylesheet('app.css');
    
	$this->includes->use_javascript(array('lib/jquery.js', 'app.js', 'common.js','jquery.form'));
	
	$data['title'] = "Police information on criminals";
	$this->load->view('web/_header', $data);

?>

<div class="row-fluid"></div>
<div class="offset3 span5 contact-forms">
    <h1 class="offset1 titles">Sign in</h1>
<div id="alert" class="offset1 alert alert-error" style="display:none;">
</div>
<form class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="email" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="password" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="button" class="btn" id="loginButton">Sign in</button>
    </div>
  </div>
</form>
</div>
</div>
<div style="clear: both;"></div>



<?php
	$this->load->view('web/_footer');
?>
