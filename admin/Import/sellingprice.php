<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $id_product = $_REQUEST['id'];
        $result = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product'");
        if(isset($_POST['id_delete'])){
            $location = $_GET['page_layout'];
            $id_delete = $_POST['id_delete'];
            $sql = "CALL xoaData('$location',$id_delete,'id_sell')";
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
                            <li class="breadcrumb-item active">Quản Lý Giá Bán</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               Giá Bán
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Selling</th>
                                            <th>ID Product</th>
                                            <th>ID Import</th>
                                            <th>Selling Price</th>
                                            <th>Date Start</th>
                                            <th>Date end</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Selling</th>
                                            <th>ID Product</th>
                                            <th>ID Import</th>
                                            <th>Selling Price</th>
                                            <th>Date Start</th>
                                            <th>Date end</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                           $id_sell = $row['id_sell'];
                                          
                                           
                                    ?>
                                        <tr>
                                            <td>  <?php echo $row['id_sell']; ?></td>
                                            <td>  <?php echo $row['id_product']; ?></td>
                                            <td>  <?php echo $row['id_import']; ?></td>
                                            <td>  <?php echo $row['selling_price']; ?></td>
                                            
                                            <td>  <?php echo $row['date_start']; ?></td>
                                            <td>  <?php echo $row['date_end']; ?></td>
                                        
                                            <td>
                                                <a href="index.php?page_layout=editSellingPrice&id=<?php echo $row['id_sell'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                            </td>
                                            <td>    
                                                <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                     <input type="hidden" class ="query" value ="<?php echo $row['id_sell'];?>" name="id_delete">
                                                     <input type="hidden" class ="query" value ="<?php echo $_REQUEST['id'];?>" name="queryToBack">
                                                     <button type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                </form>
                                            </td>
                                           
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                                
                                <a href = "index.php?page_layout=addSellingPrice&id=<?php echo $id_product;?>" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        </div>

                        
                    </div>
          
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php ?>

