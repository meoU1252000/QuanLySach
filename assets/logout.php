<?php
session_start();
if(isset($_SESSION['id_customer']) || isset($_SESSION['id_staff'])){
    session_destroy();
    header('location: ./index.php');
} else{
    header('location: ./index.php');
}
?>

