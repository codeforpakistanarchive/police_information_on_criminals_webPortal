   $(document).ready(function (){
    $('#loginButton').click(function() {
        var admin = $("#email").val();
        if(admin=="admin"){
            
            $.ajax({
                url: "<?php echo base_url();?>api/user/login_web",
                type: "POST",
                data: {
                    email: $("#email").val(),
                    password: $("#password").val()
                },
                success: function (datas) {
                    window.location.href = "<?php echo base_url();?>home/listuser";
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#alert").show();
                    $("#alert").html(xhr.status+" - Enter Valid Email and Password");
                }
            });
            }
            else
            {
                $("#alert").show();
                $("#alert").html("403 - Not Authorize");
            }
        });
        
        
    $('#addnewUser').click(function() {
        console.log("Working Fine..");
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
                    dob: "16-02-1990",
                    number_of_copies: $("#number_of_copies").val()
                },
                success: function (datas) {
                   console.log(url);
                    $("#alert").show();
                    $("#alert").html("Account Created Successfully!");
                    //window.location.href = "http://localhost:81/landroipad/home/profile";
                },
                error:function(datas){ 
                    var Data = JSON.parse(datas.responseText);
                    var Result = Data.result;
                    var Response = Result.response;
                    console.log(Response);
                    $("#alert").show();
                    $("#alert").html(Response);
                //var response = eval('(' + datas.responseText + ')');
                 //console.log(response);
              }
            });
        });
        
       
    
    });
       