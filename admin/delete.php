<?php
  ob_start();
  session_start();
  include_once './config.php';
  
    if(isset($_POST['delete_id']) && isset($_POST['queryToDelete']) && isset($_POST['locationDelete'])){
       $delete_id = $_POST['delete_id'];
       $location_delete = $_POST['locationDelete'];
       $where = $_POST['queryToDelete'];
       $sql ="DELETE from $location_delete where $where ='$delete_id'";
       
       if(mysqli_query($conn,$sql)){
            $_SESSION['status'] = "Xóa Thành Công!";
            $_SESSION['status_code']= "success";
            if(isset($_POST['queryToBack'])){
                $url = "index.php?page_layout=" .$location_delete;
                $url .="&id=" .$_POST['queryToBack'];
            }else{
                $url = "index.php?page_layout=" .$location_delete;
            }
            if(headers_sent()){
               die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                header ("location: $url");
                die();
            }
       
        } else {
            $_SESSION['status'] = "Xóa Thất Bại!";
            $_SESSION['status_code']= "error";
          
            $conn -> rollback();
            if(isset($_POST['queryToBack'])){
                $url = "index.php?page_layout=" .$location_delete;
                $url .="&id=" .$_POST['queryToBack'];
            }else{
                $url = "index.php?page_layout=" .$location_delete;
            }
            if(headers_sent()){
               die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                header ("location: $url");
                die();
            }
            
        }
    mysqli_close($conn);
    }
    ob_flush() ; 
          
    
 ?>
