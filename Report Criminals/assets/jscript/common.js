/*********** Common Functions ************/
var common = new function() {
	
	this.hideDiv = function(div_id, duration)
	{	
		if(duration != undefined)
		{
			setTimeout(function(){
			$("#"+div_id).css('display','none');
			$("#"+div_id).fadeOut('slow');
								},duration);	
		}
		else
		{
			setTimeout(function(){
			$("#"+div_id).css('display','none');
			$("#"+div_id).fadeOut('slow');
								},5000);	
		}
	}
	
	this.refreshPage = function ()
	{
		setTimeout(function(){
			window.location = document.location.href;	
		},3000);
	}
};

/*********** Ajax Functions ************/

var ajax = new function() {
	
	/*
		This is wrapper method for ajax request	
		@param url where request goes
		@param request_method (which kind of request POST OR GET 
		@param parameters using query string.
		
	*/
	this.sendRequest = function(url, request_method, parameters, successFunc, errorFunc)
	{
		$.ajax(
		{
			url: url,
			type: request_method,
			data: parameters,			  
			cache: false,
			dataType: "html",
			success: function(data)
			{
				successFunc(data);
			},
			error: function(data)
			{
				errorFunc(data);
			},
			statusCode:
			{
				404: function() 
				{
					errorFunc("");
				}
			}
		}
		);
	}

};


var page = new function()
{
	this.currentFeed = "";
	
	this.getContents = function(url, postData, targetDiv)
	{			
		ajax.sendRequest(
			url,
			"POST",
			postData, 
			function(result) { 
				var res = result.split(app.responseSeparator);
				$("#right_nav").html(result);
				/*if( res[0] == 'error' )
					app.showErrorMessage(res[1]);
				else if( res[0] == 'success' )
				{
					$("#"+targetDiv).html(res);
					$("#venue" + venueId).addClass("selected");
				}*/
			},
			
			function(result) { /*alert(result);*/ }
		);
	
	}
}

$(function() {
   $('#upload_file').submit(function(e) {
      e.preventDefault();
      $.ajaxFileUpload({
         url         :'/upload/upload_file/', 
         secureuri      :false,
         fileElementId  :'userfile',
         dataType    : 'json',
         data        : {
            'title'           : ''
         },
         success  : function (data, status)
         {
			 
            if(data.status != 'error')
            {
               //$('#files').html('<p>Reloading files...</p>');
               //refresh_files();
               //$('#title').val('');
            }
            alert(data.msg);
         }
      });
      return false;
   });
});


/*********** Ajax Functions ************/

var listing = new function() {
	
	/*
		This is wrapper method for ajax request	
		@param url where request goes
		@param request_method (which kind of request POST OR GET 
		@param parameters using query string.
		
	*/
	this.showListing = function(start, targetUrl, templateDiv)
	{
		 var page   =   $("#page").val();
		 $("#page_no").val(start);
		 var param  =   "page="+page+"&start="+start+"&template="+encodeURIComponent($("#"+templateDiv).html());
		 ajax.sendRequest(
				app.urlPrefix  + targetUrl,
				"POST",
				param, 
				function(result){
					var res = result.split(app.responseSeparator);
					if(res[0] == "success")
					{
					   $("#table_div").html(res[1]);
					}
					if(res[2] != '')
					{
						$("#page_record_count").val(res[2]);
					}
				},
				
				function(result) { /*alert(result);*/ }
			);
	}

};



/*********** POPUP Functions ************/

