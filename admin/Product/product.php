<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $result = mysqli_query($conn, "SELECT * from viewproduct ");
        if(isset($_POST['id_delete'])){
            $location = $_GET['page_layout'];
            $id_delete = $_POST['id_delete'];
            $sql = "CALL xoaData('$location',$id_delete,'id_product')";
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
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Sản Phẩm</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Sản Phẩm
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Sản Phẩm</th>
                                            <th>Loại Sản Phẩm</th>
                                            <th>Nhà Xuất Bản</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Số Lượng Tồn</th>
                                            <th>Số Lượng Đã Bán</th>
                                            <th>Ghi Chú</th>
                                            <th>Chi Tiết Giá Bán</th>
                                            <th>Chi Tiết Sản Phẩm</th>
                                            <th>Ảnh Sản Phẩm</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Sản Phẩm</th>
                                            <th>Loại Sản Phẩm</th>
                                            <th>Nhà Xuất Bản</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Số Lượng Tồn</th>
                                            <th>Số Lượng Đã Bán</th>
                                            <th>Ghi Chú</th>
                                            <th>Chi Tiết Giá Bán</th>
                                            <th>Chi Tiết Sản Phẩm</th>
                                            <th>Ảnh Sản Phẩm</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            
                                                <td>   <?php echo $row['product_id']; ?></td>
                                                <td><?php echo $row['product_type']; ?></td>
                                                <td><?php echo $row['place_publishing']; ?></td>
                                                <td> <?php echo $row['product_name']; ?></td>
                                                <td><?php echo $row['quantity_in_stock']; ?></td>
                                                <td>  <?php echo $row['quantity_sold']; ?> </td>
                                                <td>  <?php echo $row['pr_note']; ?> </td>
                                                <td style="text-align:center">
                                                     <a href="index.php?page_layout=sellingprice&id=<?php echo $row['product_id'];?>" class ="action_edit" style="text-decoration:none; color:#212529;"><i class="fas fa-external-link-alt"></i></a>
                                                </td>
                                                <td style="text-align:center">
                                                     <a href="index.php?page_layout=productdetails&id=<?php echo $row['product_id'];?>" class ="action_edit" style="text-decoration:none; color:#212529;"><i class="fas fa-external-link-alt"></i></a>
                                                </td>
                                                <td style="text-align:center">
                                                     <a href="index.php?page_layout=productimage&id=<?php echo $row['product_id'];?>" class ="action_edit" style="text-decoration:none; color:#212529;"><i class="fas fa-external-link-alt"></i></a>
                                                </td>
                                                <td style="text-align:center"> 
                                                    <a href="index.php?page_layout=editProduct&id=<?php echo $row['product_id'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                                </td>
                                                <td style="text-align:center"> 
                                                <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                    <input type="hidden" class ="query" value ="<?php echo $row['product_id'];?>" name="id_delete">
                                                    <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                </form>
                                                </td>
                                        </tr>
                                      <?php } ?>
                                    
                                    </tbody>
                                </table>
                                <a href = "index.php?page_layout=addProduct" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        </div>
                    </div>
          
    
