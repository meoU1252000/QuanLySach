<?php 

include_once '../admin/config.php';
session_start();
if(isset($_POST['codeEvent']) && isset($_POST['priceOrder'])){
    $code = $_POST['codeEvent'];
    $price = $_POST['priceOrder'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $datetime_now = date("Y-m-d h:i:s");
    $select = mysqli_query($conn,"SELECT * from codediscount where code_event = '$code' and  date_end > '$datetime_now' and  date_start <= '$datetime_now'");
    if(mysqli_num_rows($select) > 0 ){
        $row = mysqli_fetch_array($select);
        $valueDiscount = $row['discount_value'];
        $valueDiscount = $valueDiscount/100;
        $price = $price - ($price * $valueDiscount);
        $_SESSION['codeEvent'] = $code;
        print_r(floor($price));
    }else{
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }
}
?>