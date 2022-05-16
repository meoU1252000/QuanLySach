<?php 
if (!isset($_SESSION['username'])) {
  header('location: ./login.php');
}else{
  if(in_array("2", $_SESSION['roleStaff'], true)){
    $result = mysqli_query($conn, "SELECT 
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
    FROM orderdetails as a, orders as b, sellingprice as c where a.id_order = b.id_order and a.id_sell = c.id_sell and b.order_status = 'Đã Giao'");
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
                            <li class="breadcrumb-item active">Quản Lý Doanh Thu Tháng</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                       Biểu Đồ Lợi Nhuận Doanh Thu Tháng
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Năm</th>
                                            <th>Doanh Thu</th>
                                           
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Năm</th>
                                            <th>Doanh Thu</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                      
                                    <?php 
                                        $row= mysqli_fetch_array($result);
                                       $sum = 0;
                                       $date = array();
                                       $data = array();
                                       for($i=0;$i<12;$i++){
                                           $sum += $row[$i];
                                           array_push($date,$i+1);
                                    ?>
                                        <tr>
                                            
                                            <td>   <?php 
                                                       if($i <=12){
                                                        echo $i+1;
                                                    }?>
                                                    </td>
                                            <td class = "data_input">   
                                            <?php 
                                                   array_push($data,$row[$i]);
                                                  echo number_format($row[$i]); 
                                                  
                                            ?>
                                            </td>
                                            
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                                <a href = "#" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        </div>
                    </div>
                    

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
    labels: [<?php echo join(',',$date); ?>],
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
          maxTicksLimit: 10
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max:  1000000,
          maxTicksLimit: 10
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

</script>