function generareClasament() {
    var http = new XMLHttpRequest();
    var url = '../php/generareClasament.php';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() {
        if (http.readyState == 4 && http.status == 200) {
            var response = JSON.parse(http.responseText);

            for (let i = 0; i < 10; i++) {
                let element = response[i];
                puneUtilizatorInClasament(i + 1, element[0], element[1]);
            }
        }
    }
    http.send('');
}

function puneUtilizatorInClasament(numarId, nume, puncte) {
    document.getElementById('numeClasament' + numarId).innerText = nume;
    document.getElementById('puncteClasament' + numarId).innerText = puncte;
}
setInterval(function() { generareClasament(); }, 100);