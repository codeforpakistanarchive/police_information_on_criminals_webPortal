    
    

<div class="row-fluid"></div>
<div class="span7 contact-forms">
<div id="alert" class="alert alert-error" style="display:none;">
</div>

<h1 class="titles">Welcome <?php echo $EditUser['first_name'];?> <?php echo $EditUser['last_name'];?>  </h1>

<div class="row-fluid">
<div class="span5">

<form class="">

  
 
    <div class="control-group">
    <label class="control-label" for="first_name">First name</label>
    <div class="controls">
      <input type="text" id="first_name" value="<?php echo $EditUser['first_name'];?>" placeholder="First name">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="last_name">Last name</label>
    <div class="controls">
      <input type="text" id="last_name" value="<?php echo $EditUser['last_name'];?>"  placeholder="last name">
    </div>
  </div>
  
  
  <div class="control-group">
    <label class="control-label" for="zip">Zip</label>
    <div class="controls">
      <input type="text" id="zip" value="<?php echo $EditUser['zip'];?>" placeholder="zip">
    </div>
  </div>
  
<div class="control-group">
    <label class="control-label" for="city">City</label>
    <div class="controls">
      <input type="text" id="city" value="<?php echo $EditUser['city'];?>"  placeholder="city">
    </div>
  </div>
 
  </div>
  
 
  
  <div class="span5">
   
  
  <div class="control-group">
    <label class="control-label" for="State">State</label>
    <div class="controls">
      <input type="text" id="state" value="<?php echo $EditUser['state'];?>" placeholder="state">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="mobile">old password</label>
    <div class="controls">
      <input type="password" id="old_password" value="" placeholder="old password">
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="password">New Password</label>
    <div class="controls">
      <input type="password" id="change_password" value=""  placeholder="New Password">
    </div>
  </div>
 <div class="control-group">
    <label class="control-label" for="password">Confirm New Password</label>
    <div class="controls">
      <input type="password" id="confirm_change_password" value=""  placeholder="Confirm Password">
    </div>
  </div>
  </div>
<div style="clear: both;"></div>
  <div class="control-group">
    <div class="controls">
      <button type="button" class="btn" id="editUsers">Update</button>
      <input type="hidden" value="<?php echo $EditUser['user_id'];?>" id="user_id" />
      <input type="hidden" value="<?php if($EditUser['is_admin']=="Org") echo "crime"; else echo $EditUser['is_admin'];?>" id="is_admin" />
      
      <input type="hidden" value="<?php echo $EditUser['password'];?>" id="passwords" />
      <input type="hidden" value="<?php echo $EditUser['email'];?>" id="previous_email" />
    </div>
  </div>
</form>
</div>
</div>
<div style="clear: both;"></div>

