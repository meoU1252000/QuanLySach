<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("1", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $query_staff = mysqli_query($conn, "SELECT * from staff  ORDER BY id_staff ");
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
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Nhân Viên</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Nhân Viên
                            </div>
                           
                            <div class="card-body">
                               
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Họ Tên</th>
                                                <th colspan="5">Quyền</th>
                                                <th>Thêm</th>
                                                <th>Xóa</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Họ Tên</th>
                                                <th>Quyền</th>
                                                <th>Thêm</th>
                                                <th>Xóa</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        
                                        <?php 
                                           while ($row = mysqli_fetch_array($query_staff)) {
                                               $id_staff = $row['id_staff'];
                                               $query_roledetails = mysqli_query($conn,"SELECT roledetails.*, rolestaff.name_role from roledetails inner join rolestaff on roledetails.id_role = rolestaff.id_role where id_staff = '$id_staff'");
                                              
                                               
                                        ?>
                                            <tr>
                                                <td ><input type="text" name="id_staff[]" value ="<?php echo $row['id_staff']; ?>" style="border: none;background-color: transparent;width:54px"></td>
                                                <td> <?php echo $row['name_staff']; ?></td>
                                                <?php 
                                                         $id_role = array();
                                                        while($row_roledetails = mysqli_fetch_array($query_roledetails)){
                                                            array_push($id_role,$row_roledetails['id_role']);
                                                            
                                                    ?>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="checkbox" value="<?php echo $row_roledetails['id_role']; ?>"checked >
                                                      <label class="form-check-label" for="inlineCheckbox1"><?php echo $row_roledetails['name_role']; ?></label>
                                                    </div>
                                                </td>
                                                   <?php }?>
                                                   <?php  
                                                          $query_role = mysqli_query($conn,"SELECT * from rolestaff WHERE id_role NOT IN ( '" . implode( "', '" , $id_role ) . "' )"); 
                                                          if(mysqli_num_rows($query_role) > 0){
                                                          while($row_role = mysqli_fetch_array($query_role)){
    
                                                   ?>
                                                <td>
                                                   <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="checkbox" value="<?php echo $row_role['id_role']; ?>" disabled>
                                                      <label class="form-check-label" for="inlineCheckbox1"><?php echo $row_role['name_role']; ?></label>
                                                    </div>
                                                    <?php }}?>
                                                 </td>
                                                 <td style="text-align:center"> 
                                                    <a href="index.php?page_layout=addStaffRole&id=<?php echo $row['id_staff'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                                </td>
                                                <td style="text-align:center"> 
                                                    <a href="index.php?page_layout=deleteStaffRole&id=<?php echo $row['id_staff'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                       
                                        </tbody>
                                        
                                    </table>
                               
                                <a class="btn btn-primary" style="margin-top:12px" href="index.php">Trở Lại</a>
                                <!-- <a href = "index.php?page_layout=addStaff" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a> -->
                               
                            </div>
                        
                        </div>
                        
                 </div>



  
