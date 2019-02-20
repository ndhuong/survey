$(document).ready(function() {
  
	$('#room_tot_hon').hide();
	$('#how_an_uong').hide();
	$('#how_dich_vu').hide();
  $('#how_trang_bi').hide();
  $('#how_trang_tri').hide();
  $('#how_khac').hide();
  $('#employ_ten_nhan_vien').hide();
  $('#overall_how').hide(); 
  $('#khach').hide();

  $('#employ_chung').hide();
  $('#employ_tu_tin').hide();
  $('#employ_nhanh').hide();
  $('#employ_chuyen_nghiep').hide();
  $('#employ_hai_long').hide();
  $('#overall_chung').hide();
  
//----------------------------------------------------------
  $('#employ_chungHien').on("click",function(){
    if($("#employ_chungStatus").val()==1){
      $('#employ_chung').show();
      document.getElementById('employ_chungStatus').value=2;
      $("#employ_chungHien").html('Ẩn -');
    }
    else{
      $('#employ_chung').hide();
      document.getElementById('employ_chungStatus').value=1;
      $("#employ_chungHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#employ_tu_tinHien').on("click",function(){
    if($("#employ_tu_tinStatus").val()==1){
      $('#employ_tu_tin').show();
      document.getElementById('employ_tu_tinStatus').value=2;
      $("#employ_tu_tinHien").html('Ẩn -');
    }
    else{
      $('#employ_tu_tin').hide();
      document.getElementById('employ_tu_tinStatus').value=1;
      $("#employ_tu_tinHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#employ_nhanhHien').on("click",function(){
    if($("#employ_nhanhStatus").val()==1){
      $('#employ_nhanh').show();
      document.getElementById('employ_nhanhStatus').value=2;
      $("#employ_nhanhHien").html('Ẩn -');
    }
    else{
      $('#employ_nhanh').hide();
      document.getElementById('employ_nhanhStatus').value=1;
      $("#employ_nhanhHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#employ_chuyen_nghiepHien').on("click",function(){
    if($("#employ_chuyen_nghiepStatus").val()==1){
      $('#room_tot_hon').show();
      document.getElementById('employ_chuyen_nghiepStatus').value=2;
      $("#employ_chuyen_nghiepHien").html('Ẩn -');
    }
    else{
      $('#employ_chuyen_nghiep').hide();
      document.getElementById('employ_chuyen_nghiepStatus').value=1;
      $("#employ_chuyen_nghiepHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#employ_hai_longHien').on("click",function(){
    if($("#employ_hai_longStatus").val()==1){
      $('#employ_hai_long').show();
      document.getElementById('employ_hai_long').value=2;
      $("#employ_hai_longHien").html('Ẩn -');
    }
    else{
      $('#employ_hai_long').hide();
      document.getElementById('employ_hai_longStatus').value=1;
      $("#employ_hai_longHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
/*  $('#employ_ten_nhan_vienHien').on("click",function(){
    if($("#employ_ten_nhan_vienStatus").val()==1){
      $('#employ_ten_nhan_vien').show();
      document.getElementById('employ_ten_nhan_vienStatus').value=2;
      $("#employ_ten_nhan_vienHien").html('Ẩn -');
    }
    else{
      $('#employ_ten_nhan_vien').hide();
      document.getElementById('employ_ten_nhan_vienStatus').value=1;
      $("#employ_ten_nhan_vienHien").html('Hiện +');
    }
  });
 */ 
//----------------------------------------------------------
/*  $('#overall_howHien').on("click",function(){
    if($("#overall_howStatus").val()==1){
      $('#overall_how').show();
      document.getElementById('overall_howStatus').value=2;
      $("#overall_howHien").html('Ẩn -');
    }
    else{
      $('#overall_how').hide();
      document.getElementById('overall_howStatus').value=1;
      $("#overall_howHien").html('Hiện +');
    }
  });
*/
//----------------------------------------------------------
  $('#overall_chungHien').on("click",function(){
    if($("#overall_chungStatus").val()==1){
      $('#overall_chung').show();
      document.getElementById('overall_chungStatus').value=2;
      $("#overall_chungHien").html('Ẩn -');
    }
    else{
      $('#overall_chung').hide();
      document.getElementById('overall_chungStatus').value=1;
      $("#overall_chungHien").html('Hiện +');
    }
  });
//----------------------------------------------------------


	$('#room_tot_honHien').on("click",function(){
    if($("#room_tot_honStatus").val()==1){
      $('#room_tot_hon').show();
      document.getElementById('room_tot_honStatus').value=2;
      $("#room_tot_honHien").html('Ẩn -');
    }
    else{
      $('#room_tot_hon').hide();
      document.getElementById('room_tot_honStatus').value=1;
      $("#room_tot_honHien").html('Hiện +');
    }
	});
//----------------------------------------------------------
  $('#how_an_uongHien').on("click",function(){
    if($("#how_an_uongStatus").val()==1){
      $('#how_an_uong').show();
      document.getElementById('how_an_uongStatus').value=2;
      $("#how_an_uongHien").html('Ẩn -');
    }
    else{
      $('#how_an_uong').hide();
      document.getElementById('how_an_uongStatus').value=1;
      $("#how_an_uongHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#how_dich_vuHien').on("click",function(){
    if($("#how_dich_vuStatus").val()==1){
      $('#how_dich_vu').show();
      document.getElementById('how_dich_vuStatus').value=2;
      $("#how_dich_vuHien").html('Ẩn -');
    }
    else{
      $('#how_dich_vu').hide();
      document.getElementById('how_dich_vuStatus').value=1;
      $("#how_dich_vuHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#how_trang_biHien').on("click",function(){
    if($("#how_trang_biStatus").val()==1){
      $('#how_trang_bi').show();
      document.getElementById('how_trang_biStatus').value=2;
      $("#how_trang_biHien").html('Ẩn -');
    }
    else{
      $('#how_trang_bi').hide();
      document.getElementById('how_trang_biStatus').value=1;
      $("#how_trang_biHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#how_trang_triHien').on("click",function(){
    if($("#how_trang_triStatus").val()==1){
      $('#how_trang_tri').show();
      document.getElementById('how_trang_triStatus').value=2;
      $("#how_trang_triHien").html('Ẩn -');
    }
    else{
      $('#how_trang_tri').hide();
      document.getElementById('how_trang_triStatus').value=1;
      $("#how_trang_triHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#how_khacHien').on("click",function(){
    if($("#how_khacStatus").val()==1){
      $('#how_khac').show();
      document.getElementById('how_khacStatus').value=2;
      $("#how_khacHien").html('Ẩn -');
    }
    else{
      $('#how_khac').hide();
      document.getElementById('how_khacStatus').value=1;
      $("#how_khacHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#employ_ten_nhan_vienHien').on("click",function(){
    if($("#employ_ten_nhan_vienStatus").val()==1){
      $('#employ_ten_nhan_vien').show();
      document.getElementById('employ_ten_nhan_vienStatus').value=2;
      $("#employ_ten_nhan_vienHien").html('Ẩn -');
    }
    else{
      $('#employ_ten_nhan_vien').hide();
      document.getElementById('employ_ten_nhan_vienStatus').value=1;
      $("#employ_ten_nhan_vienHien").html('Hiện +');
    }
  });
//----------------------------------------------------------
  $('#overall_howHien').on("click",function(){
    if($("#overall_howStatus").val()==1){
      $('#overall_how').show();
      document.getElementById('overall_howStatus').value=2;
      $("#overall_howHien").html('Ẩn -');
    }
    else{
      $('#overall_how').hide();
      document.getElementById('overall_howStatus').value=1;
      $("#overall_howHien").html('Hiện +');
    }
  });
//----------------------------------------------------------

$('#khachHien').on("click",function(){
    if($("#khachStatus").val()==1){
      $('#khach').show();
      document.getElementById('khachStatus').value=2;
      $("#khachHien").html('Ẩn -');
    }
    else{
      $('#khach').hide();
      document.getElementById('khachStatus').value=1;
      $("#khachHien").html('Hiện +');
    }
  });
//----------------------------------------------------------

});
