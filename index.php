<?php
require './sdk/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '214325311934533',
  'secret' => '919c052b1d845e6507bf2459c2631ac6',
));
	  $fan_page = $facebook->api('/NTUCEP/?fields=feed.fields(likes.limit(1000).fields(id))');


function ary_sort(& $array) {
    for($i=1;$i<count($array);$i++){
        for($j=0;$j<=count($array) - 2;$j++){
				$a=$array[$j];
				$b=$array[$j+1];
				$aid=$a->count;
				$bid=$b->count;
				if ($aid < $bid) {
					$temp=	$array[$j];
					$array[$j]=$array[$j+1];
					$array[$j+1]=$temp;
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
      <pre>
        <?php	
		$count_array=array();
		$fan_data=$fan_page['feed']['data'];
		//print_r($fan_data);
		foreach($fan_data as $fan_data_item){
			if( array_key_exists ( 'likes' ,  $fan_data_item ) ){
				$fan_like_ary_data=$fan_data_item['likes']['data'];
				foreach($fan_like_ary_data as $fan_like_item){
					if( array_key_exists ( $fan_like_item['id'] ,  $count_array ) ){
						$count_array[$fan_like_item['id']]+=1;
					}
					else{
						$count_array[$fan_like_item['id']]=1;
					}
				}
			}
		}
		$count_array_2=array();
		$i=0;
		foreach ($count_array as $a_id=>$a_count){
			$id_result=json_decode(file_get_contents("http://graph.facebook.com/".$a_id));
		//	print_r($id_result);
			$id_name=$id_result->name;
			$count_array_2[$i]->id=$id_name;
			$count_array_2[$i]->count=$a_count;
			$i++;
		//	echo 'id:'.$a_id.' count:'.$a_count.'</br>';
		}
		ary_sort($count_array_2);
		print_r($count_array_2);
		?>
      </pre>
    </body>
</html>
