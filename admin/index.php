<?php
session_start();
include_once './config.php';

//tiến hành kiểm tra là người dùng đã đăng nhập hay chưa
//nếu chưa, chuyển hướng người dùng ra lại trang đăng nhập
if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    $id_staff = $_SESSION['id_staff'];
    $sql_role = "SELECT * from roledetails where id_staff = '$id_staff'";
    $query_role =mysqli_query($conn,$sql_role);
    
} 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Trang Quản Trị</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../assets/css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/script/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../assets/script/datatables-simple-demo.js"></script>
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Admin Dashboard</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php?page_layout=changePassword">Đổi Mật Khẩu</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Chính</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Trang Chủ
                            </a>
                        <?php 
                          while ($row_role = mysqli_fetch_array($query_role)){
                              $id_role = $row_role['id_role'];
                              if($id_role == 3){
                        ?>
                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                                <div class="sb-nav-link-icon"><i class="fas fa-th-large"></i></div>
                                Quản Lý Sản Phẩm
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseProduct" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page_layout=typeGroup">Danh Mục</a>
                                    <a class="nav-link" href="index.php?page_layout=publishingCompany">Nhà Xuất Bản</a>
                                    <a class="nav-link" href="index.php?page_layout=producttype">Thể Loại Sản Phẩm</a>
                                    <a class="nav-link" href="index.php?page_layout=product">Sản Phẩm</a>
                                </nav>
                            </div>
                            
                            <!--<div class="sb-sidenav-menu-heading"></div>-->
                            <?php }else if($id_role == 2){ ?>
                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-th-large"></i></div>
                                Quản Lý Đơn Hàng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page_layout=revenue">Doanh Thu</a>
                                    <a class="nav-link" href="index.php?page_layout=orders">Đơn Hàng</a>
                                </nav>
                            </div>
                            <?php }else if($id_role == 4){ ?>
                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapsePageOthers" aria-expanded="false" aria-controls="collapsePageOthers">
                                <div class="sb-nav-link-icon"><i class="fas fa-shipping-fast"></i></div>
                                Quản Lý Nhập Hàng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePageOthers" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page_layout=supplier">Nhà Cung Cấp</a>
                                    <a class="nav-link" href="index.php?page_layout=importproduct">Chi Tiết Nhập Hàng</a>
                                </nav>
                            </div>
                            <?php }else if($id_role == 5){ ?>
                            <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapsePageEvents" aria-expanded="false" aria-controls="collapsePageEvents">
                                <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                                Quản Lý Sự Kiện
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePageEvents" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="index.php?page_layout=codediscount">Mã Giảm Giá</a>
                                </nav>
                            </div>
                            <?php }else if($id_role == 1) {?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Quản Lý Nhân Viên
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                           <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link" href="index.php?page_layout=staff">Nhân Viên</a>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Tài Khoản Nhân Viên
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="index.php?page_layout=addStaffAccount">Tạo tài khoản mới</a>
                                            <a class="nav-link" href="index.php?page_layout=staffRole">Phân Quyền</a>
                                        </nav>
                                    </div>
                                   
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePagesCustomer" aria-expanded="false" aria-controls="collapsePagesCustomer">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Quản Lý Khách Hàng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                           <div class="collapse" id="collapsePagesCustomer" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                               <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                   <a class="nav-link" href="index.php?page_layout=customers">Thông Tin Khách Hàng</a>
                               </nav>
                                    
                            </div>
                        <?php }}?>
                            
                           <div class="sb-sidenav-menu-heading">Phân Tích</div>
                                <a class="nav-link" href="charts.html">
                                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                    Biểu Đồ
                                </a>
                                <a class="nav-link" href="tables.html">
                                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                    Bảng
                                </a>
                            </div> 
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $_SESSION['nameStaff']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                        <?php
                         //master page
                         if(isset($_GET["page_layout"])){
                            switch($_GET["page_layout"]){
                                case 'staff':include_once './Staff/staff.php';
                                   break;
                                case 'staffRole':include_once './Staff/staffRole.php';
                                   break;
                                case 'product':include_once './Product/product.php';
                                   break;
                                case 'addProduct':include_once './Product/addproduct.php';
                                   break;
                                case 'editProduct':include_once './Product/editproduct.php';
                                   break;
                                case 'productimage':include_once './Product/imgproduct.php';
                                   break;
                                case 'addImg':include_once './Product/addimg.php';
                                   break;
                                case 'editImg':include_once './Product/editImg.php';
                                   break;
                                case 'addStaffAccount':include_once './Staff/addstaffaccount.php';
                                   break;
                                case 'addStaff':include_once './Staff/addstaff.php';
                                   break;
                                case 'editStaff':include_once './Staff/editstaff.php';
                                   break;
                                case 'typeGroup':include_once './TypeGroup/typegroup.php';
                                   break;
                                case 'addTypeGroup':include_once './TypeGroup/addtypegroup.php';
                                   break;
                                case 'editTypeGroup':include_once './TypeGroup/edittypegroup.php';
                                   break;
                                case 'producttype':include_once './Type/type.php';
                                   break;
                                case 'addType':include_once './Type/addtype.php';
                                   break;
                                case 'editType':include_once './Type/edittype.php';
                                   break;
                                case 'publishingCompany':include_once './PublishingCompany/publishingCompany.php';
                                   break;
                                case 'addPublishingCompany':include_once './PublishingCompany/addPublishingCompany.php';
                                   break;
                                case 'editPublishingCompany':include_once './PublishingCompany/editPublishingCompany.php';
                                   break;
                                case 'supplier':include_once './Supplier/supplier.php';
                                   break;
                                case 'addSupplier':include_once './Supplier/addSupplier.php';
                                   break;
                                case 'editSupplier':include_once './Supplier/editSupplier.php';
                                   break;
                                case 'importproduct':include_once './Import/import.php';
                                   break;
                                case 'addImport':include_once './Import/addImport.php';
                                   break;
                                case 'editImport':include_once './Import/editImport.php';
                                   break;
                                case 'importDetails':include_once './Import/importDetails.php';
                                   break;
                                case 'addImportDetails':include_once './Import/addImportDetails.php';
                                   break;
                                case 'editImportDetails':include_once './Import/editImportDetails.php';
                                   break;
                                case 'sellingprice':include_once './Import/sellingPrice.php';
                                   break;
                                case 'addSellingPrice':include_once './Import/addSellingPrice.php';
                                   break;
                                case 'editSellingPrice':include_once './Import/editSellingPrice.php';
                                   break;
                                case 'addStaffRole' :include_once './Staff/addStaffRole.php'; break;
                                case 'deleteStaffRole' :include_once './Staff/deleteStaffRole.php'; break;
                                case 'codediscount':include_once './Event/codeDiscount.php';break;
                                case 'addCode':include_once './Event/addCode.php';break;
                                case 'editCode':include_once './Event/editCode.php';break;
                                case 'orders':include_once './Orders/orders.php';break;
                                case 'editOrder':include_once './Orders/editOrders.php';break;
                                case 'orderDetails':include_once './Orders/orderDetails.php';break;
                                case 'productdetails':include_once './Product/productDetails.php';break;
                                case 'addProductDetails':include_once './Product/addProductDetails.php';break;
                                case 'editProductDetails':include_once './Product/editProductDetails.php';break;
                                case 'revenue':include_once './Orders/revenue.php';break;
                                case 'changePassword':include_once './Staff/editPassword.php';break;
                                case 'customers':include_once './Customer/customers.php';break;
                                case 'customerAddress':include_once './Customer/customerAddress.php';break;
                              }
                         }else {
                        ?>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <?php 
                                      $main = mysqli_query($conn,"SELECT COUNT(id_order) as SL from orders where order_status = 'Đang Xử Lý' and Month(date_order) = MONTH(CURDATE()) and YEAR(date_order) = YEAR(CURDATE());"); 
                                      $rowMain = mysqli_fetch_array($main);
                                    
                                    ?>
                                    <div class="card-body"style="text-transform: capitalize;">Hiện có <?php echo $rowMain['SL']?> đơn hàng đang xử lý</div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                
                                    <?php 
                                      $warning = mysqli_query($conn,"SELECT COUNT(id_order) as SL from orders where order_status = 'Chưa Xử Lý' and Month(date_order) = MONTH(CURDATE()) and YEAR(date_order) = YEAR(CURDATE());"); 
                                      $rowWarning = mysqli_fetch_array($warning);
                                    
                                    ?>
                                    <div class="card-body"  style="text-transform: capitalize;">Hiện có <?php echo $rowWarning['SL']?> đơn hàng chưa xử lý</div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <?php 
                                      $success = mysqli_query($conn,"SELECT COUNT(id_order) as SL from orders where order_status = 'Đã Giao' and Month(date_delivery) = MONTH(CURDATE()) and YEAR(date_delivery) = YEAR(CURDATE());"); 
                                      $rowSuccess = mysqli_fetch_array($success);
                                    
                                    ?>
                                    <div class="card-body" style="text-transform: capitalize;">Tháng Này Có <?php echo $rowSuccess['SL']?> đơn hàng giao thành công</div>
                                   
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                   <?php 
                                      $danger = mysqli_query($conn,"SELECT COUNT(id_order) as SL from orders where order_status = 'Đã Hủy' and Month(date_order) = MONTH(CURDATE()) and YEAR(date_order) = YEAR(CURDATE());"); 
                                      $rowDanger = mysqli_fetch_array($danger);
                                    
                                    ?>
                                     <div class="card-body" style="text-transform: capitalize;">Tháng Này Có <?php echo $rowDanger['SL']?> đơn hàng đã hủy</div>
                                    <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Biểu Đồ Lợi Nhuận Doanh Thu Tháng Này
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                   
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Biểu Đồ Lợi Nhuận Doanh Thu Từng Tháng
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Thông Tin Đơn Hàng
                            </div>
                            <div class="card-body">
                              <?php 
                              $result = mysqli_query($conn, "SELECT * from vieworders order by id_order desc");
                              
                              ?>
                              <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nhân Viên Phụ Trách</th>
                                            <th>Địa Chỉ Giao Hàng</th>
                                            <th>Tên Người Nhận</th>
                                            <th>Số Điện Thoại Người Nhận</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Ngày Đặt Hàng</th>
                                            <th>Ngày Giao Hàng</th>
                                            <th>Tình Trạng Đơn Hàng</th>
                                            <th>Tổng Giá Trị Đơn Hàng</th>
                                            <th>Ghi Chú</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nhân Viên Phụ Trách</th>
                                            <th>Địa Chỉ Giao Hàng</th>
                                            <th>Tên Người Nhận</th>
                                            <th>Số Điện Thoại Người Nhận</th>
                                            <th>Mã Giảm Giá</th>
                                            <th>Ngày Đặt Hàng</th>
                                            <th>Ngày Giao Hàng</th>
                                            <th>Tình Trạng Đơn Hàng</th>
                                            <th>Tổng Giá Trị Đơn Hàng</th>
                                            <th>Ghi Chú</th>
                                             
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    
                                    <?php 
                                       while ($row = mysqli_fetch_array($result)) {
                                        
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id_order']; ?></td>
                                            <td> <?php echo $row['name_staff']; ?></td>
                                            <td> <?php echo $row['address_receive']; ?></td>
                                            <td> <?php echo $row['name_receive']; ?></td>
                                            <td> <?php echo $row['phone_receive']; ?></td>
                                            <td><?php echo $row['code_event']; ?></td>
                                            <td> <?php echo $row['date_order']; ?></td>
                                            <td> <?php echo $row['date_delivery']; ?></td>
                                            <td> <?php echo $row['order_status']; ?></td>
                                            <td> <?php echo number_format($row['total_price']); ?></td>
                                            <td> <?php echo $row['note_orders']; ?></td>
                                         
                                        </tr>
                                    <?php } ?>
                                   
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php 
 $barChart = mysqli_query($conn, "SELECT 
 Sum(Case Month(b.date_delivery) when 1 then c.selling_price*a.number_order else 0 end) as T1,
 Sum(Case Month(b.date_delivery) when 2 then  c.selling_price*a.number_order else 0 end) as T2,
 Sum(Case Month(b.date_delivery) when 3 then c.selling_price*a.number_order else 0 end) as T3,
 Sum(Case Month(b.date_delivery) when 4 then  c.selling_price*a.number_order else 0 end) as T4,
 Sum(Case Month(b.date_delivery) when 5 then c.selling_price*a.number_order else 0 end) as T5,
 Sum(Case Month(b.date_delivery) when 6 then  c.selling_price*a.number_order else 0 end) as T6,
 Sum(Case Month(b.date_delivery) when 7 then  c.selling_price*a.number_order else 0 end) as T7,
 Sum(Case Month(b.date_delivery) when 8 then  c.selling_price*a.number_order else 0 end) as T8,
 Sum(Case Month(b.date_delivery) when 9 then  c.selling_price*a.number_order else 0 end) as T9,
 Sum(Case Month(b.date_delivery) when 10 then  c.selling_price*a.number_order else 0 end) as T10,
 Sum(Case Month(b.date_delivery) when 11 then  c.selling_price*a.number_order else 0 end) as T11,
 Sum(Case Month(b.date_delivery) when 12 then  c.selling_price*a.number_order else 0 end) as T12
 FROM orderdetails as a, orders as b, sellingprice as c where a.id_order = b.id_order and a.id_sell = c.id_sell and b.order_status = 'Đã Giao' and YEAR(b.date_delivery) = YEAR(CURDATE());");
   $row= mysqli_fetch_array($barChart);
   $sum = 0;
   $date = array();
   $data = array();
   for($i=0;$i<12;$i++){
       $sum += $row[$i];
       array_push($date,$i+1);
       array_push($data,$row[$i]);
      
    }
 $areaChart = mysqli_query($conn,"SELECT 
  Sum(Case DAY(b.date_delivery) when 1 then c.selling_price*a.number_order else 0 end) as N1,
  Sum(Case DAY(b.date_delivery) when 2 then  c.selling_price*a.number_order else 0 end) as N2,
  Sum(Case DAY(b.date_delivery) when 3 then c.selling_price*a.number_order else 0 end) as N3,
  Sum(Case DAY(b.date_delivery) when 4 then  c.selling_price*a.number_order else 0 end) as N4,
  Sum(Case DAY(b.date_delivery) when 5 then c.selling_price*a.number_order else 0 end) as N5,
  Sum(Case DAY(b.date_delivery) when 6 then  c.selling_price*a.number_order else 0 end) as N6,
  Sum(Case DAY(b.date_delivery) when 7 then  c.selling_price*a.number_order else 0 end) as N7,
  Sum(Case DAY(b.date_delivery) when 8 then  c.selling_price*a.number_order else 0 end) as N8,
  Sum(Case DAY(b.date_delivery) when 9 then  c.selling_price*a.number_order else 0 end) as N9,
  Sum(Case DAY(b.date_delivery) when 10 then  c.selling_price*a.number_order else 0 end) as N10,
  Sum(Case DAY(b.date_delivery) when 11 then  c.selling_price*a.number_order else 0 end) as N11,
  Sum(Case DAY(b.date_delivery) when 12 then  c.selling_price*a.number_order else 0 end) as N12,
   Sum(Case DAY(b.date_delivery) when 13 then c.selling_price*a.number_order else 0 end) as N13,
  Sum(Case DAY(b.date_delivery) when 14 then  c.selling_price*a.number_order else 0 end) as N14,
  Sum(Case DAY(b.date_delivery) when 15 then c.selling_price*a.number_order else 0 end) as N15,
  Sum(Case DAY(b.date_delivery) when 16 then  c.selling_price*a.number_order else 0 end) as N16,
  Sum(Case DAY(b.date_delivery) when 17 then c.selling_price*a.number_order else 0 end) as N17,
  Sum(Case DAY(b.date_delivery) when 18 then  c.selling_price*a.number_order else 0 end) as N18,
  Sum(Case DAY(b.date_delivery) when 19 then  c.selling_price*a.number_order else 0 end) as N19,
  Sum(Case DAY(b.date_delivery) when 20 then  c.selling_price*a.number_order else 0 end) as N20,
  Sum(Case DAY(b.date_delivery) when 21 then  c.selling_price*a.number_order else 0 end) as N21,
  Sum(Case DAY(b.date_delivery) when 22 then  c.selling_price*a.number_order else 0 end) as N22,
  Sum(Case DAY(b.date_delivery) when 23 then  c.selling_price*a.number_order else 0 end) as N23,
  Sum(Case DAY(b.date_delivery) when 24 then  c.selling_price*a.number_order else 0 end) as N24,
   Sum(Case DAY(b.date_delivery) when 25 then c.selling_price*a.number_order else 0 end) as N25,
  Sum(Case DAY(b.date_delivery) when 26 then  c.selling_price*a.number_order else 0 end) as N26,
  Sum(Case DAY(b.date_delivery) when 27 then  c.selling_price*a.number_order else 0 end) as N27,
  Sum(Case DAY(b.date_delivery) when 28 then  c.selling_price*a.number_order else 0 end) as N28,
  Sum(Case DAY(b.date_delivery) when 29 then  c.selling_price*a.number_order else 0 end) as N29,
  Sum(Case DAY(b.date_delivery) when 30 then  c.selling_price*a.number_order else 0 end) as N30
  FROM orderdetails as a, orders as b, sellingprice as c where a.id_order = b.id_order and a.id_sell = c.id_sell and b.order_status = 'Đã Giao' and Month(b.date_delivery) = MONTH(CURDATE()) and YEAR(b.date_delivery) = YEAR(CURDATE());");
  $rowAreaChart = mysqli_fetch_array($areaChart);
  $sumArea = 0;
   $dateArea = array();
   $dataArea = array();
   for($i=0;$i<29;$i++){
    $sumArea += $rowAreaChart[$i];
    array_push($dateArea,$i+1);
    array_push($dataArea,$rowAreaChart[$i]);
   
 }
?>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
   Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
   Chart.defaults.global.defaultFontColor = '#292b2c';
   var dataArray = [];
   // Area Chart Example
   var ctx = document.getElementById("myAreaChart");
   console.log(ctx);
   var myLineChart = new Chart(ctx, {
     type: 'line',
     data: {
       labels: [<?php echo join(',', $dateArea); ?>],
       datasets: [{
         label: "Total Profit",
         lineTension: 0.3,
         backgroundColor: "rgba(2,117,216,0.2)",
         borderColor: "rgba(2,117,216,1)",
         pointRadius: 5,
         pointBackgroundColor: "rgba(2,117,216,1)",
         pointBorderColor: "rgba(255,255,255,0.8)",
         pointHoverRadius: 5,
         pointHoverBackgroundColor: "rgba(2,117,216,1)",
         pointHitRadius: 50,
         pointBorderWidth: 2,
         data: [<?php echo join(',',$dataArea); ?>],
       }],
     },
     options: {
       scales: {
         xAxes: [{
           time: {
             unit: 'month'
           },
           gridLines: {
             display: false
           },
           ticks: {
             maxTicksLimit: 30
           }
         }],
         yAxes: [{
           ticks: {
             min: 0,
             max:  1000000,
             maxTicksLimit: 30
           },
           gridLines: {
             color: "rgba(0, 0, 0, .125)",
           }
         }],
       },
       legend: {
         display: false
       }
     }
   });
   // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx1 = document.getElementById("myBarChart");
var myLineChart1 = new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: [<?php echo join(',',$date); ?>],
    datasets: [{
      label: "Revenue",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: [<?php echo join(',',$data); ?>],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 12
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 1000000,
          maxTicksLimit: 12
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>
                    <?php }?>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Lê Thành Đạt</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
       
       

        
    </body>
</html>

