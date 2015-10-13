/* Common List and Validation functions and Common functions */ 

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

	$('.required').each(function() {
		if( $.trim($(this).val()).length === 0 ) 
		{
			setStyle(this);
			blnError	=	true;
		}
		else
		{
			resetStyle(this);	
		}
	}); 	

	if(blnError	== true)
	{
		alert('Please enter highlighted fields.');	
		return false;
	}

	// Check Email Fields
	$('.isemail').each(function() {
		strEmailVal		=	$(this).val();	
		blnIsValidEmail	=	true;

		blnIsValidEmail	=	checkValidEmail(strEmailVal);
		
		if(blnIsValidEmail == false)
		{
			setStyle(this);
			blnEmailError	=	true;
		}
		else
		{
			resetStyle(this);	
		}

		if(blnEmailError == true)
		{
			alert('Please enter valid Email.');	
			return false;
		}
	});
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
 var emailReg = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
 // var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

 if(strEmailVal == '') {
  isValid = false;
 }
 else if(!emailReg.test(strEmailVal)) {
  isValid = false;
 }

 return isValid;
}