<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');


$imgwidth = 250; //표시할 이미지의 가로사이즈
$imgheight = 160; //표시할 이미지의 세로사이즈
?>

<style>
/*#oneshot { position:relative;margin:0 0 0 -5px;}*/
#oneshot .lt_more {position:absolute;top:10px;right:0; margin-right: 10px;}
#oneshot .la_title{position:absolute; left:0; top:0; z-index:100; background:#000; padding:5px; font-size:1em; color:#fff;margin:0 0 0 5px;filter:alpha(opacity=50);opacity:.5;}
#oneshot .img_set{width:<?php echo $imgwidth ?>px; height:<?php echo $imgheight ?>px; background:#fafafa;padding:0;}
#oneshot .subject_set{width:<?php echo $imgwidth - 13 ?>px; height:58px; padding:5px 10px 10px 3px; z-index:1; bottom:0; left:0;}
#oneshot .subject_set .sub_title{color:#333;height:17px;overflow:hidden;padding:3px 0 0 0;font-size:1.2em;font-family:NanumBarunGothic,dotum;}
#oneshot .subject_set .sub_content{color:#8c8a8a;height:30px;overflow:hidden;padding:3px 0 0;font-family:NanumGothic,dotum;}


#oneshot ul {list-style:none;clear:both;margin:0;padding:0;}
#oneshot li{float:left;list-style:none;text-decoration:none;padding:0 0 0 5px}
.subject_set  a:link, a:visited {color:#333;text-decoration:none}
.subject_set  a:hover, a:focus, a:active {color:#e60012;text-decoration:none}

/* 폰트불러오기 */
@font-face {font-family:'NanumBarunGothic';src: url('<?php echo $latest_skin_url ?>/NanumBarunGothic.eot');}
@font-face {font-family:'NanumGothic';src: url('<?php echo $latest_skin_url ?>/NanumGothic.eot');}

</style>
<div id="oneshot">
	<div class="la_title"><?php echo $bo_subject ?>	</div>
	<div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>

	<?php if (count($list) == 0) { //게시물이 없을 경우 ?>
	<div class="n_no_list">게시물이 없습니다.</div>


	<?php } else { //게시물이 있을 경우 ?>

	<div id="mov_inner">
	<ul>
		<?php for ($i = 0; $i < count($list); $i++) {
		$n_mov_content = cut_str(strip_tags($list[$i]['wr_content']), $n_mov_max_content, '...');
//  유튜브 짧은 주소를 적용해서 썸네일 이미지를 불러오기 위한 커스터마이징 WJ
		$url_check = eregi('youtu.be', $list[$i]['wr_link1']);
		$link1_id = strstr($list[$i]['wr_link1'], 'e/');
		$link1_id = explode('&', $link1_id);
		$link1_id = str_replace('e/', '', $link1_id[0]);


		$n_mov_thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $imgwidth, $imgheight);
		$n_mov_no_img = "$latest_skin_url/img/no_img.gif";
		?>
		<li>
			<div class="img_set">
				<?php if ($url_check) { //'링크1'에 'youtube'란 단어가 포함된 주소가 있을 경우 ?>
				<!--  유튜브 짧은 주소를 적용해서 썸네일 이미지를 불러오기 위한 커스터마이징 WJ -->
				<a href="#pic_<?php echo $bo_table; ?>_<?php echo $i; ?>" rel="next"><img src="http://i.ytimg.com/vi/<?php echo $link1_id; ?>/mqdefault.jpg" width="<?php echo $imgwidth; ?>" height="<?php echo $imgheight; ?>" alt="<?php echo $list[$i]['subject']; ?>" /></a>
				<?php } else { if ($n_mov_thumb['src']) {
						$img_content = '<a href="'.$list[$i]['href'].'"><img src="'.$n_mov_thumb['src'].'" width="'.$imgwidth.'" height="'.$imgheight.'" alt="'.$list[$i]['subject'].'" /></a>';
				} else {
					$img_content = '<img src="'.$n_mov_no_img.'" width="'.$imgwidth.'" height="'.$imgheight.'" alt="이미지가 없습니다." />';
				}
				echo $img_content;
				}
				?>
			</div>
			<!-- 이미지 아래 제목 출력 WJ -->
			<div class="subject_set">
				<div class="sub_title"><a href="<?php echo $list[$i]['href'] ?>"><?php echo cut_str($list[$i]['subject'], 23, "..") ?></a></div>
				<div class="sub_content"><?php echo get_text(cut_str(strip_tags($list[$i][wr_content]), 65, '...' )) ?></div>
			</div>
		</li>
		<?php } ?>
	</ul>

</div>
	<?php }	 ?>

<!--
	 <ul>
	<?php for ($i=0; $i<count($list); $i++) { ?>
		<li>
			<div class="img_set">
				<a href="<?php echo $list[$i]['href'] ?>">
					<?php
					$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $imgwidth, $imgheight);
					if($thumb['src']) {
					$img_content = '<img class="img_left" src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" width="'.$imgwidth.'" height="'.$imgheight.'">';
					} else {
					$img_content = 'NO IMAGE';
					}
					echo $img_content;
					?>
				</a>
			</div>
			<div class="subject_set">
				<div class="sub_title"><a href="<?php echo $list[$i]['href'] ?>"><?php echo cut_str($list[$i]['subject'], 23, "..") ?></a></div>
				<div class="sub_content"><?php echo get_text(cut_str(strip_tags($list[$i][wr_content]), 65, '...' )) ?></div>
			</div>
		</li>
	<?php } ?>
	</ul> -->
</div>
<div style="clear:both;"></div>
