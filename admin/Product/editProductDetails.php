
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
    if(in_array("3", $_SESSION['roleStaff'], true)){
        $id = $_REQUEST['id'];
        $query = mysqli_query($conn, "SELECT * FROM product where id_product = '$id'");
        $row = mysqli_fetch_array($query);
        $query_details = mysqli_query($conn, "SELECT * FROM productdetails where id_product = '$id'");
        $row_details = mysqli_fetch_array($query_details);
        if(isset($_POST['authorProduct'])){
             $authorProduct = $_POST['authorProduct'];
             
             if(isset($_POST['translatorProduct'])){
                $translatorProduct = $_POST['translatorProduct'];
             }else{
                 $translatorProduct = "";
             }
             $formProduct = $_POST['form_product'];
             $numberPages = $_POST['numberPages'];
             $publishingYear = $_POST['publishingYear'];
             if(isset($_POST['introduceProduct'])){
                $introduceProduct = mysqli_real_escape_string($conn,$_POST['introduceProduct']);
             }else{
                 $introduceProduct = "";
             }
            
             $sql = "UPDATE productdetails SET  author_product = '$authorProduct',
                                               translator_product = '$translatorProduct',
                                               publishing_year = '$publishingYear',
                                               pages_product = '$numberPages',
                                               form_product = '$formProduct',
                                               introduce_product = '$introduceProduct'
                                               where id_product = '$id'";
             if(mysqli_query($conn,$sql)){
                 $_SESSION['status'] = "Cập Nhật Thành Công!";
                 $_SESSION['status_code']= "success";
                $url = "index.php?page_layout=productdetails&id=".$id;
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
             }else {
                $_SESSION['status'] = "Cập Nhật Thất Bại!";
                $_SESSION['status_code']= "error";
                $conn -> rollback();
                $url = "index.php?page_layout=product";
                if(headers_sent()){
                    die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                }else{
                     header ("location: $url");
                     die();
                }
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
                    <li class="breadcrumb-item active">Quản Lý Sản Phẩm</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thêm Chi Tiết Sản Phẩm 
                                </div>
                                <div class="card-body">
                                        <div class="form-group">
                                            <label for="InputTypeGroup">Sản Phẩm </label>
                                            <select class="form-select form-control" aria-label="Default select example" id="id_product" name="id_product">
                                                
                                                    <option value="<?php echo $row['id_product']; ?>" selected><?php echo $row['name_product'];?></option>
                                               
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                        <?php if($row_details !== NULL){ ?>
                                        <div class="form-group">
                                            <label for="InputTypeGroup">Chọn Hình Thức Bìa</label>
                                            <select class="form-select form-control" aria-label="Default select example" id="form_product" name="form_product" >
                                                   <option value="" selected>Choose</option>
                                                   <option value="Bìa Mềm">Bìa Mềm</option>
                                                   <option value="Bìa Cứng">Bìa Cứng</option>
                                            </select>
                                            <span class="form-group__message"></span>
                                        </div>
                                         <div class="form-group">
                                           <label for="inputAuthor" style="margin-bottom:20px">Tên Tác Giả</label>
                                           <input type="text" class="form-control" id="authorProduct" name="authorProduct"  placeholder="Enter Name" value="<?php echo $row_details['author_product'] ?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputTranslator" style="margin-bottom:20px">Tên Người Dịch</label>
                                           <input type="text" class="form-control" id="translatorProduct" name="translatorProduct"  placeholder="Enter Name" value="<?php echo $row_details['translator_product'] ?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputPages" style="margin-bottom:20px">Số Trang</label>
                                           <input type="number" class="form-control" id="numberPages" name="numberPages"  placeholder="Enter Name" value="<?php echo $row_details['pages_product'] ?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputPublishingYear" style="margin-bottom:20px">Năm Xuất Bản</label>
                                           <input type="text" class="form-control" id="publishingYear" name="publishingYear"  value="<?php echo $row_details['publishing_year'] ?>">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                            <label for="introduceProduct">Giới Thiệu Sản Phẩm</label>
                                            <textarea class="form-control" rows="6" name="introduceProduct" id="introduceProduct"> <?php echo $row_details['introduce_product'] ?></textarea>
                                         </div>
                                         <?php }else{
                                              $_SESSION['status'] = "Truy Cập Thất Bại!";
                                              $_SESSION['status_code']= "error";
                                              $conn -> rollback();
                                              $url = "index.php?page_layout=productdetails&id=" .$id;
                                              if(headers_sent()){
                                                  die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                                              }else{
                                                   header ("location: $url");
                                                   die();
                                              }}?>
                                        
                                         <a href = "index.php?page_layout=productdetails&id=<?php echo $id ?>" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;">Submit</button>
                                </div>
                    </div>
                </form>
            </div>
        </div>
      
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../assets/script/validator.js"></script>
    <script src="../assets/resource/ckeditor/ckeditor.js"></script>
  
    <script>
        Validator({
            form: '#validator',
            formGroupSelector: '.form-group',
            errorSelector: '.form-group__message',
            rules: [
               Validator.isRequired('#id_product'),
               Validator.isRequired('#form_product'),
               Validator.isRequired('#authorProduct'),
               Validator.isRequired('#numberPages'),
               Validator.isRequired('#publishingYear')
              
            ]
        });
        CKEDITOR.replace('introduceProduct');
    </script>
<?php mysqli_close($conn);?>