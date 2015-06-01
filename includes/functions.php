<?php

 /********************************
 
 All fuctions written by Darren Williams
 unless otherwise stated
 
 ********************************/
 
 /*
 * @Curl function to bypass proxy
 * taken from
 * http://stackoverflow.com/questions/9098475/simplexml-load-file-issues-caused-by-proxy
 */
 	 function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
        curl_setopt($ch, CURLOPT_PROXY, 'proxysg.uwe.ac.uk:8080'); 
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
 
 /*
 * @This function scrapes
 * distillery information
 * from wikipedia
 */
 
 function wikiScrape($distillery){
 
 	//Create distillery name for URL
	$distilleryName = str_replace(array('%20', ' ', '+'),'_',$distillery);
	$distilleryName = $distilleryName."_distillery";
	
	//Code used from scraperwiki and modified to suit
	
	//DOM paser downloaded from http://sourceforge.net/projects/simplehtmldom/files/
	//Redbean downloaded from http://www.redbeanphp.com/
	
    //we use these two helper "libraries" to find the html and to save the data
    //into the table
    require 'simple_html_dom.php';  
   // require 'rb.php';
    
    //set up the db
   // R::setup('sqlite:distillery.sqlite');
    //This is the page we are scraping, get it 
    $url = "http://en.wikipedia.org/wiki/".$distilleryName;
    //CURL URL for proxy
	$curl = curl($url);
	/* This webpage helped with the proxy issue using simple html dom http://stackoverflow.com/questions/16622293/combining-curl-and-simple-html-dom 
	Next two lines were added in as the original code was returning an error message
	*/
    $html = new simple_html_dom();
    $html->load($curl);

    //$html_content = $url;
    //$html = file_get_html($html_content);
    //find the rows in the countries HTML table which has the class of "sortable"
	//Get founded
	$tablerows =  $html->find("table.vcard tr"); 
	//Get image
	foreach($html->find('table.vcard img') as $image) {
       echo '<img src="'. $image->src .'" /><br>';
	   }
	   
	//Get para
	$para =	$html->find('p');
	$para = preg_replace('/\[.*\]/', '', $para[0]->plaintext);
	echo '<br>'.$para.'<br>';  
	
	foreach($tablerows as $tablerow){
	$datacellshead = $tablerow->find("th");
	$datacellsdata = $tablerow->find("td");
		
		//Get founded
		if($datacellshead[0]->plaintext == 'Founded'){
			$data = preg_replace('/\[.*\]/', '', $datacellsdata[0]->plaintext);
			echo '<br>'. $datacellshead[0]->plaintext .': '.$data.'<br>';
		}
		//Get capacity
		if($datacellshead[0]->plaintext == 'Capacity'){
			$data = preg_replace('/\[.*\]/', '', $datacellsdata[0]->plaintext);
			echo $datacellshead[0]->plaintext .': '.$data.'<br>';
		}
		//Get website
		if($datacellshead[0]->plaintext == 'Website'){
			echo $datacellshead[0]->plaintext .': '.'<a href="'.$datacellsdata[0]->plaintext .'" target="_blank">'.$datacellsdata[0]->plaintext .'</a><br>';
		}
	}
	echo '<br><a href="'.$url.'" target="_blank">Wikipedia</a><br><br><strong>Contact Us</strong>';	
    //now we loop through the rows
	/*foreach($tablerows as $tablerow){
     $datacellshead = $tablerow->find("th"); 
     $datacells = $tablerow->find("td");
	 $dataimage = $tablerow->find("img");
	 
	 
     //do we have some data?
     if($datacells!=null){
         //create a new data row
         $wiki = R::dispense('wiki');
         
         // get the name and code of the wiki
         $wiki->row = $datacellshead[0]->plaintext;
         $wiki->para = $para[0]->plaintext;
         $wiki->agent = $datacells[0]->plaintext;
         $wiki->image = $dataimage[0]->src;
         // save the data back
         $id = R::store($wiki);
     }
		//Get founded
		 if($wiki->row == 'Founded'){
			$founded = $wiki->agent."<br>";
		}
		//Get website URL
		if($wiki->row == 'Website'){
			$website = $wiki->agent;
		}
		
	    //Get image
		foreach($dataimage as $image) {
		$image = '<img src="'.$wiki->image.'" /><br>';
		}
	   }
	   //Strip all references out of the wiki text
	   $para = preg_replace('/\[.*\]/', '', $wiki->para);
	   echo $image;
	   echo '<br>'.$para.'<br><br>';
	   if(!empty($website)){
			echo 'Website: <a href="'.$website.'" title="'.$distillery.' Website" tagert="_blank">'.$website.'</a><br>';
	   }
	   $founded = preg_replace('/\[.*\]/', '', $founded);
	   echo 'Founded: '.$founded;*/
	   
 }
 
 /*
 * @This function scrapes
 * whiskey information
 * from http://www.awardrobeofwhisky.com/
 *
 * The function also calculates the average
 * bottle price based on online sales prices
 * pulled from A wardrobe of Whiskey
 */
 
 function whiskeyScrape($conn,$whiskey){
	
	//Similar function as above but opted to remove readbeans 
	//and echo the content out direct
	
    require 'simple_html_dom.php';  
    
    //Generate URL and get html
	$url = getWhiskeyUrl($conn,$whiskey);
	//CURL URL for proxy
	$curl = curl($url);
	/* This webpage helped with the proxy issue using simple html dom http://stackoverflow.com/questions/16622293/combining-curl-and-simple-html-dom 
	Next two lines were added in as the original code was returning an error message
	*/
    $html = new simple_html_dom();
    $html->load($curl);
    //$html_content = $url;
    //$html = file_get_html($html_content);
	$whiskeyInfo = '';
	//Get Image
	foreach( $html->find("figure.bottle a img[itemprop=image]") as $image ){
	$whiskeyInfo .= '<img src="http://www.awardrobeofwhisky.com/'.$image->src.'" /><br><br>';
	}
	
	$whiskeyInfo .= '<strong>Details</strong><br>';
	
    //Get Details
	foreach($html->find('section.details ul li') as $li ){
    $whiskeyInfo .= $li->plaintext.'<br>';
	}
	
	//Get Copy
	$copy = '';
	foreach($html->find("p[itemprop=description]") as $para ){
    $copy = $para->plaintext;
	}
	
	//Check if copy returns
	if(!empty($copy)){
		$whiskeyInfo .= '<br>'.$copy.'<br>';
	}else{
		$whiskeyInfo .= '<br><strong>**Whiskey write-up coming soon**</strong><br>';
	}
	
	//Declare our array
	$prices = array();
	
	//Get Prices
	foreach($html->find('div.sidebar-buy ul li strong') as $li ){
	
		if($li->plaintext != 'Sold Out'){
		$price = str_replace('&pound;', '', $li->plaintext);
		$prices[] = $price.'<br>';
		}
	
	}
	//Makes sure array is not empty
	if(!empty($prices)){
		//Do math on array to find average price and round up
		$whiskeyInfo .= '<br>Average bottle price: &pound;'. round(array_sum($prices) / count($prices),2);
	}
	
	//Echo everything out
	echo $whiskeyInfo;
	   
 }
 
 
 /* @This function
* searches awardrobeofwhiskey.com
* for whiskey information
* and returns it to the user
*
* written by Darren Williams
* for individual assignment
*
*/
 
 function whiskeySearch($search){
	
    require 'simple_html_dom.php';  
    //Generate URL and get html
	$url = 'http://www.awardrobeofwhisky.com/search/?q='.urlencode($search);
	//CURL URL for proxy
	//$curl = curl($url);
	//$html_content = $url;
    $html = file_get_html($url);
	/* This webpage helped with the proxy issue using simple html dom http://stackoverflow.com/questions/16622293/combining-curl-and-simple-html-dom 
	Next two lines were added in as the original code was returning an error message
	*/
    //$html = new simple_html_dom();
   // $html->load($url);
	
	$searchResults = '';
	$i = 0;
	//Get Image, price and link
	foreach( $html->find("section[id=bottles-results] ul li img") as $image ){
		$price = $html->find("ul[class=bottles-listing] li span[class=price]");
		$link = $html->find("ul[class=bottles-listing] li a");
		//The returned link added an extra /bottle/ so I stripped it out
		$searchResults .= '<div class="searchResults"><img src="http://www.awardrobeofwhisky.com/bottle/'.str_replace('/bottle/','',$image->src).'" /><br><a href="http://www.awardrobeofwhisky.com'.$link[$i]->href.'" target="_blank">'.$link[$i]->plaintext.'</a><br><strong>';
		
		//Check if price is empty
		if(!empty($price[$i]->plaintext)){
			$searchResults .= $price[$i]->plaintext;
		}else{
			$searchResults .= 'Coming Soon';
		}
		$searchResults .= '</strong></div>';
		$i++;
	}
	
	//Echo everything out
	if(!empty($searchResults)){
		echo $searchResults;
	}else{
		echo 'No results, please try a different whiskey / brand name';
	}
	   
 }
 
 /*
 * @This function uses Google Chart API
 * to create a graph of 5 days worth of 
 * pressure data
 */

