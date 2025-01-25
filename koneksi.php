<?php 
/**
* using mysqli_connect for database connection
*/
$databaseHost = 'localhost';
$databaseName = 'oop';
$databaseUsername = 'root';
$databasePassword = '';
$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, 
$databaseName); 
?>