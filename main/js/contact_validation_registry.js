// Get the DOM addresses of the elements and register the event handlers

    var nameNode = document.getElementById("Name");
    var emailNode = document.getElementById("Email");
	var phoneNode = document.getElementById("Phone");
	var contactForm = document.getElementById('contactform');
	  
    nameNode.addEventListener("change", checkName, false);
    emailNode.addEventListener("change", checkEmail, false);
	phoneNode.addEventListener("change", checkPhone, false);
	contactForm.onsubmit = validateForm;
	  
	  
