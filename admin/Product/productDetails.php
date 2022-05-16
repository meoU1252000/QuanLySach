<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $id_product = $_REQUEST['id'];
        $result = mysqli_query($conn, "SELECT * from product where id_product = '$id_product'");
        $query = mysqli_query($conn, "SELECT * FROM productdetails where id_product = '$id_product'");
        $row = mysqli_fetch_array($result);
        $row_details = mysqli_fetch_array($query);
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
<style>
    table tbody tr td img{
        height: 320px;
        width: 500px;
    }
</style>
            
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
                                            <th>Tên Sản Phẩm</th>
                                            <th>Tác Giả</th>
                                            <th>Người Dịch</th>
                                            <th>Năm Xuất Bản</th>
                                            <th>Số Trang</th>
                                            <th>Hình Thức</th>
                                            <th>Giới Thiệu Sản Phẩm</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                   
                                        <tr>
                                            
                                                <td>   <?php echo $row['id_product']; ?></td>
                                                <td><?php echo $row['name_product']; ?></td>
                                                <?php if ($row_details !== NULL){ ?>
                                                <td><?php echo $row_details['author_product']; ?></td>
                                                <td> <?php echo $row_details['translator_product']; ?></td>
                                                <td><?php echo $row_details['publishing_year']; ?></td>
                                                <td>  <?php echo $row_details['pages_product']; ?> </td>
                                                <td>  <?php echo $row_details['form_product']; ?> </td>
                                                <td>  <?php echo $row_details['introduce_product']; ?> </td>
                                               <?php }else{ ?>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> </td>
                                                <?php }?>
                                                <td style="text-align:center"> 
                                                    <a href="index.php?page_layout=editProductDetails&id=<?php echo $row['id_product'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                                </td>
                                                <td style="text-align:center"> 
                                                <form action="#" method="POST" enctype="multipart/form-data" name="formDelete">
                                                    <input type="hidden" class ="query" value ="<?php echo $row['id_product'];?>" name="id_delete">
                                                    <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                </form>
                                                </td>
                                        </tr>
                                    </tbody>
                                   
                                
                                </table>
                             
                                <a href = "index.php?page_layout=addProductDetails&id=<?php echo $row['id_product']; ?>" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                           
                        </div>
                      
                    </div>
          <script>
            document.querySelector('img').style.width = "500px";
            document.querySelector('img').style.height = "320px";
          </script>
    
