<?php
$filename = $_POST['filename'];

// $filename = "auto";
$last_line = system('./darknet detector test cfg/voc.data cfg/tiny-yolo-voc.cfg tiny-yolo-voc.weights data/'.$filename.'.jpg -out '.$filename, $retval);
// $last_line = system('./darknet detector test cfg/voc.data cfg/tiny-yolo-voc.cfg tiny-yolo-voc.weights data/auto.jpg -out auto', $retval);
 // $last_line = system('./darknet detect cfg/yolo.cfg yolo.weights data/image1.jpg -out image1', $retval);
// system('rm data/'.$filename.'.jpg', $retval);

// echo $last_line;
if(strpos($last_line, "car") !== false)
  push("차량에 주의하세요.", $filename);

else if(strpos($last_line, "motorbike") !== false)
push("오토바이에 주의하세요.", $filename);

else if(strpos($last_line, "bicycle") !== false)
push("자전거에 주의하세요.", $filename);

else if(strpos($last_line, "traffic light") !== false)
push("행단보도에 주의하세요.", $filename);

  function push($message, $filename)
  {
    $params = array ('message' => $message,'imgurl' => $filename);
    $query = http_build_query ($params);
    // Create Http context details
    $contextData = array (
                    'method' => 'POST',
                    'header' => "Connection: close\r\n".
                                "Content-Length: ".strlen($query)."\r\n",
                    'content'=> $query );
                    echo "push";
    // Create context resource for our request
    $context = stream_context_create (array ( 'http' => $contextData ));

    // Read page rendered as result of your POST request
    $result =  file_get_contents (
                      'http://ec2-13-124-108-18.ap-northeast-2.compute.amazonaws.com/leastb/push_notification.php',  // page url
                      false,
                      $context);
                      echo $result;
  }
  // function updateIsAccident($isAccident)
  // {
  //   $con = mysqli_connect("ec2-13-124-108-18.ap-northeast-2.compute.amazonaws.com", "root", "leastb", "fcm");
  // 	// mysqli_set_charset($con,"utf8");
  // 	// if (mysqli_connect_errno($con))
  // 	// {
  // 	// 	 echo "Failed to connect to MySQL: " . mysqli_connect_error();
  // 	// }
  // 	// $query = "UPDATE image SET isaccident = 1 WHERE imgname = '$_POST['filename']';";
  // 	// $res = mysqli_query($con,$query);
  //   // $query = "select watchdayID from image where imgname = '$_POST['filename']';";
  // 	// $res = mysqli_query($con,$query);
  //   // $row = mysqli_fetch_array($res);
  // 	// $WDindex = $row['watchdayID'];
  //   // echo $WDindex;
  //   // $query = "UPDATE watchday SET accident = 1 WHERE WDindex = $WDindex;";
  // 	// $res = mysqli_query($con,$query);
  // 	// mysqli_close($con);
  // 	mysqli_set_charset($con,"utf8");
  // 	if (mysqli_connect_errno($con))
  // 	{
  // 		 echo "Failed to connect to MySQL: " . mysqli_connect_error();
  // 	}
  // 	$query = "select WDindex from watchday where id ='$id' and year = $year and month = $month and day = $day;";
  // 	$res = mysqli_query($con,$query);
  // 	$row = mysqli_fetch_array($res);
  // 	$WDindex = $row['WDindex'];
  // 	$query = "insert into image (watchdayID, imgname, latitude, longitude, isaccident) values ($WDindex, '$imgName', '$latitude', '$longitude', $isAccident);";
  // 	$res = mysqli_query($con,$query);
  // 	mysqli_close($con);
  // }
?>
