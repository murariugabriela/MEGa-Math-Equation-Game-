<?php
include_once 'bd.php';
if ( isset( $_POST['semafor'] ) && isset( $_POST['idEx'] ) )
 {
    $semafor = $_POST['semafor'];
    $id = $_POST['idEx'];
    if ( $semafor == 'sterge' ) {
        $sql = 'delete from exercises where id = $1';
        $result = pg_query_params( BD::oferaConexiune(), $sql, array( $id ) ) or die( "Cannot execute query: $sql\n" );
        // $row = pg_fetch_row( $result );
        echo "Exercitiul a fost respins";
    }
    else
    if ( $semafor == 'accepta' ) {
        $sql = 'update exercises set is_verified = 1 where id = $1';
        $result = pg_query_params( BD::oferaConexiune(), $sql, array( $id ) ) or die( "Cannot execute query: $sql\n" );
        // $row = pg_fetch_row( $result );
        echo "Exercitiul a fost acceptat";
    }

}

?>