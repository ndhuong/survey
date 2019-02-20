$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#stt").on("change",function(){
      var id=$("#stt").val();
      $.get("index.php",{ylan:"noidungmau2",stt:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
