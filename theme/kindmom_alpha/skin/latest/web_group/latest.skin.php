<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$thumb_width = 138; //썸네일 가로 사이즈
$thumb_height = 82; //썸네일 세로 사이즈

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<div class="lat_web">
    <h2><?php echo $gr_subject; ?></h2>
    <ul>
    <?php
    for ($i=0; $i<count($list); $i++) {
        $thumb = get_list_thumbnail($list[$i]['bo_table'], $list[$i]['wr_id'], $thumb_width, $thumb_height);
        if($thumb['src']) {
            $img = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
			$wr_subject = cut_str(strip_tags($list[$i]['wr_content']), 110); //이미지가 있을때 글자수
        } else {
			$wr_subject = cut_str(strip_tags($list[$i]['wr_content']), 130); //이미지가 없을때 글자수
        }
    ?>
        <li>
            <?php if($thumb['src']) { ?>
            <div class="wimg">
                <a href="<?php echo $list[$i]['href']; ?>"><?php echo $img; ?></a>
            </div>
            <?php } ?>
            <div class="wcontent" style="<?php if($thumb['src']) { ?>margin-left:<?php echo $thumb_width+12; ?>px;min-height:<?php echo $thumb_height; ?>px<?php } ?>">
                <p class="s_subject"><a href="<?php echo $list[$i]['href']; ?>"><?php echo $list[$i]['subject']; ?></a> <?php if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new']; ?></p>
                <p class="s_memo"><?php echo $wr_subject; ?></p>
                <p class="s_date"><strong><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>"><?php echo $list[$i]['bo_subject']; ?></a></strong><?php echo $list[$i]['wr_name']; ?> <?php echo $list[$i]['datetime']; ?></p>
            </div>
        </li>
    <?php } ?>
    <?php if (count($list) == 0) { //게시물이 없을 때 ?>
    <li>게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
</div>
