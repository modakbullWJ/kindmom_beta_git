<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/css/style.css">', 0);
add_javascript('<script src="'.$latest_skin_url.'/js/rollissue.js"></script>',100); //우선순위를 100으로 두는 이유는 Jquery다음으로 나와야함.
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$thumb_width = 558;
$thumb_height = 300;
function roll_strcut_utf8($str, $len, $checkmb=false, $tail='...') {
    preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
    $m    = $match[0];
    $slen = strlen($str);  // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m); // length of matched characters
    if ($slen <= $len) return $str;
    if (!$checkmb && $mlen <= $len) return $str;
    $ret   = array();
    $count = 0;
    for ($i=0; $i < $len; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1)?2:1;
        if ($count + $tlen > $len) break;
        $ret[] = $m[$i];
    }
    return join('', $ret).$tail;
}

?>
<div id="roll_issue">
  <div class="roll_issue_left">
    <div class="roll_tc">
   
      <?php
$bo_table_is = false;
for ($i=0; $i<6; $i++) {
	if(!$bo_table || $bo_table_is==true)
	{
		$bo_table_is = true;
		$bo_table = $list[$i]['bo_table'];
	}
	$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height);
	if($thumb['src']) {
		$thumb_content = "<img class=\"roll_resizeimg\" src=\"".$thumb['src']."\" />";
	} else {
		$thumb_content = "<img class=\"roll_resizeimg\" src=\"".$latest_skin_url."/img/noimg.jpg\" />";
		
		$RESULT = "";
		preg_match("/<iframe[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i",$list[$i]['wr_content'],$RESULT);
		if($RESULT)
		{
			$thumb_content = $RESULT[0]."</iframe>";
		}
	}
	
	$num = $i+1;
?>
      <div class="roll_issue_left_img roll_issue_img0<?php echo $num;?>">
		<a href="<?php echo $list[$i]['href'];?>">
        	<?=$thumb_content?>
        	<div class="roll_issue_left_img_bottom">
            	<span class="roll_issue_left_img_bottom_title"><?php echo roll_strcut_utf8($list[$i]['subject'],60,'...');?></span>
			<?
            if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
            if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
            if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
            if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
            if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
             ?>
        	</div>
        </a>
      </div>
      <? } ?>
    </div>
  </div>
  <div class="roll_issue_right">
    <?php 
      for ($i=0; $i<6; $i++) {
      $num = $i + 1;
      $object_top = $i*-300;
    ?>
    <div class="roll_issue_right_nav roll_issue_right_nav0<?php echo $num?>" onclick="roll_issue_change('roll_issue_right_nav0<?php echo $num?>','<?php echo $object_top?>');"> <span class="roll_issue_right_nav_title"><?php echo roll_strcut_utf8($list[$i]['subject'],30,'...');?></span><br/>
    <span style="color:white; padding-right:10px;">Hit <?=$list[$i]['wr_hit']?>&nbsp;&nbsp;Good <?=$list[$i]['wr_good']?>&nbsp;&nbsp;Bad <?=$list[$i]['wr_nogood']?></span>
    </div>
    <? } ?>
  </div>
</div>
