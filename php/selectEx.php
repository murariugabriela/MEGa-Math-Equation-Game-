<?php
// include_once 'bd.php';
// $host = "localhost";
// $user = "postgres";
// $pass = "student";
// $db = "MathML";
// $con = pg_connect("host = $host dbname = $db user = $user password=$pass") or die("Could not connect to Server\n");

//$database = new Database();
// $db = $database->getConnection();
function selectareExercitiu($numePagina)
{
    include_once 'bd.php';
    $db = BD::oferaConexiune();
    //SQL INJECTION
    // $sql1 = "SELECT id from variante_raspuns WHERE raspuns= $1";
    // $rs1 = pg_query_params($con, $sql1, array("$$".$_POST["varRasp1"]."$$")) or die("Cannot execute query: $sql1\n");
    $pagina = $numePagina;
    $sqlCountMax = "SELECT max(id) FROM public.exercises where categorie = $1";
    $rs1 = pg_query_params($db, $sqlCountMax, array($pagina)) or die("Cannot execute query: $sqlCountMax\n");
    $numarExercitii = intval(pg_fetch_row($rs1)[0]);
    // echo $numarExercitii;
    //$exercitiiNeverificate = pg_fetch_row( $rs );
    $exercitiiVerificate = array();
    $sqlaltul = "SELECT count(*) FROM public.exercises WHERE (is_verified = 1 AND categorie = '$pagina')";
    $rs = pg_query($db, $sqlaltul);
    $nrExercitiiVerificate = intval(pg_fetch_row($rs)[0]);

    $sqlCountMax = "SELECT id FROM public.exercises WHERE (is_verified = 1 AND categorie = '$pagina') ";
    $rs = pg_query($db, $sqlCountMax);

    while ($row2 = pg_fetch_row($rs))
        $exercitiiVerificate[] = $row2[0];
    $semafor = 0;
    $semafor2 = 1;
    // print_r($exercitiiVerificate);
    // $sqlCountMax = "SELECT id FROM public.exercises";
    // $rs = pg_query($db, $sqlCountMax);
    // $exercitiiVerificate = pg_fetch_row( $rs );
    while ($semafor == 0) {
        $randNumber = rand(1, $numarExercitii);
        // echo $randNumber."\t";
        $semafor = 0;
        // verific sa fie un exercitiu diferit de cele neverificate
        for ($j = 0; $j < count($exercitiiVerificate); $j++) {
            if ($exercitiiVerificate[$j] == $randNumber) {
                $semafor = 1;
            }
        }
        // $semafor2 = 0;
        // $ok = 1;
        // for ($j = 0; $j < count($exercitiiVerificate); $j++){
        //         if ($exercitiiVerificate[$j] == $randNumber){
        //             $ok = 0; echo "am gasit id";
        //         }
        //     }
        //     if($ok == 1){
        //         $semafor2 = 1;
        //     }
    }
    $sql = "SELECT * FROM public.exercises WHERE id=$1";
    $rs = pg_query_params($db, $sql, array($randNumber)) or die("Cannot execute query: $sql\n");
    //while($row = pg_fetch_row($rs)){ //merge si fara while ca-i o singura linie returnata
    $row = pg_fetch_row($rs);
    // echo "$row[0] $row[1] $row[2] <br/> $row[3] <br/>";
    echo $row[1];
    $ca = $row[2]; // ca - correct answers - un string - row[2] contine variantele corecte
    $correctAnswers = generareVectorCuVariante($ca);
    // echo "Variantele corecte <br />";
    //pentru fiecare raspuns corect
    // foreach ($correctAnswers as $value) {
    //     //formez interogarea si selectez din variantele de raspuns varianta ce contine raspunsul corect
    //     $sql1 = "SELECT * FROM public.variante_raspuns WHERE id=$1";
    //     echo "value este: ".$value;
    //     $rs1 = pg_query_params($db, $sql1, array(intval($value))) or die("Cannot execute query: $sql1\n");
    //     // while ($row1 = pg_fetch_row($rs1)) {
    //     //     echo "$row1[1]";
    //     // }
    // }
    // echo "<br />Toate variantele <br />";
    $ans = $row[3]; // ans - answers - un string - row[3] contine variantele de raspuns
    $answersID = generareVectorCuVariante($ans);
    $answersValues = array();
    //pentru fiecare raspuns
    foreach ($answersID as $value) {
        //formez interogarea si selectez din variantele de raspuns varianta ce contine raspunsul
        $sql2 = "SELECT * FROM public.variante_raspuns WHERE id=$1";
        $rs2 = pg_query_params($db, $sql2, array(intval($value))) or die("Cannot execute query: $sql2\n");
        while ($row2 = pg_fetch_row($rs2)) {
            $answersValues[] = $row2[1];
            //echo "$row2[1]";
        }
    }
    generareExercitiu($answersID, $correctAnswers, $answersValues);
}

