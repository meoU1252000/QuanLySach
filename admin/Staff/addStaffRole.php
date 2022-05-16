
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("1", $_SESSION['roleStaff'], true)){
        $id_staff = $_REQUEST['id'];
        $query_staff = mysqli_query($conn,"SELECT * from staff where id_staff = '$id_staff'");
        $row_staff = mysqli_fetch_array($query_staff);
        $query_role = mysqli_query($conn, "SELECT * from roledetails where id_staff = '$id_staff'");
        if(isset($_POST['add_role'])){
            $i = 0;
            $role_add= array();
            foreach($_POST['id_role'] as $newrole){
                $role_add[$i]=$newrole;
                $i=$i+1;
            }
            $sql = "";
            for($i = 0; $i < count($role_add) ; $i++){
                $sql .= " INSERT into roledetails(id_staff,id_role) values ('$id_staff', '".$role_add[$i]."');";
            }
            if(mysqli_multi_query($conn,$sql)){
                $_SESSION['status'] = "Thêm Thành Công!";
                $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=staffRole";
                if(headers_sent()){
                   die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
               }else{
                    header ("location: $url");
                    die();
               }
            }else {
            //    $_SESSION['status'] = "Thêm Thất Bại!";
            //    $_SESSION['status_code']= "error";
            //    $conn -> rollback();
            //    $url = "index.php?page_layout=staffRole";
            //    if(headers_sent()){
            //        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            //    }else{
            //         header ("location: $url");
            //         die();
            //    }
               echo "Error: " . $sql . "<br>" . mysqli_error($conn);
           }
        }
    }else{
        echo '<script language="javascript">';
        echo 'alert("Bạn không có quyền truy cập vào trang này")';
        echo '</script>';
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

         <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Quản Lý Quyền Truy Cập Nhân Viên</li>
                </ol>
            <div class="body-page--function-form">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Phân Quyền Nhân Viên
                    </div>
                            <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                                <div class="card-body">
                                        <div class="form-group">
                                            <label for="InputTypeGroup">Nhân Viên</label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_staff" name="id_staff" required>
                                                <option value="<?php echo $row_staff['id_staff']; ?>" selected><?php echo $row_staff['name_staff'];?></option>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                           <?php 
                                               $id_newRole = array();
                                               while($row_role = mysqli_fetch_array($query_role)){
                                                  array_push($id_newRole,$row_role['id_role']);
                                               }
                                            ?>
                                               
                                         <div class="form-group">
                                           <p><label for="inputAddress">Các Quyền Có Thể Thêm</label></p>
                                           <?php 
                                               $query_newrole = mysqli_query($conn,"SELECT * from rolestaff WHERE id_role NOT IN ( '" . implode( "', '" , $id_newRole ) . "' )"); 
                                               if(mysqli_num_rows($query_newrole) > 0){
                                               while($row_newrole = mysqli_fetch_array($query_newrole)){
                                            
                                            ?>
                                               <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="checkbox" value="<?php echo $row_newrole['id_role']; ?>" name="id_role[]">
                                                      <label class="form-check-label" for="inlineCheckbox1"><?php echo $row_newrole['name_role']; ?></label>
                                                </div>
                                           <?php }}?>
                                           <span class="form-group__message"></span>
                                         </div>
                                    
                                         <a href = "index.php?page_layout=staffRole" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;"  type="submit" name="add_role">Submit</button>
                                </div>
                            </form>
                    </div>
            </div>
        </div>
      
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../assets/script/validator.js"></script>
