<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<?php
if(isset($_SESSION['status']) && $_SESSION['status'] !=''){
?>
<script>
     swal({
                title: "<?php echo $_SESSION['status'];?>",
                text: "<?php if(isset($_SESSION['notice'])){ 
                                echo $_SESSION['notice'];
                              }else{ 
                                echo "";
                              }
                        ?>",
                icon: "<?php echo $_SESSION['status_code']?>",
              });
</script>
<?php
unset($_SESSION['status']);
unset($_SESSION['notice']);
}

?>
<script>
    function deleteData(event){
      event.preventDefault();
      var form = event.target.closest("form");
      //console.log(form);
        swal({
          title: "Chắc chắn xóa?",
          text: "Dữ liệu sau khi xóa sẽ không thể khôi phục. Tiếp tục ?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
              form.submit();
            } else {
              swal("Hủy thành công!");
            }
         });;
        
    }
</script>

