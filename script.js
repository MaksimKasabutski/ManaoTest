function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}


var loginForm = document.getElementById('loginForm');
var registrationForm = document.getElementById('registrationForm')
var servResponse = document.getElementById('response');
var loginWindow = document.getElementById('loginWindow');
var registrationWindow = document.getElementById('registrationWindow');

loginForm.onsubmit = function(event) {
    event.preventDefault();
    
    var login = document.getElementsByClassName('login')[0].value;
    var password = document.getElementsByClassName('password')[0].value;
    
    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"login" : login , "password" : password});

    xhr.open("POST", 'login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                loginWindow.style.display = 'none';
                registrationWindow.style.display = 'none';
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            } else {
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            }
        }  
    }
}


registrationForm.onsubmit = function(event) {
    event.preventDefault();

    var login = document.getElementsByClassName('login')[1].value;
    var password = document.getElementsByClassName('password')[1].value;
    var passwordConf = document.getElementById('confirm_password').value;
    var email = document.getElementById('email').value;
    var name = document.getElementById('name').value;

    var xhr = new XMLHttpRequest();
    var body = JSON.stringify({"login" : login , "password" : password, "passwordConf" : passwordConf, "email" : email, "name" : name});

    xhr.open("POST", 'register.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json')
    xhr.send(body);

    xhr.onreadystatechange = function () {
        if(xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            if (json.result === 'success') {
                loginWindow.style.display = 'none';
                registrationWindow.style.display = 'none';
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            } else {
                servResponse.style.display = 'block';
                servResponse.textContent = json.message;
            }
        }  
    }
}