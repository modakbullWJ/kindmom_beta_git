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
                   <li class="global_top "><a href="<?php echo G5_URL ?>/">착한엄마</a></li>
                   <li class="km_sale gnb_seleted"><a href="<?php echo G5_SHOP_URL?>/">착한엄마 SHOP</a></li>

               </ul>
           </div>
           <div class="util">
             <ul>
               <?php  if ($is_member) { ?>
               <?php if ($is_admin) {  ?>
               <li><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/"><b>관리자</b></a></li>
               <?php }  ?>
              <li><a href="<?php  echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php">정보수정</a></li>
               <li><a href="<?php echo G5_BBS_URL; ?>/logout.php?url=shop">로그아웃</a></li>
               <li class=""><a href="#">마이페이지</a></li>
               <li class=""><a href="#">장바구니</a></li>
               <?php } else { ?>
               <li><a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a></li>
               <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><b>로그인</b></a></li>
               <?php } ?>

                <li class=""><a href="#">고객센터</a></li>
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

						 </ul>

						 <h1 class="logo"><a href="<?php echo G5_SHOP_URL?>/"><img src="<?php echo G5_THEME_URL ?>/img/main/shop_logo_w.png" alt="로고" /></a></h1>
						 <div class="search">
								 <input type="text" id="search_bar" class="search_bar"><button id="search_btn" class="search_btn"></button>
						 </div>
				 </div>
				 <div class="lnb">

						 <ul id="mainnav">
								 <li class=""><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=10">뷰티</a></li>
                 <li class=""><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=20">푸드/건강</a></li>
								 <li class=""><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=30">패션/악세사리</a></li>
								 <li class=""><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=40">베이비/맘</a></li>
								 <li class=""><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=50">생활/주방용품</a></li>

								 <li class=""><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=60">디지털</a></li>

						 </ul>

						 <!--서브메뉴-->
						 <div class="subnav_hover">
								<div class="subnav_wrap">
										<ul class="subnav_list submenu1">
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=1010">기초</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=1020">스페셜케어</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=1030">바디/헤어</a></li>
										</ul>
										<ul class="subnav_list submenu2">
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=2010">임산부/성인</a></li>
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=2020">출산/유아</a></li>
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=2030">유아용품</a></li>

										</ul>
										<ul class="subnav_list submenu3">
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=3010">시계</a></li>
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=3020">선글라스</a></li>
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=3030">쥬얼리</a></li>
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=3040">패션잡화</a></li>
                      <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=3050">캐리어</a></li>
										</ul>
										<ul class="subnav_list submenu4">
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4010">생활/미용가전</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4020">주방가전/주방용품</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4030">엘지생활건강</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4040">생활/청소/헬스</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4050">침구/패브릭</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4060">캠핑/야외용품</a></li>
                     	 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=4070">캔들/램프/디퓨저</a></li>
										</ul>
										<ul class="subnav_list submenu5">
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=5010">커피류</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=5020">건강식품</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=5030">간식</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=5040">음료</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=5050">식품</a></li>
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=5060">유기농차</a></li>
										</ul>
										<ul class="subnav_list submenu6">
											 <li><a href="<?php echo G5_SHOP_URL?>/list.php?ca_id=6010">휴대폰케이스/충전기</a></li>

										</ul>
										<!-- <ul class="subnav_list submenu7">
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
										</ul> -->
								 </div>
						 </div>
						 <!--서브메뉴끝-->
  
				 </div>
		 </div>
