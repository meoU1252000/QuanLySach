<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    include_once './alert.php';
    if(in_array("4", $_SESSION['roleStaff'], true)){
        $result = mysqli_query($conn, "SELECT * from supplier ORDER BY id_supplier ");
        if(isset($_POST['id_delete'])){
            $location = $_GET['page_layout'];
            $id_delete = $_POST['id_delete'];
            $sql = "CALL xoaData('$location',$id_delete,'id_supplier')";
           if(mysqli_query($conn,$sql)){
                $_SESSION['status'] = "Xóa Thành Công!";
                $_SESSION['status_code']= "success";
                if(isset($_POST['queryToBack'])){
                    $url = "index.php?page_layout=" .$_GET['page_layout'];
                    $url .="&id=" .$_POST['queryToBack'];
                }else{
                    $url = "index.php?page_layout=" .$_GET['page_layout'];
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
                    $url = "index.php?page_layout=" .$_GET['page_layout'];
                    $url .="&id=" .$_POST['queryToBack'];
                }else{
                    $url = "index.php?page_layout=" .$_GET['page_layout'];
                }
                if(headers_sent()){
                   die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                    header ("location: $url");
                    die();
                }
               
               // echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }else{
        // echo '<script language="javascript">';
        // echo 'alert("Bạn không có quyền truy cập vào trang này")';
        // echo '</script>';
        // $url = "index.php";
        // if(headers_sent()){
        //     die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
        // }else{
        //     header ("location: $url");
        //     die();
        // }
    }
}
?>


            
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Nhà Cung Cấp</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Nhà Cung Cấp
                            </div>
                            
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Nhà Cung Cấp</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Địa Chỉ</th>
                                            <th>Ghi Chú</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Nhà Cung Cấp</th>
                                            <th>Số Điện Thoại</th>
                                            <th>Địa Chỉ</th>
                                            <th>Ghi Chú</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                         
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id_supplier']; ?></td>
                                            <td> <?php echo $row['name_supplier']; ?></td>
                                            <td><?php echo $row['phone_supplier']; ?></td>
                                            <td><?php echo $row['address_supplier']; ?></td>
                                            <td> <?php echo $row['note_supplier']; ?></td>
                                            <td style="text-align:center"> 
                                                <a href="index.php?page_layout=editSupplier&id=<?php echo $row['id_supplier'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                            </td>
                                            <td style="text-align:center"> 
                                                 <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                      <input type="hidden" class ="query" value ="<?php echo $row['id_supplier'];?>" name="id_delete">
                                                     <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                  </form>
                                             </td>
                                        </tr>
                                    <?php } ?>
                                   
                                    </tbody>
                                    
                                </table>
                                <a href = "index.php?page_layout=addSupplier" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        
                        </div>
                        
                 </div>




  
