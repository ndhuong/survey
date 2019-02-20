$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#ca_truc").on("change",function(){
      var ca=$("#ca_truc").val();
      var ngay=$("#ngay").val();
      $.get("index.php",{ylan:"grcl5",ngay:ngay,ca:ca},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
