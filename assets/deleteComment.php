<?php 
include_once '../admin/config.php';
session_start();
if(isset($_POST['idComment'])){
    $output = "Thành Công";
    $idComment = $_POST['idComment'];
    $sql = "DELETE from productcomment where id_comment = '$idComment'";
    if(mysqli_query($conn,$sql)){
        echo $output;
    }
}
?>
