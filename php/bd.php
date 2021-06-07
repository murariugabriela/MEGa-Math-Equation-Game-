<?php

class BD {
    private static $conexiune = null;
    public static function oferaConexiune() {
        if ( is_null( self::$conexiune ) )
        {
            self::$conexiune = pg_connect( 'host=localhost port=5432 dbname=MathML user=postgres password=gabriela' ) or die( 'Could not connect' );
        }
        return self::$conexiune;
    }
}

?>