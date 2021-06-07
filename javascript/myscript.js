var i = 0;

function openCloseForm() {
    if (!(i % 2 == 0))
        document.getElementById("myForm").style.display = "none";
    else
        document.getElementById("myForm").style.display = "block";
    i = i + 1;
}

function citat() {
    var citate = ["I’ve always enjoyed mathematics. It is the most precise and concise way of expressing an idea.", "There should be no such thing as boring mathematics.", "Mathematics is the music of reason.", "Matematician nu este cel ce știe matematică, ci cel ce creează matematică.", "Matematica este muzica raţiunii.", "Lumea este condusă de numere.", "Pure mathematics is, in its way, the poetry of logical ideas.", "Without mathematics, there’s nothing you can do. Everything around you is mathematics. Everything around you is numbers."];
    document.getElementById("citat").innerHTML = citate[Math.floor(Math.random() * (citate.length - 1))];
}
var numarDeX = 0;

function Xsi0show(id) {
    let variabila = document.getElementById(id);
    if (variabila.textContent == "") {
        variabila.textContent = 'X';
        numarDeX++;
        var semafor = true;
        if (!verificareCastigatorx0()) {
            if (numarDeX != 5) {
                while (semafor) {
                    semafor = false;
                    var random = Math.floor(Math.random() * 9) + 1;
                    if (document.getElementById("x-elem" + random).textContent == 'X' || document.getElementById("x-elem" + random).textContent == '0')
                        semafor = true;
                }
                document.getElementById("x-elem" + random).textContent = '0';
                verificareCastigatorx0();
            } else {
                alert('Strâns joc! Remiză!');
                window.location.href = "../html/index.html";
                numarDeX = 0;
            }
        }
    }
}

function verificareCastigatorx0() {
    // verificam liniile
    var celula1 = document.getElementById("x-elem1").textContent;
    var celula2 = document.getElementById("x-elem2").textContent;
    var celula3 = document.getElementById("x-elem3").textContent;
    var celula4 = document.getElementById("x-elem4").textContent;
    var celula5 = document.getElementById("x-elem5").textContent;
    var celula6 = document.getElementById("x-elem6").textContent;
    var celula7 = document.getElementById("x-elem7").textContent;
    var celula8 = document.getElementById("x-elem8").textContent;
    var celula9 = document.getElementById("x-elem9").textContent;

    //verificare pe linie
    if ((celula1 === celula2) && (celula2 === celula3) && celula1 != '') {
        if (celula1 === 'X')
            alert("Ai câștigat!");
        else if (celula1 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "../html/index.html";
        return true;
    }
    if ((celula4 === celula5) && (celula5 === celula6) && celula4 != '') {
        if (celula4 === 'X')
            alert("Ai câștigat!");
        else if (celula4 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "../html/index.html";
        return true;
    }
    if ((celula7 === celula8) && (celula8 === celula9) && celula7 != '') {
        if (celula7 === 'X')
            alert("Ai câștigat!");
        else if (celula7 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "../html/index.html";
        return true;
    }

    //verificare pe coloana
    if ((celula1 === celula4) && (celula1 === celula7) && celula1 != '') {
        if (celula1 === 'X')
            alert("Ai câștigat!");
        else if (celula1 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "../html/index.html";
        return true;
    }
    if ((celula2 === celula5) && (celula2 === celula8) && celula2 != '') {
        if (celula2 === 'X')
            alert("Ai câștigat!");
        else if (celula2 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "../html/index.html";
        return true;
    }
    if ((celula3 === celula6) && (celula3 === celula9) && celula6 != '') {
        if (celula3 === 'X')
            alert("Ai câștigat!");
        else if (celula3 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "../html/index.html";
        return true;
    }

    //verificare pe diagonala
    if ((celula1 === celula5) && (celula1 === celula9) && celula1 != '') {
        if (celula1 === 'X')
            alert("Ai câștigat!");
        else if (celula1 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "index.html";
        return true;
    }
    if ((celula3 === celula5) && (celula3 === celula7) && celula3 != '') {
        if (celula3 === 'X')
            alert("Ai câștigat!");
        else if (celula3 === '0')
            alert("A câștigat calculatorul!");
        window.location.href = "index.html";
        return true;
    }
    return false;
}

function displayCenterContentItem(id) {
    document.getElementById('teorie').style.display = "none";
    document.getElementById('probRezolvate').style.display = "none";
    document.getElementById('probNerezolvate').style.display = "none";
    document.getElementById('test').style.display = "none";
    document.getElementById(id).style.display = "flex";
    document.getElementById(id).style.flexDirection = "column";
}
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
        var params = 'points=' + punctaj + '&username=' + greeting.substring(greeting.indexOf(',') + 2, greeting.indexOf("Scorul") - 1);
        http.open('POST', url, true);
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {
            if (http.readyState == 4 && http.status == 200) {
                // alert("Am adaugat");
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

function buttonSymbol(id) {
    if (id == "adunare") {
        document.getElementById("katexSymbols").textContent = "+";
    } else if (id == "scadere") {
        document.getElementById("katexSymbols").textContent = "-";
    } else if (id == "inmultire") {
        document.getElementById("katexSymbols").textContent = "\\cdot";
    } else if (id == "impartire") {
        document.getElementById("katexSymbols").textContent = ":";
    } else if (id == "plusMinus") {
        document.getElementById("katexSymbols").textContent = "±";
    } else if (id == "diferit") {
        document.getElementById("katexSymbols").textContent = "\\neq";
    } else if (id == "oricareArFi") {
        document.getElementById("katexSymbols").textContent = "\\forall";
    } else if (id == "exista") {
        document.getElementById("katexSymbols").textContent = "\\exist";
    } else if (id == "nuExista") {
        document.getElementById("katexSymbols").textContent = "\\nexists";
    } else if (id == "apartine") {
        document.getElementById("katexSymbols").textContent = "\\in";
    } else if (id == "nuApartine") {
        document.getElementById("katexSymbols").textContent = "\\notin";
    } else if (id == "fractie") {
        document.getElementById("katexSymbols").textContent = "\\frac{x}{y}";
    } else if (id == "modul") {
        document.getElementById("katexSymbols").textContent = "\\vert";
    } else if (id == "xLaY") {
        document.getElementById("katexSymbols").textContent = "{x}^{y}";
    } else if (id == "radical") {
        document.getElementById("katexSymbols").textContent = "\\sqrt{x}";
    } else if (id == "integrala") {
        document.getElementById("katexSymbols").textContent = "\\int";
    } else if (id == "parantezaRotundaDeschisa") {
        document.getElementById("katexSymbols").textContent = "(";
    } else if (id == "parantezaRotundaInchisa") {
        document.getElementById("katexSymbols").textContent = ")";
    } else if (id == "parantezaPatrataDeschisa") {
        document.getElementById("katexSymbols").textContent = "[";
    } else if (id == "parantezaPatrataInchisa") {
        document.getElementById("katexSymbols").textContent = "]";
    }
}
