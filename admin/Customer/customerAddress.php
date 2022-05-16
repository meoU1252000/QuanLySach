<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("1", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $id = $_REQUEST['id'];
        $result = mysqli_query($conn, "SELECT * from customeraddress where id_customer = '$id' ");
       
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
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Khách Hàng</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Khách Hàng
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID Khách Hàng</th>
                                            <th>ID Địa Chỉ</th>
                                            <th>Địa Chỉ Liên Hệ</th>
                                            <th>Tên Người Nhận Hàng</th>
                                            <th>Số Điện Thoại Người Nhận</th>
                                           
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Khách Hàng</th>
                                            <th>ID Địa Chỉ</th>
                                            <th>Địa Chỉ Liên Hệ</th>
                                            <th>Tên Người Nhận Hàng</th>
                                            <th>Số Điện Thoại Người Nhận</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            
                                                <td>   <?php echo $row['id_customer']; ?></td>
                                                <td><?php echo $row['id_address']; ?></td>
                                                <td><?php echo $row['address_receive']; ?></td>
                                                <td> <?php echo $row['name_receive']; ?></td>
                                                <td><?php echo $row['phone_receive']; ?></td>
                                              
                                        </tr>
                                      <?php } ?>
                                    
                                    </tbody>
                                </table>
                                <a href = "index.php?page_layout=customers" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                            </div>
                        </div>
                    </div>
          
    
