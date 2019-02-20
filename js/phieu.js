$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#sophieu").on("change",function(){
      var id=$("#sophieu").val();
      $.get("index.php",{ylan:"phieu",id:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
