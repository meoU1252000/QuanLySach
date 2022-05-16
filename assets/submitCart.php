
<?php 
use PHPMailer\PHPMailer\PHPMailer;
include_once '../admin/config.php';
session_start();
if(isset($_POST['items'])){
  $items = json_decode($_POST['items'], true);
  //  print_r($_POST['items']);
  $address = $_POST['addressCus'];
  $totalOrderAll = $_POST['totalOrderAll'];
  $totalPrice = $_POST['totalOrder'];
  $id_customer = $_POST['idCustomer'];
  if(isset($_POST['noteOrder'])){
    $note = $_POST['noteOrder'];
  }else{
    $note = "";
  }
 


  if(json_last_error() == JSON_ERROR_NONE){
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $datetime_send = date("Y-m-d h:i:s");
    if($_POST['idCode'] !== NULL){
      $id_code = $_POST['idCode'];
      $query_order = "INSERT into orders(id_order,id_customer,id_address,id_code,date_order,order_status,total_price,note_orders) values ('','$id_customer','$address','$id_code','$datetime_send','Chưa Xử Lý','$totalPrice','$note') ";
    }else{
      $id_code = NULL;
      $query_order = "INSERT into orders(id_order,id_customer,id_address,date_order,order_status,total_price,note_orders) values ('','$id_customer','$address','$datetime_send','Chưa Xử Lý','$totalPrice','$note') ";
    }
    
    if(mysqli_query($conn,$query_order)){
      $last_id = mysqli_insert_id($conn);
      $query_address = mysqli_query($conn,"SELECT * from customeraddress where id_address = '$address'");
      $row_address = mysqli_fetch_array($query_address);
      $id_customer = $row_address['id_customer'];
      $query_customer = mysqli_query($conn,"SELECT * FROM customers where id_customer = '$id_customer'");
      $row_customer = mysqli_fetch_array($query_customer);
      $arrProduct = array();
      $arrIDSell = array();
       foreach($items as $item){
           $arrProduct[] = $item["id"];
           $arrIDSell[] = $item['idSell'];
           $arrNumber[] = $item['number'];
       }
   
       $strIDSell = implode(',',$arrIDSell);
       $selling_price = "SELECT * from sellingprice where id_sell in ($strIDSell) order by id_sell desc";
       $sql_sell = mysqli_query($conn,$selling_price);
       // $strNumber[] = implode(',', $arrNumber);
        $strID = implode(',',$arrProduct);
        // $sql = "SELECT * FROM product where id_product IN ($strID) ORDER BY id_product DESC";
        // $query_product = mysqli_query($conn,$sql);
        $insert = "";
        $update = "";
        for($i = 0 ; $i < count($arrProduct);$i++){
          $insert = "INSERT into orderdetails(id_order,id_sell,number_order) values ('$last_id','".$arrIDSell[$i]."','".$arrNumber[$i]."')";
          mysqli_query($conn,$insert);
          $update = "UPDATE product SET number_product = (number_product - '".$arrNumber[$i]."'),
                                        product_sold = (product_sold + '".$arrNumber[$i]."')WHERE id_product = $arrProduct[$i]";
          mysqli_query($conn,$update);
        }
        $select = mysqli_query($conn,"SELECT * from orderdetails where id_order = '$last_id'");
        if(mysqli_num_rows($select)>0){
                $strBody='';
                $strBody .= '<table border= "1px" cellpadding = "10px" cellspacing="11px" width="100%" style=" border-collapse: collapse; color:black;">
                <tr>
                <td align="center" style="	background-image: linear-gradient(
                    to right bottom,
                    #ff6666, #6033cc
                    );" colspan="4"><font color="white"><b><h1 style="font-size: 55px;">BookStore</h1></b></td>
            </tr>
             <tr>
              <td align="center" bgcolor="black" colspan="4"><font color="white"><b>Xác Nhận Hóa Đơn</b></td>
             </tr>
                
                <tr>
                    <td colspan="4">
                       <p color="black">
                         <b>Khách hàng: </b> '.$row_address['name_receive'].'<br />
                         <b>Email:</b> '.$row_customer['email_customer'].'<br />
                         <b>Điện thoại: </b> '.$row_address['phone_receive'].' <br />
                         <b>Địa Chỉ: </b> '.$row_address['address_receive'].' <br />
                       </p>
                       <p color="black">
                           <ul style="padding-left:0px;">
                               <b>Nếu có bất kỳ thắc mắc nào vui lòng liên hệ với BookStore Shop thông qua:</b> </ul>
                           <ul style="padding-left: 18px;">
                             <li><b>Email:</b>lethanhdat1251990@gmail.com</li>
                             <li><b>Điện thoại:</b>0984978407</li>
                             <li><b>Địa Chỉ: </b>182/45 Trần Hưng Đạo, phường 7, Quận 3, TP Hồ Chí Minh</li>
                          </ul>
                        </p>
                   </td>
                </tr>
                <tr id="invoice-bar">
                   <td width="45%"><b>Tên Sản Phẩm</b></td>
                   <td width="20%"><b>Giá</b></td>
                   <td width="15%"><b>Số lượng</b></td>
                   <td width="20%"><b>Thành tiền</b></td>
                </tr> ';
               
                // $product = "SELECT * FROM product where id_product IN ($strID) ORDER BY id_product DESC";
                // $query_product = mysqli_query($conn,$product);
               
                $i = 0;
                $id_code = $_POST['idCode'];
                $codeEvent = mysqli_query($conn,"SELECT * from codediscount where id_code ='$id_code'");
                $rowEvent = mysqli_fetch_array($codeEvent);
                $valueDiscount = $rowEvent['discount_value']; 
                $valueDiscount = $valueDiscount/100;
                $discount = floor($totalPrice * $valueDiscount);
                while($rowphp = mysqli_fetch_array($sql_sell)){
                    $id_book = $rowphp['id_product'];
                    $id_sell = $rowphp['id_sell'];
                    $product = "SELECT * FROM product where id_product = '$id_book' ";
                    $query_product = mysqli_query($conn,$product);
                    $row_book = mysqli_fetch_array($query_product);
                    $query_discount = mysqli_query($conn,"SELECT * from discountvalue where id_sell = '$id_sell'");
                    $row_discount = mysqli_fetch_array($query_discount);
                $strBody .='<tr>
                 <td class="prd-name"> '.$row_book['name_product'].'</td>
                 <td class="prd-price"><font color="#FF6666"> '.number_format($rowphp['selling_price']).' VNĐ</font></td>
                 <td class="prd-number">'.$arrNumber[$i].' </td>
                 <td class="prd-total"><font color="#FF6666"> '.number_format($rowphp['selling_price']*$arrNumber[$i]).'VNĐ</font></td>
                </tr>';
                  $i = $i + 1;
                }
                $strBody .='
                <tr>
                   <td colspan="3" class ="prd-name">Giảm Giá: </td>
                   <td class="prd-total"><b><font color ="#FF6666">' .number_format($discount).' VNĐ </font></b></td>
                </tr>
                <tr>
                   <td colspan="3" class ="prd-name">Phí Ship: </td>
                   <td class="prd-total"><b><font color ="#FF6666">' .number_format(30000).' VNĐ </font></b></td>
                </tr>
                <tr>
                  <td colspan="3" class ="prd-name">Tổng giá trị hóa đơn là: </td>
                  <td class="prd-total"><b><font color ="#FF6666">' .number_format($totalOrderAll).' VNĐ </font></b></td>
                </tr>
                </table>';
               
                require_once 'phpmailer/Exception.php';
                require_once 'phpmailer/PHPMailer.php';
                require_once 'phpmailer/SMTP.php';
      
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'pnhb13lethanhdat@gmail.com'; // Mail sử dụng như 1 SMTP server
                $mail->Password = '0984978407'; // Gmail Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = '587';
                $mail->setFrom('pnhb13lethanhdat@gmail.com'); // Mail sử dụng như 1 SMTP server
                $mail->addAddress($row_customer['email_customer'],$row_address['name_receive']); // Mail nguoi nhan
                $mail->AddCC("lethanhdat1251990@gmail.com","Le Thanh Dat"); // Gui mail cho admin
                $mail->FromName='BookStore';
                $mail->From = 'pnhb13lethanhdat@gmail.com';
                $mail->Subject='Hoa don xac nhan mua hang tu BookStore';
                $mail -> IsHTML(TRUE);
                $mail->Body=$strBody;
                if(!$mail->send()){
                  $_SESSION['title'] = "Gửi Mail Xác Nhận Thất Bại !";
                  $_SESSION['text'] = "Shop sẽ liện hệ lại qua Số Điện Thoại. Mong Quý Khách Thông Cảm !";
                  $_SESSION['icon']= "error";
                  //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
                  $conn -> rollback();
                  $url = "index.php";
                  if(headers_sent()){
                      die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                  }else{
                       header ("location: $url");
                       die();
                  }
                }else{
                  $_SESSION['title'] = "Gửi Mail Xác Nhận Thành Công!";
                  $_SESSION['icon']= "success";
                  $url = "index.php";
                  if(headers_sent()){
                      die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
                  }else{
                       header ("location: $url");
                       die();
                  }
                }
           
            
        }else{
          $_SESSION['title'] = "Đặt Hàng Thất Bại !";
          $_SESSION['icon']= "error";
          //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
          $conn -> rollback();
          $url = "index.php";
          if(headers_sent()){
              die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
          }else{
               header ("location: $url");
               die();
          }
        }

    }
    
  }else{
      echo json_last_error_msg();
  }
}else{
    $_SESSION['title'] = "Truy Cập Thất Bại !";
    $_SESSION['icon']= "error";
    //  echo "Lỗi. Vui lòng thử lại " . $sql . "<br>" . mysqli_error($conn);
    $conn -> rollback();
    $url = "index.php";
    if(headers_sent()){
        die('<script type ="text/javascript">window.location.href="'.$url.'" </script>');
    }else{
         header ("location: $url");
         die();
    }
}
?>
