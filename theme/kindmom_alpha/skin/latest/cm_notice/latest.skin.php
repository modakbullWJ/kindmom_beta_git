<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>

<!--
<div class="notice">
    <h2>공지사항</h2>
    <ul>
        <li><a href="#">당사 제조 공정 기사와 관련하여 착한엄마 고객... <span class="date">2016.06.06</span></a></li>
        <li><a href="#">당사 제조 공정 기사와 관련하여 착한엄마 고객... <span class="date">2016.06.06</span></a></li>
        <li><a href="#">당사 제조 공정 기사와 관련하여 착한엄마 고객... <span class="date">2016.06.06</span></a></li>
        <li><a href="#">당사 제조 공정 기사와 관련하여 착한엄마 고객... <span class="date">2016.06.06</span></a></li>
    </ul>
</div> -->


<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<!-- <div class="notice"> -->
  <h2><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>">공지사항</h2></a>
    <!-- <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></strong> -->
    <ul>
    <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li>
            <?php
            //echo $list[$i]['icon_reply']." ";
            echo "<a href=\"".$list[$i]['href']."\">";
            if ($list[$i]['is_notice'])
                echo $list[$i]['subject'], "<span class = \"date\">".date('Y/m/d', strtotime($list[$i]['wr_datetime']))."</span>";
            else
                echo $list[$i]['subject'];

            if ($list[$i]['comment_cnt'])
                echo $list[$i]['comment_cnt'];

            echo "</a>";

            // if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
            // if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

            if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
            if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
            if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
            if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
            if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
             ?>
        </li>
      <!-- <span id="notice_date"><?php	echo date('y/m/d', strtotime($list[$i]['wr_datetime'])); ?> </span> -->
    <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <li>게시물이 없습니다.</li>
    <?php }  ?>
    </ul>
    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
<!-- </div> -->
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
