<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<h2 class="sound_only">최신글</h2>
<!-- 최신글 시작 { -->
<!--
<div style="float:left;width:352px;">
    <?php //echo latest_group("theme/web_group2", "talk", 5, 20); ?>
</div> -->

<div class="banner_upside">
</div>
<!--/.banner_upside -->


<div class="comm_tab">
   <?php echo latest_tab_group("talk|cookRes|life", 5, 10, latest_tab_group, 0);  ?>
</div>
<!--/.comm_tab  -->



<div class="news_slider">
<?php
$hp_imgwidth = "240";  // 표시할 이미지의 가로사이즈
$hp_imgheight  = "155";  // 표시할 이미지의 세로사이즈
$hp_minSlides = "1";  // 슬라이드 최소개수
$hp_maxSlides = "1" ;  // 슬라이드 최대개수
$hp_slideMargin = "6";  // 슬라이드 이미지 간격
echo latest_all("theme/hp5_slidersjs03", "ns_sports,ns_eco,ns_car", 5, 20, 1,
"$hp_imgwidth, $hp_imgheight, $hp_minSlides, $hp_maxSlides, $hp_slideMargin");

//  $options = array( 'thumb_width' => 220, 'thumb_height' => 150, 'box_width' => 270 );
//  echo latest("theme/latest_box", "ns_sports", 5, 100, 0, $options);
?>
</div>
<!--/.news_slider -->

<?php //echo latest("theme/simple_mov", videos, 3, 40); ?>
<?php
// echo latest_all("theme/clean_gallery", "vd_sports,vd_music", 3, 20);
echo latest("theme/clean_gallery", "vd_music", 3, 25); ?>


<div class="banner_mid">
</div>
<!-- /.banner_mid -->



<div id="main_tab_area">


  <ul class="tabs">
    <li class="active" rel="tab1">1</li>
    <li rel="tab2">2</li>
    <li rel="tab3">3</li>
    <li rel="tab4">4</li>
    <li rel="tab5">5</li>
    <li rel="tab6">6</li>
</ul>
<div class="tab_container">
    <div id="tab1" class="tab_content">
      <?php
      //  echo latest("theme/x-gallery", "talk_humor", 40, 40, 1,
      //           array(
      //           'width'	=>250,
      //           'height'	=>250,
      //           'radius'	=> 0
      //           ));
                  ?>
    </div>
    <!-- #tab1 -->
    <div id="tab2" class="tab_content">
      <?php echo latest("theme/clean_gallery", "vd_music", 3, 25); ?>
    </div>
    <!-- #tab2 -->
    <div id="tab3" class="tab_content">3333Halo: Reach is the culmination of the superlative combat, sensational multiplayer, and seamless online integration that are the hallmarks of this superb series.</div>
    <!-- #tab3 -->
  <div id="tab4" class="tab_content">44444
  </div>
  <div id="tab5" class="tab_content">55555
  </div>
  <div id="tab6" class="tab_content">6666
  </div>

</div>
<!-- .tab_container -->

</div>
<!-- /#main_tab_area -->


<script type="text/javascript">
$(function () {

    $(".tab_content").hide();
    $(".tab_content:first").show();

    $("ul.tabs li").click(function () {
        $("ul.tabs li").removeClass("active").css("color", "#333");
        //$(this).addClass("active").css({"color": "darkred","font-weight": "bolder"});
        $(this).addClass("active").css("color", "darkred");
        $(".tab_content").hide()
        var activeTab = $(this).attr("rel");
        $("#" + activeTab).fadeIn()
    });
});
</script>




 <!-- <div class="news_slider">
  <?php //echo latest("section_bnr", "ns_sports", "5", "30");?>
</div> -->

 <?php// echo latest("theme/oneshot", "ns_sports", 2, 25); ?>















<?php
//  최신글
// $sql = " select bo_table
//             from `{$g5['board_table']}` a left join `{$g5['group_table']}` b on (a.gr_id=b.gr_id)
//             where a.bo_device <> 'mobile' ";
// if(!$is_admin)
//     $sql .= " and a.bo_use_cert = '' ";
// $sql .= " order by b.gr_order, a.bo_order ";
// $result = sql_query($sql);
// for ($i=0; $row=sql_fetch_array($result); $i++) {
//     if ($i%2==1) $lt_style = "margin-left:20px";
//     else $lt_style = "";
?>
    <!-- <div style="float:left;<?php //echo $lt_style ?>">
        <?php
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
      //  echo latest('theme/main_latest', $row['bo_table'], 5, 25);
        ?>
    </div> -->
<?php
//}
?>
<!-- } 최신글 끝 -->






<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
