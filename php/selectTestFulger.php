<?php
function selectareTest($dificultateTest)
{
    include_once 'bd.php';
    $con = BD::oferaConexiune();
    $db = $con;
    $nrRandomAlese = array();
    $dificultate = $dificultateTest;
    $sqlCountMax = "SELECT max(id) FROM public.exercises WHERE is_verified = 1 AND dificultate = '$dificultate'"; // WHERE is_verified <> 0";
    $rs = pg_query($db, $sqlCountMax);
    $randNumberMax = intval(pg_fetch_row($rs)[0]);
    //echo "randNbMax".$randNumberMax.' ';
    $exercitiiVerificate = array();
    $sqlCountMax = "SELECT id FROM public.exercises WHERE is_verified = 1 AND dificultate = '$dificultate'";
    $rs = pg_query($db, $sqlCountMax);
    while ($row = pg_fetch_row($rs)){
        $exercitiiVerificate[] = $row[0];
        // echo $row[0].' ';
    }
    // print_r($exercitiiVerificate);
    for ($i = 1; $i <= 5; $i++) {
        $semafor = 0;
        $semafor2 = 0;
        while ($semafor == 0 || $semafor2 == 0) {

            $randNumber = rand(1, $randNumberMax);
            $semafor = 1;
            // verific sa nu mai fi fost ales acest exercitiu
            for ($j = 0; $j < count($nrRandomAlese); $j++) {
                if ($nrRandomAlese[$j] == $randNumber) {
                    $semafor = 0;
                }
            }
            $semafor2 = 0;
            // verific sa fie un exercitiu diferit de cele neverificate
            for ($j = 0; $j < count($exercitiiVerificate); $j++) {
                if ($exercitiiVerificate[$j] == $randNumber) {
                    $semafor2 = 1;
                }
            }
        }
        $nrRandomAlese[] = $randNumber;
        
        //echo $randNumber;
        $sql = "SELECT * FROM public.exercises WHERE id=$1 AND dificultate = $2";
        $rs = pg_query_params($db, $sql, array($randNumber, $dificultate)) or die("Cannot execute query: $sql\n");
        //while($row = pg_fetch_row($rs)){ //merge si fara while ca-i o singura linie returnata
        $row = pg_fetch_row($rs);
        // echo "$row[0] $row[1] $row[2] <br/> $row[3] <br/>";
        echo $row[1];
        $ca = $row[2]; // ca - correct answers - un string - row[2] contine variantele corecte
        $correctAnswers = generareVectorCuVarianteTest($ca);
        // echo "Variantele corecte <br />";
        //pentru fiecare raspuns corect
        foreach ($correctAnswers as $value) {
            //formez interogarea si selectez din variantele de raspuns varianta ce contine raspunsul corect
            $sql1 = "SELECT * FROM public.variante_raspuns WHERE id='$value'";
            $rs1 = pg_query($db, $sql1) or die("Cannot execute query: $sql1\n");
            // while ($row1 = pg_fetch_row($rs1)) {
            //     echo "$row1[1]";
            // }
        }
        // echo "<br />Toate variantele <br />";
        $ans = $row[3]; // ans - answers - un string - row[3] contine variantele de raspuns
        $answersID = generareVectorCuVarianteTest($ans);
        $answersValues = array();
        //pentru fiecare raspuns
        foreach ($answersID as $value) {
            //formez interogarea si selectez din variantele de raspuns varianta ce contine raspunsul
            $sql2 = "SELECT * FROM public.variante_raspuns WHERE id='$value'";
            $rs2 = pg_query($db, $sql2) or die("Cannot execute query: $sql2\n");
            while ($row2 = pg_fetch_row($rs2)) {
                $answersValues[] = $row2[1];
                //echo "$row2[1]";
            }
        }
        generareExercitiuTest($answersID, $correctAnswers, $answersValues, 't1' . $i);
    }
    // print_r($nrRandomAlese);
}

function generareVectorCuVarianteTest($string)
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

function generareExercitiuTest($answers, $correctAnswers, $answersValues, $prefix)
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
        new DOMAttr('id', $prefix . 'a')
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
        new DOMAttr('id', $prefix . 'var1')
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
        new DOMAttr('for', $prefix . 'var1')
    );
    $inputVarAElement = $varAElement->appendChild(new DOMElement('p'));
    $atributInputVarAElement = $inputVarAElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'input1')
    );
    $inputVarAElement->setIdAttribute('id', true);

    //var2

    $varBElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassVarB = $varBElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDVarB = $varBElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'b')
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
        new DOMAttr('id', $prefix . 'var2')
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
        new DOMAttr('for', $prefix . 'var2')
    );
    $inputVarBElement = $varBElement->appendChild(new DOMElement('p'));
    $atributInputVarBElement = $inputVarBElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'input2')
    );
    $inputVarBElement->setIdAttribute('id', true);

    //var3

    $varCElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassvarC = $varCElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDvarC = $varCElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'c')
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
        new DOMAttr('id', $prefix . 'var3')
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
        new DOMAttr('for', $prefix . 'var3')
    );
    $inputvarCElement = $varCElement->appendChild(new DOMElement('p'));
    $atributInputvarCElement = $inputvarCElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'input3')
    );
    $inputvarCElement->setIdAttribute('id', true);

    //var4

    $varDElement = $responseEx1Element->appendChild(new DOMElement('div'));
    $atributClassvarD = $varDElement->setAttributeNode(new DOMAttr('class', 'var'));
    $atributIDvarD = $varDElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'd')
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
        new DOMAttr('id', $prefix . 'var4')
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
        new DOMAttr('for', $prefix . 'var4')
    );
    $inputvarDElement = $varDElement->appendChild(new DOMElement('p'));
    $atributInputvarDElement = $inputvarDElement->setAttributeNode(
        new DOMAttr('id', $prefix . 'input4')
    );
    $inputvarCElement->setIdAttribute('id', true);

    $buttonEx1 = $responseEx1Element->appendChild(new DOMElement('button', 'Verifica raspuns'));
    $atribut1ButtonEx1 = $buttonEx1->setAttributeNode(new DOMAttr('type', 'button'));
    $atribut2ButtonEx1 = $buttonEx1->setAttributeNode(new DOMAttr('class', 'send-answer'));
    $atribut3ButtonEx1 = $buttonEx1->setAttributeNode(new DOMAttr('onclick', 'verifyAnswer(\'' . $prefix . '\')'));
    $atribut4ButtonEx1 = $buttonEx1->setAttributeNode((new DOMAttr('id', $prefix . 'button-ex')));
    $buttonEx1->setIdAttribute('id', true);
    echo $dom->saveHTML();
}
