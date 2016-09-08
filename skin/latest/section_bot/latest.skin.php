<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$thumb_width=115;
$thumb_height=115;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<script src="<?php echo G5_PLUGIN_URL;?>/jquery.bxslider/jquery.bxslider.min.js"></script>
<link href="<?php echo G5_PLUGIN_URL;?>/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<ul class="slider_bot">
<?php for ($i=0; $i<count($list); $i++) {  ?>
    <li>
        <?php
            $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height);
            if($thumb['src']) {
                $img = '<img src="'.$thumb['src'].'" title="'.$list[$i]['subject'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
            } else {
                $img = "NO IMAGE";
            }
        ?>
        <a href="<?php echo $list[$i]['href'];?>"><?php echo $img;?></a>
    </li>
<?php }  ?>
<?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li>게시물이 없습니다.</li>
<?php }  ?>
</ul>
<!--<div class="btn_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>-->
<script type="text/javascript">
$(document).ready(function(){
	$('.slider_bot').bxSlider({
		slideWidth: 115,
		minSlides: 2,
		maxSlides: 8,
		slideMargin: 10,
		pager:false
	});	
});	
</script>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->