<?php
//require './config/config.php';	
$sql='SHOW FULL TABLES FROM mthl_survey';
$query=mysqli_query($source,$sql);
if($query){
	$table='<select name="table" id="table" value=""> </option>';
	while ($row=mysqli_fetch_array( $query )) {
		$table=$table.'<option value="'.$row[0].'" >'.$row[0].'</option>';

	}

	$table=$table.'</select>';
}
else{
	$table= "Có lỗi. Show table". mysqli_error($source);

}


include './views/data.phtml';
?>