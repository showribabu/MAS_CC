//variable formed in JS have same name of class or id


// fname
var fname = document.getElementById("fname");
fname.addEventListener('input', func_fname);
var fname_regex = /^[A-Z][A-Za-z]*$/;
function func_fname() {
    const check = fname.value;
    var validationMessage = document.getElementById("para_fname");
    if (fname_regex.test(check)) {
        validationMessage.textContent = 'Given F-Name meets the requirements.';
        validationMessage.style.color = 'green';

    }
    else {
        validationMessage.textContent = 'F-Name must has first letter as capital and must only contain alphabets';
        validationMessage.style.color = 'red'; form_id.action = "./register.php";
    }
}

// main email id
var email = document.getElementById("email");
email.addEventListener('input', func_email);
var email_regex = /^[\w.-]+@[\w.-]+\.[\w.-]+$/;
function func_email() {
    const check = email.value;
    var validationMessage = document.getElementById("para_email");
    if (email_regex.test(check)) {
        validationMessage.textContent = 'Given E-mail meets the requirements.';
        validationMessage.style.color = 'green';

    }
    else {
        validationMessage.textContent = 'E-mail must be in the form name@domainname';
        validationMessage.style.color = 'red'; form_id.action = "./register.php";
    }
}


//alternate email id(optional)
var emailalt = document.getElementById("emailalt");
emailalt.addEventListener('input', func_emailalt);
var altemail_regex = /^[\w.-]+@[\w.-]+\.[\w.-]+$/;
function func_emailalt() {
    const check = emailalt.value;
    var validationMessage = document.getElementById("para_emailalt");
    if (altemail_regex.test(check)) {
        validationMessage.textContent = 'Given E-mail meets the requirements.';
        validationMessage.style.color = 'green';

    }
    else {
        validationMessage.textContent = 'E-mail must be in the form name@domainname';
        validationMessage.style.color = 'red'; form_id.action = "./register.php";
    }
}


//contact
var contact = document.getElementById("contact");
contact.addEventListener('input', func_contact);
var contact_regex = /^[1-9][0-9]{9}$/;
function func_contact() {
    const check = contact.value;
    var validationMessage = document.getElementById("para_contact");
    if (contact_regex.test(check)) {
        validationMessage.textContent = 'Given Contact meets the requirements.';
        validationMessage.style.color = 'green';

    }
    else {
        validationMessage.textContent = 'Contains only digits from 0 to 9 and has a length of exactly 10 digits and can not start with 0';
        validationMessage.style.color = 'red'; form_id.action = "./register.php";
    }
}



//userid
var userid = document.getElementById("userid");
userid.addEventListener('input', func_userid);
var userid_regex = /^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*_)[a-zA-Z0-9_]{8,}$/;

function func_userid() {
    const check = userid.value;
    var validationMessage = document.getElementById("para_userid");
    if (userid_regex.test(check)) {
        validationMessage.textContent = 'Given Userid meets the requirements.';
        validationMessage.style.color = 'green';

    }
    else {
        validationMessage.textContent = 'Has a minimum length of 8 characters & Can only contain alphabets, numbers, underscores & must conatain an alphabet , number, underscores. Also it must start with an alphabet';
        validationMessage.style.color = 'red'; form_id.action = "./register.php";
    }
}





//QUESTION
function checkOption() {
    var selectElement = document.getElementById("options");
    var otherOptionInput = document.getElementById("otherOption");

    if (selectElement.value === "other") {
        otherOptionInput.removeAttribute("readonly");
        otherOptionInput.style.display = "inline";
        otherOptionInput.setAttribute("required", "required"); // Make the input field required
    } else {
        otherOptionInput
        otherOptionInput.removeAttribute("required"); // Remove the required attribute
        otherOptionInput.value = ""; // Clear the input field
    }
}








//PASSWORD
var password = document.getElementById("password");
password.addEventListener('input', func_password);
var password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=[\]{};':\"\\|,.<>/?]).{8,}$/
function func_password() {
    const check = password.value;
    var validationMessage = document.getElementById("para_password");
    if (password_regex.test(check)) {
        validationMessage.textContent = 'Password meets the requirements.';
        validationMessage.style.color = 'green';
        document.getElementById("myForm").action = "./register.php";
    }
    else {
        validationMessage.textContent = 'Password must contain at least one uppercase letter, one lowercase letter, one numeric digit, one special character, and be at least 8 characters long.';
        validationMessage.style.color = 'red';
        document.getElementById("myForm").action = "./register.php";
    }
}



