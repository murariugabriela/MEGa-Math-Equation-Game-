function verificareDateAdaugareExercitiu() {
    var enunt = document.forms["sendAdaugareExercitiu"]["enunt"].value;
    var var1 = document.forms["sendAdaugareExercitiu"]["varRasp1"].value;
    var var2 = document.forms["sendAdaugareExercitiu"]["varRasp2"].value;
    var var3 = document.forms["sendAdaugareExercitiu"]["varRasp3"].value;
    var var4 = document.forms["sendAdaugareExercitiu"]["varRasp4"].value;
    // alert(enunt + "." + var1 + "." + var2 + "." + var3 + "." + var4);
    if (!(document.getElementById('checkbox1').checked ||
            document.getElementById('checkbox2').checked ||
            document.getElementById('checkbox3').checked ||
            document.getElementById('checkbox4').checked)) {
        alert("Trebuie sa bifezi măcar o variantă de răspuns corectă!");
        return false;
    }

    if (!(document.getElementById('checkboxCategorie1').checked ||
            document.getElementById('checkboxCategorie2').checked ||
            document.getElementById('checkboxCategorie3').checked ||
            document.getElementById('checkboxCategorie4').checked)) {
        alert("Trebuie sa bifezi categoria");
        return false;
    }

    if (enunt === " " || var1 === " " || var2 === " " || var3 === " " || var4 === " " || enunt === "" || var1 === "" || var2 === "" || var3 === "" || var4 === "") {
        alert("Toate campurile trebuiesc completate");
        return false;
    }
    return true;
}