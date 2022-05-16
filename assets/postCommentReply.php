<?php 
include_once '../admin/config.php';
session_start();
if(isset($_POST['idStaff']) && isset($_POST['idComment']) && isset($_POST['reply']) && isset($_POST['dateTime'])){
   $output = "Thành Công";
   $idStaff = $_POST['idStaff'];
   $idComment = $_POST['idComment'];
   $replyComment = $_POST['reply'];
   $dateTime = $_POST['dateTime'];
   $sql ="INSERT into productcommentreply(id_comment,id_staff,comment_reply,time_reply) value ('$idComment','$idStaff','$replyComment','$dateTime')";
   if(mysqli_query($conn,$sql)){
      echo $output;
   }else{
       echo "Error: ".mysqli_error($conn);
   }
}
?>