function dailyPressureChart($high,$low){

	$js = '<script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			var data = google.visualization.arrayToDataTable([
			  ["Day", "High", "Low"],
			  ["Monday",'.$high[0].','.$low[0].'],
			  ["Tuesday",'.$high[1].','.$low[1].'],
			  ["Wednesday",'.$high[2].','.$low[2].'],
			  ["Thursday",'.$high[3].','.$low[3].'],
			  ["Friday",'.$high[4].','.$low[4].']
			]);

			var options = {
			  title: "Forcast"
			 // hAxis: {title: "Day", titleTextStyle: {color: "red"}},
			 // vAxis: {title: "Day", titleTextStyle: {color: "red"}}
			};

			var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
			chart.draw(data, options);
		  }
		</script>';
		echo $js;

}

/*
* @Function used to 
* create map with pointer and address on hover
*
*/

function getDistilleryMap($conn,$url,$distillery){
	$address = getAddress($conn,$distillery);
	$js ='<script type="text/javascript">
	function initialize() {
	var myLatlng = new google.maps.LatLng('.getLatLong($url).');
	var mapOptions = {
    zoom: 7,
	scrollwheel: false,
    center: myLatlng
	  }
	  var map = new google.maps.Map(document.getElementById("regionMap"), mapOptions);

	  var marker = new google.maps.Marker({
		  position: myLatlng,
		  map: map,
		  clickable: true
	  });
	  
		marker.info = new google.maps.InfoWindow({
			content: "'.$address.'"
		});

	google.maps.event.addListener(marker, "click", function() {
	  marker.info.open(map, marker);
	});
	}

	google.maps.event.addDomListener(window, "load", initialize);</script>';
	
	echo $js;
}


