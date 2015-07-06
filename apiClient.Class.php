<?php
class APIClient
{
    private static $url = 'https://ion.hugeserver.com/api/v2/';
    private static $key = 'user:key';

    public static function __callStatic( $method, $param )
    {
        if ( !extension_loaded('curl') ) {
            throw new Exception('cURL support is required',1);
        }
        if ( !isset( $method ) ) {
            throw new Exception( "Syntax Error", 3 );
        }

        $ch = curl_init();

        if ( isset( $param[0] ) && !( count( $param[0] ) == 1 && strpos( key( $param[0] ), 'ID') > 1 ) ) {
            for( $i=0; $i < count( $param[0] ); $i++ ) {
                if( is_array( $param[0][ key( $param[0] ) ] ) ) {
                    $param[0][ key( $param[0] ) ] = json_encode( $param[0][ key( $param[0] ) ] );
                }
                next( $param[0] );
            }
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $param[0] );
            curl_setopt( $ch, CURLOPT_URL, self::$url . $method );
        } else if( isset( $param[0] ) ) {
            curl_setopt( $ch, CURLOPT_URL, self::$url . $method . '/' . $param[0][ key($param[0]) ] );
        } else {
            curl_setopt( $ch, CURLOPT_URL, self::$url . $method );
        }

        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_USERPWD, self::$key );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,1 );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 2 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        try {
            $result = curl_exec( $ch );
        } catch ( RestException $e ) {
            throw new Exception( curl_error( $ch ), curl_errno( $ch ) );
        }
        if( $result === false ) {
            curl_close( $ch );
            throw new Exception( curl_error( $ch ), curl_errno( $ch ) );
        }
        if( strpos( $result, "{" ) < 3 || curl_getinfo( $ch, CURLINFO_CONTENT_TYPE ) == 'application/json') {
            return json_decode($result, true);
        } else {
            return ($result);
        }
    }
}

