<?php
include_once 'bd.php';

class User {
    public function adaugaUtilizator( $username, $email, $password ) {
        $sql = 'select count(*) from users where email = $1';
        $result = pg_query_params( BD::oferaConexiune(), $sql, array( $email ) ) or die( "Cannot execute query: $sql\n" );
        ;
        // print_r( pg_fetch_row( $result )[0] );
        if ( intval( pg_fetch_row( $result )[0] ) != 1 ) {
            $sql = 'select count(*) from users where username = $1';
            $result = pg_query_params( BD::oferaConexiune(), $sql, array( $username ) );
            if ( intval( pg_fetch_row( $result )[0] ) != 1 ) {
                $hashPassword = password_hash( $password, PASSWORD_BCRYPT );
                $sql = 'insert into users (username, email, hash_password) values ($1, $2, $3)';
                $result = pg_query_params( BD::oferaConexiune(), $sql, array( $username, $email, $hashPassword ) ) or die( "Cannot execute query: $sql\n" );

            } else {
                return 2;
            }
        } else {
            return 3;
        }
        return 1;
    }

    public function logareUtilizator( $email, $password ) {
        $sql = 'select hash_password from users where email = $1';
        $result = pg_query_params( BD::oferaConexiune(), $sql, array( $email ) ) or die( "Cannot execute query: $sql\n" );
        $hashPassword = pg_fetch_row( $result )[0] ?? '';
        if ( password_verify( $password, $hashPassword ) ) {
            return 1;
        }
        return 0;
    }

    public function clasamentUtilizatori() {
        function toArr() {
            return func_get_args();
        }
        $sql = 'select username, points from users order by points desc limit 10;';
        $result = pg_query( BD::oferaConexiune(), $sql );
        $users = array();
        $points = array();
        while( $row = pg_fetch_row( $result ) ) {
            $users[] = $row[0];
            $points[] = number_format( $row[1], 2, '.', ',' );
        }

        $fp = fopen( '../csv/persons.csv', 'w' );
        fputcsv( $fp, array( "Username", "Punctaj") , ',');
        for ( $i = 0; $i<10; $i++ ) {
            fputcsv( $fp, array( $users[$i], $points[$i]) , ',');
        }
        fclose( $fp );
        $c = array_map ( 'toArr', $users, $points );

        echo json_encode( $c );
    }
    //TO DO: sterge utilizator
}
?>