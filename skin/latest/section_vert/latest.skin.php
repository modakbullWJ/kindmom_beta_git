<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$thumb1_width=300;
$thumb1_height=160;
$thumb2_width=60;
$thumb2_height=60;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="section_vert">
	<?php
	$thumb = get_list_thumbnail($bo_table, $list[0]['wr_id'], $thumb1_width, $thumb1_height);
	if($thumb['src']) {
		$img = '<img src="'.$thumb['src'].'" alt="'.$list[0]['subject'].'" width="'.$thumb1_width.'" height="'.$thumb1_height.'">';
	} else {
		$img = "NO IMAGE";
	}?>
	<div class="main">
		<div class="img_main">
			<a href="<?php echo $list[0]['href'];?>"><span class="roll mobile1"></span><?php echo $img;?></a>
            <span class="tit_board"><?php echo $board['bo_subject'];?></span>
		</div>
        <p class="txt_main">
            <span class="time"><?php echo $list[0]['datetime']?></span>
            <span class="cmt"><span class="ico_heart">♥</span><?php echo $list[0]['wr_comment'];?></span>
        </p>
        <p class="tit_main"><a href="<?php echo $list[0]['href'];?>"><?php echo $list[0]['subject'];?></a></p>
        <p class="desc_main"><a href="<?php echo $list[0]['href'];?>"><?php echo cut_str(strip_tags($list[0]['wr_content']),90);?></a></p>
	</div>

    <div class="sub">
    	<ul>
		<?php
            for ($i=1; $i<count($list); $i++) {
				$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb2_width, $thumb2_height);
				if($thumb['src']) {
					$img = '<img src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" width="'.$thumb2_width.'" height="'.$thumb2_height.'">';
				} else {
					$img = "NO IMAGE";
				}?>
            <li>
				<div class="img_sub">
                	<a href="<?php echo $list[$i]['href'];?>"><span class="roll mobile2"></span><?php echo $img;?></a>
				</div>
                <div class="inner_sub">
                	<p class="txt_sub"><?php echo $list[$i]['datetime'];?></p>
                    <p class="tit_sub"><a href="<?php echo $list[$i]['href'];?>"><?php echo cut_str($list[$i]['wr_subject'],50);?></a></p>
                </div>
			</li>
        <?php }?>
    	</ul>
    </div>
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->