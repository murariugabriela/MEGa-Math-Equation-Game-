<?php

function afisareExercitii()
 {
    include_once 'bd.php';
    $db = BD::oferaConexiune();
}

function selectareExercitiu()
 {
    include_once 'bd.php';
    $db = BD::oferaConexiune();
    //SQL INJECTION
    // $sql1 = "SELECT id from variante_raspuns WHERE raspuns= $1";
    // $rs1 = pg_query_params( $con, $sql1, array( "$$".$_POST['varRasp1']."$$" ) ) or die( "Cannot execute query: $sql1\n" );
    $sqlCountMax = 'SELECT count(*) FROM public.exercises where is_verified = 0';
    $rs1 = pg_query( $db, $sqlCountMax ) or die( "Cannot execute query: $sqlCountMax\n" );
    $numarExercitii = intval( pg_fetch_row( $rs1 )[0] );
    // echo $numarExercitii;
    //$exercitiiNeverificate = pg_fetch_row( $rs );
    $exercitiiNeverificate = array();

    $sql = 'SELECT * FROM public.exercises WHERE is_verified = 0 ';
    $rs = pg_query( $db, $sql );

    while ( $row2 = pg_fetch_row( $rs ) )
    $exercitiiNeverificate[] = $row2[0];
    for ( $i = 0; $i < sizeof( $exercitiiNeverificate );
    $i++ ) {
        $sql = "SELECT * FROM public.exercises WHERE id=$1";
        $rs = pg_query_params( $db, $sql, array( $exercitiiNeverificate[$i] ) ) or die( "Cannot execute query: $sql\n" );
        //while( $row = pg_fetch_row( $rs ) ) {
        //merge si fara while ca-i o singura linie returnata
        $row = pg_fetch_row( $rs );
        // echo "$row[0] $row[1] $row[2] <br/> $row[3] <br/>";
        echo $row[1].'<br/>';
        $exId = intval( $row[0] );
        echo "$$".$row[5]."$$";
        $ca = $row[2];
        // ca - correct answers - un string - row[2] contine variantele corecte
        $correctAnswers = generareVectorCuVariante( $ca );

        $ans = $row[3];
        // ans - answers - un string - row[3] contine variantele de raspuns
        $answersID = generareVectorCuVariante( $ans );
        $answersValues = array();
        //pentru fiecare raspuns
        foreach ( $answersID as $value ) {
            //formez interogarea si selectez din variantele de raspuns varianta ce contine raspunsul
            $sql2 = "SELECT * FROM public.variante_raspuns WHERE id=$1";
            $rs2 = pg_query_params( $db, $sql2, array( intval( $value ) ) ) or die( "Cannot execute query: $sql2\n" );
            while ( $row2 = pg_fetch_row( $rs2 ) ) {
                $answersValues[] = $row2[1];
                //echo "$row2[1]";
            }
        }
        generareExercitiu( $answersID, $correctAnswers, $answersValues, $i, $exId );
    }
}

function generareVectorCuVariante( $string )
 {

    $answers = array();

    $delimiters = ', ';
    // delimitatorii
    $string = strtok( $string, $delimiters );
    while ( $string !== false ) {
        $answers[] = $string;
        $string = strtok( $delimiters );
    }
    return $answers;
}

