<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes

//Connection to db
include 'assets/functions.php';

//load xml file
$xml = simplexml_load_file('xvid.xml');

//counter
$old = 0;
$new = 0;

//assign items to variable
foreach ($xml->item as $item) {
	$guid = $item->guid;
	$title = $item->title;
	$keywords = $item->keywords;
	$url = $item->link;
	$thumbnail = $item->thumb_verybig;
	$rate = $item->rate;
	$duration = $item->clips->duration;
	$date = date("Y-m-d H:i:s");

	//check if exist
	$sql = "SELECT * FROM tbl_videos WHERE guid='".$guid."'";
	$rs_result = mysqli_query ($con, $sql);

	if (mysqli_num_rows($rs_result) > 0) {
		//$sql = "DELETE FROM tbl_videos WHERE guid='".$guid."'";
		$sql = "UPDATE tbl_videos SET keywords='".$keywords."', url='".$url."', thumbnail='".$thumbnail."', rate='".$rate."', duration='".$duration."', date='".$date."' WHERE guid='".$guid."'";
		mysqli_query($con, $sql);
		$old++;
	} else {
		$sql = "INSERT INTO tbl_videos(guid, title, keywords, url, thumbnail, rate, duration, views, date) VALUES('".$guid."', '".$title."', '".$keywords."', '".$url."', '".$thumbnail."', '".$rate."', '".$duration."', 0, '".$date."')";
		mysqli_query($con, $sql);
		$new++;
	}		
}

echo "Finished!!<br>";
echo $old." updated<br>";
echo $new." added";

?>