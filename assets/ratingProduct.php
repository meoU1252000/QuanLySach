<?php 
include_once '../admin/config.php';
session_start();
  if(isset($_POST['idProduct']) && isset($_POST['idCus']) && isset($_POST['starRating']) && isset($_POST['idOrder'])){
    $output = "Thành Công";
    $idOrder = $_POST['idOrder'];
    $idProduct = $_POST['idProduct'];
    $idCus = $_POST['idCus'];  
    $starRating = $_POST['starRating'];
    $sql = "INSERT into productrating(id_order,id_product,id_customer,star_rating) values ('$idOrder','$idProduct','$idCus','$starRating')";
    if(mysqli_query($conn,$sql)){
        echo $output;
    }
  }
?>