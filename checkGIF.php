<?php
$imgName = $_POST['post1'];
// $imgName = 'leastb201768-1496865343166';
$con = mysqli_connect("ec2-13-124-108-18.ap-northeast-2.compute.amazonaws.com", "root", "leastb", "fcm");
mysqli_set_charset($con,"utf8");
if (mysqli_connect_errno($con))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$query = "select * from gif where gifName = '$imgName';";
$res = mysqli_query($con,$query);
$total_record = mysqli_num_rows($res);
if($total_record == 1 )
{
  echo "already";
  mysqli_close($con);
}
else
{
$query = "select imgname from image where watchdayID = (select watchdayID from image where imgname ='$imgName');";
$res = mysqli_query($con, $query);
$result = array();
while($row = mysqli_fetch_array($res))
{
array_push($result, array('imgName'=>$row[0]));
}
$gifIndex;
for($i=0;$i<count($result);$i++)
{
if($result[$i]['imgName']== $imgName)
{
$gifIndex = $i;
break;
}
}
$startIndex=0;
$endIndex=count($result)-1;
if($gifIndex-5>=0)
$startIndex = $gifIndex-5;
if($gifIndex+5<count($result))
$endIndex = $gifIndex+5;
// echo "gifIndex:".$gifIndex." start :".$startIndex." end :".$endIndex."<br>";
$gifs="";
for($i=$startIndex;$i<=$endIndex;$i++)
$gifs.= $result[$i]['imgName'].".jpg ";
shell_exec("convert -delay 100 -loop 0 ".$gifs.$imgName.".gif");
$query = "insert into gif(gifName) values('$imgName');";
$res = mysqli_query($con, $query);
mysqli_close($con);
echo "complete";
}
// shell_exec("convert -delay 100 -loop 0 ".$gifs."test.gif" . " > /dev/null 2>/dev/null &")
 ?>
