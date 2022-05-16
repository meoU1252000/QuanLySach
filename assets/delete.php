<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script>
    function deleteData(event){
      event.preventDefault();
      var form = event.target.closest("form");
      //console.log(form);
        swal({
          title: "Chắc chắn xóa?",
          text: "Dữ liệu sau khi xóa sẽ không thể khôi phục. Tiếp tục ?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              form.submit();
            } else {
              swal("Hủy thành công!");
            }
         });;
        
    }
</script>
<?php
  include_once '../admin/config.php';
  ob_start();

  
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
