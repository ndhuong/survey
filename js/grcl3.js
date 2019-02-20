$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#thang").on("change",function(){
      var thang=$("#thang").val();
      var nam=$("#nam").val();
      $.get("index.php",{ylan:"grcl4",month:thang,year:nam},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
