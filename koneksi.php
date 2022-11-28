<?php
    $host="localhost";
    $user="root";
    $password="";
    $database="db_hp";
    
    $koneksi=mysqli_connect($host, $user, $password, $database);
    error_reporting(E_ALL ^ E_DEPRECATED && E_NOTICE);
?>