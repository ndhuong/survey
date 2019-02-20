$(document).ready(function() {
	$("#ngay1").on("change",function(){
    	var id=$("#ngay1").val();
    	$.get("lichtrucmod3",{ngay:id,type:1},function(data){
	        $("#ketQua1").html(data);
	      });
  	});
  	$("#ngay2").on("change",function(){
    	var id=$("#ngay2").val();
    	$.get("index.php",{ylan:"lichtrucmod3",ngay:id,type:2},function(data){
	        $("#ketQua2").html(data);
	      });
  	});
});
