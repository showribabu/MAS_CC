
    var form_id=document.getElementById("form_id");
    const passwordInput = document.getElementById('password');
    const validationMessage = document.getElementById('password-validation');

    passwordInput.addEventListener('input', validatePassword);

    function validatePassword() {
  const password = passwordInput.value;

    // Define the regex pattern for password validation
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (regex.test(password)) {
        validationMessage.textContent = 'Password meets the requirements.';
    validationMessage.style.color = 'green';
    form_id.action="/phpt/forgot.php";

} else {
        validationMessage.textContent = validationMessage.textContent = 'Password must contain at least one uppercase letter\n' + 'one lowercase letter\n' + 'one numeric digit\n' + 'one special character\n' + 'and be at least 8 characters long.\n'
        + 'Don\'t click on reset until the password meets the requirements.';

    validationMessage.style.color = 'red';
    form_id.action="/phpt/forgot.php";

  }
}

