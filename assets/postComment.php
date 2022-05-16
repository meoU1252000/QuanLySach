<?php 
include_once '../admin/config.php';
session_start();
if(isset($_POST['idCustomer']) && isset($_POST['idProduct']) && isset($_POST['productComment']) && isset($_POST['dateTime'])){
   $output = "Thành Công";
   $id_customer = $_POST['idCustomer'];
   $id_product = $_POST['idProduct'];
   $productComment = $_POST['productComment'];
   $dateTime = $_POST['dateTime'];
   $sql ="INSERT into productcomment(id_product,id_customer,product_comment,time_comment) value ('$id_product','$id_customer','$productComment','$dateTime')";
   if(mysqli_query($conn,$sql)){
      echo $output;
   }else{
       echo "Error: ".mysqli_error($conn);
   }
}
?>