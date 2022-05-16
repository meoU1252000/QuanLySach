<?php
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("1", $_SESSION['roleStaff'], true)){
        include_once './alert.php';
        $result = mysqli_query($conn, "SELECT * from customers ");
       
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
                                            <th>Tên Khách Hàng</th>
                                            <th>Số Điện Thoại Liên Hệ</th>
                                            <th>Email Khách Hàng</th>
                                            <th>Tên Đăng Nhập</th>
                                            <th>Địa Chỉ Liên Hệ</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID Khách Hàng</th>
                                            <th>Tên Khách Hàng</th>
                                            <th>Số Điện Thoại Liên Hệ</th>
                                            <th>Email Khách Hàng</th>
                                            <th>Tên Đăng Nhập</th>
                                            <th>Địa Chỉ Liên Hệ</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            
                                                <td>   <?php echo $row['id_customer']; ?></td>
                                                <td><?php echo $row['name_customer']; ?></td>
                                                <td><?php echo $row['phone_customer']; ?></td>
                                                <td> <?php echo $row['email_customer']; ?></td>
                                                <td><?php echo $row['username_customer']; ?></td>
                                                <td style="text-align:center">
                                                     <a href="index.php?page_layout=customerAddress&id=<?php echo $row['id_customer'];?>" class ="action_edit" style="text-decoration:none; color:#212529;"><i class="fas fa-external-link-alt"></i></a>
                                                </td>
                                        </tr>
                                      <?php } ?>
                                    
                                    </tbody>
                                </table>
                                <a href = "index.php" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Về Trang Chủ</a>
                            </div>
                        </div>
                    </div>
          
    
