
<?php
include_once './config.php';

if (!isset($_SESSION['username'])) {
    header('location: ./login.php');
}else{
  if(in_array("5", $_SESSION['roleStaff'], true)){
    if(isset($_POST['codeEvent']) && isset($_POST['discountValue']) && isset($_POST['dateStart']) && isset($_POST['dateEnd'])){
         $code = $_POST['codeEvent'];
         $value = $_POST['discountValue'];
         $dateStart = $_POST['dateStart'];
         $dateEnd = $_POST['dateEnd'];
         $sql = "INSERT into codediscount(code_event,discount_value,date_start,date_end) values ('$code','$value','$dateStart','$dateEnd')";
         if(mysqli_query($conn,$sql)){
             $_SESSION['status'] = "Thêm Thành Công!";
             $_SESSION['status_code']= "success";
            $url = "index.php?page_layout=codediscount";
            if(headers_sent()){
                die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                 header ("location: $url");
                 die();
            }
         }else {
            $_SESSION['status'] = "Thêm Thất Bại!";
            $_SESSION['status_code']= "error";
            $conn -> rollback();
            $url = "index.php?page_layout=codediscount";
            if(headers_sent()){
                die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
            }else{
                 header ("location: $url");
                 die();
            }
        }
    }
    mysqli_close($conn);
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
                    <li class="breadcrumb-item active">Quản Lý Mã Giảm Giá</li>
                </ol>
            <div class="body-page--function-form">
                <form action="#" method="POST" enctype="multipart/form-data" id = "validator" >
                    <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Thêm Mã Giảm Giá Mới
                                </div>
                                <div class="card-body">
                                         <div class="form-group">
                                           <label for="inputName">Code Event</label>
                                           <input type="text" class="form-control" id="codeEvent" name="codeEvent"  placeholder="Enter Code">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputAddress">Phần Trăm Giảm</label>
                                           <div class="detail-box_wrap">
                                               <div class="input-box">
                                                 <button id="decrement"> - </button>
                                                 <input type="number" min="1" max="100" step="0.5" value="1" id="my-input" readonly name="discountValue">
                                                 <button id="increment"> + </button>
                                               </div>
                                            </div>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Bắt Đầu Sự Kiện</label>
                                            <input type="date" class="form-control" id="dateStart" name="dateStart"  style="width:12%">
                                          
                                           <span class="form-group__message"></span>
                                         </div>
                                         <div class="form-group">
                                           <label for="inputName" style="margin-bottom:20px">Chọn Ngày Kết Thúc Sự Kiện</label>
                                           <input type="date" class="form-control" id="dateEnd" name="dateEnd"  style="width:12%">
                                           <span class="form-group__message"></span>
                                         </div>
                                         <a href = "index.php?page_layout=codediscount" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                         <button type="submit" class="btn btn-primary" style="background-color: #212529;margin-top:12px;">Submit</button>
                                </div>
                    </div>
                </form>
            </div>
        </div>
      
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../assets/script/validator.js"></script>
    
  
    <script>
        Validator({
            form: '#validator',
            formGroupSelector: '.form-group',
            errorSelector: '.form-group__message',
            rules: [
               Validator.isRequired('#codeEvent'),
               Validator.isRequired('#dateStart'),
               Validator.isRequired('#dateEnd')
            ]
        });
        const increment = document.getElementById('increment');
        increment.addEventListener("click", function (event) {
          event.preventDefault();
          var eventListener = event.target;
          var eventParent = eventListener.parentElement;
          // console.log(eventParent);
          const myInput = eventParent.querySelector("#my-input");
          let id = eventParent.querySelector("#increment").innerText;
          let min = myInput.getAttribute("min");
          let max = myInput.getAttribute("max");
          let step = myInput.getAttribute("step");
          let val = myInput.getAttribute("value");
          let calcStep = id == "+" ? step * 1 : step * -1;
          let newValue = parseFloat(val) + calcStep;
         
          if (newValue >= min && newValue <= max) {
            myInput.setAttribute("value", newValue);
          }
        });
        const decrement = document.getElementById("decrement");
        decrement.addEventListener("click", function (event) {
          event.preventDefault();
          var eventListener = event.target;
          var eventParent = eventListener.parentElement;
          // console.log(eventParent);
          const myInput = eventParent.querySelector("#my-input");
          let id = eventParent.querySelector("#decrement").innerText;
          let min = myInput.getAttribute("min");
          let max = myInput.getAttribute("max");
          let step = myInput.getAttribute("step");
          let val = myInput.getAttribute("value");
          let calcStep = id == "-" ? step * -1 : step * 1;
          let newValue = parseFloat(val) + calcStep;
          if (newValue >= min && newValue <= max) {
            myInput.setAttribute("value", newValue);
          }
        });
        var today = new Date();
        var dd = today.getDate() + 1;
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        
        if (dd < 10) {
           dd = '0' + dd;
        }
        
        if (mm < 10) {
           mm = '0' + mm;
        } 
            
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("dateStart").setAttribute("min", today);
        document.getElementById("dateEnd").setAttribute("min", today);
    </script>