<!-- 메인메뉴 -->
 <script type="text/javascript">
 //GNB
	$(document).ready(function() {
		 $(".subnav_hover").css({display: "none"});
	var useragent = navigator.userAgent;
	 // IE7이 아니고 IE6일때는
	 if ((useragent.indexOf('MSIE 6')>0) && (useragent.indexOf('MSIE 7')==-1))
	 {
		 $("#mainnav li").hover(function() {
			 $(".subnav_hover").slideDown('normal').show();
		 });
		 $("#mainnav").hover(function() {
			 $(this).show();
		 },function(){
			 $(this).hide();
			 $("header").mouseleave(function() {
			 });
		 })
	 } else {
		 $("#mainnav li").hover(function() {
			 $(".subnav_hover").show();
		 });
		 $(".subnav_hover").hover(function() {
			 $(this).show();
		 },function(){
			 $(this).slideUp(300);
			 $("header").mouseleave(function() {
				 setTimeout("jQuery('.subnav_hover').slideUp(140;)",250)
				 $(".subnav_hover").fadeOut();
			 });
		 })
	 }
	});
 </script>
 <!-- /메인메뉴 -->

 <div id="main_wrap">


   <div class="global_wrap">
	<div class="inner">
        <div class="service">
            <ul>
                <li class="mimint_top"><a href="" class="on">착한엄마</a></li><!-- 접속중인 서비스명에 해당하는 a태그에 on 클래스 추가 -->
                <li class="mintsale"><a href="http://sale.mimint.co.kr" target="_blank">착한엄마 SHOP</a></li>
                <!--<li class="mintblog"><a href="http://blog.mimint.co.kr" target="_blank"">mint blog</a></li>-->

            </ul>
        </div>
        <div class="util">

              <?php  if ($is_member) { ?>
              <?php if ($is_admin) {  ?>
              <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/"><b>관리자</b></a></li>
              <?php }  ?>
              <!-- <li><a href="<?php //echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php">정보수정</a></li> -->
              <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">로그아웃</a></li>
              <?php } else { ?>
              <li><a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a></li>
              <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><b>로그인</b></a></li>
              <?php } ?>
                <li class=""><a href="#"></a></li>
                <li class=""><a href="#"></a></li>
                <li class=""><a href="#">고객센터</a></li>


                <!-- <li class="logout"><a href="#"><span>로그아웃</span></a></li>

                <li class="toon"><a href="/play/"><span>만화게임</span></a></li>
                <li class="bg"><a href="/event_n/consumer_list.asp"><span>체험단</span></a></li>
                 <li class="center"><a href="#"><span>고객센터</span></a></li> -->
            </ul>
        </div>
    </div>
</div>




		 <div id="header">
				 <div class="top">
						 <ul class="sns_icon">
								 <li class=""><a href="#"><img src="<?php echo G5_THEME_URL ?>/img/main/sns_facebook.png" alt="페이스북" /></a></li>
								 <li class=""><a href="#"><img src="<?php echo G5_THEME_URL ?>/img/main/sns_kakao.png" alt="카카오톡" /></a></li>
								 <li class=""><a href="#"><img src="<?php echo G5_THEME_URL ?>/img/main/sns_naver.png" alt="네이버카페" /></a></li>
								 <!-- <li class=""><a href="#"><img src="<?php echo G5_THEME_URL ?>/img/main/sns_wechat.png" alt="위챗" /></a></li> -->
						 </ul>


						 <h1 class="logo"><a href="/"><img src="<?php echo G5_THEME_URL ?>/img/main/logo.png" alt="로고" /></a>
						 <!-- <div class="search">
								 <input type="text" id="search_bar" class="search_bar"><button id="search_btn" class="search_btn"></button> -->

                 <fieldset id="hd_sch">
                     <legend>사이트 내 전체검색</legend>
                     <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                     <input type="hidden" name="sfl" value="wr_subject||wr_content">
                     <input type="hidden" name="sop" value="and">
                     <label for="sch_stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                     <input type="text" name="stx" id="sch_stx" maxlength="20">
                     <input type="submit" id="sch_submit" value="검색">
                     </form>

                     <script>
                     function fsearchbox_submit(f)
                     {
                         if (f.stx.value.length < 2) {
                             alert("검색어는 두글자 이상 입력하십시오.");
                             f.stx.select();
                             f.stx.focus();
                             return false;
                         }

                         // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                         var cnt = 0;
                         for (var i=0; i<f.stx.value.length; i++) {
                             if (f.stx.value.charAt(i) == ' ')
                                 cnt++;
                         }

                         if (cnt > 1) {
                             alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                             f.stx.select();
                             f.stx.focus();
                             return false;
                         }

                         return true;
                     }
                     </script>
                 </fieldset>
              </h1>


