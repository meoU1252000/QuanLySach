<?php 
include '../admin/config.php';
session_start();
if(isset($_POST['search'])){
    $search = $_POST['search'];
    $sql = mysqli_query($conn,"SELECT * from product where name_product like '%$search%' order by id_product asc limit 1 ");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_array($sql);
        $id = $row['id_product'];
        $url = "index.php?page_layout=productDetails&id=" .$id;
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
            header ("location: $url");
            die();
            // echo mysqli_error($conn);
            // echo $sql;
        }
    }else{
        $_SESSION['title'] = "Thất Bại!";
        $_SESSION['text'] = "Sản Phẩm không tồn tại! Vui lòng thử lại";
        $_SESSION['icon']= "error";
        // echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
        $conn -> rollback();
        $url = "index.php";
        if(headers_sent()){
            die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        }else{
             header ("location: $url");
             die();
        }
    }
}
?>