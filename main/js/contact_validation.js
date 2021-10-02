
// ********************************************************** //
// The event handler function for the Overall Validation
function validateForm() {
	var name_regex = new RegExp(/^[A-Za-z\s]+$/, 'i');
	var email_regex = new RegExp(/^[\w.-]+@([\w]+\.){1,3}[A-Za-z]{2,3}$/, 'i');	
	var phone_regex = new RegExp(/^[+]?[\d]{8,10}$/, 'i');
	
	var nameNode = document.getElementById("Name");
    var emailNode = document.getElementById("Email");
	var phoneNode = document.getElementById("Phone");
	
	var name_test = name_regex.test(nameNode.value);
	if (name_test == false) {
    alert("The name you entered (\"" + nameNode.value+ "\") contains invalid characters or is empty. \n"+
		  "Kindly try again.");
	nameNode.focus();
    nameNode.select();
	return false;
	}
	
	var email_test = email_regex.test(emailNode.value);
	if (email_test == false) {
    alert("The email you entered (\"" + emailNode.value + 
          "\") is invalid.\n"+
		  "Kindly enter a valid email address. ");
    emailNode.focus();
    emailNode.select();
	return false;
	}
	
	var phone_test = phone_regex.test(phoneNode.value);
	if (phone_test == false) {
    alert("The Phone Number you entered (\"" + phoneNode.value + 
          "\") is invalid.\n"+
		  "Kindly enter a valid Phone Number without spaces. ");
    phoneNode.focus();
    phoneNode.select();
	return false;
	}
}

// ********************************************************** //
// The event handler function for the Name text box
function checkName(event) {
	var nameEntered = event.currentTarget; 
	
	var name_regex = new RegExp(/^[A-Za-z\s]+$/, 'i');
	
	var name_test = name_regex.test(nameEntered.value);
	
	if (name_test == false) {
    alert("The name you entered (\"" + nameEntered.value + 
          "\") contains invalid characters or is empty. \n"+
		  "Kindly try again.");
    nameEntered.focus();
    nameEntered.select();
	return false;
	}
}

// ********************************************************** //
// The event handler function for the Email text box

function checkEmail(event) {
	var emailEntered = event.currentTarget; 
	
	var email_regex = new RegExp(/^[\w.-]+@([\w]+\.){1,3}[A-Za-z]{2,3}$/, 'i');
	
	var email_test = email_regex.test(emailEntered.value);
	
	if (email_test == false) {
    alert("The email you entered (\"" + emailEntered.value + 
          "\") is invalid.\n"+
		  "Kindly enter a valid email address. ");
    emailEntered.focus();
    emailEntered.select();
	return false;
	}
}


// ********************************************************** //
// The event handler function for the Phone Number
function checkPhone(event) {
	var phoneEntered = event.currentTarget; 
	
	var phone_regex = new RegExp(/^[+]?[\d]{8,10}$/, 'i');
	
	var phone_test = phone_regex.test(phoneEntered.value);
	
	if (phone_test == false) {
    alert("The Phone Number you entered (\"" + phoneEntered.value + 
          "\") is invalid.\n"+
		  "Kindly enter a valid Phone Number without spaces. ");
    phoneEntered.focus();
    phoneEntered.select();
	return false;
	}
}
