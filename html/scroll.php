<?php
include 'connection.php';
include 'timeAgo.php';

# This needs to update in real-time, can be done with AJAX
# http://stackoverflow.com/questions/32241639/run-php-script-every-10-seconds


if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
$actionfunction = $_REQUEST['actionfunction'];

  call_user_func($actionfunction,$_REQUEST,$conn,$limit);
}
function showData($data,$conn,$limit){
 $page = $data['page'];
  if($page==1){
  $start = 0;
 }
 else{
 $start = ($page-1)*$limit;
 }

# Prints from the public_table
$sql = "SELECT * FROM public_table ORDER BY ourDatetime DESC, ID DESC LIMIT $start, $limit";
$str='';
$data = $conn->query($sql);
if($data!=null && $data->num_rows>0){

 while( $row = $data->fetch_array(MYSQLI_ASSOC)){
  $str.="<li>";
  $str.="<div class=\"source\"><meta itemprop=\"url\" content=" . $row['url'] . ">" . $row['source']. '</a>' . '&nbsp;&nbsp;&nbsp;&nbsp;' . ago($row['ourDateTime']). "</div>";
  $str.="<div class=\"headline\" itemprop=\"headline\"><a href=\" " . $row['url'] . "\" itemprop=\"publisher\" target=\"_blank\">" . $row['headline'] . "</a></div>";
  $str.="</li>";
}
  $str.="<input type='hidden' class='nextpage' value='".($page+1)."'><input type='hidden' class='isload' value='true'>";
}else{
 $str.= "<script>
           $(window).scroll(function() {
             if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                 alert(\"Bottom has been reached!\");
             }
          });
        </script>";
 $str.="<input type='hidden' class='isload' value='false'><p>0 News</p>";
}
 // echo "<li>
 //        <div>
 //          <p class=\"source green-text\">Sponsor</p>
 //        </div>
 //      </li>";
echo $str;
}
// <meta itemprop="headline" content="Obama approval hits new high - CNNPolitics.com">
// <meta itemprop="url" content="http://www.cnn.com/2016/10/06/politics/obama-approval-rating-new-high/index.html">
?>