/*
* @This function is used
* to pull all weather data in
*
*/

function getData($url){

	//Declare empty content variable
	$contents = "";
	//Declare array
	$low = array();
	$high = array();
	$weather = array();
	$day = array(); 
	//Set e to 0
	$e = 0;
	//CURL URL
	$curl = curl($url);
	//Pull in XML data
	$xml = simplexml_load_string($curl);
	//Go get our title
	$contents .= $xml->channel->item->title."<br><br>";
	//Get our weather data
	//Uncomment to pull in all data --
	//$contents .= $xml->channel->item->description."<br>";
	$contents .= '<strong>Current Weather</strong><br>';
	//Get current weather
	$con = $xml->channel->item->xpath("yweather:condition[1]");
	$current = $con[0]->attributes();
	
	//Change current text to image
	if(strpos($current,'Cloudy') !== false || strpos($current,'Wind') !== false) {
		$contents .= '<img src="img/cloudy.png"><br>';
	}else if(strpos($current,'Rain') !== false || strpos($current,'Showers') !== false) {
		$contents .= '<img src="img/rain.png"><br>';
	}else if(strpos($current,'Sunny') !== false) {
		$contents .= '<img src="img/sun.png"><br>';
	}else{
		$contents .= $current->text.'<br><br>';
	}
	//$contents .= $current->text.'<br><br>';
	//Loop through, get pressure and daily weather
	for($i=1;$i<6;$i++){
		$bar = $xml->channel->item->xpath("yweather:forecast[$i]");
		$foo = $bar[0]->attributes();
		$low[] = $foo->low;
		$high[] = $foo->high;
		//Loop through and change weather text to images
		if($foo->text != ''){
		$weather[] = $foo->text;
			//$weather[] = 'rain.jpg';
		}else{
			$weather[] = $foo->text;
		}
		//Get Day
		$day[] = $foo->day;
		//$contents .= $day[$e].': <img src="img/'.$weather[$e].'"><br>';
		$contents .= $day[$e].': '.$weather[$e].'<br>';
		$e++;
	}	
	
	//Construct Pressure Chart
	dailyPressureChart($high,$low);
	
	//Echo everything out
	echo $contents;

}

