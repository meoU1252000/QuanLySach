<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("4", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $id_import = $_REQUEST['id'];
        $result = mysqli_query($conn, "SELECT * from importdetails where id_import = '$id_import'");
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
                            <li class="breadcrumb-item active">Quản Lý Nhập Hàng</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               Nhập Hàng
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Nhập Hàng</th>
                                            <th>ID Sản Phẩm</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>ID Nhà Cung Cấp</th>
                                            <th>Tên Nhà Cung Cấp</th>
                                            <th>Giá Nhập Hàng</th>
                                            <th>Số Lượng Nhập</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Nhập Hàng</th>
                                            <th>ID Sản Phẩm</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Tên ID Nhà Cung Cấp</th>
                                            <th>Nhà Cung Cấp</th>
                                            <th>Giá Nhập Hàng</th>
                                            <th>Số Lượng Nhập</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {

                                           //Lấy thông tin Sản Phẩm để trình bày
                                           $id_product = $row['id_product'];
                                           $sql_product = mysqli_query($conn,"SELECT * from product where id_product = '$id_product'");
                                           $row_product = mysqli_fetch_array($sql_product);

                                           //Lấy thông tin nhà cung cấp
                                           $id_supplier = $row['id_supplier'];
                                           $sql_supplier = mysqli_query($conn,"SELECT * from supplier where id_supplier = '$id_supplier'");
                                           $row_supplier = mysqli_fetch_array($sql_supplier);
                                    ?>
                                        <tr>
                                            <td>  <?php echo $row['id_import']; ?></td>
                                            <td>  <?php echo $row['id_product']; ?></td>
                                            <td><?php echo $row_product['name_product']; ?></td>
                                            <td>  <?php echo $row['id_supplier']; ?></td>
                                            <td><?php echo $row_supplier['name_supplier']; ?></td>
                                            <td>  <?php echo $row['price_import']; ?></td>
                                            <td>  <?php echo $row['number_import']; ?></td>
                                          
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                                
                                <a href = "index.php?page_layout=addImportDetails&id=<?php echo $id_import; ?>" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        </div>

                        
                    </div>
          
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php ?>