function generareExercitiu( $answers, $correctAnswers, $answersValues, $prefix, $id )
 {

    libxml_use_internal_errors( true );
    $dom = new DOMDocument( '1.0', 'iso-8859-1' );
    libxml_clear_errors();
    $divExId = $dom->appendChild( new DOMElement( 'div' ) );
    $atributIDEX = $divExId->setAttributeNode(
        new DOMAttr( 'id', $prefix.'idEx' )
    );
    $divExId->setIdAttribute( 'id', true );
    $textIdEx = $divExId->appendChild( new DOMElement( 'text', $id ) );
    $form = $dom->appendChild( new DOMElement( 'form' ) );
    $atributForm = $form->setAttributeNode(
        new DOMAttr( 'class', 'raspunsuri' )
    );
    $responseEx1Element = $form->appendChild( new DOMElement( 'div' ) );
    $atributResponseEx1 = $responseEx1Element->setAttributeNode(
        new DOMAttr( 'class', 'raspunsuri-ex-1' )
    );

    //var1

    $varAElement = $responseEx1Element->appendChild( new DOMElement( 'div' ) );
    $atributClassVarA = $varAElement->setAttributeNode( new DOMAttr( 'class', 'var' ) );
    $atributIDVarA = $varAElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'a' )
    );
    $varAElement->setIdAttribute( 'id', true );
    $checkboxElement = $varAElement->appendChild( new DOMElement( 'div' ) );
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr( 'class', 'checkbox' )
    );
    $inputVarA = $checkboxElement->appendChild( new DOMElement( 'input' ) );
    $atributInputVarAType = $inputVarA->setAttributeNode(
        new DOMAttr( 'type', 'checkbox' )
    );

    $atributInputVarAID = $inputVarA->setAttributeNode(
        new DOMAttr( 'id', $prefix.'var1' )
    );
    $inputVarA->setIdAttribute( 'id', true );
    $labelEx1Element = $checkboxElement->appendChild( new DOMElement( 'label', $answersValues[0] ) );
    $labelEx1Element->nodeValue = $answersValues[0];

    $valoareDeAdevarA = 'false';
    foreach ( $correctAnswers as $value ) {
        if ( $value === $answers[0] ) {
            $valoareDeAdevarA = 'true';
        }
    }
    $atributInputVarAValue = $inputVarA->setAttributeNode(
        new DOMAttr( 'value', $valoareDeAdevarA )
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr( 'for', $prefix.'var1' )
    );
    $inputVarAElement = $varAElement->appendChild( new DOMElement( 'p' ) );
    $atributInputVarAElement = $inputVarAElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'input1' )
    );
    $inputVarAElement->setIdAttribute( 'id', true );

    //var2

    $varBElement = $responseEx1Element->appendChild( new DOMElement( 'div' ) );
    $atributClassVarB = $varBElement->setAttributeNode( new DOMAttr( 'class', 'var' ) );
    $atributIDVarB = $varBElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'b' )
    );
    $varBElement->setIdAttribute( 'id', true );
    $checkboxElement = $varBElement->appendChild( new DOMElement( 'div' ) );
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr( 'class', 'checkbox' )
    );
    $inputVarB = $checkboxElement->appendChild( new DOMElement( 'input' ) );
    $atributInputVarBType = $inputVarB->setAttributeNode(
        new DOMAttr( 'type', 'checkbox' )
    );
    $atributInputVarBID = $inputVarB->setAttributeNode(
        new DOMAttr( 'id', $prefix.'var2' )
    );
    $inputVarB->setIdAttribute( 'id', true );
    $labelEx1Element = $checkboxElement->appendChild( new DOMElement( 'label', $answersValues[1] ) );
    $valoareDeAdevarB = 'false';
    foreach ( $correctAnswers as $value ) {
        if ( $value === $answers[1] ) {
            $valoareDeAdevarB = 'true';
        }
    }
    $atributInputVarBValue = $inputVarB->setAttributeNode(
        new DOMAttr( 'value', $valoareDeAdevarB )
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr( 'for', $prefix.'var2' )
    );
    $inputVarBElement = $varBElement->appendChild( new DOMElement( 'p' ) );
    $atributInputVarBElement = $inputVarBElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'input2' )
    );
    $inputVarBElement->setIdAttribute( 'id', true );

    //var3

    $varCElement = $responseEx1Element->appendChild( new DOMElement( 'div' ) );
    $atributClassvarC = $varCElement->setAttributeNode( new DOMAttr( 'class', 'var' ) );
    $atributIDvarC = $varCElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'c' )
    );
    $varCElement->setIdAttribute( 'id', true );
    $checkboxElement = $varCElement->appendChild( new DOMElement( 'div' ) );
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr( 'class', 'checkbox' )
    );
    $inputvarC = $checkboxElement->appendChild( new DOMElement( 'input' ) );
    $atributInputvarCType = $inputvarC->setAttributeNode(
        new DOMAttr( 'type', 'checkbox' )
    );
    $atributInputvarCID = $inputvarC->setAttributeNode(
        new DOMAttr( 'id', $prefix.'var3' )
    );
    $inputvarC->setIdAttribute( 'id', true );
    $labelEx1Element = $checkboxElement->appendChild( new DOMElement( 'label', $answersValues[2] ) );
    $valoareDeAdevarC = 'false';
    foreach ( $correctAnswers as $value ) {
        if ( $value === $answers[2] ) {
            $valoareDeAdevarC = 'true';
        }
    }
    $atributInputvarCValue = $inputvarC->setAttributeNode(
        new DOMAttr( 'value', $valoareDeAdevarC )
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr( 'for', $prefix.'var3' )
    );
    $inputvarCElement = $varCElement->appendChild( new DOMElement( 'p' ) );
    $atributInputvarCElement = $inputvarCElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'input3' )
    );
    $inputvarCElement->setIdAttribute( 'id', true );

    //var4

    $varDElement = $responseEx1Element->appendChild( new DOMElement( 'div' ) );
    $atributClassvarD = $varDElement->setAttributeNode( new DOMAttr( 'class', 'var' ) );
    $atributIDvarD = $varDElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'d' )
    );
    $varDElement->setIdAttribute( 'id', true );
    $checkboxElement = $varDElement->appendChild( new DOMElement( 'div' ) );
    $atributCheckboxElement = $checkboxElement->setAttributeNode(
        new DOMAttr( 'class', 'checkbox' )
    );
    $inputvarD = $checkboxElement->appendChild( new DOMElement( 'input' ) );
    $atributInputvarDType = $inputvarD->setAttributeNode(
        new DOMAttr( 'type', 'checkbox' )
    );
    $atributInputvarDID = $inputvarD->setAttributeNode(
        new DOMAttr( 'id', $prefix.'var4' )
    );
    $inputvarD->setIdAttribute( 'id', true );
    $labelEx1Element = $checkboxElement->appendChild( new DOMElement( 'label', $answersValues[3] ) );
    $valoareDeAdevarD = 'false';
    foreach ( $correctAnswers as $value ) {
        if ( $value === $answers[3] ) {
            $valoareDeAdevarD = 'true';
        }
    }
    $atributInputvarDValue = $inputvarD->setAttributeNode(
        new DOMAttr( 'value', $valoareDeAdevarD )
    );
    $atributLabelEx1Element = $labelEx1Element->setAttributeNode(
        new DOMAttr( 'for', $prefix.'var4' )
    );
    $inputvarDElement = $varDElement->appendChild( new DOMElement( 'p' ) );
    $atributInputvarDElement = $inputvarDElement->setAttributeNode(
        new DOMAttr( 'id', $prefix.'input4' )
    );
    $inputvarCElement->setIdAttribute( 'id', true );

    $buttonEx1 = $responseEx1Element->appendChild( new DOMElement( 'button', 'Accepta' ) );
    $button1Click = $buttonEx1->setAttributeNode(
        new DOMAttr( 'onclick', 'verificaExercitiu(\'accepta\', '.$prefix.')' )
    );
    $button2Ex1 = $responseEx1Element->appendChild( new DOMElement( 'button', 'Respinge' ) );
    $button2Click = $button2Ex1->setAttributeNode(
        new DOMAttr( 'onclick', 'verificaExercitiu(\'sterge\', '.$prefix.')' )
    );
    $atribut1ButtonEx1 = $buttonEx1->setAttributeNode( new DOMAttr( 'type', 'button' ) );
    $atribut2ButtonEx1 = $buttonEx1->setAttributeNode( new DOMAttr( 'class', 'send-answer' ) );
    $atributB = $button2Ex1->setAttributeNode( new DOMAttr( 'class', 'send-answer' ) );
    // $atribut3ButtonEx1 = $buttonEx1->setAttributeNode( new DOMAttr( 'onclick', 'verifyAnswer(\'\')' ) );
    // $atribut4ButtonEx1 = $buttonEx1->setAttributeNode( ( new DOMAttr( 'id', $prefix.'button-ex' ) ) );
    // $buttonEx1->setIdAttribute( 'id', true );
    echo $dom->saveHTML();
}
