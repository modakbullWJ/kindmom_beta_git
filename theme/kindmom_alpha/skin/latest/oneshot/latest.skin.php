<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$imgwidth = 230; //표시할 이미지의 가로사이즈
$imgheight = 165; //표시할 이미지의 세로사이즈
?>
<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css">




<div style="float:left; margin-left:10px;">

<?php for ($i=0; $i<count($list); $i++) { ?>

	<div style="width:<?php echo $imgwidth ?>px; height:<?php echo $imgheight ?>px; background:#fff;padding:0; ">
			<div style="position:absolute; left:10; top:0; z-index:100; background:#4266b2; padding:5px; font-size:11px; color:#fff;"><?php echo $bo_subject ?></div>
			<?php
			$n_mov_content = cut_str(strip_tags($list[$i]['wr_content']), $n_mov_max_content, '...');
	//  유튜브 짧은 주소를 적용해서 썸네일 이미지를 불러오기 위한 커스터마이징 WJ
			$url_check = eregi('youtu.be', $list[$i]['wr_link1']);
			$link1_id = strstr($list[$i]['wr_link1'], 'e/');
			$link1_id = explode('&', $link1_id);
			$link1_id = str_replace('e/', '', $link1_id[0]);


			$n_mov_thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $imgwidth, $imgheight);
			$n_mov_no_img = "$latest_skin_url/img/no_img.gif";
			?>


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


	  <!-- <a href="<?php echo $list[$i]['href'] ?>">
    <?php
                        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $imgwidth, $imgheight);
                        if($thumb['src']) {
                            $img_content = '<img class="img_left" src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" width="'.$imgwidth.'" height="'.$imgheight.'">';
                        } else {
                            $img_content = 'NO IMAGE';
                        }
                        echo $img_content;
    ?>
    </a> -->
    </div>
    <div style="width:<?php echo $imgwidth - 20 ?>px; height:50px; background:#000000; padding:10px; z-index:1; bottom:0; left:0;">
    <ul style="list-style:none; display:block; padding:0; margin:0;">
    	<li><strong><a href="<?php echo $list[$i]['href'] ?>" style="color:#fff; font-size:15px; letter-spacing:-0.06em;"><?php echo cut_str($list[$i]['subject'], 20, "..") ?></a></strong></li>
        <li style="margin-top:5px;"><a href="<?php echo $list[$i]['href'] ?>" style="color:#888; font-size:11px; letter-spacing:-0.06em;"><?php echo get_text(cut_str(strip_tags($list[$i][wr_content]), 65, '...' )) ?></a></li>
    </ul>
    </div>
	</div>
<?php } ?>
