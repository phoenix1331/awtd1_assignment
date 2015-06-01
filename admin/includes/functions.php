<?php

 /********************************
 
 All fuctions written by Darren Williams
 
 ********************************/
 
 
 function insertDistillery($conn,$username,$password){
	$sql = "INSERT INTO distillery (name, weatherID, fk1_regionName) VALUES ('".$username."','".$password."','Islay')"; 
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		
}

/* 
* @This function counts
* how many whiskey
* entries for the distillery
*/

	function countWhiskey($conn,$id){
		$query = "SELECT * FROM whiskey WHERE fk1_id = '$id'";
		$result = mysqli_query($conn,$query);
		return mysqli_num_rows($result);	
	}

/*
* @This function
* gets all distillery entries
*
*/

function getDistilleries($conn){
	$sql = "SELECT * FROM distillery ORDER BY fk1_regionName ASC"; 
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){
			$whiskey = countWhiskey($conn,$row['id']);
			$tableRows = '<tr><td>'.$row['name'].'</td><td>'.$row['fk1_regionName'].'</td><td>'.$whiskey.'</td></tr>';	
			echo $tableRows;			
		}
}



/*
* @This function
* gets all whiskey entries
*
*/

function getWhiskeys($conn){
	$sql = "SELECT * FROM whiskey ORDER BY fk1_id ASC"; 
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){
			$tableRows = '<tr><td>'.$row['name'].'</td></tr>';	
			echo $tableRows;			
		}
		
}
/*
* @This function gets all
* regions to populate a 
* dropdown list
*/

function getRegionsList($conn){

$list = '<select name="region">';
$sql = "SELECT * FROM region";
$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){

		  $list .= "<option value=\"";
		  $list .= $row['regionName'];
		  $list .= "\">";
		  $list .= $row['regionName'];
		  $list .= "</option>";
		  
	}
	 $list .= '</select>';
	echo $list;
 }
 
 /*
 * @This function
 * gets the distillery
 * data and populates a list
 * for use in the
 * add whiskey page*/
 
 function getDistilleryList($conn){

$list = '<select name="distillery">';
$sql = "SELECT * FROM distillery";
$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){

		  $list .= "<option value=\"";
		  $list .= $row['id'];
		  $list .= "\">";
		  $list .= $row['name'];
		  $list .= "</option>";
		  
	}
	 $list .= '</select>';
	echo $list;
 }
 
 /*
 * @This function uses
 * the entered postcode to 
 * return the WOEID
 *
 *
 * Need to look at errors when returning
 * more than one id or id is empty
 *
 * Will work as long as postcode is correct
 */
 
 function getWOEID($postcode){
	
    require 'simple_html_dom.php';  

	$url = 'http://woeid.rosselliot.co.nz/lookup/'.str_replace('%20',' ',$postcode);
	$html = file_get_html($url);
	$id = '';
	foreach( $html->find("td[class=woeid]") as $data ){
	$id .= $data->plaintext;
	}
	
	//Echo everything out
	if(empty($id)){
		echo 'please try again';
	}else{
		return $id;
	 }
 }


 
 
 ?>