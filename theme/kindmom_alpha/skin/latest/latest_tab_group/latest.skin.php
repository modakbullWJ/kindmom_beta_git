<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$group_latest_skin_url.'/style.css">', 0);
?>

<!-- <?php echo $bo_subject; ?> 최신글 시작 { -->
<div style="height:106px" class="tab_list m1">
<ul>
<? 
for($m=0; $m<count($gr_id); $m++) { 
$num = $m+1;  
?>
<li class="m<?=$num?>">
<a href="#" jquery16408452460570924265="<?=$num?>">
<span><?=$gr[$m][gr_subject]?></span>
</a> 
<ul>
<?
$empty_row = $rows - count($list[$m]);

for($n=0; $n<count($list[$m]); $n++) {
  echo "<li>";
  echo "<a class=\"board\" href=\"{$list[$m][$n][bo_table]}\">[{$list[$m][$n][bo_subject]}] </a>";
  echo "<a href=\"{$list[$m][$n]['href']}\">{$list[$m][$n][subject]}</a>";
  if ($list[$m][$n]['comment_cnt']) 
  echo " <a class=\"commnet\" href=\"{$list[$m][$n]['comment_href']}\">{$list[$m][$n]['comment_cnt']}</a>";
  echo "<span class=\"datetime\">{$list[$m][$n][datetime2]}</span>";

//echo date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600));
//echo $list[$m][$n]['wr_datetime'];

    $list[$m][$n]['icon_new'] = '';
    if ($list[$m][$n]['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
        $list[$m][$n]['icon_new'] = '<img src="'.$group_latest_skin_url.'/img/icon_new.gif" alt="새글">';


					
    $list[$m][$n]['icon_link'] = '';
    if ($list[$m][$n]['wr_link1'] || $list[$m][$n]['wr_link2'])
	$list[$m][$n]['icon_link'] = '<img src="'.$group_latest_skin_url.'/img/icon_link.gif" alt="관련링크">';	

    if ($list[$m][$n]['file']['count'])
        $list[$m][$n]['icon_file'] = '<img src="'.$group_latest_skin_url.'/img/icon_file.gif" alt="첨부파일">';
		
    $list[$m][$n]['icon_hot'] = '';
    if ($board['bo_hot'] && $list[$m][$n]['wr_hit'] >= $board[$m][$n]['bo_hot'])
        $list[$m][$n]['icon_hot'] = '<img src="'.$group_latest_skin_url.'/img/icon_hot.gif" alt="인기글">';

    $list[$m][$n]['icon_secret'] = '';
    if (strstr($list[$m][$n]['wr_option'], 'secret'))
        $list[$m][$n]['icon_secret'] = '<img src="'.$group_latest_skin_url.'/img/icon_secret.gif" alt="비밀글">';


//if (isset($list[$m][$n]['icon_new'])) echo " " . $list[$m][$n]['icon_new'];
  echo " " . $list[$i][$n]['icon_new']; 
  echo " " . $list[$m][$n]['icon_file']; 
  echo " " . $list[$m][$n]['icon_link']; 
  echo " " . $list[$m][$n]['icon_hot']; 
  echo " " . $list[$m][$n]['icon_secret'];  

  echo "</li>";  
}

            
            /*/echo $list[$i]['icon_reply']." ";
            echo "<a href=\"".$list[$i]['href']."\">";
            if ($list[$i]['is_notice'])
                echo "<strong>".$list[$i]['subject']."</strong>";
            else
                echo $list[$i]['subject'];

            if ($list[$i]['comment_cnt'])
                echo $list[$i]['comment_cnt'];

            echo "</a>";

            // if ($list[$m][$n]['link']['count']) { echo "[{$list[$m][$n]['link']['count']}]"; }
            // if ($list[$m][$n]['file']['count']) { echo "<{$list[$m][$n]['file']['count']}>"; }

            if (isset($list[$m][$n]['icon_new'])) echo " " . $list[$m][$n]['icon_new'];
            if (isset($list[$m][$n]['icon_hot'])) echo " " . $list[$m][$n]['icon_hot'];
            if (isset($list[$m][$n]['icon_file'])) echo " " . $list[$m][$n]['icon_file'];
            if (isset($list[$m][$n]['icon_link'])) echo " " . $list[$m][$n]['icon_link'];
            if (isset($list[$m][$n]['icon_secret'])) echo " " . $list[$m][$n]['icon_secret'];
			*/
            
for($l=0; $l<$empty_row; $l++) {
  echo "<li> <a href='#'>".$gr[$m][gr_subject]."탭의 최신글이 더 없습니다.</a></li>";
}
?>
<li class="more"> <a href="<?php echo G5_BBS_URL?>/group.php?gr_id=<?=$gr_id[$m]?>">더보기</a> 
</li>
</ul>
</li>
<? } ?>
</ul>
</div>

<script type="text/javascript">
jQuery(function($){
	var tab = $('.tab_list');
	tab.removeClass('js_off');
	tab.css('height', tab.find('>ul>li>ul:visible').height()+40);
	function onSelectTab(){
		var t = $(this);
		var myClass = t.parent('li').attr('class');
		t.parents('.tab_list:first').attr('class', 'tab_list '+myClass);
		tab.css('height', t.next('ul').height()+40);
	}
	tab.find('>ul>li>a').click(onSelectTab).focus(onSelectTab);
});
</script>
