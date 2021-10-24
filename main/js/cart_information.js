function validateForm() {
	var name_regex = new RegExp(/^[A-Za-z\s]+$/, 'i');
	var email_regex = new RegExp(/^[\w.-]+@([\w]+\.){1,3}[a-zA-Z]{2,3}$/, 'i');
	var phone_regex = new RegExp(/^[+]{0,1}[0-9]{8,10}$/,'i');
	var pwd_regex = new RegExp(/^[a-zA-Z0-9]{8,16}$/, 'i');
	
	var nameNode = document.getElementById("cust_name");
    var emailNode = document.getElementById("cust_email");
	var phoneNode = document.getElementById("cust_phone");
	
	var name_test = name_regex.test(nameNode.value);
	if (name_test == false) {
    alert("The name entered (\"" + nameNode.value+ "\") contains invalid characters. \n"+
		  "Kindly enter the name in correct format.");
	nameNode.focus();
    nameNode.select();
	return false;
	}
	
	var email_test = email_regex.test(emailNode.value);
	if (email_test == false) {
    alert("The email entered (\"" + emailNode.value + 
          "\") is invalid.\n"+
		  "Kindly enter a valid email address. ");
    emailNode.focus();
    emailNode.select();
	return false;
	}
	
	var phone_test = phone_regex.test(phoneNode.value);
	if (phone_test == false) {
    alert("The phone number entered (\"" + phoneNode.value + 
          "\") is invalid.\n"+
		  "Kindly enter a valid phone number. ");
    phoneNode.focus();
    phoneNode.select();
	return false;
	}
	if (document.getElementById("no_member").checked) {
		var pwdNode = document.getElementById("new_password");
		var confirm_pwdNode = document.getElementById("confirm_password");
		var pwdNode_test = pwd_regex.test(pwdNode.value);
		var confirm_pwdNode_test = pwd_regex.test(confirm_pwdNode.value);
		
		if ((pwdNode_test == false)||(confirm_pwdNode == false)) {
		alert("The password entered is empty or contains invalid characters. \n"+
			  "Password can only contain letters and numbers (No Special characters). Minimum length is 8 characters. \n"+
			  "Kindly enter password in correct format.");
		pwdNode.focus();
		pwdNode.select();
		return false;
		}
		if ((pwdNode.value) != (confirm_pwdNode.value)) {
			alert("The passwords entered do not match. \n"+
				  "Password can only contain letters and numbers (No Special characters). Minimum length is 8 characters. \n"+
				  "Kindly enter passwords again.");
			pwdNode.focus();
			pwdNode.select();
			return false;
		}
	}
	if (document.getElementById("yes_member").checked) {
		var pwdNode = document.getElementById("old_password");
		var pwdNode_test = pwd_regex.test(pwdNode.value);
		
		if ((pwdNode_test == false)) {
		alert("The password entered is empty or contains invalid characters. \n"+
			  "Password can only contain letters and numbers (No Special characters). Minimum length is 8 characters. \n"+
			  "Kindly enter password in correct format.");
		pwdNode.focus();
		pwdNode.select();
		return false;
		}
	}
	
}
function showMember_nonMember(){
	if (document.getElementById("no_member").checked) {
		document.getElementById("not_a_member").style.display = "block";
	}
	else {
		document.getElementById("not_a_member").style.display = "none"; }
		
	if (document.getElementById("yes_member").checked) {
		document.getElementById("yes_a_member").style.display = "block";
	}
	else {
		document.getElementById("yes_a_member").style.display = "none"; }
}