$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#sophieu").on("change",function(){
      var id=$("#sophieu").val();
      $.get("index.php",{ylan:"phieu2",id:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
