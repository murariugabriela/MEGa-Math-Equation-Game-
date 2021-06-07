<?php
// $host = "localhost";
// $user = "postgres";
// $pass = "student";
// $db = "MathML";
// $con = pg_connect("host = $host dbname = $db user = $user password=$pass") or die ("Could not connect to Server\n");
include_once 'bd.php';
$con = BD::oferaConexiune();
//verificare campuri sa fie completate
$categorie = "";
if (isset($_POST["cat"])) {
    $categorie = $_POST["cat"];
}
// } else if (isset($_POST["checkboxCategorie2"])) {
//     $categorie = "analiza";
// } else if (isset($_POST["checkboxCategorie3"])) {
//     $categorie = "geometrie";
// } else if (isset($_POST["checkboxCategorie4"])) {
//     $categorie = "trigonometrie";
// }
if (
    isset($_POST["enunt"]) && strlen(trim($_POST["enunt"])) != 0 &&
    isset($_POST["varRasp1"]) && strlen(trim($_POST["varRasp1"])) != 0 &&
    isset($_POST["varRasp2"]) && strlen(trim($_POST["varRasp2"])) != 0 &&
    isset($_POST["varRasp3"]) && strlen(trim($_POST["varRasp3"])) != 0 &&
    isset($_POST["varRasp4"]) && strlen(trim($_POST["varRasp4"])) != 0
) {

    // select mare pt count(id)
    $sql0 = "SELECT MAX(id) from variante_raspuns";
    $rs0 = pg_query($con, $sql0) or die("Cannot execute query: $sql1\n");
    $countIdInitial = intval(pg_fetch_row($rs0)[0]);

    //initializare cu null ca sa facem diferenta la urma
    $id1 = 0;
    $id2 = 0;
    $id3 = 0;
    $id4 = 0;

    //cautam daca mai exista variantele in baza de date si actualizam
    //SQL INJECTION
    $sql1 = "SELECT id from variante_raspuns WHERE raspuns= $1";
    $rs1 = pg_query_params($con, $sql1, array("$$" . $_POST["varRasp1"] . "$$")) or die("Cannot execute query: $sql1\n");
    $id1 = intval(pg_fetch_row($rs1)[0] ?? 0);

    $rs2 = pg_query_params($con, $sql1, array("$$" . $_POST["varRasp2"] . "$$")) or die("Cannot execute query: $sql1\n");
    $id2 = intval(pg_fetch_row($rs2)[0] ?? 0);

    $rs3 = pg_query_params($con, $sql1, array("$$" . $_POST["varRasp3"] . "$$")) or die("Cannot execute query: $sql1\n");
    $id3 = intval(pg_fetch_row($rs3)[0] ?? 0);

    $rs4 = pg_query_params($con, $sql1, array("$$" . $_POST["varRasp4"] . "$$")) or die("Cannot execute query: $sql1\n");
    $id4 = intval(pg_fetch_row($rs4)[0] ?? 0);

    //actualizare id-uri care au ramas null cu ultima urmatoare a id-ului din tabela de variante + 1
    $valoarePentruIduri = $countIdInitial;
    $sqlInsert = "INSERT into variante_raspuns (raspuns) VALUES ($1)";
    if ($id1 == 0) {
        $valoarePentruIduri = $valoarePentruIduri + 1;
        $id1 = $valoarePentruIduri;
        //il inserez

        $rsId1 = pg_query_params($con, $sqlInsert, array("$$" . $_POST["varRasp1"] . "$$"));
    }
    if ($id2 == 0) {
        $valoarePentruIduri = $valoarePentruIduri + 1;
        $id2 = $valoarePentruIduri;
        //il inserez
        $rsId2 = pg_query_params($con, $sqlInsert, array("$$" . $_POST["varRasp2"] . "$$"));
    }
    if ($id3 == 0) {
        $valoarePentruIduri = $valoarePentruIduri + 1;
        $id3 = $valoarePentruIduri;
        //il inserez
        $rsId3 = pg_query_params($con, $sqlInsert, array("$$" . $_POST["varRasp3"] . "$$"));
    }
    if ($id4 == 0) {
        $valoarePentruIduri = $valoarePentruIduri + 1;
        $id4 = $valoarePentruIduri;
        //il inserez
        $rsId4 = pg_query_params($con, $sqlInsert, array("$$" . $_POST["varRasp4"] . "$$"));
    }

    //formez stringul pt variantele corecte de rasp pentru a insera in tabela exercitii
    $varCorecte = "";
    if (isset($_POST["checkbox1"])) {
        //concatenez cu o virgula si un spatiu in cazul in care sunt mai multe variante corecte
        if ($varCorecte != "") {
            $varCorecte .= ", ";
        }
        $varCorecte .= $id1;
    }
    if (isset($_POST["checkbox2"])) {
        if ($varCorecte != "") {
            $varCorecte .= ", ";
        }
        $varCorecte .= $id2;
    }
    if (isset($_POST["checkbox3"])) {
        if ($varCorecte != "") {
            $varCorecte .= ", ";
        }
        $varCorecte .= $id3;
    }
    if (isset($_POST["checkbox4"])) {
        if ($varCorecte != "") {
            $varCorecte .= ", ";
        }
        $varCorecte .= $id4;
    }

    //formez string cu toate variantele
    $toateVar = "";
    $toateVar .= $id1 . ", " . $id2 . ", " . $id3 . ", " . $id4;

    //inserez enuntul cu variantele de raspuns in tabela exercises
    $sqlInsertExercitiu = "INSERT into exercises (problem, correct_answers, answers, categorie, dificultate) VALUES ($1, $2, $3, $4, 'medium')";
    $rsInsertExercitiu = pg_query_params($con, $sqlInsertExercitiu, array("$$" . $_POST["enunt"] . "$$", $varCorecte, $toateVar, $categorie));
    header("Location:../html/adaugareExercitiu.html");
} else {
    header("Location:../html/adaugareExercitiu.html");
}
