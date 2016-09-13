<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

add_stylesheet('<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.css">', 0);


$thumb_width = abs($thumb_width) > 0 ? abs($thumb_width) : 125;
$thumb_height = abs($thumb_height) > 0 ? abs($thumb_height) : 100;
?>


<style>


</style>



<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div class="Nb_slt">
	<div class="NB_slt_title_wrap">
		<?php echo $bo_subject; ?>
		 <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>">
			 <span class="sound_only"><?php echo $bo_subject ?></span>+</a>
	</div>




		 <?php
		 for ($i=0; $i<1; $i++) {
			 $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'],$thumb_width, $thumb_height);
			 if($thumb['src']) {
				 $img_content = '<img  src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
			 } else {
				 if($thumb['ori']) {
					 $img_content = '<img   src="'.$thumb['ori'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
				 } else {
					 $img_content = '';
				 }
			 }
			 if ($img_content) {
				 ?>
				 <div class ="news_photo"><a href="<?php echo $list[$i]['href']; ?>" class="lt_image"><?php echo $img_content; ?>

					 <?php
							 echo "<a id =\"news_photo_title\" href=\"".$list[$i]['href']."\">";
					 if ($list[$i]['is_notice'])
							 echo '<strong >'.$list[$i]['subject'].'</strong>';
					 else
							 echo $list[$i]['subject'];

					 if ($list[$i]['comment_cnt'])
							 echo $list[$i]['comment_cnt'];

					 echo "</a>"; ?>

<span id="Nb_slt_datetime_1"><?=$list[$i][datetime]?></span>
				 </a>
			 </div>
				 <?php
				//  첫번째 게시물에 이미지가 없을 때



			 }if(!$img_content){
				 ?>
				 <div class ="news_photo">
<span class="fz_gallery_thumb"><i class="fa fa-picture-o">
	<a href="<?php echo $list[$i]['href']; ?>" class="lt_image"><?php echo $img_content; ?> </a></i></span>





					 <?php
							 echo "<a href=\"".$list[$i]['href']."\">";
					 if ($list[$i]['is_notice'])
							 echo "<strong>".$list[$i]['subject']."</strong>";
					 else
							 echo $list[$i]['subject'];

					 if ($list[$i]['comment_cnt'])
							 echo $list[$i]['comment_cnt'];

					 echo "</a>";
					 ?>

 <span class="Nb_slt_datetime"><?=$list[$i][datetime]?></span>

			 </div>

<?php  } ?>
<?php  }?>



	<ul id="ululul">
    <?php for ($i=1; $i<count($list); $i++) {  ?>

				<li>
		  <!-- <img src="<?=$latest_skin_url?>/img/spot.png" border=0 align='absmiddle'>&nbsp; -->
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
          //  if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
            if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
            if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
             ?>


			 <span class="Nb_slt_datetime"><?=$list[$i][datetime]?></span>
		 </li>


   <?php }  ?>
	 </ul>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
    <td align=center>게시물이 없습니다.</td>
    <?php }  ?>

</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
