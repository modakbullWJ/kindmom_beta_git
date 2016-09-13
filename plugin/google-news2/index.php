<?php
/**
 * GoogleNews2 (GoogleNews2 for Gnuboard4)
 *
 * Copyright (c) 2009 Choi Jae-Young <www.miwit.com>
 *
 * 저작권 안내
 * - 저작권자는 이 프로그램을 사용하므로서 발생하는 모든 문제에 대하여 책임을 지지 않습니다.
 * - 이 프로그램을 어떠한 형태로든 재배포 및 공개하는 것을 허락하지 않습니다.
 * - 이 저작권 표시사항을 저작권자를 제외한 그 누구도 수정할 수 없습니다.
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$plugin_path = $g4['path']."/plugin/google-news2";

include("keyword.php");
$keyword = array_filter(array_map("trim", $keyword), 'strlen');
$keyword = array_values($keyword);

$tmp = array();
foreach ($keyword as $key => $values) {
    $tmp[$values] = $values;
}
$keyword = $tmp;

$keyword['-'] = "주요뉴스";
$keyword['p'] = "정치";
$keyword['y'] = "사회";
$keyword['l'] = "문화/생활";
$keyword['w'] = "세계";
$keyword['t'] = "정보과학";
$keyword['s'] = "스포츠";
$keyword['e'] = "연예";
?>
<style>
#google-news { width:757px; overflow:hidden; background-color:#e1e1e1; border-top:2px solid #72ACE7;
margin-left: 15px;
border-left: 1px solid #dcdcdc;
border-right: 1px solid #dcdcdc;
border-bottom: 1px solid #dcdcdc;

 }
#google-news td { background-color:#fff; }
#google-news a { color:#2F3743; }
#google-news .subject { background-color:#fcfcfc; width:130px; height:25px; font-weight:bold; overflow:hidden; }
#google-news .subject .margin {  margin:5px 0 0 15px; }
#google-news #list { float:left; margin:0; padding:0; list-style:none; width:130px; height:160px;  }
#google-news #list .margin {  padding:5px 0 0 15px; }
#google-news #list li { height:17px; line-height:17px; }
#google-news #list .gn_item { color:#6B6D70; font-size:11px; font-family:dotum; }
#google-news #list .gn_item:hover { color:#000; text-decoration:underline; }
#google-news #list .gn_sel { color:#6079A8; text-decoration:underline; font-weight:bold; font-size:11px; }

#google-news #news ul { float:left; margin:0; padding:0; list-style:none; margin:5px 5px 5px 10px; overflow:hidden; }
#google-news #news li { width:450px; height:21px; line-height:20px; overflow:hidden; float:left; }
#google-news #news li { margin:0; padding:0 0 0 7px; background:url(<?=$plugin_path?>/img/dot.gif) no-repeat 0 7px; }
#google-news #news li a { font-size:12px; }
#google-news #news li a:hover { color:#438A01; text-decoration:underline; }
#google-news #news li a:visited {  }
#google-news #news li a:active { color:#438A01;  }
#google-news #news .image { float:left; margin:10px 0 0 10px; width:110px; height:125px; padding:0; }
#google-news #news .image img { width:100px; height:120px; }

#google-news .today { font-size:11px; }
#ajax-loading { display:none; position:absolute; margin:5px 5px 0 385px; }
</style>

<table border="0" cellpadding="0" cellspacing="1" id="google-news">
<tr>
    <td class="subject" valign="top">
        <div class="margin">구글뉴스</div>
    </td>
    <td style="background-color:#F8F8F8; padding-left:10px;">
        <div class="today">
            <img src="<?=$plugin_path?>/img/icon_clock.gif" align="absmiddle">
            <span id="mw-today"></span><span id="mw-time"></span>
        </div>
    </td>
<tr>
    <td width="130">
        <ul id="list">
            <div class="margin">
            <?php
            foreach ($keyword as $key => $value) {
                if ($key == '-') $key = '';
                if (strlen($key>1)) $key = $value;
                ?><li><a href="#;" onclick="mw_google_news('<?php echo $key?>')" id="gn-<?php echo $key?>"
                    class="gn_item"><?php echo $value?></a></li>
            <?php } ?>
            </div>
        </ul>
    </td>
    <td valign="top">
        <div id="ajax-loading"><img src="<?=$plugin_path?>/img/loading.gif"></div>
        <div id="news"></div>
    </td>
</tr>
</table>

<script>
gns = new Array();
<?php
$i = 0;
foreach ($keyword as $key => $value) {
    if ($key == '-') $key = '';
    if (strlen($key>1)) $key = $value;
    echo "gns[{$i}] = \"{$key}\";\n";
    $i++;
}
?>
gns_idx = -1;
gns_time = "";
function mw_google_news(topic) {
    $("#news").load("<?php echo $plugin_path?>/get_news.php?topic="+topic);
    $(".gn_sel").each(function () {
        $(this).removeClass().addClass("gn_item");
    });
    $("#gn-"+topic).removeClass().addClass("gn_sel");
    for (i=0; i<gns.length; i++) {
        if (gns['i'] == topic) {
            gns_idx = i;
        }
    }
}
function mw_google_news_change() {
    if (++gns_idx >= gns.length)
        gns_idx = 0;
    mw_google_news(gns[gns_idx]);
    gns_time = setTimeout("mw_google_news_change()", 9000);
}
$("#google-news").hover(function () {
    clearTimeout(gns_time);
},
function () {
    gns_time = setTimeout("mw_google_news_change()", 9000);
});

mw_timer_init = <?php echo time()*1000?>;
function mw_timer() {
    mw_timer_init += 1000;
    var date = new Date(mw_timer_init);
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var time = date.toLocaleTimeString();
    var wstr = "일월화수목금토";
    var week = wstr.substr(date.getDay(),1);
    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;
    //var str = month + "월 " + day + "일 " + "(" + week + ") ";
    var str = month + "." + day + " (" + week + ") ";
    document.getElementById("mw-today").innerHTML =  str;
    document.getElementById("mw-time").innerHTML = time;
    setTimeout("mw_timer()", 1000);
}
$(document).ready(function() {
    $("#ajax-loading").ajaxStart(function() {
	//$("#news").hide();
	$(this).show();
    }).ajaxStop(function() {
	$(this).hide();
	$("#news").show();
    });
    mw_google_news_change();
    mw_timer();
});

</script>
