<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$thumb1_width=320;
$thumb1_height=140;
$thumb2_width=155;
$thumb2_height=145;
// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<script src="<?php echo G5_PLUGIN_URL;?>/jquery-image-rollover/custom.js"></script>
<link href="<?php echo G5_PLUGIN_URL;?>/jquery-image-rollover/styles.css" rel="stylesheet" />

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="aside">
<?php for ($i=0; $i<count($list); $i++) {
	if($i==0){
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb1_width, $thumb1_height);
		if($thumb['src']) {
			$img = '<img src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" class="image" width="'.$thumb1_width.'" height="'.$thumb1_height.'">';
		} else {
			$img = "NO IMAGE";
		}?>
        <div class="img_main">
        	<a href="<?php echo $list[$i]['href'];?>"><span class="roll aside1" ></span><?php echo $img;?></a>
            <span class="tit_board"><?php echo $board['bo_subject'];?></span>
		</div>
	<?php }else{
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb2_width, $thumb2_height);
		if($thumb['src']) {
			$img = '<img src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" width="'.$thumb2_width.'" height="'.$thumb2_height.'">';
		} else {
			$img = "NO IMAGE";
		}?>
        <div class="img_sub <?php if($i%2==0){echo "lst";}?>">
        	<a href="<?php echo $list[$i]['href'];?>"><span class="roll aside2"></span><?php echo $img;?></a>
		</div>
	<?php }?>
<?php }?>
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->