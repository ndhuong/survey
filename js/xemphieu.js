$(document).ready(function() {
  
	
//------------------------------------------------------------------------
	$("#month").on("change",function(){
      var id=$("#month").val();
       
      $.get("index.php",{ylan:"xemphieu2",id:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
