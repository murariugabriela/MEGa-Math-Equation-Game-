function validare_formular() {
    var p1 = document.forms["formular_register"]["psw"].value;
    var p2 = document.forms["formular_register"]["psw-repeat"].value;
    if (p1 !== p2) {
        alert('Parolele nu coincid');
        return false;
    }
    return (p1 === p2);

}

function validareDateIntrare() {
    if (document.cookie
        .split('; ')
        .find(row => row.startsWith('response='))) {
        alert(document.cookie
            .split('; ')
            .find(row => row.startsWith('response='))
            .split('=')[1] + " deja folosit!");
        document.cookie = "response=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }
}

setInterval(function() { validareDateIntrare(); }, 100);