<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

/*
스킨원본: http://sir.co.kr/bbs/board.php?bo_table=g5_skin&wr_id=2656

<?php
$hp_imgwidth = "110";  // 표시할 이미지의 가로사이즈
$hp_imgheight  = "80";  // 표시할 이미지의 세로사이즈
$hp_minSlides = "2";  // 슬라이드 최소개수
$hp_maxSlides = "5" ;  // 슬라이드 최대개수
$hp_slideMargin = "6";  // 슬라이드 이미지 간격
echo latest("hp5_slidersjs03", "drawing", 15, 25, 1, "$hp_imgwidth, $hp_imgheight, $hp_minSlides, $hp_maxSlides, $hp_slideMargin");
?>

*/

//옵션분리
list($imgwidth, $imgheight, $minSlides, $maxSlides, $slideMargin) = explode(",", $options);

if (!$imgwidth) {
	$imgwidth = "100"; //표시할 이미지의 가로사이즈
	$imgheight = "100"; //표시할 이미지의 세로사이즈
}

?>

<style>
/* 새글 스킨 (latest) */
.gy {position:relative; float:left; margin:0px 0px 0 10px; !important; } /* 140306 수정 */

.gy .lt_title {display:block; padding:10px; } /* 140221 수정 */
.gy .lt_title a:link {color:#000;text-decoration:none; font-size:1.25em !important; } /* 140306 추가 */
.gy .lt_title a:visited {color:#000;text-decoration:none; font-size:1.25em !important; } /* 140306 추가 */
/*.gy .lt_title a:hover, a:focus, a:active {color:#000;text-decoration:none; font-size:1.25em !important; } /* 140306 추가 */*/

.gy .lt_more {position:absolute;top:10px;right:10px; } /* 140221 수정 */
.gy .lt_more a:link {color:#2d2d2d; text-decoration:none; font-size:inherit !important; } /* 140306 추가 */
.gy .lt_more a:visited {color:#2d2d2d; text-decoration:none; font-size:inherit !important; } /* 140306 추가 */
/*.gy .lt_more a:hover, a:focus, a:active {color:#2d2d2d; text-decoration:none; font-size:inherit !important; } /* 140306 추가 */*/

.gy .cnt_cmt {display:inline-block;margin:0 0 0 3px;font-weight:bold}
.gy .red { color:#ff0000; } /* 140306 추가 */

/* modifided by redsalt */
.gy .gy_cotent { position:absolute; width:100%; height:30px; line-height:30px; z-index:10; top:<?php echo $imgheight;?>px; left:0px; background: #000; background:rgba(0, 0, 0, 0.7);} /* 140306 추가 */
.gy .gy_cotent a:link {color:#FFF;text-decoration:none; font-family: 'NanumBarunGothic,dotum';} /* 140306 추가 */
.gy .gy_cotent a:visited {color:#FFF;text-decoration:none; } /* 140306 추가 */
/*.gy .gy_cotent a:hover, a:focus, a:active {color:#FFF;text-decoration:none; } /* 140306 추가 */*/

.gy .slider1 { text-align:center; height:<?php echo $imgheight;?>px; } /* 150510 edit */
.gy .slider1 .slide { display:inline; } /* 140306 추가 */
.gy .sbox { width:<?php echo $imgwidth;?>px; height:<?php echo $imgheight + 30;?>px; border:1px solid #cdcdcd; } /* 140306 추가 */
.gy .sbox img { width:<?php echo $imgwidth;?>px; height:<?php echo $imgheight;?>px; } /* 140306 추가 */
.gy .sbox_over { width:<?php echo $imgwidth;?>px; height:<?php echo $imgheight+30;?>px; border:1px solid #ff0000; } /* 140306 추가 */
.gy .sbox_over img { width:<?php echo $imgwidth;?>px; height:<?php echo $imgheight;?>px; } /* 140306 추가 */
</style>

<!--link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style_gallery.css"-->
<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/jquery.bxslider.css">
<script type="text/javascript" src="<?php echo $latest_skin_url ?>/jquery.bxslider.js"></script>

<script type="text/javascript">
// 메인 갤러리 슬라이드 적용
$(document).ready(function(){
  $('.slider1').bxSlider({
    auto:true,
	slideWidth: <?php echo $imgwidth; ?>,
    minSlides: <?php echo $minSlides; ?>,
    maxSlides: <?php echo $maxSlides; ?>,
    slideMargin: <?php echo $slideMargin; ?>
  });
});


// 메인 갤러리 슬라이드 마우스 오버 적용
$(window).load(function() {

	//On mouseenter Event
	$(".slide").mouseenter(function() {
		$(this).removeClass("sbox");
		$(this).addClass("sbox_over");
	});

	//On mouseleave Event
	$(".slide").mouseleave(function() {
		$(this).removeClass("sbox_over");
		$(this).addClass("sbox");
	});
});
</script>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->

<div class="news_slider_title">
	<h2>뉴스 NEWS</h2>
	    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/group.php?gr_id=news"><span class="sound_only"></span>더보기</a></div>
</div>



<div class="gy">
    <!--
    <strong class="lt_title"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject; ?></a></strong>
    <div class="lt_more"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><span class="sound_only"><?php echo $bo_subject ?></span>더보기</a></div>
    -->
	<div class="slider1">
	<?php for ($i=0; $i<count($list); $i++) { ?>
    	<div class="slide sbox">
    	<a href="<?php echo $list[$i]['href'] ?>">
    	<?php
       		$thumb = get_list_thumbnail($list[$i]['bo_table'], $list[$i]['wr_id'], $imgwidth, $imgheight);
       		if($thumb['src']) {
           		$img_content = '<img src="'.$thumb['src'].'" alt="'.$list[$i]['subject'].'" width="" height="">';
        		} else {
           		$img_content = 'NO IMAGE';
        		}
         	echo $img_content;
       ?>
       </a>
    		<div class="gy_cotent"><strong><a href="<?php echo $list[$i]['href'] ?>"><?php echo cut_str($list[$i]['subject'], 80, "..") ?></a></strong>
        	</div>
        </div>
    <?php } ?>
    <? if (count($list) == 0) { //게시물이 없을 때 ?>
    게시물이 없습니다.
    <? } ?>
    </div>
</div>
<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