var cpassword = document.getElementById("cpassword");
cpassword.addEventListener('input', func_cpassword);
function func_cpassword() {
    var validationMessage = document.getElementById("para_cpassword");
    if (password.value === cpassword.value) {
        validationMessage.textContent = 'Confirm-Password meets the requirements.';
        validationMessage.style.color = 'green';
        form_id.action = "./register.php";

    }
    else {
        validationMessage.textContent = 'Password and confirm-password do not match';
        validationMessage.style.color = 'red'; form_id.action = "./register.php";
    }
}



var fileInput = document.getElementById('file');
fileInput.addEventListener('change', function () {
    var file = fileInput.files[0];
    var fileSize = file.size; // File size in bytes
    var maxSize = 5 * 1024 * 1024; // 5MB limit (adjust as needed)

    if (fileSize > maxSize) {
        var validationMessage = document.getElementById("para_photo");
            validationMessage.textContent = 'File size must not exceed 5MB';
            validationMessage.style.color = 'red'; form_id.action = "./register.php";
            // fileInput.value = ''; // Clear the file input
        }
    });



function form_validation() {
    if (!email_regex.test(email.value)) {
        return false;
    }
    if (!contact_regex.test(contact.value)) {
        return false;
    }
    if (!userid_regex.test(userid.value)) {
        return false;
    }
    if (!answer_regex.test(answer.value)) {
        return false;
    }
    if (!password_regex.test(password.value)) {
        return false;
    }

    if (cpassword.value != password.value) {
        return false;
    }

    if (!fname_regex.test(fname.value)) {
        return false;
    }

    var fileInput = document.getElementById('file');
    fileInput.addEventListener('change', function () {
        var file = fileInput.files[0];
        var fileSize = file.size; // File size in bytes
        var maxSize = 5 * 1024 * 1024; // 5MB limit (adjust as needed)

        if (fileSize > maxSize) {
           return false;
        }
    });
    
  

    return true;
}




function dot(){
    var signInField = document.getElementsById("signInField");
    signInField.setAttribute('hidden');
    var q_a = document.getElementById("q_a");
    q_a.removeAttribute('hidden');
    var signUpField = document.getElementsById("signUpField");
    signUpField.setAttribute('hidden');
    var qt = document.getElementById("qt");
    var finalbtn = document.getElementsById("finalbtn");
    finalbtn.removeAttribute('hidden');
    qt.value = "<?php echo $showques; ?>";
    // bt.setAttribute('name', 'finalsubmit');
    qt.setAttribute("readonly");

}


var userid = document.getElementById('userid');
var togglepassworduserid = document.getElementById('togglepassworduserid');

togglepassworduserid.addEventListener('click', function() {
  if (userid.type === 'password') {
    userid.type = 'text';
    togglepassworduserid.classList.remove('fa-eye');
    togglepassworduserid.classList.add('fa-eye-slash');
  } else {
    userid.type = 'password';
    togglepassworduserid.classList.remove('fa-eye-slash');
    togglepassworduserid.classList.add('fa-eye');
  }
});
var password = document.getElementById('password');
var togglepasswordpassword = document.getElementById('togglepasswordpassword');

togglepasswordpassword.addEventListener('click', function() {
  if (password.type === 'password') {
    password.type = 'text';
    togglepasswordpassword.classList.remove('fa-eye');
    togglepasswordpassword.classList.add('fa-eye-slash');
  } else {
    password.type = 'password';
    togglepasswordpassword.classList.remove('fa-eye-slash');
    togglepasswordpassword.classList.add('fa-eye');
  }
});

var cpassword = document.getElementById('cpassword');
var togglepasswordcpassword = document.getElementById('togglepasswordcpassword');

togglepasswordcpassword.addEventListener('click', function() {
  if (cpassword.type === 'password') {
    cpassword.type = 'text';
    togglepasswordcpassword.classList.remove('fa-eye');
    togglepasswordcpassword.classList.add('fa-eye-slash');
  } else {
    cpassword.type = 'password';
    togglepasswordcpassword.classList.remove('fa-eye-slash');
    togglepasswordcpassword.classList.add('fa-eye');
  }
});
