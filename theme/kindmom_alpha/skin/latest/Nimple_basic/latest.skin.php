<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);


?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<!-- <div class="Nb_slt"> -->
	<div class="NB_slt_title_wrap">
		<?php echo $bo_subject; ?>
		 <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>+</a>
	</div>


	 <table cellspacing=0 cellpadding=0 width='100%'  border=0  class="Nb_slt_content">
    <?php for ($i=0; $i<count($list); $i++) {  ?>
      <tr>
		  <td >
		  <img src="<?=$latest_skin_url?>/img/spot.png" border=0 align='absmiddle'>&nbsp;
			<?php
            //echo $list[$i]['icon_reply']." ";
            echo "<a href=\"".$list[$i]['href']."\">";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
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
			 </td>
			 <td align=right>
			 <span class="Nb_slt_datetime"><?=$list[$i][datetime]?></span>
			 </td>
		 </tr>
   <?php }  ?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <tr><td align=center>게시물이 없습니다.</td></tr>
    <?php }  ?>
 </table>
<!-- </div> -->
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
