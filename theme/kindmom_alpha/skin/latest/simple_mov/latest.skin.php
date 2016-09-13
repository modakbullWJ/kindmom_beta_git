<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
global $is_admin;

$n_thumb_width = 120; //썸네일 가로 크기
$n_thumb_height = 90; //썸네일 세로 크기
$n_mov_max_content = 220; //게시판 글 내용 최대 글자 수
$n_mov_width = 470; //레이어 팝업 동영상 가로 크기
$n_mov_height = 350; //레이어 팝업 동영상 세로 크기
$n_mov_auto = 1; //레이어 팝업 동영상 자동 재생 여부, 자동으로 재생하지 않으려면 '0'을 입력
?>

<script type="text/javascript" src="<?php echo $latest_skin_url; ?>/js/jwplayer.js"></script>
<script type="text/javascript" src="<?php echo $latest_skin_url; ?>/js/fancyzoom.js"></script>
<link rel="stylesheet" href="<?php echo $latest_skin_url; ?>/style.css">

<section class="n_mov_wrap">
  <div class="n_title_wrap">
    <div class="n_title"><a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table; ?>"><?php echo $bo_subject; ?></a></div>
    <div class="n_right_wrap">
      <?php if ($is_admin == 'super' || $is_auth) { ?>
      <a href="<?php echo G5_URL; ?>/adm/board_form.php?w=u&bo_table=<?php echo $bo_table; ?>"><img src="<?php echo $latest_skin_url; ?>/img/icon_setting.gif" width="13" height="13" alt="게시판설정" /></a>
      <?php } ?>
      <a href="<?php echo G5_BBS_URL; ?>/write.php?bo_table=<?php echo $bo_table; ?><?php echo $write_href; ?>"><img src="<?php echo $latest_skin_url; ?>/img/icon_write.gif" width="13" height="13" alt="글쓰기" /></a>
      <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table; ?>"><img src="<?php echo $latest_skin_url; ?>/img/icon_more.gif" width="13" height="13" alt="더보기" /></a>
    </div>
  </div>
  <?php if (count($list) == 0) { //게시물이 없을 경우 ?>
  <div class="n_no_list">게시물이 없습니다.</div>
  <?php } else { //게시물이 있을 경우 ?>
  <ul>
    <?php for ($i = 0; $i < count($list); $i++) {
    $n_mov_content = cut_str(strip_tags($list[$i]['wr_content']), $n_mov_max_content, '...');
    $url_check = eregi('youtube', $list[$i]['wr_link1']);
    $link1_id = strstr($list[$i]['wr_link1'], '=');
    $link1_id = explode('&', $link1_id);
    $link1_id = str_replace('=', '', $link1_id[0]);

    $n_mov_thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $n_thumb_width, $n_thumb_height);
    $n_mov_no_img = "$latest_skin_url/img/no_img.gif";
    ?>
    <li>
      <div class="n_list_thumb">
        <?php if ($url_check) { //'링크1'에 'youtube'란 단어가 포함된 주소가 있을 경우 ?>
        <a href="#pic_<?php echo $bo_table; ?>_<?php echo $i; ?>" rel="next"><img src="http://img.youtube.com/vi/<?php echo $link1_id; ?>/1.jpg" width="<?php echo $n_thumb_width; ?>" height="<?php echo $n_thumb_height; ?>" alt="<?php echo $list[$i]['subject']; ?>" /></a>
        <?php } else { if ($n_mov_thumb['src']) {
            $img_content = '<a href="'.$list[$i]['href'].'"><img src="'.$n_mov_thumb['src'].'" width="'.$n_thumb_width.'" height="'.$n_thumb_height.'" alt="'.$list[$i]['subject'].'" /></a>';
        } else {
	        $img_content = '<img src="'.$n_mov_no_img.'" width="'.$n_thumb_width.'" height="'.$n_thumb_height.'" alt="이미지가 없습니다." />';
        }
        echo $img_content;
        }
        ?>
      </div>
      <?php if ($url_check) { //'링크1'에 'youtube'란 단어가 포함된 주소가 있을 경우 동영상 레이어 팝업 생성 ?>
      <div id="pic_<?php echo $bo_table; ?>_<?php echo $i; ?>" class="n_mov_layer">
        <div id="<?php echo $bo_table; ?>_<?php echo $i; ?>"></div>
        <script type="text/javascript">
        jwplayer("<?php echo $bo_table; ?>_<?php echo $i; ?>").setup({
            'flashplayer': '<?php echo $latest_skin_url; ?>/jwplayer.swf',
            'file': '<?php echo $list[$i]['wr_link1']; ?>',
	        'width': '<?php echo $n_mov_width; ?>',
	        'height': '<?php echo $n_mov_height; ?>',
	        'autostart': '<?php echo $n_mov_auto; ?>',
	        'controlbar': 'bottom',
            'screencolor': '000000',
	        'frontcolor': 'ffffff',
	        'backcolor': '000000',
	        'lightcolor': 'ffffff'
        });
        </script>
        <div class="n_mov_subject" style="width:<?php echo $n_mov_width; ?>px; overflow:hidden"><a href="<?php echo $list[$i]['href']; ?>"><?php echo $list[$i]['subject']; ?></a></div>
      </div>
      <?php } ?>
      <div class="n_list_right">
        <a href="<?php echo $list[$i]['href']; ?>"><?php echo $list[$i]['subject']; ?></a>
        <?php if ($list[$i]['comment_cnt']) { ?><span class="n_list_cmt">(<?php echo $list[$i]['comment_cnt']; ?>)</span><?php } ?>
        <span class="n_mov_icon"><?php if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new']; ?></span>
        <p><?php echo $n_mov_content; ?></p>
      </div>
    </li>
    <?php } ?>
  </ul>
  <?php } ?>
</section>
