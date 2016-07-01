





function lengthrestriction(id,lbl_id,msg,minval,maxval)
{
var elem =document.getElementById(id).value;
var msg1='';
var condition='';
	
	if(minval!="" && minval=="")
	{
		condition = elem.length<minval;
		msg1=msg+" Should be greater than "+minval;
	}
	else if(minval=="" && minval!="")
	{
		condition = elem.length>maxval;
		msg1=msg+" Should be less than "+maxval;
	}
	else if(minval!="" && minval!="")
	{
			condition =elem.length<minval || elem.length>maxval;
			msg1=msg+" Should be greater than "+minval+" and less than "+maxval;
	}
	if(condition)
			{ 
			document.getElementById(lbl_id).innerHTML=msg1;
			return false;
			}
			else
			{
			document.getElementById(lbl_id).innerHTML="";
			return true;
			}
	
}


function isalphanumeric(id,lbl_id,msg)
{
var elem =document.getElementById(id).value;
var alphaExp = /^[0-9a-zA-Z]+$/;
	
			if(elem.length<3 || elem.length>128)
			{ 
			document.getElementById(lbl_id).innerHTML=msg+" length must be within 3 to 128.";
			return false;
			}
			else
			{
					if(elem.match(alphaExp)){
					document.getElementById(lbl_id).innerHTML="";
						return true;
					}else{
						document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Alphanumeric";
						return false;
					}
			}
	
}


function isnumeric(id,lbl_id,msg)
{
var elem =document.getElementById(id).value;
var alphaExp = /^[0-9]+$/;
			
	if(elem.match(alphaExp)){
		document.getElementById(lbl_id).innerHTML="";
			return true;
		}else{
			document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Numeric";
			return false;
		}
			
}

function ischar(id,lbl_id,msg)
{
	var elem =document.getElementById(id).value;
	var alphaExp = /^[a-zA-z ,  ]+$/;
	if(elem.match(alphaExp)){
		document.getElementById(lbl_id).innerHTML="";
			return true;
		}else{
			document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Character";
			return false;
		}
			
	
}


function madeselection(id,lbl_id,msg)
{
	
	var elem =document.getElementById(id).value;
	if(elem.length==0)
	{
	document.getElementById(lbl_id).innerHTML="Please select "+msg;
	return false;
	}
	else
	{
	document.getElementById(lbl_id).innerHTML="";
	return true;
	}
}


function urlvalidation(id,lbl_id)
{
		var url = document.getElementById(id).value;
		//alert(url);
        var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        if (pattern.test(url)) {
           document.getElementById(lbl_id).innerHTML="";
			return true;
        }
		else
		{
				document.getElementById(lbl_id).innerHTML="Please enter valid url";
			return false;
		}
}

function chk_telephone_no(id,lbl_id,msg,minval,maxval)
{
	if(document.getElementById(id).value=="")
	{
		document.getElementById(lbl_id).innerHTML="Field marked with red color can not be empty";
		return false;
	}
	else
	{
		if(isnumeric(id,lbl_id,msg))
		{
			if(lengthrestriction(id,lbl_id,msg,minval,maxval))
			{
						return true;
			}
		}
	}
	
}

function chk_fax(id,lbl_id,msg)
{
	if(document.getElementById(id).value!="")
	{
		if(isnumeric(id,lbl_id,msg))
		{
			return true;
		}
	}
	else
	{
		document.getElementById(lbl_id).innerHTML ="";
		return true;
	}
}

function chk_address(id,lbl_id,msg)
{
	if(document.getElementById(id).value=="")
	{
		document.getElementById(lbl_id).innerHTML="Field marked with red color can not be empty";
		return false;
	}
	else
	{
		if(isalphanumeric(id,lbl_id,msg))
		{
			return true;
		}
	}
	
}

function chk_area(id,lbl_id,msg)
{
	if(document.getElementById(id).value!="")
	{
		if(isalphanumeric(id,lbl_id,msg))
		{
			return true;
		}
	}
	else
	{
		document.getElementById(lbl_id).innerHTML ="";
		return true;
	}
}

function chk_postcode(id,lbl_id,msg)
{
	if(document.getElementById(id).value=="")
	{
		document.getElementById(lbl_id).innerHTML="Field marked with red color can not be empty";
		return false;
	}
	else
	{
		if(isnumeric(id,lbl_id,msg))
		{
			if(lengthrestriction(id,lbl_id,msg,3,10))
			{
				return true;
			}
		}
	}
	
}

function chk_name(id,lbl_id,msg)
{
		
	if(document.getElementById(id).value=="")
	{
		document.getElementById(lbl_id).innerHTML="Field marked with red color can not be empty";
		return false;
	}
	else
	{	
		if(ischar(id,lbl_id,msg))
		{
			return true;
		}
	}
	
}





//added on 24-11-2012
/*function setDisplayNumber(number)
{
	
	
	if(number!='')
		{
			display_number = '';
			decimal_palces = '<?php echo $this->getDecimalPlace(); ?>';
			symbol_right   = '<?php echo $this->getSymbolRight(); ?>';
			display_number = number.toFixed(decimal_palces);
			if(symbol_right!='')
			{
				display_number = symbol_right + display_number;
			}
			return display_number;
		}
		else
		{
			return 0;
		}
}*/


