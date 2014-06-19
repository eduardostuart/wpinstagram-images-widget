<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WPIWrongResponseException extends \RunTimeException{}
class WPICouldNotCreateLocalImageException extends \OutOfBoundsException{}

class WPIInvalidNameException extends \OutOfBoundsException{}
class WPIInvalidURLException  extends \OutOfBoundsException{}
class WPIInvalidPathException extends \OutOfBoundsException{}

class WPICouldNotParse extends \RunTimeException{}
class WPICoultNotGetUserDataException extends \OutOfBoundsException{}
class WPICouldNotCreateImageDirectoryException  extends \OutOfBoundsException{}
