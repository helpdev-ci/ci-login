<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once "../application/libraries/HPG/Auth_library.php";
class Auth extends Auth_library {
    public function __construct() {
        parent::__construct();
    }
}