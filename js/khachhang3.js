$(document).ready(function() {
  
$("#maso").on("change",function(){
	var id=$("#maso").val();
	$.ajax({
	   type:"get",
	   url:"index.php",
	   data:"ylan=khachhang4&maso='"+id+"'",
	   async:false,
	   success:function(data){
	    $("#ketQua").html(data);
	   }
	  })
	$("#hovaten").on("change",function(){
      var id=$("#hovaten").val();
	      $.get("index.php",{ylan:"khachhang4",hoten:"'"+id+"'"},function(data){
	       $("#ketQua").html(data);
      });
  	});

});
//------------------------------------------------------------------------
/* phần này đã chạy đc mã số, chưa chạy đc họ và tên
	$("#maso").on("change",function(){
      var id=$("#maso").val();
      $.get("index.php",{ylan:"khachhang4",maso:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
	$("#hovaten").on("change",function(){
      var id=$("#hovaten").val();
      $.get("index.php",{ylan:"khachhang4",hoten:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------

*/
});
