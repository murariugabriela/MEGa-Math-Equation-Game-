var punctajTest = 0;

function verifyAnswer(prefix) {
    if (!document.getElementById(prefix + 'var1').checked &&
        !document.getElementById(prefix + 'var2').checked &&
        !document.getElementById(prefix + 'var3').checked &&
        !document.getElementById(prefix + 'var4').checked) {
        alert('Alege macar o varianta de raspuns!');
    } else {
        var punctaj = 0;
        var varianteGresite = 0,
            varianteCorecte = 0;
        document.getElementById(prefix + 'input1').textContent = '';
        document.getElementById(prefix + 'input2').textContent = '';
        document.getElementById(prefix + 'input3').textContent = '';
        document.getElementById(prefix + 'input4').textContent = '';
        document.getElementById(prefix + 'b').style.border = '1px solid gray';
        document.getElementById(prefix + 'd').style.border = '1px solid gray';
        document.getElementById(prefix + 'a').style.border = '1px solid gray';
        document.getElementById(prefix + 'c').style.border = '1px solid gray';
        if (document.getElementById(prefix + 'var1').value == 'true')
            varianteCorecte++;
        else varianteGresite++;
        if (document.getElementById(prefix + 'var2').value == 'true')
            varianteCorecte++;
        else varianteGresite++;
        if (document.getElementById(prefix + 'var3').value == 'true')
            varianteCorecte++;
        else varianteGresite++;
        if (document.getElementById(prefix + 'var4').value == 'true')
            varianteCorecte++;
        else varianteGresite++;
        if (document.getElementById(prefix + 'var1').checked) {
            if (document.getElementById(prefix + 'var1').value == 'true') {
                document.getElementById(prefix + 'a').style.border = '3px solid limegreen';
                punctaj = punctaj + 1 / varianteCorecte;
                // varianteCorecte++;
            } else {
                document.getElementById(prefix + 'a').style.border = '3px solid red';
                punctaj -= 1 / varianteCorecte;
            }
        } else if (!document.getElementById(prefix + 'var1').checked && document.getElementById(prefix + 'var1').value == 'true')
            document.getElementById(prefix + 'input1').textContent = 'Trebuia bifat';
        if (document.getElementById(prefix + 'var2').checked) {
            if (document.getElementById(prefix + 'var2').value == 'true') {
                document.getElementById(prefix + 'b').style.border = '3px solid limegreen';
                punctaj += 1 / varianteCorecte;
            } else {
                document.getElementById(prefix + 'b').style.border = '3px solid red';
                punctaj -= 1 / varianteCorecte;
            }
        } else if (!document.getElementById(prefix + 'var2').checked && document.getElementById(prefix + 'var2').value == 'true')
            document.getElementById(prefix + 'input2').textContent = 'Trebuia bifat';
        if (document.getElementById(prefix + 'var3').checked) {
            if (document.getElementById(prefix + 'var3').value == 'true') {
                document.getElementById(prefix + 'c').style.border = '3px solid limegreen';
                punctaj += 1 / varianteCorecte;
            } else {
                document.getElementById(prefix + 'c').style.border = '3px solid red';
                punctaj -= 1 / varianteCorecte;
            }
        } else if (!document.getElementById(prefix + 'var3').checked && document.getElementById(prefix + 'var3').value == 'true')
            document.getElementById(prefix + 'input3').textContent = 'Trebuia bifat';
        if (document.getElementById(prefix + 'var4').checked) {
            if (document.getElementById(prefix + 'var4').value == 'true') {
                document.getElementById(prefix + 'd').style.border = '3px solid limegreen';
                punctaj += 1 / varianteCorecte;
            } else {
                document.getElementById(prefix + 'd').style.border = '3px solid red';
                punctaj -= 1 / varianteCorecte;
            }
        } else if (!document.getElementById(prefix + 'var4').checked && document.getElementById(prefix + 'var4').value == 'true')
            document.getElementById(prefix + 'input4').textContent = 'Trebuia bifat';
        punctaj = punctaj >= 0 ? punctaj : 0;
        adaugaPunctaj(punctaj);
        alert('Ai obtinut ' + punctaj + ' puncte la acest exercitiu.');
        /* TO DO: faza cu timpul -> a expirat -> alert cu punctajul inregistrat + adaugat in baza de date*/
        if (prefix.includes("t")) {
            punctajTest += punctaj;
        }
        document.getElementById(prefix + 'button-ex').style.display = "none";

        document.getElementById(prefix + 'var1').checked = false;
        document.getElementById(prefix + 'var2').checked = false;
        document.getElementById(prefix + 'var3').checked = false;
        document.getElementById(prefix + 'var4').checked = false;
    }
    document.getElementById(prefix + 'var1').checked = false;
    document.getElementById(prefix + 'var2').checked = false;
    document.getElementById(prefix + 'var3').checked = false;
    document.getElementById(prefix + 'var4').checked = false;

    // return true;

}

function adaugaPunctaj(punctaj) {
    var greeting = document.getElementById('currentUser').textContent;
    if (greeting != "") {
        var http = new XMLHttpRequest();
        var url = '../php/adaugarePunctaj.php';
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var params = 'points=' + punctaj + '&username=' + greeting.substring(greeting.indexOf(',') + 2, greeting.indexOf("Scorul") - 1);
        http.onreadystatechange = function() {
            if (http.readyState == 4 && http.status == 200) {
                var response = JSON.parse(http.responseText);
                console.log(response);
            }
        }
        http.send(params);
    }
}

function testFunction() {
    /* TO DO: adaugat punctajul in baza de date daca este conectat */
    window.alert('La acest test ai obtinut ' + punctajTest + ' puncte.');
    window.location.href = "index.html";
    punctajTest = 0;
}
var seconds = 80;
var sufixCurent;

function displayTimer(sufix) {
    var path = window.location.pathname;
    var page = path.split("/").pop();
    // alert(window.location.pathname);
    var id = 'timer';
    sufixCurent = sufix;
    var sufixNou;
    document.getElementById(id + sufixCurent).innerHTML = seconds;
    document.getElementById('divtimer' + sufixCurent).style.background = 'yellow';
    seconds--;
    if (seconds == -1) {
        document.getElementById(id + sufixCurent).innerHTML = '';
        document.getElementById('divtimer' + sufixCurent).style.background = 'red';
        document.getElementById('t11button-ex').style.display = "none";
        document.getElementById('t12button-ex').style.display = "none";
        document.getElementById('t13button-ex').style.display = "none";
        document.getElementById('t14button-ex').style.display = "none";
        document.getElementById('t15button-ex').style.display = "none";
        alert("S-a scurs timpul!");

        testFunction();
    }
}
var interval = setInterval(function() { displayTimer(sufixCurent); }, 1000);