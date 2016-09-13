<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$thumb_width  = isset($options['thumb_width']) ? $options['thumb_width'] : $board['bo_gallery_width'];
$thumb_height = isset($options['thumb_height']) ? $options['thumb_height'] : $board['bo_gallery_height'];
$thumb_arrange = isset($options['thumb_arrange']) ? $options['thumb_arrange'] : "v";
$box_width = isset($options['box_width']) ? $options['box_width'] : 280;

$thumb_width = abs($thumb_width) > 0 ? abs($thumb_width) : 240;
$thumb_height = abs($thumb_height) > 0 ? abs($thumb_height) : 180;
?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div style="clear:both;width:<?php echo $box_width; ?>px;">
<div class="lt_box">

<div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
<div class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></div>

<div class="lt_table">
<table border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed;">
	<tr>

	<?php
	for ($i=0; $i<1; $i++) {
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height);
		if($thumb['src']) {
			$img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
		} else {
			if($thumb['ori']) {
				$img_content = '<img src="'.$thumb['ori'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
			} else {
				$img_content = '';
			}
		}
		if ($img_content) {
			?>
			<th><a href="<?php echo $list[$i]['href']; ?>" class="lt_image"><?php echo $img_content; ?></a></th>
			<?php
		}
	}
	?>

<?php if ($thumb_arrange == "h") { ?>

		<td valign="top" class="pdl">

<?php } else { ?>

	</tr>
	<tr>
		<td>

<?php } ?>

<?php for ($i=0; $i<count($list); $i++) { ?>

	<div class="list">
		<img src='http://i.imgur.com/omOzOtu.gif' align="absmiddle"><!-- <img src='<?php echo $latest_skin_url; ?>/img/icon_middot.gif' align="absmiddle"> -->
		<?
		echo $list[$i][icon_reply] . "";
		echo "<a href='{$list[$i][href]}'>";
		if ($list[$i][is_notice])
			echo "<span style='color:#5A61B1;'><strong>{$list[$i][subject]}</strong></span>";
		else
			echo "<span>{$list[$i][subject]}</span>";
		echo "</a>";

		if ($list[$i][comment_cnt])
		echo " <a href=\"{$list[$i][comment_href]}\"><span style='font-size:8pt; color:#9A9A9A;'>{$list[$i][comment_cnt]}</span></a>";

		// if ($list[$i]['link']['count']) { echo "[{$list[$i]['link']['count']}]"; }
		// if ($list[$i]['file']['count']) { echo "<{$list[$i]['file']['count']}>"; }

		if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
		//if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
		//if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
		//if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
		//if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];
		?>

	</div>

<?php } ?>

<?php if(count($list) == 0){ ?>게시물이 없습니다.<? } ?>

		</td>
	</tr>
</table>
</div>

</div>
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
