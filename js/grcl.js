$(document).ready(function() {

$(".submit").click(function() {
    $(".submit").addClass("loading");
});
	
//------------------------------------------------------------------------
	$("#ca_truc").on("change",function(){
      var id=$("#ca_truc").val();
      $.get("index.php",{ylan:"grcl2",ca:id},function(data){
	        $("#ketQua").html(data);
	      });
      
  });
//------------------------------------------------------------------------
});