function getLatLong($url){

	//Declare empty content variable
	$contents = "";
	//CURL URL
	$curl = curl($url);
	//Pull in XML data
	$xml = simplexml_load_string($curl);
	//Go get the Latitude
	$geoLat =  $xml->channel->item->xpath("geo:lat");
	$contents .= $geoLat[0].",";
	//Go get the Longitude
	$geoLong =  $xml->channel->item->xpath("geo:long");
	$contents .=  $geoLong[0];
	//Return Lat and Long
	return $contents;
	echo $curl;

}

/*****************************

	Database Functions

*****************************/

/*
* @This function is used to 
* create menu links based upon
* each region
*/ 

function getMenuLinks($conn){
	$sql = 'SELECT * FROM region ORDER BY regionName DESC';
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){

				  $region = '';
				  $region .= '<li><a href="index.php?region='.urlencode($row['regionName']).'" title="'.$row['regionName'].'">'.$row['regionName'].'</a></li>';
				  echo $region;
		}
}

/*
* @This function creates page
* breadcrumbs
*/

function breadcrumbs($region,$distillery,$whiskey){
	//Home link
	$breadcrumbs = '<div id="breadcrumbs"><a href="index.php">Home</a>&nbsp;&raquo;&nbsp;';
	//Region text else region Link
	if(!empty($region) && empty($distillery)){
		$breadcrumbs .= $region. ' Region';
	}else{
		$breadcrumbs  .= '<a href="index.php?region='.$region.'">'.$region.' Region</a>';
	}
	//Distillery text
	if(!empty($region) && !empty($distillery) && empty($whiskey)){
		$breadcrumbs .= '&nbsp;&raquo;&nbsp;'.$distillery.' Distillery';
	}
	//Distillery link and whiskey text
	if(!empty($region) && !empty($distillery) && !empty($whiskey)){	
		$breadcrumbs .= '&nbsp;&raquo;
		<a href="index.php?region='.$region.'&amp;distillery='.$distillery.'">'.$distillery.' Distillery</a>';
		$breadcrumbs .= '&nbsp;&raquo;&nbsp;'.$whiskey;
	}
	$breadcrumbs .= '</div>';
	//echo everything out
	echo $breadcrumbs;
}

/*
* @This function is used
* to create the Yahoo weather URL
*
*/

function getWeatherURL($conn,$distillery){
	$sql = "SELECT * FROM distillery WHERE name = '$distillery' LIMIT 1";
	$result = mysqli_query($conn,$sql);
		//If no results show error
		if (!mysqli_query($conn, $sql)) {
			printf(mysqli_error($conn));
		}
		$row = mysqli_fetch_assoc($result);
		$weatherID = $row['weatherID'];
		$link = 'http://weather.yahooapis.com/forecastrss?w='.$weatherID;
		return $link;
}

/*
* @This function pulls
* the distillery address from the database
*/

function getAddress($conn,$distillery){
	$sql = "SELECT * FROM distillery WHERE name = '$distillery' LIMIT 1";
	$result = mysqli_query($conn,$sql);
		//If no results show error
		if (!mysqli_query($conn, $sql)) {
			printf(mysqli_error($conn));
		}
		$row = mysqli_fetch_array($result);
		$address = $row['address1'].',<br>'.$row['address2'].',<br>'
		.$row['address3'].',<br>'.$row['address4'].',<br>'.$row['postcode'];
		return $address;
}

/*
* @This function is used
* to list distilleries
* by the chosen region
*/

function getDistilleries($conn,$region){
	$sql = "SELECT * FROM distillery WHERE fk1_regionName = '$region'";
	$result = mysqli_query($conn,$sql);
		//If no results show error
		if (!mysqli_query($conn, $sql)) {
			printf(mysqli_error($conn));
		}	
		$link = '<ul>';
		while ($row = mysqli_fetch_array($result)){
			$link .= '<li><a href="index.php?region='.urlencode($region).'&distillery='.urlencode($row['name']).'" title="" >'.$row['name'].'</a></li>';
			
		}
		$link .= '</ul>';
		echo $link;
}

