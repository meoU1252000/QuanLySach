<?php 
in
?>
   
                <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Quản Lý Thông Tin Danh Mục</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                       Biểu Đồ Lợi Nhuận Doanh Thu Tháng
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               Doanh Thu Năm <?php $year = $_REQUEST['id_nam'];  echo $year;?> 
                            </div>
                        </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Tháng</th>
                                            <th>Doanh Thu</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Tháng</th>
                                            <th>Doanh Thu</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                       $casemonth = mysqli_query($conn,"SELECT 
                                       Sum(Case Month(a.ngaygh) when 1 then b.giadathang else 0 end) as T1,
                                       Sum(Case Month(a.ngaygh) when 2 then b.giadathang else 0 end) as T2,
                                       Sum(Case Month(a.ngaygh) when 3 then b.giadathang else 0 end) as T3,
                                       Sum(Case Month(a.ngaygh) when 4 then b.giadathang else 0 end) as T4,
                                       Sum(Case Month(a.ngaygh) when 5 then b.giadathang else 0 end) as T5,
                                       Sum(Case Month(a.ngaygh) when 6 then b.giadathang else 0 end) as T6,
                                       Sum(Case Month(a.ngaygh) when 7 then b.giadathang else 0 end) as T7,
                                       Sum(Case Month(a.ngaygh) when 8 then b.giadathang else 0 end) as T8,
                                       Sum(Case Month(a.ngaygh) when 9 then b.giadathang else 0 end) as T9,
                                       Sum(Case Month(a.ngaygh) when 10 then b.giadathang else 0 end) as T10,
                                       Sum(Case Month(a.ngaygh) when 11 then b.giadathang else 0 end) as T11,
                                       Sum(Case Month(a.ngaygh) when 12 then b.giadathang else 0 end) as T12
                                       From dathang as a, chitietdathang as b
                                       Where a.sodondh = b.sodondh
                                             and a.trangthaidh = 'Đã Giao'
                                             and Year(a.ngaygh) = '$year'");
                                      $row= mysqli_fetch_array($casemonth);
                                      $sum = 0;
                                      $date = array();
                                      $data = array();
                                      for($i=0;$i<12;$i++){
                                          $sum += $row[$i];
                                          array_push($date,$i+1);
                                    ?>
                                       
                                        <tr>
                                           
                                            <td>   <?php if($i <=12){
                                                        echo $i+1;
                                                    }?></td>
                                            <td class = "data_input">   
                                            <?php array_push($data,$row[$i]);
                                            echo number_format($row[$i]); 
                                            ?>
                                            </td>
                                        </tr>
                                      <?php } ?>
                                    </tbody>
                                </table>
                                <a href = "index.php?page_layout=doanhthu" class="btn btn-primary " style="margin-top:12px"><i class="fas fa-arrow-left" style="margin-right:6px"></i>Back</a>
                                <a href = "#" class="btn btn-primary" style="background-color: #212529;color:white;text-decoration:none;margin-top:12px">Create New</a>
                            </div>
                        </div>
                    </div>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script>

    // Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
var dataArray = [];
// Area Chart Example
var ctx = document.getElementById("myAreaChart");
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
          unit: 'date'
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
          max: 40000000,
          maxTicksLimit: 5
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
