$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#sophieu").on("change",function(){
      var id=$("#sophieu").val();
      $.get("index.php",{ylan:"phieu5",id:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
