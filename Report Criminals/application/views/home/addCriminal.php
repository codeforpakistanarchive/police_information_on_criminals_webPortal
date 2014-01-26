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
    <h1 class="titles">Add New Criminal </h1>
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
    <label class="control-label" for="inputEmail">Age</label>
    <div class="controls">
      <input type="text" id="age" placeholder="age">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">color</label>
    <div class="controls">
      <input type="text" id="color" placeholder="White">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Gender</label>
    <div class="controls">
      <select id="gender">
      <option value="male">Male</option>
      <option value="female">Female</option>
      </select>
    </div>
  </div>
  </div>
  <div class="span5">
  <div class="control-group">
    <label class="control-label" for="city">Height Feet</label>
    <div class="controls">
      <input type="text" id="heightfeet" placeholder="4">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="State">Height Inch</label>
    <div class="controls">
      <input type="text" id="heightinch" placeholder="0">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="zip">Wanted Rate</label>
    <div class="controls">
      <input type="text" id="wantedrate" placeholder="0-5">
    </div>
  </div>
  <select id="isarrest">
      <option value="no">No</option>
      <option value="yes">Yes</option>
      </select>
  <input type="hidden" id="OrganizationUniqueId" value="<?php echo $OrganizationUniqueId;?>"/>
  </div>
<div style="clear: both;"></div>
  <div class="control-group">
    <div class="controls">
      <button type="button" class="btn" id="addnewCriminal">Add</button>
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
