$(document).ready(function() {

	$('#password2').keyup(function(){
		$('#result').html(checkStrength($('#password2').val()))
	})	
	
	function checkStrength(password){
    
	//initial strength
    var strength = 0
	
    //if the password length is less than 6, return message.
    if (password.length < 6) { 
		$('#result').removeClass()
		$('#result').addClass('short')
		return 'Very Weak' 
	}
    
    //length is ok, lets continue.
	
	//if length is 8 characters or more, increase strength value
	if (password.length > 7) strength += 1
	
	//if password contains both lower and uppercase characters, increase strength value
	if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))  strength += 1
	
	//if it has numbers and characters, increase strength value
	if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))  strength += 1 
	
	//if it has one special character, increase strength value
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))  strength += 1
	
	//if it has two special characters, increase strength value
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
	
	//now we have calculated strength value, we can return messages
	
	//if value is less than 2
	if( strength == 0 ) {
			return 'Very Weak' ;
			$("#register").removeClass();
			$('#register').addClass('veryweak')
	} else 	if (strength == 1 ) {
		$("#register").removeClass();
		$('#register').addClass('weak')
			
		//$('#result').removeClass()
		//$('#result').addClass('weak')
		return 'Weak' ;			
	} else if (strength == 2 ) {
		$("#register").removeClass();
		$('#register').addClass('good')
		
		//$('#result').removeClass()
		//$('#result').addClass('good')
		
		return 'Medium' ;
	} else if( strength == 3 ) {
		return 'Strong';		
	}
	else if( strength >= 4 ) {
		return 'Very Strong' ;
	}
	else {
		$("#register").removeClass();
		$('#register').addClass('veryweak')
			
		$('#result').removeClass()
		$('#result').addClass('weak')
		return 'Weak' ;
	}
	
	/**
	case 1:
			  $('#pwdMeter').addClass('veryweak');
			  $('#pwdMeter').text('Very Weak');
			  break;
			case 2:
			  $('#pwdMeter').addClass('weak');
			  $('#pwdMeter').text('Weak');
			  break;
			case 3:
			  $('#pwdMeter').addClass('medium');
			  $('#pwdMeter').text('Medium');
			  break;
			case 4:
			  $('#pwdMeter').addClass('strong');
			  $('#pwdMeter').text('Strong');
			  break;
			case 5:
			  $('#pwdMeter').addClass('verystrong');
			  $('#pwdMeter').text('Very Strong');
	**/
	
	
}
});