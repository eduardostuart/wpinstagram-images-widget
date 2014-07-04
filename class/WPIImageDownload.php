<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPIImageDownload {

    public $url;

    public $name;

    public $path;


    public static function save( $url , $path , $name )
    {

        $instance = new static;

        $instance->url    = $url;
        $instance->path   = $path;
        $instance->name   = $name;

        if( $instance->makeDirectory( $instance->path ) !== true )
        {
            throw new WPICouldNotCreateImageDirectoryException(__('Could not create WPInstagram image path',WPINSTAGRAM_TXT_DOMAIN));
        }

        if( $instance->fileExists() !== false )
        {
            return $instance;
        }

        $imageBody = $instance->grab();

        $instance->createLocalImage( $imageBody );

        return $instance;
    }

    public function getImageFile()
    {
        return rtrim($this->path ,'/') . '/' . $this->name;
    }

    protected function fileExists()
    {
        return ( file_exists( $this->getImageFile() ) );
    }

    protected function makeDirectory( $directory )
    {
        return wp_mkdir_p( $directory );
    }

    protected function grab()
    {
        $get  = wp_remote_get( $this->url );
        $body = wp_remote_retrieve_body( $get );
        return $body;
    }

    protected function createLocalImage( $body )
    {

        if( empty( $body ) )
        {
            throw new WPICouldNotCreateLocalImageException(__('Could not create local image',WPINSTAGRAM_TXT_DOMAIN));
        }

        $fp = @fopen( $this->getImageFile() , 'wb');

        if( !$fp )
        {
            throw new WPICouldNotCreateLocalImageException(__('Could not create local image',WPINSTAGRAM_TXT_DOMAIN));
        }

        $fw = fwrite( $fp , $body );
        fclose($fp);
        clearstatcache();

        return $fw;
    }

}