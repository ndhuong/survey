$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#user").on("change",function(){
      var user=$("#user").val();
      $.get("index.php",{ylan:"user2",id:"'"+user+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
