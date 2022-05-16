
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("4", $_SESSION['roleStaff'], true)){
       $id = $_REQUEST['id'];
       $query_import = mysqli_query($conn,"SELECT * from importproduct where id_import = '$id'");
       $query_importdetails = mysqli_query($conn,"SELECT * from importdetails where id_import = '$id'");
       if(mysqli_num_rows($query_importdetails) > 0 ){
           $arrID = array();
           while($row_importdetails = mysqli_fetch_array($query_importdetails)){
               array_push($arrID, $row_importdetails['id_product']);
           }
           $strID = implode(',',$arrID);
           $query_product = mysqli_query($conn,"SELECT * from product where id_product not in ($strID) order by id_product");
          
       }else{
           $query_product = mysqli_query($conn,"SELECT * from product order by id_product");
       }
       $query_supplier = mysqli_query($conn,"SELECT * from supplier order by id_supplier");
       if(isset($_POST['submit'])){
           $id_import = $_POST['id_import'];
           $id_supplier = $_POST['id_supplier'];
           $i =0;
           $id_product = array();
           $productPrice= array();
           $productNumber= array();
           foreach($_POST['id_product'] as $product){
               $id_product[$i]=$product;
               $i=$i+1;
           }
           $i= 0;
           foreach($_POST['productPrice'] as $productPri){
               $productPrice[$i]=$productPri;
               $i=$i+1;
           }
           $i =0;
           foreach($_POST['productNumber'] as $productNum){
               $productNumber[$i]=$productNum;
               $i=$i+1;
           }
          
            for($i = 0; $i < count($id_product); $i++){
               $sql .= " INSERT into importdetails(id_import,id_supplier,id_product,price_import,number_import) values ('$id_import','$id_supplier','".$id_product[$i]."','".$productPrice[$i]."','".$productNumber[$i]."');";
               $sql .= " UPDATE product SET number_product = number_product + '".$productNumber[$i]."' WHERE id_product = '".$id_product[$i]."';" ;
           
            }
            if(mysqli_multi_query($conn,$sql)){
               
                $_SESSION['status'] = "Thêm Thành Công!";
                $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=importproduct";
                if(headers_sent()){
                   die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
               }else{
                    header ("location: $url");
                    die();
               }
            }else {
               /*$_SESSION['status'] = "Thêm Thất Bại!";
               $_SESSION['status_code']= "error";
               $conn -> rollback();
               $url = "index.php?page_layout=import";
               if(headers_sent()){
                   die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
               }else{
                    header ("location: $url");
                    die();
               }*/
               echo "Error: " . $sql . "<br>" . mysqli_error($conn);
           }
       }
       mysqli_close($conn);
    }else {
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
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thêm Chi Tiết Nhập Hàng Mới
                                </div>
                                <div class="card-body">
                                      <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Mã Nhập Hàng</label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_import" name="id_import" required>
                                                  
                                                <?php 
                                                    while($row_import = mysqli_fetch_array($query_import)){
                                                ?>
                                                    <option value="<?php echo $row_import['id_import']; ?>"><?php echo $row_import['id_import'];?></option>
                                                <?php }?>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                        <div class="form-group">
                                                <label for="InputTypeGroup">Chọn Nhà Cung Cấp </label>
                                                  <select class="form-select form-control" aria-label="Default select example" id="id_supplier" name="id_supplier" required>
                                                       <option value="" selected>Choose</option>
                                                    <?php 
                                                        while($row_supplier = mysqli_fetch_array($query_supplier)){
                                                    ?>
                                                        <option value="<?php echo $row_supplier['id_supplier']; ?>"><?php echo $row_supplier['name_supplier'];?></option>
                                                    <?php }?>
                                                </select>
                                                <span class="form-group__message"></span>
                                           </div>
                                        <div class="form-group">
                                           <label for="inputVolume" style="margin-bottom:20px">Số Lượng Sản Phẩm Nhập</label>
                                           <input type="number" class="form-control" id="volume" name="volume"  placeholder="Enter Volume" required>
                                           <span class="form-group__message"></span>
                                        </div>
                                        <a href = "index.php?page_layout=import" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                        <button type="button" class="btn btn-primary" style="background-color: #212529;margin-top:12px;" id="volumeImport" onclick="showImportData();">Submit</button>     
                                </div>
                                <div class="card-body card_more">
                                </div>
                    </div>
                </form>
            </div>
        </div>
      
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../assets/script/validator.js"></script>
  
    <script>
        function showImportData(){
            const volumeImport = document.getElementById('volume').value;
            event.preventDefault();
            var data = '';
            if(volumeImport > 0){
                for(let i = 0 ; i< volumeImport ; i++){
                    data += ' <h6 class="card-body__heading" style="margin-top:36px">Sản Phẩm'+' ' +[i+1] +'</h6> <div class="form-group">'
                                                + '<label for="InputTypeGroup">Chọn Sản Phẩm</label>'
                                               + '<select class="form-select form-control" aria-label="Default select example"  name="id_product[]" required>'
                                                +      ' <option value="" selected>Choose</option>'
                                                <?php 
                                                        while($row_product = mysqli_fetch_array($query_product)){
                                                    ?>
                                                  +     ' <option value="<?php echo $row_product['id_product']; ?>"><?php echo $row_product['name_product'];?></option>'
                                                    <?php }?>
                                              
                                               + '</select>'
                                             +  ' <span class="form-group__message"></span>'
                                           + '</div>'
                                           
                                           + '<div class="form-group">'
                                           +    '<label for="inputVolume">Giá Nhập </label>'
                                           +    '<input type="number" class="form-control" name="productPrice[]"  placeholder="Enter Price" required>'
                                           +    '<span class="form-group__message"></span>'
                                           + '</div>'
                                           + '<div class="form-group">'
                                           +    '<label for="inputVolume">Số Lượng Nhập </label>'
                                           +    '<input type="number" class="form-control"  name="productNumber[]" placeholder="Enter Number" required>'
                                           +    '<span class="form-group__message"></span>'
                                           + '</div>';
                                      
               }
                data += ' <a href = "index.php?page_layout=importproduct" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a><button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;" name="submit">Submit</button>'
               
               document.querySelector('.card_more').innerHTML = data; 

            }
       };
    </script>
    