function is_char(id,lbl_id,req,msg)
{
	var elem =document.getElementById(id).value;
	var alphaExp = /^[a-zA-z ,  ]+$/;
	if(req=='YES')
	{
		if(document.getElementById(id).value=="")
		{
			document.getElementById(lbl_id).innerHTML="Field marked with red color can not be empty";
			return false;
		}
		else
		{
			if(elem.match(alphaExp)){
				document.getElementById(lbl_id).innerHTML="";
				return true;
			}else{
				document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Character";
				return false;
			}
		}
	}
	else if(req=='NO')
	{
		document.getElementById(lbl_id).innerHTML="";
		if(document.getElementById(id).value!="")
		{
			if(elem.match(alphaExp)){
				document.getElementById(lbl_id).innerHTML="";
				return true;
			}else{
				document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Character";
				return false;
			}
		}
	}
}

function is_charwithoutspace(id,lbl_id,req,msg)
{
	var elem =document.getElementById(id).value;
	var alphaExp = /^[a-zA-z]+$/;
	if(req=='YES')
	{
		if(document.getElementById(id).value=="")
		{
			document.getElementById(lbl_id).innerHTML="Field marked with red color can not be empty";
			return false;
		}
		else
		{
			if(elem.match(alphaExp)){
				document.getElementById(lbl_id).innerHTML="";
				return true;
			}else{
				document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Character";
				return false;
			}
		}
	}
	else if(req=='NO')
	{
		document.getElementById(lbl_id).innerHTML="";
		if(document.getElementById(id).value!="")
		{
			if(elem.match(alphaExp)){
				document.getElementById(lbl_id).innerHTML="";
				return true;
			}else{
				document.getElementById(lbl_id).innerHTML="This "+msg+" Should be Character";
				return false;
			}
		}
	}
}
function is_empty(id,lbl_id,msg)
{
	var elem =document.getElementById(id).value;
	if(elem=='' || elem.length==0 ||  elem==null)
	{
		document.getElementById(lbl_id).innerHTML="Fields marked with red color can not be empty";
		return false;
	}
	else
	{
		document.getElementById(lbl_id).innerHTML="";
		return true;
	}
}

function emailvalidater(id,lbl_id,msg)
{
var elem =document.getElementById(id).value;
var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
if(elem.length==0)
	{
	document.getElementById(lbl_id).innerHTML="Fields marked with red color can not be empty";
	return false;
	}
	else
	{
		if(elem.match(emailExp)){
			document.getElementById(lbl_id).innerHTML="";
			return true;
		}else{
			document.getElementById(lbl_id).innerHTML="Please enter valid "+ msg +"";
			return false;
		}
	}
}




function confrmpwd(pwdid,cpwdid,lbl_pid,lbl_cpid)
{
	
	var pwd  = document.getElementById(pwdid).value;
	var cpwd = document.getElementById(cpwdid).value;
	
	if(pwd.length==0 || cpwd.length==0)
	{
		if(pwd=='' || pwd.length==0 || pwd==null)
		{
			document.getElementById(lbl_pid).innerHTML="Fields marked with red color can not be empty";
			
		}
		if(cpwd=='' || cpwd.length==0 || cpwd==null)
		{
			document.getElementById(lbl_cpid).innerHTML="Fields marked with red color can not be empty";
			
		}
		return false;
	}
	else
	{
		document.getElementById(lbl_pid).innerHTML="";
		if(pwd!=cpwd)
		{
			document.getElementById(lbl_cpid).innerHTML="Confirm Password Should match with Password";
			return false;
		}
		else
		{
			document.getElementById(lbl_cpid).innerHTML="";
			return true;
		}
	}
	
}

function confirmpassword(pwdid,cpwdid,lbl_pid,lbl_cpid)
{
	
	var pwd  = document.getElementById(pwdid).value;
	var cpwd = document.getElementById(cpwdid).value;
	
	if(pwd.length==0 || cpwd.length==0)
	{
		if(pwd=='' || pwd.length==0 || pwd==null)
		{
			document.getElementById(lbl_pid).innerHTML="Fields marked with red color can not be empty";
			
		}
		if(cpwd=='' || cpwd.length==0 || cpwd==null)
		{
			document.getElementById(lbl_cpid).innerHTML="Fields marked with red color can not be empty";
			
		}
		return false;
	}
	else
	{
		document.getElementById(lbl_pid).innerHTML="";
		if(pwd!=cpwd)
		{
			document.getElementById(lbl_cpid).innerHTML="Confirm Password Should match with Password";
			return false;
		}
		else
		{
			document.getElementById(lbl_cpid).innerHTML="";
			return true;
		}
	}
	
}



function isalphanumericwithhypencomma(id,lbl_id,msg)
{
var elem =document.getElementById(id).value;

var alphaExp = /^[0-9a-zA-Z\ , \- \.]+$/;
	
			if(elem.length<3 || elem.length>128)
			{ 
		
			document.getElementById(lbl_id).innerHTML=msg+" length must be within 3 to 128.";
			return false;
			}
			else
			{
				
					if(elem.match(alphaExp)){
						
					document.getElementById(lbl_id).innerHTML="";
						return true;
					}else{
						
						document.getElementById(lbl_id).innerHTML=" "+msg+" Should be Alphanumeric";
						return false;
					}
			}
	
}



