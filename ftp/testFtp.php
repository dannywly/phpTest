<?php 
class ftp{ 
    public $conn; 

    public function __construct($url){ 
        $this->conn = ftp_connect($url); 
    } 
    
    public function __call($func,$a){ 
        if(strstr($func,'ftp_') !== false && function_exists($func)){ 
            array_unshift($a,$this->conn); 
            return call_user_func_array($func,$a); 
        }else{ 
            // replace with your own error handler. 
            die("$func is not a valid FTP function"); 
        } 
    } 
} 

// Example 
// $ftp = new ftp('192.168.33.10'); 
// $ftp->ftp_login('tester1','abc123_'); 
$login_result = ftp_login('192.168.33.10','tester1','abc123_'); 
var_dump($login_result); 
?>