/* Common List and Validation functions and Common functions */

$(document).ready(function() {
	$('.date-picker').datepicker();
	/*$('.date-picker').datepicker().next().on(ace.click_event, function(){
		$(this).prev().focus();
	});*/
	$('.date-picker').on('changeDate', function(ev){
		$(this).datepicker('hide');
	});
	$(".chzn-select").chosen();
	$('[data-rel=popover]').popover({html:true});
}); 

Array.prototype.contains = function (element) 
{
	for (var i = 0; i < this.length; i++) 
	{
		if (this[i] == element) 
		{
			return true;
		}
	}
	
	return false;
}

function trim(str)
{
    if(!str || typeof str != 'string')
        return '';
    return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

function checkAll(strName)
{
	if( $("#chkAll_"+strName).is(':checked') )
	{
		$("input[name='chk_lst_"+strName+"[]']").each(function(index){
			$(this).attr("checked","checked");
		});
	}
	else
	{
		$("input[name='chk_lst_"+strName+"[]']").each(function(index){
			$(this).attr("checked",false);
		});
	}
}

function submit_form(form)
{
	var formid	=	form.id;
	var blnError	=	false;
	
	$(".errmsg").remove();

	$('#'+formid+' .required').each(function() {
		if( $.trim($(this).val()).length == 0 ) 
		{
			//alert(this.id);
			setStyle(this);
			//$(this).after('<span class="errmsg">* This field is required.</span>');
			blnError	=	true;
		}
		else
		{
			resetStyle(this);	
		}
	}); 	

	if(blnError	== true)
	{
		// alert('Please enter highlighted fields.');	
		return false;
	}

	// Check Email Fields
	$('#'+formid+' .isemail').each(function() {
		strEmailVal		=	$(this).val();	
		blnIsValidEmail	=	true;
		

		if(strEmailVal != "")
			blnIsValidEmail	=	checkValidEmail(strEmailVal);
		
		if(blnIsValidEmail == false)
		{
			setStyle(this);
			$(this).after('<span class="errmsg red clearfix">Please enter valid Email</span>');
			blnError	=	true;
		}
		else
		{
			resetStyle(this);
		}
	});
	
	if(blnError == true)
	{
		return false;
	}
	
	// Check Number Fields
	$('#'+formid+' .isnumber').each(function() {
		var numberRegex = "/^[0-9]+$/";
		blnIsNumber	=	true;
		intNumberVal		=	$(this).val();
		if(intNumberVal != "")
		{
			
			var check = isNaN(intNumberVal);
			
			if(check != false)
			{
				blnIsNumber = false;
				
			}
		}
		
		if(blnIsNumber == false)
		{
			setStyle(this);
			$(this).after('<span class="errmsg red clearfix">Please enter numeric value</span>');
			blnError	=	true;
		}
		else
		{
			resetStyle(this);
		}
	});
	
	if(blnError == true)
	{
		return false;
	}
	
	
	// Check for extraValid function
	if (typeof extraValid == 'function') 
	{
        return extraValid();
    }
	return true
}

function setStyle(element)
{
	//element.style.border	=	'1px solid #F00';
	$(element).addClass('border-red');
}

function resetStyle(element)
{
	//element.style.border	=	'none;';
	$(element).removeClass('border-red');
}

function checkValidEmail(strEmailVal)
{
	var isValid = true;
 	//var emailReg = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
	var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

	if(strEmailVal == '') {
		isValid = false;
	}
	else if(!emailReg.test(strEmailVal)) {
		isValid = false;
	}

 return isValid;
}

function OnlyNumeric(val) {
    val = (val) ? val : window.event;
    var charCode = (val.which) ? val.which : val.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //alert("This field accepts numbers only.");
        return false;
    }   
    return true;
}

function windowOpen(theURL,winName,width,height,left,top)
{
	var win;
	var features='toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=no,width='+width+',height='+height+',left='+left+',top='+top+',screenX='+left+',screenY='+top;
	win=window.open(theURL,winName,features);
	win.focus();
}


function onClickFunc(objControl, strMsg)
{
	if(objControl.value == strMsg)
		objControl.value = '';
}

function onBlurFunc(objControl, strMsg)
{
	if(objControl.value == '')
		objControl.value = strMsg;
}

function gotoURL(strHref)
{
	window.location.href = strHref;	
}

// print html content
function printContent(el){
	$('body').removeClass('navbar-fixed');
	var restorepage = document.body.innerHTML;
	$(".non-printable").hide();
	var printcontent = document.getElementById(el).innerHTML;
	console.log(printcontent);
	document.body.innerHTML = printcontent;
	window.print();
	$('body').addClass('navbar-fixed');
	document.body.innerHTML = restorepage;
}


