<!-- sttart footer -->
<div class="container">
<footer style="margin-top: 3%;">
  <div class="box2"></div>
  <center><p class="tulisan-footer">&copy; Lorem ipsum dolor sit amet, consectetur.</p></center>
</footer>
</div>
<script src="asset/js/vendor/bootstrap.min.js"></script>
<script src="asset/DataTables/datatables.min.js"></script>
<script src="asset/datepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="asset/datepicker/js/locales/bootstrap-datetimepicker.id.js"></script>
<script>
    function myFunction() {
      document.getElementsByClassName("topnav")[0].classList.toggle("responsive");
    }
</script>
<script type="text/javascript">
  function readURL(input){
    if(input.files && input.files[0]){
          var reader = new FileReader();
          reader.onload = function(e){
            $('#tampil').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
  }
  $("#upload").change(function(){
    readURL(this);
        $('#hasil').show();
        $('#hilang').hide();
  });
</script>
<script type="text/javascript">
  $(window).load(function(){
        $(".loader").fadeOut("slow");
      });
  
  $(document).ready(function() {
      var path = window.location.href;
      $('ul li a').each(function(){
        if (this.href === path) {
          $(this).closest('a').addClass('active');
        } 
      });

        $(".dropdown-btn").click(function(){
            var val=$(this).attr('id');     
            if(val=="open"){
              $(".drop").hide();
              $(this).attr('id', ''); 
            }else{
              $(".drop").show();
              $(this).attr('id', 'open');
            } 
        });

      gone = function(val)
      {
          var form1 = $("#form1");
          var form2 = $("#form2");

          if (val.checked == true)
          {
              form1.addClass('gone');
              form2.removeClass('gone');
          }
          else
          {
              $("#form1").removeClass('gone');
              $("#form2").addClass('gone');
          }
      }

      $('#dataTabel').DataTable();

      $("#btn-search").click(function(){
          $.ajax({
            url: 'search.php',
            type: 'POST', 
            data: {keyword: $("#keyword").val()}, 
            dataType: "json",
            beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
              }
            },
            success: function(response){
              $(".view").html(response.hasil);
            },
            error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.responseText);
            }
          });
        });

      $("#btn-adm").click(function(){
          $.ajax({
            url: 'search_adm.php',
            type: 'POST', 
            data: {keyword: $("#keyword").val()}, 
            dataType: "json",
            beforeSend: function(e) {
              if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
              }
            },
            success: function(response){
              $(".view").html(response.hasil);
            },
            error: function (xhr, ajaxOptions, thrownError) {
              alert(xhr.responseText);
            }
          });
        });

        $('.start').datetimepicker({
          language:  'id',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
        });
          
        $('.finish').datetimepicker({
          language:  'id',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
        });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {

      var detik   = <?= $detik; ?>;
      var menit   = <?= $menit; ?>;
      
      function hitung() {
          setTimeout(hitung,1000);

          // $('#timer').html(
          //     '<h1 align="center">Sisa waktu anda <br />' + menit + ' menit : ' + detik + ' detik</h1><hr>'
          // );
          
          detik --;
          
          if(detik < 0) {
              detik = 59;
              menit --;
                       
            if(menit < 0) { 
                clearInterval(hitung);
                window.location.href="limit.php";
            }      
          } 
      } 
      hitung();
  });
</script>
</body>
</html>