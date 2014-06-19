<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPICache {


    public static function isCacheEnabled()
    {
        return (defined('WPINSTAGRAM_CACHE_ENABLED') && WPINSTAGRAM_CACHE_ENABLED == true );
    }


    public static function set( $key , $value , $lifetime = 300 )
    {
        $value = array(
            'expires'  => time() + $lifetime,
            'values'   => $values
        );

        delete_option( $key );
        add_option( $key , serialize($value) );

        return $values;
    }

    public static function delete( $key )
    {
        delete_option( $key );
    }

    public static function get( $key )
    {

        if( !self::isCacheEnabled() )
        {
            return null;
        }

        $cached = get_option( $key );

        if( !$cached ){
            return null;
        }

        $cached = @unserialize($cached);

        if( !$cached || !isset($cached['expires'])  )
        {
            return null;
        }

        if( !self::hasExpired( $cached['expires'] ) )
        {
            return $cached['values'];
        }

        return null;
    }

    public function hasExpired( $expires )
    {
        return ( $expires < time() );
    }


}