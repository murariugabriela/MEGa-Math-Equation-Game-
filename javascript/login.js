function isLoggedIn() {

    if (document.cookie
        .split('; ')
        .find(row => row.startsWith('jwt='))) {
        var http = new XMLHttpRequest();
        var url = '../php/jwt/php-jwt-master/src/decodeJWT.php';
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var params = 'jwt=' + document.cookie
            .split('; ')
            .find(row => row.startsWith('jwt='))
            .split('=')[1];
        http.onreadystatechange = function() {
            if (http.readyState == 4 && http.status == 200) {
                var response = http.responseText;
                var obj = JSON.parse(response);
                document.getElementById('currentUser').innerText = "Salut, " + obj.username + "\n Scorul tău: " + getUserPoints(obj.email);
                // alert(obj);
                if (obj.isAdmin == 1) {
                    verificaAdmin(1);
                    document.getElementById('butonPaginaAdmin').style.display = "block";
                } else {
                    verificaAdmin(0);
                    document.getElementById('butonPaginaAdmin').style.display = "none";
                }
            }
        }
        http.send(params);

        document.getElementById('registerButton').style.display = "none";
        document.getElementById('inputForLogin').style.display = "none";
        document.getElementById('butonLogin').style.display = "none";
        document.getElementById('butonLogout').style.display = "block";
    } else {
        if (document.cookie
            .split('; ')
            .find(row => row.startsWith('response='))) {
            alert("Autentificare esuata!");
            document.cookie = "response=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        }
        document.getElementById('currentUser').innerText = "";
        document.getElementById('registerButton').style.display = "block";
        document.getElementById('registerButton').onclick = function() { window.location.href = 'register.html'; };
        document.getElementById('inputForLogin').style.display = "block";
        document.getElementById('butonLogin').style.display = "block";
        document.getElementById('butonLogout').style.display = "none";
        document.getElementById('butonPaginaAdmin').style.display = "none";
        verificaAdmin(0);
    }
}

setInterval(function() { isLoggedIn(); }, 100);

function logout() {

    if (document.cookie
        .split('; ')
        .find(row => row.startsWith('jwt='))) {
        document.cookie = "jwt=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
}
var userPoints = 0;

function getUserPoints(email) {
    var points = "";
    var http = new XMLHttpRequest();
    var url = '../php/getUserPoints.php';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    var params = 'email=' + email;
    http.onreadystatechange = function() {
        if (http.readyState == 4 && http.status == 200) {
            var response = JSON.parse(http.responseText);
            points = http.responseText;
            setPoints(points);
        }
    }
    http.send(params);
    return userPoints;
}

function setPoints(points) {
    userPoints = points;
};

function verificaAdmin(isAdmin) {
    var path = window.location.pathname;
    var page = path.split("/").pop();
    if (page == "adminPage.html") {
        if (isAdmin == 0) {
            document.getElementById("admin").style.display = "none";
            document.getElementById("nonAdmin").style.display = "block";
        } else {
            document.getElementById("admin").style.display = "block";
            document.getElementById("nonAdmin").style.display = "none";
        }
    }
}