$(document).ready(function() {
  	
//------------------------------------------------------------------------
	$("#table").on("change",function(){
      var data=$("#table").val();
        
	      $.get("index.php",{ylan:"data2",table:"'"+data+"'"},function(data){
	        $("#ketqua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
