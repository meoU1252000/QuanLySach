<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $id_product = $_REQUEST['id'];
        $result = mysqli_query($conn, "SELECT * from productimage  where id_product = '$id_product'");
        $query_product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
        $row_product = mysqli_fetch_array($query_product);
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
                            <li class="breadcrumb-item active">Quản Lý Hình Ảnh Sản Phẩm</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Ảnh Sản Phẩm <?php echo $row_product['name_product'];?>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Ảnh Sản Phẩm</th>
                                            <th>Ảnh Sản Phẩm</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Ảnh Sản Phẩm</th>
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
                                           
                                            <td>   <?php echo $row['id_img']; ?></td>
                                            <td style = "text-align:center;width: 14.395%;"><img src="./<?php echo $row['link_img']; ?>" alt="Chưa có hình ảnh " class="img_product"> </td>
                                           
                                            <td style="text-align:center"> 
                                                <a href="index.php?page_layout=editImg&id=<?php echo $row['id_product'];?>" class ="action_edit"><i class="far fa-edit icon_action"></i></a>
                                            </td>
                                            <td style="text-align:center"> 
                                                 <form action="./delete.php" method="POST" enctype="multipart/form-data" name="formDelete">
                                                     <input type="hidden" class ="location" value ="<?php echo $_GET["page_layout"];?>" name="locationDelete">
                                                     <input type="hidden" class ="query" value ="id_img" name="queryToDelete">
                                                     <input type="hidden" class ="query" value ="<?php echo $_REQUEST['id'];?>" name="queryToBack">
                                                     <input type="hidden" class ="delete_id_value" value ="<?php echo $row['id_img']; ?>" name="delete_id">
                                                     <button  type="submit" class="deleteData deleteButton" name="delete" onclick= "deleteData(event)" ><i class="far fa-trash-alt icon_action"></i></a>
                                                  </form>
                                             </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                                <a href = "index.php?page_layout=product" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                <a href = "index.php?page_layout=addImg&id=<?php echo $id_product;?>" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        </div>
                    </div>
          
    
