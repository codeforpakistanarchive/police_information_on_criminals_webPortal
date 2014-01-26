    
    

<div class="row-fluid"></div>
<div class="span7 contact-forms">
<div id="alert" class="alert alert-error" style="display:none;">
</div>
<?php if($EditUser['is_admin']==1) { ?>
<h1 class="titles">Welcome <?php echo $EditUser['first_name'];?> <?php echo $EditUser['last_name'];?>  </h1>
<?php } ?>
<div class="row-fluid">
<div class="span5">

<form class="">
<?php if($EditUser['is_admin']==1) { ?>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls"> 
      <input type="text" id="email" disabled="disabled" value="<?php echo $EditUser['email'];?>" placeholder="Email">
    </div>
  </div>
  <?php } ?>
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
   <?php if($EditUser['is_admin']==0) { ?>
  <div class="control-group">
    <label class="control-label" for="zip">Zip</label>
    <div class="controls">
      <input type="text" id="zip" value="<?php echo $EditUser['zip'];?>" placeholder="zip">
    </div>
  </div>
  

 
  <div class="control-group">
    <label class="control-label" for="number_of_copies"></label>
    <div class="controls">
      <img src="<?php echo $EditUser['PhotoPath'];?>" title="<?php echo $EditUser['first_name'];?>" width="50" height="50" />
    </div>
  </div>
  
  <?php } ?>
  </div>
  <div class="span5">
   <?php if($EditUser['is_admin']==0) { ?>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls"> 
      <input type="text" id="email" disabled="disabled" value="<?php echo $EditUser['email'];?>" placeholder="Email">
    </div>
  </div>
  <?php } ?>
  <?php if($EditUser['is_admin']==1) { ?>
  <div class="control-group">
    <label class="control-label" for="password">Old Password</label>
    <div class="controls">
      <input type="password" id="old_password" value=""  placeholder="Old Password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="password">New Password</label>
    <div class="controls">
      <input type="password" id="change_password" value=""  placeholder="New Password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="State">State</label>
    <div class="controls">
      <input type="text" id="state" value="<?php echo $EditUser['state'];?>" placeholder="state">
    </div>
  </div>
  
  <?php } else { ?>
  <div class="control-group">
    <label class="control-label" for="city">City</label>
    <div class="controls">
      <input type="text" id="city" value="<?php echo $EditUser['city'];?>"  placeholder="city">
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
  <?php } ?>
  </div>
<div style="clear: both;"></div>
  <div class="control-group">
    <div class="controls">
      <button type="button" class="btn" id="editUser">Update</button>
      <input type="hidden" value="<?php echo $EditUser['user_id'];?>" id="user_id" />
      <input type="hidden" value="<?php if($EditUser['is_admin']==0) echo "0"; else echo $EditUser['is_admin'];?>" id="is_admin" />
      
      <input type="hidden" value="<?php echo $EditUser['password'];?>" id="passwords" />
      <input type="hidden" value="<?php echo $EditUser['email'];?>" id="previous_email" />
    </div>
  </div>
</form>
</div>
</div>
<div style="clear: both;"></div>

