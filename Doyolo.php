<?php
$filename = $_POST['filename'];
$last_line = system('./darknet detector test cfg/voc.data cfg/tiny-yolo-voc.cfg tiny-yolo-voc.weights data/'.$filename.'.jpg -out '.$filename, $retval);
 // $last_line = system('./darknet detect cfg/yolo.cfg yolo.weights data/image1.jpg -out image1', $retval);
// system('rm data/'.$filename.'.jpg', $retval);

// Build Http query using params
echo $last_line;
if(strpos($last_line, "car") !== false)
{
  //  system('mv '.$filename.'.jpg results/' .$filename.'.jpg', $retval);
echo "warn";
$params = array ('message' =>'위험물이 감지되었습니다.','imgurl' => 'http://ec2-13-124-33-214.ap-northeast-2.compute.amazonaws.com/darknet/'.$filename.'.jpg');
$query = http_build_query ($params);

// Create Http context details
$contextData = array (
                'method' => 'POST',
                'header' => "Connection: close\r\n".
                            "Content-Length: ".strlen($query)."\r\n",
                'content'=> $query );

// Create context resource for our request
$context = stream_context_create (array ( 'http' => $contextData ));

// Read page rendered as result of your POST request
$result =  file_get_contents (
                  'http://ec2-13-124-108-18.ap-northeast-2.compute.amazonaws.com/leastb/push_notification.php',  // page url
                  false,
                  $context);
}
else {
  echo "no";

  // $params = array ('message' =>'위험물아님 테스트.','imgurl' => 'http://ec2-13-124-33-214.ap-northeast-2.compute.amazonaws.com/darknet/'.$filename.'.jpg');
  // $query = http_build_query ($params);
  //
  // // Create Http context details
  // $contextData = array (
  //                 'method' => 'POST',
  //                 'header' => "Connection: close\r\n".
  //                             "Content-Length: ".strlen($query)."\r\n",
  //                 'content'=> $query );
  //
  // // Create context resource for our request
  // $context = stream_context_create (array ( 'http' => $contextData ));
  //
  // // Read page rendered as result of your POST request
  // $result =  file_get_contents (
  //                   'http://ec2-13-124-108-18.ap-northeast-2.compute.amazonaws.com/leastb/push_notification.php',  // page url
  //                   false,
  //                   $context);
}
?>
