<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>

<link href="<?php echo base_url('assets/template/default/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/template/default/css/bootstrap.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/template/default/css/app.css') ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jscript/lib/jquery-1.7.2.min.js') ?>"></script>

<script src="<?php echo base_url('assets/jscript/stupidtable.js?dev')  ?>"></script>

 <script type="text/javascript" src="<?php echo base_url('assets/jscript/jquery.fancybox-1.3.4.pack.js');?>"></script> 
 
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/template/default/css/jquery.fancybox-1.3.4.css');?>" media="screen" />
<script>
    $(function(){
        $("table").stupidtable();
    });
  </script>
  
<style type="text/css">
    table {
      border-collapse: collapse;
    }
   
      th, td {
    border: 1px solid #0E116A;
    padding: 0 26px;
    }

    th {
      
    }
    th[data-sort]{
      cursor:pointer;
    }
    tr.awesome{
      color: red;
    }
  </style>
<script type="text/javascript">
  window.history.forward(); 

       $(document).ready(function (){
    $('#loginButton').click(function() {
        var admin = $("#email").val();
        
            
            $.ajax({
                url: "<?php echo base_url();?>api/user/login_web",
                type: "POST",
                data: {
                    email: $("#email").val(),
                    password: $("#password").val()
                },
                success: function (datas) {
                    console.log(datas);
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    var statusss = Result.status;
                   if(statusss=="success"){window.location.href="<?php echo base_url();?>home/listuser";}
                   else{
                    $("#alert").show();
                    $("#alert").html(Response);}
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(datas);
                    $("#alert").show();
                    $("#alert").html(xhr.status+" - Enter Email and Password");
                }
            });
           
        });
        
        $(".showTr").live('click',function(event){
            var id = $(this).attr("id");
            $("tr.hidess").show("slow");
            $("tr#"+id).show("slow");
        }); 
    $('#addnewUser').click(function() {
            var password = $("#password").val();
            var confirm  = $("#Confirmpassword").val();
            
            if(password==confirm){
           $.ajax({
                url: "<?php echo base_url();?>api/user/signup",
                type: "POST",
                
                data: {
                    email: $("#email").val(),
                    password: $("#password").val(),
                    city: $("#city").val(),
                    state: $("#state").val(),
                    zip: $("#zip").val(),
                    address: $("#address").val(),
                    mobile: $("#mobile").val(),
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    dob: "16-02-1990"
                   
                },
                success: function (datas) {
                   
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    var statusss = Result.status;
                   if(statusss=="success"){window.location.href="<?php echo base_url();?>home/listuser";}
                    else{$("#alert").show();
                    $("#alert").html(Response);}
                    
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    
                    $("#alert").show();
                    $("#alert").html(Response);
                    
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
            }
            else
            {
                $("#alert").show();
                $("#alert").html("Password not match");
            }
        });
		
		
		
		$('#addnewCriminal').click(function() {
            var password = $("#age").val();
            var confirm  = $("#wantedrate").val();
            
            if(password!="" && confirm!=""){
           $.ajax({
                url: "<?php echo base_url();?>api/user/addcriminal",
                type: "POST",
                
                data: {
                    color: $("#color").val(),
                    age: $("#age").val(),
                    heightfeet: $("#heightfeet").val(),
                    heightinch: $("#heightinch").val(),
                    wantedrate: $("#wantedrate").val(),
                    gender: $("#gender").val(),
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
					isarrest: $("#isarrest").val(),
					OrganizationUniqueId: $("#OrganizationUniqueId").val()
                   
                   
                },
                success: function (datas) {
                   
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    var statusss = Result.status;
                   if(statusss=="success"){window.location.href="<?php echo base_url();?>home/listuser";}
                    else{$("#alert").show();
                    $("#alert").html(Response);}
                    
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    
                    $("#alert").show();
                    $("#alert").html(Response);
                    
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
            }
            else
            {
                $("#alert").show();
                $("#alert").html("Fill All Field");
            }
        });
        
       
    
    });
       
        function CallPopUp(id,admin){
			console.log(id);
			console.log(admin);
			if(admin==1){
		// pop up handler
		$("#"+id).live(
			"click",
				function( event ){

					// get the id of the item clicked on
					var id = $(this).attr('id');
						$.fancybox({
							'autoDimensions':	false,
							'speedIn'		:	600,
							'speedOut'		:	200,
							'overlayShow'	:	true,
							'width'			:	800,
							'height'		:	600,
							
							'scrolling'		:	'no',
							'transitionIn'	:	'elastic',
							'transitionOut'	:	'fade',
							'enableEscapeButton'	: 'true',
							'overlayOpacity'		: 0.5,
							'href'			: '<?php echo base_url();?>api/user/edit_profile?user_id='+id,
							'onClosed'		: function() {
								$("table").stupidtable();
                                window.location.reload();
							}
						});

				// block the href actually working
				return( false );
								}
			);
			}
			else
			{
				// pop up handler
		$("#"+id).live(
			"click",
				function( event ){

					// get the id of the item clicked on
					var id = $(this).attr('id');
						$.fancybox({
							'autoDimensions':	false,
							'speedIn'		:	600,
							'speedOut'		:	200,
							'overlayShow'	:	true,
							'width'			:	800,
							'height'		:	600,
							
							'scrolling'		:	'no',
							'transitionIn'	:	'elastic',
							'transitionOut'	:	'fade',
							'enableEscapeButton'	: 'true',
							'overlayOpacity'		: 0.5,
							'href'			: '<?php echo base_url();?>api/user/edit_org?org_id='+id,
							'onClosed'		: function() {
								$("table").stupidtable();
                                window.location.reload();
							}
						});

				// block the href actually working
				return( false );
								}
			);
			}
	
		$("table").stupidtable();
        
        
        $('#editUser').live('click',function(event) {
			if(admin==1){
        console.clear();
        console.log("Working fine ....");
        var is_admin = $("#is_admin").val();
        var id = $("#user_id").val();
        
        var password;
       
        
        if(is_admin==1){
            var passwords = $("#passwords").val();
            var changes = $("#change_password").val();
            var old_password= $("#old_password").val();
            var confirm_change_password = $("#confirm_change_password").val();
        if(changes==confirm_change_password){
           $.ajax({
                url: "<?php echo base_url();?>api/user/edituser?user_id="+id,
                type: "GET",
                data: {
                    email: $("#email").val(),
                    password: passwords,
                    change: changes,
                    old_password: old_password,
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    is_admin: $("#is_admin").val()
                },
                success: function (datas) {
                   
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    $("#alert").show();
                    $("#alert").html(Response);
                    if(Response=="Updated Successfully"){
                    $("#alert").css('background','#dff2bf');
                    $("#alert").css('color','#4a850b');}
                    
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    
                    $("#alert").show();
                    $("#alert").html(Response);
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
            }
            else{
                    $("#alert").show();
                    $("#alert").html("Confirm password not match!");
            }
           }
           else{
                    var number_of_copies = $("#number_of_copies").val();
                    var passwords        = $("#passwords").val();
                    var changes          = $("#change_password").val();
                    var old_password     = $("#old_password").val();
                    var remaining_copies = $("#remaining_copies").val();
                    var number_of_copies_db = $("#number_of_copies_db").val();
                    if(number_of_copies!=""){
                        $.ajax({
                url: "<?php echo base_url();?>api/user/edituser?user_id="+id,
                type: "GET",
                data: {
                    email: $("#email").val(),
                    password: passwords,
                    change: changes,
                    previous_email: $("#previous_email").val(),
                    old_password: old_password,
                    city: $("#city").val(),
                    state: $("#state").val(),
                    zip: $("#zip").val(),
                    number_of_copies_db: number_of_copies_db,
                    mobile: $("#mobile").val(),
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    dob: "16-02-1990"
                },
                success: function (datas) {
        
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    $("#alert").show();
                    $("#alert").html(Response);
                    if(Response=="Updated Successfully"){
                    $("#alert").css('background','#dff2bf');
                    $("#alert").css('color','#4a850b');}
                   
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    $("#alert").show();
                    $("#alert").html(Response);
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
                    }
                    else{
                    $("#alert").show();
                    $("#alert").html("Fill number of copies");
                    
                    }
           }
			}
		});
		$('#editUsers').live('click',function(event) {
			
				 console.clear();
        console.log("Working fine ....");
        var is_admin = $("#is_admin").val();
        var id = $("#user_id").val();
        
        var password;
       
        console.log(is_admin);
        if(is_admin=="Org"){
            var passwords = $("#passwords").val();
            var changes = $("#change_password").val();
            var old_password= $("#old_password").val();
            var confirm_change_password = $("#confirm_change_password").val();
        if(changes==confirm_change_password){
           $.ajax({
                url: "<?php echo base_url();?>api/user/addCriminal?user_id="+id,
                type: "GET",
                data: {
                    email: $("#email").val(),
                    password: passwords,
                    change: changes,
                    old_password: old_password,
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    is_admin: $("#is_admin").val()
                },
                success: function (datas) {
                   
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    $("#alert").show();
                    $("#alert").html(Response);
                    if(Response=="Updated Successfully"){
                    $("#alert").css('background','#dff2bf');
                    $("#alert").css('color','#4a850b');}
                    
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    
                    $("#alert").show();
                    $("#alert").html(Response);
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
            }
            else{
                    $("#alert").show();
                    $("#alert").html("Confirm password not match!");
            }
           }
           else{
                    
                    var passwords        = $("#passwords").val();
                    var changes          = $("#change_password").val();
                    var old_password     = $("#old_password").val();
                    var idss = $("#user_id").val();
                    
                        $.ajax({
                url: "<?php echo base_url();?>api/user/editorg?orgs_id="+idss,
                type: "GET",
                data: {
                    email: $("#email").val(),
                    password: passwords,
                    change: changes,
                    previous_email: $("#previous_email").val(),
                    old_password: old_password,
                    city: $("#city").val(),
                    state: $("#state").val(),
                    zip: $("#zip").val(),
                    mobile: $("#mobile").val(),
                    first_name: $("#first_name").val(),
                    last_name: $("#last_name").val(),
                    dob: "16-02-1990",
                    is_admin: $("#is_admin").val()
                },
                success: function (datas) {
        
                    var Data = JSON.parse(datas);
                    var Result = Data.result;
                    var Response = Result.response;
                    $("#alert").show();
                    $("#alert").html(Response);
                    if(Response=="Updated Successfully"){
                    $("#alert").css('background','#dff2bf');
                    $("#alert").css('color','#4a850b');}
                   
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    $("#alert").show();
                    $("#alert").html(Response);
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
                    
           }
			
        });
      
        }

		
	</script>
</head>

<body>

<div class="row-fluid">
    <div class="offset1 span10 navbars">
        <ul class="dropdown">
            <li><a href="<?php echo base_url();?>" title="Police information on criminals"><img src="<?php echo base_url('assets/template/default/images/logo.png');?>" /></a></li>
            <?php if($session_id!=""){?>
            <li class="offset2"><a href="<?php echo base_url();?>home/listuser">Organization List</a></li>
            <li><a id="" href="<?php echo base_url();?>home/addnew">Add New</a></li>
           <?php if($is_admin==1) { ?><li style="cursor: pointer;"><a href="<?php echo base_url();?>home/addCriminal" id="<?php echo $session_id?>">Add Criminal</a></li> <li style="cursor: pointer;"><a onclick="CallPopUp(<?php echo $session_id?>,<?php echo $is_admin;?>)" id="<?php echo $session_id?>">Update Profile</a></li> <?php } else { ?>
           <li style="cursor: pointer;"><a href="<?php echo base_url();?>home/addCriminal" id="<?php echo $session_id?>">Add Criminal</a></li>
           <?php } ?>
            <li><a  href="<?php echo base_url();?>home/signout">Sign Out</a></li>
            <?php } ?>
        </ul>
    </div>
</div>