function ValidationMobileForm(){
	var err = 0;

	mobile = document.getElementById("mobilenum");
	if(!CheckPhone("mobilenum")){
		err++;
		mobile.focus();
	}

	if(err > 0){
		return false;
	}
}

function ValidationCodeForm(){
	var err = 0;

	code = document.getElementById("codenum");
	if(!code.value){
		alert('لطفا کد مربوطه را وارد کنید');
		err++;
		code.focus();
	}

	if(err > 0){
		return false;
	}
}

	
function CheckPhone(number_id){
	var numberobj = document.getElementById(number_id);
	number = numberobj.value;
	if(number.length != 11 && number.length != 10) {
		alert("تعداد ارقام شماره موبایل صحیح نیست");
		return false;
	}

	else if( (((number.charAt(0) + number.charAt(1)) != "09") && ((number.charAt(0) + number.charAt(1)) != "۰۹")) && (number.charAt(0) != "9") && (number.charAt(0) != "۹") ) {
		alert("شماره شما باید با 09 شروع شود");
		return false;
	}
	return true;
}

function CheckEmail(email){
	emailVal = email.value;
	if(emailVal != ""){ 
		var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
		if (!re.test(emailVal))
		{
			alert("ایمیل نامعتبر است");
			//jQuery("#jform_email").focus();
			return false;
		}
	}
	else{
		if(email.getAttribute('required') == "required") {
			alert("ایمیل را وارد نمایید.");
			return false;
		}
	}
	return true;
} 
	
 function ValidationRegistrationForm(){
	 
	 err = 0;
	 email = document.getElementById("email");
		if(email){
			if(!CheckEmail(email)) {
				err++;
			}
		}
	 
	 password = document.getElementById("password");
		if(password.value == ""){
			alert("رمز ورود خود را وارد کنید");
			err++;
		}
	 
	 if(err > 0){
			return false;
		}
	 
	 return true;
 }

 function commonPermitted(e) {
	var arr = [
		8, // backspace
		9, // tab
		16, // shift
		17, // ctrl
		35, // end
		36, // home
		37, // left
		39, // right
		46, // del
		// you may want to permit enter/return here too
	];
	if (arr.indexOf(e.keyCode) != -1)
		return true;
	if (e.ctrlKey && ['a', 'c', 'v', 'x'].indexOf(String.fromCharCode(e.keyCode).toLowerCase()))
		return true;
	return;
}

function numberValidate(e) {

	var theEvent = e || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	//alert(key);
	if (commonPermitted(e)) return;

	var regex = /^[0-9]/;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

function validateOnlyDigit(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function startTimerLR(duration, display, link) {
    var timer = duration, minutes, seconds;
    var circleLoop = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
        
        if(timer == 0) {
            clearInterval(circleLoop);
            display.innerHTML = "<a href='"+link+"'>ارسال مجدد کد</a>";
        }
    }, 1000);
}
