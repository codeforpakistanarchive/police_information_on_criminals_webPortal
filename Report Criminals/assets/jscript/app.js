/****** App specific functions ******/
var app = new function() {
    
	// Constant Declarations
	this.responseSeparator = "|~|";
	this.urlPrefix = "/";
	this.refreshInterval = "10000"; //1000 = 1 second
	
	this.setMessageClass = function (type, which) {
		
		if(typeof which === "undefined")
			which = "";
		else
			which = "_" + which;
			
		if(type == "success")
		{
			$('#error_msg' + which).removeClass("error");
			$('#error_msg' + which).addClass("success");
		}
		else
		{
			$('#error_msg' + which).removeClass("success");
			$('#error_msg' + which).addClass("error");
		}
		
	};
	
	this.showSuccessMessage = function (text, which){
		this.setMessageClass("success", which);
		this.showMessage(text, which);
	};
	
	this.showErrorMessage = function (text, which){
		this.setMessageClass("error", which);
		this.showMessage(text, which);
	};
	
	this.showMessage = function (text, which){
		
		if(typeof which === "undefined")
			mywhich = "";
		else
			mywhich = "_" + which;
			
		$('#error_msg' + mywhich).html( text );
		$('#error_msg' + mywhich).fadeIn("slow");
		
		setTimeout( function() { app.hideMessage(which); }, 5000 );
	};
		
	this.hideMessage = function (which){
		if(typeof which === "undefined")
			mywhich = "";
		else
			mywhich = "_" + which;
			
		$('#error_msg' + mywhich).fadeOut("slow");
	};
	
}

// Created By: M.Rizwan
// Created On: Jun 1, 2012
// Description: Fires on keydown event of pages. If We have set ControlToTriggeronEnter variable in JS,
//              this function will call its click event on Enter key, otherwise will not do anything.
document.onkeydown = function (e) {

    if ((typeof ControlToTriggeronEnter !== 'undefined') && ControlToTriggeronEnter != '') {
        var keyEvent;
        if (e) {
            keyEvent = e;
        }
        else {
            keyEvent = window.event;
        }
        if (keyEvent.keyCode == 13 && keyEvent.target.type == 'text') {
            if (keyEvent.stopPropagation) {
                keyEvent.stopPropagation();
                keyEvent.cancelBubble = true;
                keyEvent.returnValue = false;
                ControlToTriggeronEnter.trigger("click");
                return false;
            }
        }
    }
}

// Created By: M.Rizwan
// Created On: Jun 1, 2012
// Description: Fires when page is ready. If We have set ControlToFocus variable in JS,
//              this function will setfocus to it, otherwise will not do anything.
$(document).ready(function () {
    if ((typeof ControlToFocus !== 'undefined') && ControlToFocus != '') {
        ControlToFocus.focus();
    }
	
	if ((typeof FunctionToCallOnStartup !== 'undefined') && typeof FunctionToCallOnStartup == "function") {
        FunctionToCallOnStartup();
    }
});