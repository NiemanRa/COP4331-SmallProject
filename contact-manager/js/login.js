async function onRegister() {
    let firstName = document.getElementById("firstName").value;
    let lastName = document.getElementById("lastName").value;
    let email = document.getElementById("email").value;
    let username = document.getElementById("registerUsername").value;
    let password = document.getElementById("registerPassword").value;


    let req = new XMLHttpRequest();
    req.open("POST", "../api/register.php", true);
    req.setRequestHeader("Content-Type", "application/json");
    req.send(JSON.stringify({
        firstName: firstName,
        lastName: lastName,
        email: email,
        username: username,
        password: password
    }));
}

async function onLogin() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    let req = new XMLHttpRequest();
    req.open("POST", "../api/login.php", true);
    req.setRequestHeader("Content-Type", "application/json");
    req.send(JSON.stringify({
        username: username,
        password: password
    }));
    req.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                //window.location.href = "../contacts";
            } else {
                // Do alert bootstrap class div to indicate invalid credentials
            }
        }
    }
}