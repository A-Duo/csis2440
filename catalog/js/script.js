var usernameWarnings = [];
var passwordWarnings = [];

function outputWarnings() {
    let errorOutput = document.getElementById('errorList');

    let outStr = '';
    let warnings = [...usernameWarnings, ...passwordWarnings];
    for (warning of warnings) {
        outStr += '<li><b>'+warning+'</b></li>';
    }
    
    errorOutput.innerHTML = outStr;
    if (warnings.length == 0 && document.getElementById('password').value.length > 0) {
        document.getElementById('submit').disabled = false;
    } else {
        document.getElementById('submit').disabled = true;
    }
}

document.getElementById('username').addEventListener('input', function(event) {
    let newWarnings = [];
    let text = event.target.value;

    if (text.length < 1) newWarnings.push('Username is required');
    if (text.length > 50) newWarnings.push('Username exceeds max length (50 characters)');

    usernameWarnings = newWarnings;
    outputWarnings();
});

document.getElementById('password').addEventListener('input', checkPassword);
document.getElementById('password2').addEventListener('input', checkPassword);

function checkPassword(event) {
    let newWarnings = [];
    let text = document.getElementById('password').value;
    let text2 = document.getElementById('password2').value;

    if (text.length < 1) newWarnings.push('Password required');
    else if (text.length < 8) newWarnings.push('Password must be at least 8 characters');
    if (text.length > 128) newWarnings.push('Password must not exceed 128 characters');

    if (/[^\w~`!@#$%^&*()\-_+=[{}\]\|:;"\'<,>.?\/\\]/.test(text))
        newWarnings.push('Password must only be alphanumeric characters or any of the following characters: ~`!@#$%^&*()-_+=[{}]|:;&quot;\'&lt;,&gt;.?/\\');
    if (!/\d/.test(text)) newWarnings.push('Password must contain at least 1 number');

    if (text2.length < 1) newWarnings.push('Must confirm password');
    if (text != text2) newWarnings.push('Passwords must match');

    passwordWarnings = newWarnings;
    outputWarnings();
}
