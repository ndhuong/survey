$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#ca_truc").on("change",function(){
      var id=$("#ca_truc").val();
      $.get("index.php",{ylan:"modc2",ca:id},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
