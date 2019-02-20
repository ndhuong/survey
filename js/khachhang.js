$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#maso").on("change",function(){
      var id=$("#maso").val();
      $.get("index.php",{ylan:"khachhang2",maso:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