/*
* @This function is used
* to echo distillery weather data
* by the chosen region
*/

function getDistilleriesData($conn,$region,$distillery){
	$sql = "SELECT * FROM distillery WHERE fk1_regionName = '$region' AND name = '$distillery'"; 
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){
				$id = $row['weatherID'];  
				//Set Link
				$link = "http://weather.yahooapis.com/forecastrss?w=".$id;
				//Get lat and long
				$latLong = getLatLong($link);
				//Get all data
				echo getData($link);
		}
}

/*
* @This function is used
* to return the
* whiskey data url for
* http://www.awardrobeofwhisky.com/
*/

function getWhiskeyUrl($conn,$whiskey){
	$sql = "SELECT * FROM whiskey WHERE name = '$whiskey'"; 
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		while ($row = mysqli_fetch_array($result)){
				$url = $row['url'];  
				//Return URL
				return $url;
		}
}

/*
* @This function is used to 
* list whiskey links
* per distillery
*/

function getWhiskeys($conn,$region,$distillery){
	$sql = "
	SELECT *
	FROM distillery
	INNER JOIN whiskey
	ON distillery.id=whiskey.fk1_id
	WHERE distillery.name = '$distillery'
	";	
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		$whiskey = '<ul>';
		while ($row = mysqli_fetch_array($result)){
				  $whiskey .= '<li><a href="index.php?region='.$region.'&amp;distillery='.$distillery.'&amp;whiskey='.urlencode($row['name']).'" title="'.$row['name'].'">'.$row['name'].'</a></li>';  
		}
		$whiskey .= '</ul>';
		echo $whiskey;
}

/*
* @This function is used to 
* list other whiskeys from the same
* distillery
*/

function getOtherWhiskeys($conn,$region,$distillery,$whiskey){
	$sql = "
	SELECT *
	FROM distillery
	INNER JOIN whiskey
	ON distillery.id=whiskey.fk1_id
	WHERE distillery.name = '$distillery'
	AND whiskey.name != '$whiskey'
	";	
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		$whiskey = '<ul>';
		while ($row = mysqli_fetch_array($result)){
				  $whiskey .= '<li><a href="index.php?region='.$region.'&amp;distillery='.$distillery.'&amp;whiskey='.urlencode($row['name']).'" title="'.$row['name'].'">'.$row['name'].'</a></li>';		  
		}
		$whiskey .= '</ul>';
		echo $whiskey;
}

/*
* @This function gets all map marker
* for each distillery within the db
* and also creates the address for the map info
* window
*/

function getAllMarkers($conn){
	$sql = "SELECT * FROM distillery"; 
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
	//Set marker number
	$i = 0;
	$js = '';
		while ($row = mysqli_fetch_array($result)){
			$id = $row['weatherID']; 
			$distillery = $row['name'];
			$address = getAddress($conn,$distillery);
			$region = $row['fk1_regionName'];	
			$distillery = $row['name'];			
			//Set Link
			$link = "http://weather.yahooapis.com/forecastrss?w=".$id;
			//Get lat and long
			$latLong = getLatLong($link);
			//Create js for each entry in table
			$js .= 'var myLatlng = new google.maps.LatLng('.$latLong.');
					  var marker'.$i.' = new google.maps.Marker({
					  position: myLatlng,
					  map: map,
					  clickable: true
				  });
				  	marker'.$i.'.info = new google.maps.InfoWindow({
			content: "<div class=info>'.$address.'<br><a href=index.php?region='.$region.'&amp;distillery='.urlencode($distillery).'>View Page</a></div>"
		});

	google.maps.event.addListener(marker'.$i.', "click", function() {
	  marker'.$i.'.info.open(map, marker'.$i.');
	});
';				//Incriment marker number
				$i++;  
		}
		
		return $js;
}

/*
* @This function is used to 
* get the region description copy
*/ 

function getDescription($conn,$region){
	$sql = "SELECT description FROM region WHERE regionName = '$region'";
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}
		$row = mysqli_fetch_assoc($result);
		echo $row['description'];
}

?>