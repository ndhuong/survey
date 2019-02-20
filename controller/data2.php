<?php
if(isset($_GET['table'])){
	//require './config/config.php';	
	$table=substr($_GET['table'],1,strlen($_GET['table'])-2);
	$sql='SHOW COLUMNS FROM '.$table;
	$query=mysqli_query($source,$sql);
	if($query){
		$tmp= '<table border=1><tr><th>Field</th><th>Type</th><th>Null</th><th>KEY</th><th>Extra</th></tr>';
		while ($row=mysqli_fetch_array( $query )) {
			//var_dump($row);
			//echo $row[0]."<br>";
			$tmp=$tmp.'<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td></tr>';
			
		}
		$tmp=$tmp.'</table>';
	}
	else{
		$tmp= "Có lỗi. ". mysqli_error($source).$sql;

	}
	echo $tmp;
}



?>