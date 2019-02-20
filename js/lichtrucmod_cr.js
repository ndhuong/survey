$(document).ready(function() {
		$("#month").on("change",function(){
      var id=$("#month").val();
      $.get("index.php",{ylan:"lichtrucmod_cr2",month:"'"+id+"'"},function(data){
	        $("#ketQua").html(data);
	      });
  });
});