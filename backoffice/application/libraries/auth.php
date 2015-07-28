<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once "../application/libraries/HPG/Auth.php";
class Auth extends HPG_Auth {
    public function __construct() {
        parent::__construct();
    }
}