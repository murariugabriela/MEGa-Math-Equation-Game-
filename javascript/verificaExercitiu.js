function verificaExercitiu(semafor, prefix) {
    var http = new XMLHttpRequest();
    var url = '../php/acceptaStergeEx.php';
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    var params = 'semafor=' + semafor + '&idEx=' + document.getElementById(prefix + "idEx").textContent;
    http.onreadystatechange = function() {
        if (http.readyState == 4 && http.status == 200) {
            var response = http.responseText;
            alert(response);
            window.location.href = 'adminPage.html';
        }
    }
    http.send(params);
}