<!--
						 </div> -->
				 </div>
				 <div class="lnb">

						 <ul id="mainnav">
								 <li class=""><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=talk">톡톡톡</a></li>
								 <li class=""><a href="#">요리·맛집</a></li>
								 <li class=""><a href="#">육아</a></li>
								 <li class=""><a href="#">러브</a></li>
								 <li class=""><a href="#">라이프</a></li>
								 <li class=""><a href="#">뉴스</a></li>
								 <li class=""><a href="#">놀아요</a></li>
								 <li class=""><a href="#">무료운세</a></li>
                 <li class=""><a href="#">할인정보</a></li>
                 <li class=""><a href="#">이벤트</a></li>
                 <li class=""><a href="#">전체보기</a></li>
                 <li class=""><a href="#">포인트 경매</a></li>
                 <li class=""><a href="#">기타</a></li>
                 <li class=""><a href="#">기타</a></li>
						 </ul>

						 <!--서브메뉴-->
						 <div class="subnav_hover">
								<div class="subnav_wrap">
										<ul class="subnav_list submenu1">
											 <li><a href="#">사는이야기</a></li>
											 <li><a href="#">베스트</a></li>
											 <li><a href="#">수다</a></li>
										</ul>
										<ul class="subnav_list submenu2">
											 <li><a href="#">디지털</a></li>
											 <li><a href="#">아날로그</a></li>
											 <li><a href="#">레이저</a></li>
											 <li><a href="#">MTS</a></li>
											 <li><a href="#">머신부품</a></li>
										</ul>
										<ul class="subnav_list submenu3">
											 <li><a href="#">디지털</a></li>
											 <li><a href="#">아날로그</a></li>
											 <li><a href="#">엠보</a></li>
											 <li><a href="#">수지</a></li>
											 <li><a href="#">캡</a></li>
										</ul>
										<ul class="subnav_list submenu4">
											 <li><a href="#">클렌징</a></li>
											 <li><a href="#">모이스처라이징</a></li>
											 <li><a href="#">스페셜케어</a></li>
											 <li><a href="#">썬케어</a></li>
											 <li><a href="#">세트</a></li>
											 <li><a href="#">스페셜케어</a></li>
										</ul>
										<ul class="subnav_list submenu5">
											 <li><a href="#">클렌징</a></li>
											 <li><a href="#">모이스처라이징</a></li>
											 <li><a href="#">스페셜케어</a></li>
											 <li><a href="#">썬케어</a></li>
											 <li><a href="#">세트</a></li>
											 <li><a href="#">스페셜케어</a></li>
										</ul>
										<ul class="subnav_list submenu6">
											 <li><a href="#">클렌징</a></li>
											 <li><a href="#">모이스처라이징</a></li>
											 <li><a href="#">스페셜케어</a></li>
											 <li><a href="#">썬케어</a></li>
											 <li><a href="#">세트</a></li>
											 <li><a href="#">스페셜케어</a></li>
										</ul>
										<ul class="subnav_list submenu7">
											 <li><a href="#">클렌징</a></li>
											 <li><a href="#">모이스처라이징</a></li>
											 <li><a href="#">스페셜케어</a></li>
											 <li><a href="#">썬케어</a></li>
											 <li><a href="#">세트</a></li>
											 <li><a href="#">스페셜케어</a></li>
										</ul>
										<ul class="subnav_list submenu8">
											 <li><a href="#">클렌징</a></li>
											 <li><a href="#">모이스처라이징</a></li>
											 <li><a href="#">스페셜케어</a></li>
											 <li><a href="#">썬케어</a></li>
											 <li><a href="#">세트</a></li>
											 <li><a href="#">스페셜케어</a></li>
										</ul>
								 </div>
						 </div>
						 <!--서브메뉴끝-->

				 </div>
		 </div>