function generareVectorCuVariante($string)
{

    $answers = array();

    $delimiters = ", "; // delimitatorii
    $string = strtok($string, $delimiters);
    while ($string !== false) {
        $answers[] = $string;
        $string = strtok($delimiters);
    }
    // foreach($answers as $value){
    //     echo "$value <br/>";
    // }
    return $answers;
}

function generareExercitiu($answers, $correctAnswers, $answersValues)
{

    libxml_use_internal_errors(true);
    $dom = new DOMDocument('1.0', 'iso-8859-1');
    libxml_clear_errors();

    $form = $dom->appendChild(new DOMElement('form'));
    $atributForm = $form->setAttributeNode(
        new DOMAttr('class', 'raspunsuri')
    );
    $responseEx1Element = $form->appendChild(new DOMElement('div'));
    $atributResponseEx1 = $responseEx1Element->setAttributeNode(
        new DOMAttr('class', 'raspunsuri-ex-1')
    );

    //var1

    $varAElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassVarA = $varAElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDVarA = $varAElement->setAttributeNode(
        new DOMAttr('id', 'a')
    );
    $varAElement->setIdAttribute('id', true);
    $checkboxElement = $varAElement->appendChild(new DOMElement('div'));
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr('class', 'checkbox')
    );
    $inputVarA = $checkboxElement->appendChild(new DOMElement('input'));
    $atributInputVarAType = $inputVarA->setAttributeNode(
        new DOMAttr('type', 'checkbox')
    );

    $atributInputVarAID = $inputVarA->setAttributeNode(
        new DOMAttr('id', 'var1')
    );
    $inputVarA->setIdAttribute('id', true);
    $labelEx1Element = $checkboxElement->appendChild(new DOMElement('label', $answersValues[0]));
    $labelEx1Element->nodeValue = $answersValues[0];

    $valoareDeAdevarA = 'false';
    foreach ($correctAnswers as $value) {
        if ($value === $answers[0]) {
            $valoareDeAdevarA = 'true';
        }
    }
    $atributInputVarAValue = $inputVarA->setAttributeNode(
        new DOMAttr('value', $valoareDeAdevarA)
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr('for', 'var1')
    );
    $inputVarAElement = $varAElement->appendChild(new DOMElement('p'));
    $atributInputVarAElement = $inputVarAElement->setAttributeNode(
        new DOMAttr('id', 'input1')
    );
    $inputVarAElement->setIdAttribute('id', true);

    //var2

    $varBElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassVarB = $varBElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDVarB = $varBElement->setAttributeNode(
        new DOMAttr('id', 'b')
    );
    $varBElement->setIdAttribute('id', true);
    $checkboxElement = $varBElement->appendChild(new DOMElement('div'));
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr('class', 'checkbox')
    );
    $inputVarB = $checkboxElement->appendChild(new DOMElement('input'));
    $atributInputVarBType = $inputVarB->setAttributeNode(
        new DOMAttr('type', 'checkbox')
    );
    $atributInputVarBID = $inputVarB->setAttributeNode(
        new DOMAttr('id', 'var2')
    );
    $inputVarB->setIdAttribute('id', true);
    $labelEx1Element = $checkboxElement->appendChild(new DOMElement('label', $answersValues[1]));
    $valoareDeAdevarB = 'false';
    foreach ($correctAnswers as $value) {
        if ($value === $answers[1]) {
            $valoareDeAdevarB = 'true';
        }
    }
    $atributInputVarBValue = $inputVarB->setAttributeNode(
        new DOMAttr('value', $valoareDeAdevarB)
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr('for', 'var2')
    );
    $inputVarBElement = $varBElement->appendChild(new DOMElement('p'));
    $atributInputVarBElement = $inputVarBElement->setAttributeNode(
        new DOMAttr('id', 'input2')
    );
    $inputVarBElement->setIdAttribute('id', true);

    //var3

    $varCElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassvarC = $varCElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDvarC = $varCElement->setAttributeNode(
        new DOMAttr('id', 'c')
    );
    $varCElement->setIdAttribute('id', true);
    $checkboxElement = $varCElement->appendChild(new DOMElement('div'));
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr('class', 'checkbox')
    );
    $inputvarC = $checkboxElement->appendChild(new DOMElement('input'));
    $atributInputvarCType = $inputvarC->setAttributeNode(
        new DOMAttr('type', 'checkbox')
    );
    $atributInputvarCID = $inputvarC->setAttributeNode(
        new DOMAttr('id', 'var3')
    );
    $inputvarC->setIdAttribute('id', true);
    $labelEx1Element = $checkboxElement->appendChild(new DOMElement('label', $answersValues[2]));
    $valoareDeAdevarC = 'false';
    foreach ($correctAnswers as $value) {
        if ($value === $answers[2]) {
            $valoareDeAdevarC = 'true';
        }
    }
    $atributInputvarCValue = $inputvarC->setAttributeNode(
        new DOMAttr('value', $valoareDeAdevarC)
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr('for', 'var3')
    );
    $inputvarCElement = $varCElement->appendChild(new DOMElement('p'));
    $atributInputvarCElement = $inputvarCElement->setAttributeNode(
        new DOMAttr('id', 'input3')
    );
    $inputvarCElement->setIdAttribute('id', true);

    //var4

    $varDElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassvarD = $varDElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDvarD = $varDElement->setAttributeNode(
        new DOMAttr('id', 'd')
    );
    $varDElement->setIdAttribute('id', true);
    $checkboxElement = $varDElement->appendChild(new DOMElement('div'));
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr('class', 'checkbox')
    );
    $inputvarD = $checkboxElement->appendChild(new DOMElement('input'));
    $atributInputvarDType = $inputvarD->setAttributeNode(
        new DOMAttr('type', 'checkbox')
    );
    $atributInputvarDID = $inputvarD->setAttributeNode(
        new DOMAttr('id', 'var4')
    );
    $inputvarD->setIdAttribute('id', true);
    $labelEx1Element = $checkboxElement->appendChild(new DOMElement('label', $answersValues[3]));
    $valoareDeAdevarD = 'false';
    foreach ($correctAnswers as $value) {
        if ($value === $answers[3]) {
            $valoareDeAdevarD = 'true';
        }
    }
    $atributInputvarDValue = $inputvarD->setAttributeNode(
        new DOMAttr('value', $valoareDeAdevarD)
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr('for', 'var4')
    );
    $inputvarDElement = $varDElement->appendChild(new DOMElement('p'));
    $atributInputvarDElement = $inputvarDElement->setAttributeNode(
        new DOMAttr('id', 'input4')
    );
    $inputvarCElement->setIdAttribute('id', true);

    $buttonEx1 = $responseEx1Element->appendChild(new DOMElement('button', 'Verifica raspuns'));
    $atribut1ButtonEx1 = $buttonEx1->setAttributeNode(new DOMAttr('type', 'button'));
    $atribut2ButtonEx1 = $buttonEx1->setAttributeNode(new DOMAttr('class', 'send-answer'));
    $atribut3ButtonEx1 = $buttonEx1->setAttributeNode(new DOMAttr('onclick', 'verifyAnswer(\'\')'));
    $atribut4ButtonEx1 = $buttonEx1->setAttributeNode((new DOMAttr('id', 'button-ex')));
    $buttonEx1->setIdAttribute('id', true);
    echo $dom->saveHTML();
}
