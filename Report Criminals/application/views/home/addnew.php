<?php
	$this->includes->use_stylesheet('app.css');
	$this->includes->use_javascript(array('lib/jquery.js', 'app.js', 'common.js','jquery.form'));
	$data['title'] = "Police information on criminals";
	$this->load->view('web/_header', $data);

?>
<script>
$(function(){
    var $form = $('#myform'),
        $result = $('#result');
                     
    $('form').delegate('#image', 'change', function(){
        $result.ajaxStart(function(){
            $(this).text('Loading....');
        });
        $form.ajaxForm({
            target: $result
        }).submit();
    });
                
})
</script>
<div class="row-fluid"></div>
<div class="offset3 span9 contact-forms">
    <h1 class="titles">Add New Organization</h1>
<div id="alert" class="alert alert-error" style="display:none;">
</div>
<div class="row-fluid">
<div class="span5">
<form>
    <div class="control-group">
    <label class="control-label" for="first_name">First name</label>
    <div class="controls">
      <input type="text" id="first_name" placeholder="First name">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="last_name">Last name</label>
    <div class="controls">
      <input type="text" id="last_name" placeholder="last name">
    </div>
  </div>
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
    <label class="control-label" for="inputPassword">Confirm Password</label>
    <div class="controls">
      <input type="password" id="Confirmpassword" placeholder="Password">
    </div>
  </div>
  </div>
  <div class="span5">
  <div class="control-group">
    <label class="control-label" for="city">City</label>
    <div class="controls">
      <input type="text" id="city" placeholder="city">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="State">State</label>
    <div class="controls">
      <input type="text" id="state" placeholder="state">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="zip">Zip</label>
    <div class="controls">
      <input type="text" id="zip" placeholder="zip">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="mobile">mobile</label>
    <div class="controls">
      <input type="text" id="mobile" placeholder="mobile">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="address">Address</label>
    <div class="controls">
      <textarea id="address" style="height: 100px;;"></textarea>
    </div>
  </div>
  </div>
<div style="clear: both;"></div>
  <div class="control-group">
    <div class="controls">
      <button type="button" class="btn" id="addnewUser">Add</button>
    </div>
  </div>
</form>

</form>
</div>
</div>
<div style="clear: both;"></div>



<?php
	$this->load->view('web/_footer');
?>
