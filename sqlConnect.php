<?php
$db_hostname = 'localhost';
$db_username = 'root';
$db_password = 'root';
$database = 'metagen';
$db_con = \mysqli_connect($db_hostname, $db_username, $db_password, $database);
if($db_con === NULL){
    echo "Database connection error";
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
