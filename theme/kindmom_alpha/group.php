<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/group.php');
    return;
}

if(!$is_admin && $group['gr_device'] == 'mobile')
    alert($group['gr_subject'].' 그룹은 모바일에서만 접근할 수 있습니다.');

$g5['title'] = $group['gr_subject'];
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<?php

if($g5['title'] == '고객센터'){

  // include_once(G5_THEME_PATH.'/inc/community/sub/sub_aside.php');

  // 자유게시판
  echo  '<div>';
  echo latest("theme/Nimple_basic","cm_notice","8",'15');
  echo '</div>';

  echo  '<div>';
  echo latest("theme/Nimple_basic","qa","8",'15');
  echo '</div>';

}



if($g5['title'] == '톡톡톡'){

  // include_once(G5_THEME_PATH.'/inc/community/sub/sub_aside.php');

  echo '<div id="talk_upside">';
//  echo latest_all("theme/roll_issue1.08","talk_free,talk_humor",4,50);
   echo latest_group_hit_img("theme/roll_issue1.08", "talk", 3, 20, 20);
  echo '</div>';




  // 자유게시판
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","talk_free","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","talk_tv","8",'15');
  echo '</div>';
  // 재미
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","talk_humor","8",'15');
  echo '</div>';
  // 우울
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","talk_blue","8",'15');
  echo '</div>';
  // 고민
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","talk_worry","8",'15');
  echo '</div>';
  // 좋은글귀
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","talk_good","8",'15');
  echo '</div>';
}


if($g5['title'] == '요리·맛집'){

  // include_once(G5_THEME_PATH.'/inc/community/sub/sub_aside.php');


  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
}


if($g5['title'] == '육아'){

  // include_once(G5_THEME_PATH.'/inc/community/sub/sub_aside.php');

  // 자유게시판
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  // 재미
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';  // 우울
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  // 고민
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  // 좋은글귀
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
}

if($g5['title'] == '라이프'){
  // include_once(G5_THEME_PATH.'/inc/community/sub/sub_aside.php');

  // 자유게시판
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';

  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  // 재미
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';  // 우울
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  // 고민
  echo  '<div class="Nb_slt_left">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
  // 좋은글귀
  echo  '<div class="Nb_slt_right">';
  echo latest("theme/Nimple_basic","","8",'15');
  echo '</div>';
}




if($g5['title'] == '뉴스'){
  // include_once(G5_THEME_PATH.'/inc/community/sub/sub_aside.php');

include("$g4[path]/plugin/google-news2/index.php");

  echo  '<div id="">';
  echo latest("theme/Nimple_basic_news","ns_sports","7",'20');
  echo '</div>';

  echo  '<div id="">';
  echo latest("theme/Nimple_basic_news","ns_social","7",'20');
  echo '</div>';

  echo  '<div id="">';
  echo latest("theme/Nimple_basic_news","ns_tv","7",'20');
  echo '</div>';

  echo  '<div id="">';
  echo latest("theme/Nimple_basic_news","ns_eco","7",'20');
  echo '</div>';

  echo  '<div id="">';
  echo latest("theme/Nimple_basic_news","ns_culture","7",'20');
  echo '</div>';

  echo  '<div id="">';
  echo latest("theme/Nimple_basic_news","ns_car","7",'20');
  echo '</div>';
}



?>





<!-- 메인화면 최신글 시작
<?php
//  최신글
// $sql = " select bo_table, bo_subject
//             from {$g5[board_table]}
//             where gr_id = '{$gr_id}'
//               and bo_list_level <= '{$member[mb_level]}'
//               and bo_device <> 'mobile' ";
// if(!$is_admin)
//     $sql .= " and bo_use_cert = '' ";
// $sql .= " order by bo_order ";
// $result = sql_query($sql);
// for ($i=0; $row=sql_fetch_array($result); $i++) {
//     $lt_style = "";
//     if ($i%2==1) $lt_style = "margin-left:20px";
//     else $lt_style = "";
?>
    <div style="float:left;<?php// echo $lt_style ?>">
    <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
  //  echo latest('theme/basic', $row['bo_table'], 5, 70);
    ?>
    </div>
<?php
//}
?>
 메인화면 최신글 끝 -->

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>