var popup = new function() {

	this.open_popup_at_loc = function(heading,popup_for,content_url,w,h,l,t,parameters)
	{
		
		var width=640;
		var height=480;
		if(w)
			width=w;
		if(h)
			height=h;
		
		var msg_div='inner_data';
		document.getElementById('popup_heading').innerHTML=heading;
		document.getElementById('popup').style.width=width+'px';
		document.getElementById('popup').style.height=height+'px';
		document.getElementById('popup_innerBody').style.height=(height-50)+'px';
		
		if(popup_for == "iframe")
		{
			$('#popup_innerBody').html('');
			$('#popup_innerBody').html("<iframe name=\"popup_form\" id=\"popup_form\" src=\""+content_url+"\" height=\"99%\" width=\"99%\" frameborder=\"0\"></iframe>");
			$('#popup_innerBody').bgColor='#000000';
			$('#popup_form').css('display','block');	
		}
		else if(popup_for == "no_iframe")
		{
			$('#popup_innerBody').html("");
			$.ajax(
					{
					  url: content_url,
									  data: parameters,
					  type: "POST",			  	  
					  cache: false,
					  dataType: "html",
					  success: function(data)
					  {
						$('#popup_innerBody').html(data); 	  				 			 
					  },
					  error: function(data)
					  {
							//alert(":: Error ::"+data);  
					  },
					  statusCode: {
									404: function() 
									{
									  alert('page not found');
									}
								  }
					}
				 );	
		
		}
		
		show_popup_at_loc(width,height,l,t);
		//get_page(msg_div,url,'');
		
	}

	this.show_popup_at_loc = function(PopupWidth,PopupHeight,PopupLeft,PopupTop)
	{
		var docSize=getDocSize();
		var height=docSize['height'];
		var width=docSize['width'];
		
		var top="";
		if (PopupTop=="")
			top=(height-PopupHeight)/2;
		else
			top = PopupTop;
		
		var left="";	
		if (PopupLeft=="")
			left=(width-PopupWidth)/2;
		else
			left = PopupLeft;
			
		
		
	   // document.getElementById('popup').style.left=left+'px';
		//document.getElementById('popup').style.top=top+'px';
		
		 document.getElementById('popup').style.left=left+'px';
		document.getElementById('popup').style.top=top+'px';
		
		//Effect.Appear('popup');
		//$('popup').style.display='block';
		setTimeout("document.getElementById('popup').style.display='block'",500);
		
		document.getElementById('popup').style.position='absolute';
		//if(navigator.appName!='Microsoft Internet Explorer')
	   document.getElementById('black_back').style.display='block';
		document.getElementById('black_back').className='plain_disable';//Added where we want to have static disable background without colored disable layer
	}
		
	this.close_popup = function(optional)
	{
		document.getElementById('black_back').style.display='none';
		document.getElementById('popup').className='';//Removing class so that nothing old effect available
		//Effect.Fade('popup');
		document.getElementById('black_back').style.display='none';
		document.getElementById('popup').style.display='none';
		document.getElementById('popup_innerBody').innerHTML = "";
	   // $('popup_form').src='';
		if (typeof optional == "undefined")
			window.location.reload();
	//	$('popup_innerBody').innerHTML="<div class=\"message_box\">Loading...</div>";	
		if(($('#hdn_last_queue_id') && $('#hdn_last_queue_id').val()!="") || parent.$("#hdn_last_queue_id") && parent.$("#hdn_last_queue_id").val()!="") 
			parent.$("#progress_message").css('display',"block");	
		
	}
		
	this.findPosX = function(obj)
	{
		var curleft = 0;
		
		if(obj.offsetParent)
		{
			while(1)
			{
				curleft += obj.offsetLeft;
				if(!obj.offsetParent)
					break;
				obj = obj.offsetParent;
			}
		}
		else if(obj.x)
		{
			curleft += obj.x;
		}
		
		obj.style.position = "static";
		
		return curleft;
	}
	
	this.findPosY = function(obj)
	{
		var curtop = 0;
		
		if(obj.offsetParent)
		{
			while(1)
			{
			  curtop += obj.offsetTop;
			  if(!obj.offsetParent)
				break;
			  obj = obj.offsetParent;
			}
		}
		else if(obj.y)
		{
			curtop += obj.y;
		}
		
		return curtop;
	}
	
	this.findPos = function(obj)
	{
		var left = findPosX(obj);
		var top = findPosY(obj);
		
		return [left , top];
	}
	
	this.findPosition = function( oElement )
	{
		if( typeof( oElement.offsetParent ) != 'undefined' )
		{
			for( var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent )
			{
			posX += oElement.offsetLeft;
			posY += oElement.offsetTop;
			}
			return [ posX, posY ];
		} else {
			return [ oElement.x, oElement.y ];
		}
	}
	
	this.getDocSize = function()
	{
		var myWidth = 0, myHeight = 0;
		if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		}
		else if( document.documentElement &&
				( document.documentElement.clientWidth || document.documentElement.clientHeight ) )
		{
			//IE 6+ in 'standards compliant mode'
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}
		var docSize=new Array();
		docSize['width']=myWidth;
		docSize['height']=myHeight;
		return docSize;
	}	
	
	this.close_popup1 = function()
	{
	
		formVisible=false;
		 close_popup('no');
		//close_popup("noload");
	}	

};