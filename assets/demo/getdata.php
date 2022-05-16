<?php
session_start();
include_once '../../admin/config.php';
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
                                       Sum(Case Month(a.ngaygh) when 12 then b.giadathang else 0 end) as T12,
                                       SUM(b.giadathang) as CaNam
                                       From dathang as a, chitietdathang as b
                                       Where a.sodondh = b.sodondh
                                             and a.trangthaidh = 'Đã Giao'");
                                      $row= mysqli_fetch_array($casemonth);
                                      $sum = 0;
                                      for($i=0;$i<12;$i++){
                                          $sum += $row[$i];
                                          if($i <=12){
                                            echo $i+1;
                                        }echo number_format($row[$i]); }

?>
