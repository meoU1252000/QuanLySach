<?php  
include_once '../admin/config.php';
session_start();

if(isset($_POST['last_id']) && !isset($_POST['idGroup']) && !isset($_POST['idType'])){
    $output = '';  
    $product_id = '';  
    $sql = "SELECT * FROM product WHERE id_product > ".$_POST['last_id']." LIMIT 6";  
    $result = mysqli_query($conn, $sql);  
    if(mysqli_num_rows($result) > 0)  
    {  
         while($row_book = mysqli_fetch_array($result))  
         {  
            $id_product = $row_book['id_product'];
            $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
            $row_img = mysqli_fetch_array($query_img);
            $currentDate = date("Y-m-d");
            $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
            $row_sellingprice = mysqli_fetch_array($query_sellingprice);
            $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id_product' ");
            $row_rating = mysqli_fetch_array($query_rating);
            $sum = 0;
            $cost =0;
            $totalStar = 5;
            $totalStarRating = 0;
            $averageRating = 0;
              $output .= '  
              <div class="col-sm-6 col-md-4 " name="productCol">
              <a href="index.php?page_layout=productDetails&id='.$row_book['id_product'].'">
                  <div class="box ">
                    <div class="img-box">
                      <img src="'.$row_img['link_img'].'" alt="" class="img_book">
                      
                    </div>
                    <div class="detail-box">
                       
                          <h5 style="    display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden">'
                            .$row_book['name_product'].
                          '</h5>
                        
                        <p style="font-size:1.2rem;color:red">'.number_format($row_sellingprice['selling_price'],0,",",".").' VNĐ</p>
                        <p class="product_star">
                        <fieldset class="rate" style="color:#cccccc">';
                              
                        if($row_rating['totalRating']>0){
                          
                          $sum = $row_rating['totalRating'];
                          $totalStarRating = $row_rating['totalStar'];
                          $averageRating = round($totalStarRating / $sum,2);
                         
                     
                          $cost =  $totalStar - $averageRating;
                           for($i = 0; $i < intval($averageRating);$i++){
  
                             $output .= '<i class="fa-solid fa-star starActive" style="letter-spacing:3.5px"></i>';
                        
                        }  for($j = 0; $j < $cost ; $j++){
                           
                         $output .=  '<i class="fa-solid fa-star starNotActive" style="letter-spacing:3.5px"></i>';
                       
                       }
                         $output .=    '<span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">('.$sum.') </span>';
                      }else{
                      $output.=  '<i class="fa-solid fa-star starNotActive"></i>
                        <i class="fa-solid fa-star starNotActive"></i>
                        <i class="fa-solid fa-star starNotActive"></i>
                        <i class="fa-solid fa-star starNotActive"></i>
                        <i class="fa-solid fa-star starNotActive"></i>
                        <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(0)</span>';
                      }
                           
                      $output.=  '</fieldset>
                   
                          </p>
                    </div>
                    
                  </div>
              </a>
            </div>';  
          }  
          $output.= '   <div class="row readMore" style="margin-top: 36px;margin-bottom:36px;display: block;width: 100%;" id="readMore"><button name="btn_more"  data-book="'.$id_product.'" id="btn_more" style="display:flex;align-item:center;">Xem Thêm</button></div>';
         
         echo $output;  
    }  

}else if(isset($_POST['idType'])){
    $output = '';  
    $product_id = ''; 
    $id = $_POST['idType'];
    
    if(!isset($_POST['last_id'])){
      $sql = "SELECT * FROM product WHERE id_type = '$id' order by id_product asc limit 6";  
    }else{
      $sql = "SELECT * FROM product WHERE id_type = '$id' and id_product > ".$_POST['last_id']." LIMIT 6"; 
    }
    $result = mysqli_query($conn, $sql);  
    if(mysqli_num_rows($result) > 0)  
    {  
        while($row_book = mysqli_fetch_array($result))  
        {  
           $id_product = $row_book['id_product'];
           $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
           $row_img = mysqli_fetch_array($query_img);
           $currentDate = date("Y-m-d");
           $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
           $row_sellingprice = mysqli_fetch_array($query_sellingprice);
           $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id_product' ");
           $row_rating = mysqli_fetch_array($query_rating);
           $sum = 0;
           $cost =0;
           $totalStar = 5;
           $totalStarRating = 0;
           $averageRating = 0;
             $output .= '  
             <div class="col-sm-6 col-md-4 " name="productCol">
             <a href="index.php?page_layout=productDetails&id='.$row_book['id_product'].'">
                 <div class="box ">
                   <div class="img-box">
                     <img src="'.$row_img['link_img'].'" alt="" class="img_book">
                     
                   </div>
                   <div class="detail-box">
                      
                         <h5 style="    display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden">'
                           .$row_book['name_product'].
                         '</h5>
                       
                       <p style="font-size:1.2rem;color:red">'.number_format($row_sellingprice['selling_price'],0,",",".").' VNĐ</p>
                       <p class="product_star">
                       <fieldset class="rate" style="color:#cccccc">';
                              
                       if($row_rating['totalRating']>0){
                         
                         $sum = $row_rating['totalRating'];
                         $totalStarRating = $row_rating['totalStar'];
                         $averageRating = round($totalStarRating / $sum,2);
                         $cost =  $totalStar - $averageRating;
                          for($i = 0; $i < intval($averageRating);$i++){
 
                            $output .= '<i class="fa-solid fa-star starActive" style="letter-spacing:3.5px"></i>';
                       
                       }  for($j = 0; $j < $cost ; $j++){
                          
                        $output .=  '<i class="fa-solid fa-star starNotActive" style="letter-spacing:3.5px"></i>';
                      
                      }
                        $output .=  '<span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">('.$sum.')  </span>';
                     }else{
                     $output.=  '<i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <i class="fa-solid fa-star starNotActive"></i>
                       <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(0)</span>';
                     }
                          
                     $output.=  '</fieldset>
                  
                         </p>
                   </div>
                   
                 </div>
             </a>
           </div>';  
        }  
        $output.= '   <div class="row readMore" style="margin-top: 36px;margin-bottom:36px;display: block;width: 100%;" id="readMore"><button name="btn_more" data-type='.$id.'  data-book="'.$id_product.'" id="btn_more" style="display:flex;align-item:center;">Xem Thêm</button></div>';
        
        echo $output;  
    }
}else if(isset($_POST['idGroup'])){
  $output = '';  
  $product_id = ''; 
  $id = $_POST['idGroup'];
  $query = mysqli_query($conn,"SELECT * from typegroup where id_typegroup = '$id' ");
  $row_typegroup = mysqli_fetch_array($query);
  $id_typegroup = $row_typegroup['id_typegroup'];
  $id_product = 0;
  $idProductCheck = 0;
  if(!isset($_POST['last_id'])){
    
    $query_type = mysqli_query($conn,"SELECT * from producttype where id_typegroup = '$id_typegroup'");
    while($row_type = mysqli_fetch_array($query_type)){
      
      $id_type = $row_type['id_type'];
      $sql = "SELECT * FROM product WHERE id_type = '$id_type' order by id_product asc limit 6 ";  
      $result = mysqli_query($conn, $sql);  
      if(mysqli_num_rows($result) > 0)  
      {  
          while($row_book = mysqli_fetch_array($result))  
          {  
             $id_product = $row_book['id_product'];
             if($idProductCheck < $id_product){
              $idProductCheck = $id_product;
            }
             $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
             $row_img = mysqli_fetch_array($query_img);
             $currentDate = date("Y-m-d");
             $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
             $row_sellingprice = mysqli_fetch_array($query_sellingprice);
             $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id_product' ");
             $row_rating = mysqli_fetch_array($query_rating);
             $sum = 0;
             $cost =0;
             $totalStar = 5;
             $totalStarRating = 0;
             $averageRating = 0;
               $output .= '  
               <div class="col-sm-6 col-md-4" name="productCol">
               <a href="index.php?page_layout=productDetails&id='.$row_book['id_product'].'">
                   <div class="box">
                     <div class="img-box">
                       <img src="'.$row_img['link_img'].'" alt="" class="img_book">
                       
                     </div>
                     <div class="detail-box">
                        
                           <h5 style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden">'
                             .$row_book['name_product'].
                           '</h5>
                         
                         <p style="font-size:1.2rem;color:red">'.number_format($row_sellingprice['selling_price'],0,",",".").' VNĐ</p>
                         <p class="product_star">
                             <fieldset class="rate" style="color:#cccccc">';
                                  
                             if($row_rating['totalRating']>0){
                               
                               $sum = $row_rating['totalRating'];
                               $totalStarRating = $row_rating['totalStar'];
                               $averageRating = round($totalStarRating / $sum,2);
                              
                          
                               $cost =  $totalStar - $averageRating;
                                for($i = 0; $i < intval($averageRating);$i++){
   
                                  $output .= '<i class="fa-solid fa-star starActive" style="letter-spacing:3.5px"></i>';
                             
                                 }  
                              for($j = 0; $j < $cost ; $j++){
                                
                                  $output .=  '<i class="fa-solid fa-star starNotActive" style="letter-spacing:3.5px"></i>';
                             
                               }
                              $output .=  '<span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">('.$sum.')</span>';
                           }else{
                           $output.=  '<i class="fa-solid fa-star starNotActive"></i>
                             <i class="fa-solid fa-star starNotActive"></i>
                             <i class="fa-solid fa-star starNotActive"></i>
                             <i class="fa-solid fa-star starNotActive"></i>
                             <i class="fa-solid fa-star starNotActive"></i>
                             <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(0)</span>';
                           }
                                
                           $output.=  '</fieldset>
                    
                           </p>
                     </div>
                     
                   </div>
               </a>
             </div>';  
          }  
         
          
        }
      }
      $output.= '   <div class="row readMore" style="margin-top: 36px;margin-bottom:36px;display: block;width: 100%;" id="readMore"><button name="btn_more" data-typegroup="'.$id.'"  data-book="'.$idProductCheck.'" id="btn_more" style="display:flex;align-item:center;">Xem Thêm</button></div>';
      echo $output;  
  }else{
    $query_type = mysqli_query($conn,"SELECT * from producttype where id_typegroup = '$id_typegroup'");
    $check = 0;
    $idProductCheck = 0;
    while($row_type = mysqli_fetch_array($query_type)){
      $id_type = $row_type['id_type'];
      $sql = "SELECT * FROM product WHERE id_type = '$id_type' and id_product > ".$_POST['last_id']." LIMIT 6";  
      $result = mysqli_query($conn, $sql);  
      if(mysqli_num_rows($result) > 0)  
      {  
          while($row_book = mysqli_fetch_array($result))  
          {  
             $id_product = $row_book['id_product'];
             if($idProductCheck < $id_product){
               $idProductCheck = $id_product;
             }
             $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
             $row_img = mysqli_fetch_array($query_img);
             $currentDate = date("Y-m-d");
             $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
             $row_sellingprice = mysqli_fetch_array($query_sellingprice);
             $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id_product' ");
             $row_rating = mysqli_fetch_array($query_rating);
             $sum = 0;
             $cost =0;
             $totalStar = 5;
             $totalStarRating = 0;
             $averageRating = 0;
               $output .= '  
               <div class="col-sm-6 col-md-4 " name="productCol">
               <a href="index.php?page_layout=productDetails&id='.$row_book['id_product'].'">
                   <div class="box ">
                     <div class="img-box">
                       <img src="'.$row_img['link_img'].'" alt="" class="img_book">
                      
                     </div>
                     <div class="detail-box">
                        
                           <h5 style="display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden">'
                             .$row_book['name_product'].
                           '</h5>
                         
                         <p style="font-size:1.2rem;color:red">'.number_format($row_sellingprice['selling_price'],0,",",".").' VNĐ</p>
                         <p class="product_star">
                               <fieldset class="rate" style="color:#cccccc">';
                              
                               if($row_rating['totalRating']>0){
                                 
                                 $sum = $row_rating['totalRating'];
                                 $totalStarRating = $row_rating['totalStar'];
                                 $averageRating = ceil($totalStarRating / $sum);
                                
                            
                                 $cost =  $totalStar - $averageRating;
                                  for($i = 0; $i < $averageRating;$i++){
         
                                    $output .= '<i class="fa-solid fa-star starActive" style="letter-spacing:3.5px"></i>';
                               
                               }  for($j = 0; $j < $cost ; $j++){
                                  
                                $output .=  '<i class="fa-solid fa-star starNotActive"></i>';
                              
                              }
                                $output .=    '<span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">('.$sum.')  </span>';
                             }else{
                             $output.=  '<i class="fa-solid fa-star starNotActive"></i>
                               <i class="fa-solid fa-star starNotActive"></i>
                               <i class="fa-solid fa-star starNotActive"></i>
                               <i class="fa-solid fa-star starNotActive"></i>
                               <i class="fa-solid fa-star starNotActive"></i>
                               <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(0)</span>';
                             }
                                  
                             $output.=  '</fieldset>
                    
                           </p>
                     </div>
                     
                   </div>
               </a>
             </div>';  
          }  
         $check = 1;
          
        }
       
      }
      
      if($check == 0){
        $output = '';
        echo $output;  
      }else{
        $output.= '   <div class="row readMore" style="margin-top: 36px;margin-bottom:36px;display: block;width: 100%;" id="readMore"><button name="btn_more" data-typegroup="'.$id.'"  data-book="'.$idProductCheck.'" id="btn_more" style="display:flex;align-item:center;">Xem Thêm</button></div>';
        echo $output;  

      }
  }
}else if(isset($_POST['idAll'])){
  $output = '';  
  $query_book = mysqli_query($conn,"SELECT * from product order by id_product asc limit 6");
  while ($row_book = mysqli_fetch_array($query_book)){
    $id_product = $row_book['id_product'];
    $id_type = $row_book['id_type'];
    $id_publishingcompany = $row_book['id_publishingcompany'];
    $query_img = mysqli_query($conn,"SELECT * from productimage where id_product = '$id_product'");
    $row_img = mysqli_fetch_array($query_img);
    $query_type = mysqli_query($conn,"SELECT * from producttype where id_type = '$id_type'");
    $row_type = mysqli_fetch_array($query_type);
    $query_publishingcompany = mysqli_query($conn,"SELECT * from publishingcompany where id_publishingcompany = '$id_publishingcompany'");
    $row_publishingcompany = mysqli_fetch_array($query_publishingcompany);
    $id_typegroup = $row_type['id_typegroup'];
    $query_typegroup = mysqli_query($conn,"SELECT * from typegroup where id_typegroup = '$id_typegroup'");
    $row_typegroup = mysqli_fetch_array($query_typegroup);
    $currentDate = date("Y-m-d");
    $query_sellingprice = mysqli_query($conn,"SELECT * from sellingprice where id_product = '$id_product' and date_end >= '$currentDate' or date_end = '' and id_product='$id_product'");
    $query_rating = mysqli_query($conn,"SELECT SUM(star_rating) as totalStar, Count(id_product) as totalRating from productrating where id_product = '$id_product' ");
    $row_rating = mysqli_fetch_array($query_rating);
    $sum = 0;
    $cost =0;
    $totalStar = 5;
    $totalStarRating = 0;
    $averageRating = 0;
    $row_sellingprice = mysqli_fetch_array($query_sellingprice);
    $output.='<div class="col-sm-6 col-md-4" name="productCol">
    <a href="index.php?page_layout=productDetails&id='.$row_book['id_product'].'">
        <div class="box ">
          <div class="img-box">
            <img src="'.$row_img['link_img'].'" alt="" class="img_book">
            
          </div>
          <div class="detail-box">
             
                <h5 style=" display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;overflow: hidden">
                '.$row_book['name_product'].'
                </h5>
              
              <p style="font-size:1.2rem;color:red">'.number_format($row_sellingprice['selling_price'],0,",",".").' VNĐ</p>
              <p class="product_star">
              <fieldset class="rate" style="color:#cccccc">';
                              
              if($row_rating['totalRating']>0){
                
                $sum = $row_rating['totalRating'];
                $totalStarRating = $row_rating['totalStar'];
                $averageRating = round($totalStarRating / $sum,2);
                $cost =  $totalStar - $averageRating;
                 for($i = 0; $i < intval($averageRating);$i++){

                   $output .= '<i class="fa-solid fa-star starActive" style="letter-spacing:3.5px"></i>';
              
              }  for($j = 0; $j < $cost ; $j++){
                 
               $output .=  '<i class="fa-solid fa-star starNotActive" style="letter-spacing:3.5px"></i>';
             
             }
               $output .=  '<span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">('.$sum.')  </span>';
            }else{
            $output.=  '<i class="fa-solid fa-star starNotActive"></i>
              <i class="fa-solid fa-star starNotActive"></i>
              <i class="fa-solid fa-star starNotActive"></i>
              <i class="fa-solid fa-star starNotActive"></i>
              <i class="fa-solid fa-star starNotActive"></i>
              <span style="margin-left: 5px;transform: translateY(-30%);font-size:16px;color:orange;">(0)</span>';
            }
                 
            $output.=  '</fieldset>
         
               
                      </p>
                </div>
                
              </div>
          </a>
         </div>';
  }
  $output.= '      <div class="row readMore" style="margin-top: 36px;margin-bottom:36px;display: block;width: 100%;" id="readMore">
  <button name="btn_more"  data-book="'.$id_product.'" id="btn_more" style="display:flex;align-item:center;">Xem Thêm</button>
</div>';
        
  echo $output;  
}else if(isset($_POST['price'])){
  
}
?>
