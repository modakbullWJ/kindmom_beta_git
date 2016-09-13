<!-- 메인메뉴 -->

<script type="text/javascript">

  /* 전체보기 메뉴 */
 $(document).ready(function() {
    $(".subnav_hover").css({display: "none"});
 var useragent = navigator.userAgent;
  // IE7이 아니고 IE6일때는
  if ((useragent.indexOf('MSIE 6')>0) && (useragent.indexOf('MSIE 7')==-1))
  {
    $("#mainnav #allMenu").click(function() {
      $(".subnav_hover").slideDown('normal').show();
    });
    $("#allMenu").hover(function() {
      $(this).show();
    },function(){
      $(this).hide();
      $("header").mouseleave(function() {
      });
    })
  } else {
    $("#mainnav #allMenu").click(function() {
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



   $(function(){
   $(".subnav_3depth").hide();
   //hover요소(마우스의 오버와 아웃기능 동시에 가진다)
   $("#mainnav #dropMenu").hover(function(){
     $(".subnav_3depth",this).fadeIn("fast");
   },function(){
     $(".subnav_3depth", this).fadeOut("fast");
   });
 });
</script>
<!-- /메인메뉴 -->


 <!-- /메인메뉴 -->


 <div id="main_wrap">




   <div class="global_wrap">
    <div class="inner">
        <div class="service">
            <ul>
                <li class="global_top gnb_seleted"><a href="<?php echo G5_URL ?>/">착한엄마</a></li>
                <li class="km_sale "><a href="<?php echo G5_SHOP_URL?>/">착한엄마 SHOP</a></li>

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
            <!-- <li class=""><a href="#">장바구니</a></li> -->
            <?php } else { ?>
            <li><a href="<?php echo G5_BBS_URL; ?>/register.php">회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo $urlencode; ?>"><b>로그인</b></a></li>
            <?php } ?>

             <li class=""><a href="<?php echo G5_BBS_URL; ?>/group.php?gr_id=cm_center">고객센터</a></li>
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
                 <li class="txtColorPink" id="dropMenu"><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=talk">톡톡톡</a>

						 <!--3Depth _ 톡톡톡 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>사는이야기</h5></li>
								   <li><a href="#">베스트</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=talk_free">수다</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=talk_worry">고민</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=talk_blue">우울</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=talk_humor">재미(짤방)</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=talk_free">좋은글귀</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>관심별이야기</h5></li>
								   <li><a href="#">연예,시사</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=talk_tv">- 연예가수다</a></li>
								   <li><a href="#">- TV드라마영화</a></li>
								   <li><a href="#">- 스타포토</a></li>
								   <li><a href="#">취미,반려</a></li>
								   <li><a href="#">맛집여행</a></li>
								   <li><a href="#">운동,다이어트</a></li>
								</ul>
								<ul class="subnav_list submenu3">
								   <li><h5>동영상</h5></li>
								   <li><a href="#">베스트</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=vd_music">음악·뮤직비디오</a></li>
								   <li><a href="#">유머·패러디</a></li>
								   <li><a href="#">연예·방송TV</a></li>
								</ul>
								<ul class="subnav_list submenu4">
								   <li><h5>웹툰</h5></li>
								   <li><a href="#">따뜻한이야기</a></li>
								   <li><a href="#">이야기카툰</a></li>
								   <li><a href="#">궁합,애정</a></li>
								   <li><a href="#">심심풀이운세</a></li>
								</ul>
								<ul class="subnav_list submenu5">
								   <li><h5>어메이징스토리</h5></li>
								   <li><a href="#">첫사랑찾기</a></li>
								   <li><a href="#">전생에닮은연예인</a></li>
								   <li><a href="#">날짝사랑하는스타</a></li>
								   <li><a href="#">연예인궁합</a></li>
								   <li><a href="#">인디언식이름짓기</a></li>
								   <li><a href="#">중세식이름짓기</a></li>
								   <li><a href="#">나와어울리는초능력</a></li>
								   <li><a href="#">천국?지옥</a></li>
								</ul>
								<ul class="subnav_list submenu6">
								   <li><h5>MY</h5></li>
								   <li><a href="#">내가 작성한 글</a></li>
								   <li><a href="#">내가 작성한 댓글</a></li>
								   <li><a href="#">내가 스크랩한 글</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class="txtColorPink" id="dropMenu"><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=cookRes">요리·맛집</a>

						 <!--3Depth _ 요리,맛집 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>요리 레시피</h5></li>
								   <li><a href="#">밥,떡</a></li>
								   <li><a href="#">국,탕,찌개</a></li>
								   <li><a href="#">메인반찬</a></li>
								   <li><a href="#">밑반찬</a></li>
								   <li><a href="#">면,밀가루음식</a></li>
								   <li><a href="#">베이커리</a></li>
								   <li><a href="#">음료</a></li>
								   <li><a href="#">기타</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>맛집 지역별</h5></li>
								   <li><a href="#">서울</a></li>
								   <li><a href="#">인천</a></li>
								   <li><a href="#">광주</a></li>
								   <li><a href="#">대구</a></li>
								   <li><a href="#">대전</a></li>
								   <li><a href="#">부산</a></li>
								   <li><a href="#">울산</a></li>
								   <li><a href="#">경기도</a></li>
								   <li><a href="#">강원도</a></li>
								   <li><a href="#">전라도</a></li>
								   <li><a href="#">충청도</a></li>
								   <li><a href="#">경상도</a></li>
								   <li><a href="#">제주도</a></li>
								</ul>
								<ul class="subnav_list submenu3">
								   <li><h5>맛집 종류별</h5></li>
								   <li><a href="#">한식</a></li>
								   <li><a href="#">중식</a></li>
								   <li><a href="#">일식</a></li>
								   <li><a href="#">양식</a></li>
								   <li><a href="#">분식</a></li>
								   <li><a href="#">야식</a></li>
								   <li><a href="#">고기</a></li>
								   <li><a href="#">횟집</a></li>
								   <li><a href="#">술집</a></li>
								   <li><a href="#">카페</a></li>
								   <li><a href="#">베이커리</a></li>
								   <li><a href="#">기타</a></li>
								</ul>
								<ul class="subnav_list submenu4">
								   <li><h5>요리 정보 공유</h5></li>
								   <li><a href="#">오늘의 요리</a></li>
								   <li><a href="#">나만의 쿡팁</a></li>
								   <li><a href="#">요리재료, 도구</a></li>
								   <li><a href="#">요리상식</a></li>
								</ul>
								<ul class="subnav_list submenu5">
								   <li><h5>MY</h5></li>
								   <li><a href="#">내가 작성한 글</a></li>
								   <li><a href="#">내가 작성한 댓글</a></li>
								   <li><a href="#">내가 스크랩한 글</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class="txtColorPink" id="dropMenu"><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=baby">육아</a>

						 <!--3Depth _ 육아 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>육아</h5></li>
								   <li><a href="#">임신·출산</a></li>
								   <li><a href="#">건강·음식</a></li>
								   <li><a href="#">놀이·교육</a></li>
								   <li><a href="#">유치원·어린이집</a></li>
								   <li><a href="#">육아 쇼핑 정보 나눔</a></li>
								   <li><a href="#">포토존</a></li>
								   <li><a href="#">특별한이야기</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>정보마당</h5></li>
								   <li><a href="#">임신·출산 정보</a></li>
								   <li><a href="#">육아·교육 정보</a></li>
								</ul>
								<ul class="subnav_list submenu3">
								   <li><h5>임신,육아 도우미</h5></li>
								   <li><a href="#">성씨 추명학</a></li>
								   <li><a href="#">가임기 테스트</a></li>
								   <li><a href="#">임신 테스트</a></li>
								   <li><a href="#">태몽상담</a></li>
								</ul>
								<ul class="subnav_list submenu4">
								   <li><h5>MY</h5></li>
								   <li><a href="#">내가 작성한 글</a></li>
								   <li><a href="#">내가 작성한 댓글</a></li>
								   <li><a href="#">내가 스크랩한 글</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class="txtColorPink" id="dropMenu"><a href="#">
                 </a>

						 <!--3Depth _ 러브 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>러브</h5></li>
								   <li><a href="#">베스트</a></li>
								   <li><a href="#">썸ing</a></li>
								   <li><a href="#">연애중</a></li>
								   <li><a href="#">헤어진후에</a></li>
								   <li><a href="#">결혼</a></li>
								   <li><a href="#">부부이야기</a></li>
								   <li><a href="#">시월드</a></li>
								   <li><a href="#">쉿!여자들만</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>사랑의기술</h5></li>
								   <li><a href="#">여자의성</a></li>
								   <li><a href="#">남자의성</a></li>
								   <li><a href="#">부부클리닉</a></li>
								   <li><a href="#">성인유머야담</a></li>
								</ul>
								<ul class="subnav_list submenu3">
								   <li><h5>심리테스트</h5></li>
								   <li><a href="#">성격</a></li>
								   <li><a href="#">그림</a></li>
								   <li><a href="#">연애</a></li>
								   <li><a href="#">아이큐테스트</a></li>
								   <li><a href="#">별자리</a></li>
								   <li><a href="#">혈액형</a></li>
								</ul>
								<ul class="subnav_list submenu4">
								   <li><h5>MY</h5></li>
								   <li><a href="#">내가 작성한 글</a></li>
								   <li><a href="#">내가 작성한 댓글</a></li>
								   <li><a href="#">내가 스크랩한 글</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class="txtColorPink" id="dropMenu"><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=life">라이프</a>

						 <!--3Depth _ 라이프 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>패션·뷰티</h5></li>
								   <li><a href="#">패션 톡</a></li>
								   <li><a href="#">성형</a></li>
								   <li><a href="#">- 성형톡</a></li>
								   <li><a href="#">- 예뻐지는질문</a></li>
								   <li><a href="#">코스매틱 톡</a></li>
								   <li><a href="#">다이어트 톡</a></li>
								   <li><a href="#">쇼핑몰 추천</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>인테리어</h5></li>
								   <li><a href="#">Before & After</a></li>
								   <li><a href="#">건축·리모델링</a></li>
								   <li><a href="#">인테리어Tip</a></li>
								   <li><a href="#">가구&소품</a></li>
								   <li><a href="#">리폼DIY</a></li>
								   <li><a href="#">기타</a></li>
								</ul>
								<ul class="subnav_list submenu3">
								   <li><h5>생활·건강</h5></li>
								   <li><a href="#">건강</a></li>
								   <li><a href="#">절약</a></li>
								   <li><a href="#">일반상식</a></li>
								   <li><a href="#">청소,빨래</a></li>
								   <li><a href="#">기타</a></li>
								</ul>
								<ul class="subnav_list submenu4">
								   <li><h5>무료,서식 양식</h5></li>
								   <li><a href="#">이력서·자기소개서</a></li>
								   <li><a href="#">회사서식</a></li>
								   <li><a href="#">세무·회계</a></li>
								   <li><a href="#">계약서</a></li>
								   <li><a href="#">법률서식</a></li>
								   <li><a href="#">생활서식</a></li>
								   <li><a href="#">교육서식</a></li>
								   <li><a href="#">민원행정서식</a></li>
								   <li><a href="#">기타서식</a></li>
								</ul>
								<ul class="subnav_list submenu5">
								   <li><h5>MY</h5></li>
								   <li><a href="#">내가 작성한 글</a></li>
								   <li><a href="#">내가 작성한 댓글</a></li>
								   <li><a href="#">내가 스크랩한 글</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class="" id="dropMenu"><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=news">뉴스</a>

						 <!--3Depth _ 뉴스 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>뉴스</h5></li>
								   <li><a href="#">TV연예</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=ns_sports">스포츠</a></li>
								   <li><a href="#">정치</a></li>
								   <li><a href="#">경제</a></li>
								   <li><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=ns_sports">사회</a></li>
								   <li><a href="#">문화</a></li>
								   <li><a href="#">라이프</a></li>
								   <li><a href="#">자동차</a></li>
								   <li><a href="#">전국</a></li>
								   <li><a href="#">국제</a></li>
								   <li><a href="#">포토</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>MY</h5></li>
								   <li><a href="#">내가 작성한 댓글</a></li>
								   <li><a href="#">내가 스크랩한 글</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class="" id="dropMenu"><a href="#">놀아요</a>

						 <!--3Depth _ 놀아요 -->
						 <div class="subnav_3depth">
							<div class="subnav_wrap_3depth">
								<ul class="subnav_list submenu1">
								   <li><h5>만화</h5></li>
								   <li><a href="#">액션</a></li>
								   <li><a href="#">무협</a></li>
								   <li><a href="#">섹시</a></li>
								   <li><a href="#">드라마</a></li>
								   <li><a href="#">SF/판타지/호러</a></li>
								   <li><a href="#">순정BL</a></li>
								   <li><a href="#">코믹</a></li>
								   <li><a href="#">웹툰</a></li>
								   <li><a href="#">찜목록</a></li>
								</ul>
								<ul class="subnav_list submenu2">
								   <li><h5>게임</h5></li>
								   <li><a href="#">게임</a></li>
								   <li><a href="#">인기게임</a></li>
								   <li><a href="#">이벤트</a></li>
								</ul>
							 </div>
						 </div>

				 </li>

                 <li class=""><a href="#">무료운세</a></li>
                 <li class=""><a href="#">할인정보</a></li>
                 <li class=""><a href="#">이벤트</a></li>
                 <li class="" id="allMenu"><a href="#">전체보기&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                 <li class="txtColorGray"><a href="#">출석부</a></li>
                 <li class="txtColorGray"><a href="#">포인트 경매</a></li>
                 <li class="txtColorGray"><a href="#">마이 페이지</a></li>
             </ul>

             <!--서브  2Depth ALL 메뉴-->
             <div class="subnav_hover">
                <div class="subnav_wrap">
                    <ul class="subnav_list submenu1">
                       <li><h5>톡톡톡</h5></li>
					   <li><a href="#">사는이야기</a></li>
                       <li><a href="#">관심별이야기</a></li>
                       <li><a href="<?php echo G5_BBS_URL?>/group.php?gr_id=videos">동영상</a></li>
                       <li><a href="#">웹툰</a></li>
                       <li><a href="#">어메이징스토리</a></li>
                    </ul>
                    <ul class="subnav_list submenu2">
                       <li><h5>요리·맛집</h5></li>
					   <li><a href="#">요리레시피</a></li>
                       <li><a href="#">맛집</a></li>
                       <li><a href="#">요리 정보공유</a></li>
                    </ul>
                    <ul class="subnav_list submenu3">
                       <li><h5>육아</h5></li>
					   <li><a href="#">임신·출산</a></li>
                       <li><a href="#">건강,음식</a></li>
                       <li><a href="#">놀이,교육</a></li>
                       <li><a href="#">유치원,어린이집</a></li>
                       <li><a href="#">육아쇼핑 정보나눔</a></li>
					   <li><a href="#">임신·출산정보</a></li>
                       <li><a href="#">육아,교육정보</a></li>
                       <li><a href="#">알림판</a></li>
					   <li><a href="#">포토존</a></li>
                       <li><a href="#">특별한이야기</a></li>
                       <li><a href="#">성씨 추명학</a></li>
                       <li><a href="#">가임기 테스트</a></li>
                       <li><a href="#">임신 테스트</a></li>
                       <li><a href="#">태몽상담</a></li>
                    </ul>
                    <ul class="subnav_list submenu4">
                       <li><h5>러브</h5></li>
					   <li><a href="#">러브</a></li>
                       <li><a href="#">사랑의기술</a></li>
                       <li><a href="#">심리테스트</a></li>
                    </ul>
                    <ul class="subnav_list submenu5">
                       <li><h5>라이프</h5></li>
					   <li><a href="#">패션·뷰티</a></li>
                       <li><a href="#">성형</a></li>
                       <li><a href="#">인테리어·DIY</a></li>
                       <li><a href="#">생활·건강</a></li>
                       <li><a href="#">무료 서식 양식</a></li>
                    </ul>
                    <ul class="subnav_list submenu6">
                       <li><h5>뉴스</h5></li>
					   <li><a href="#">TV연예</a></li>
					   <li><a href="#">스포츠</a></li>
					   <li><a href="#">정치</a></li>
					   <li><a href="#">경제</a></li>
					   <li><a href="#">사회</a></li>
					   <li><a href="#">문화</a></li>
					   <li><a href="#">라이프</a></li>
					   <li><a href="#">자동차</a></li>
					   <li><a href="#">전국</a></li>
					   <li><a href="#">국제</a></li>
					   <li><a href="#">포토</a></li>
                    </ul>
                    <ul class="subnav_list submenu7">
                       <li><h5>놀아요</h5></li>
					   <li><a href="#">만화</a></li>
					   <li><a href="#">게임</a></li>
                    </ul>
                    <ul class="subnav_list submenu8">
                       <li><h5>이벤트</h5></li>
					   <li><a href="#">출석부</a></li>
					   <li><a href="#">동전찾기</a></li>
					   <li><a href="#">포인트경매</a></li>
					   <li><a href="#">공연,시사회</a></li>
					   <li><a href="#">경품이벤트</a></li>
					   <li><a href="#">리서치</a></li>
					   <li><a href="#">체험단 신청</a></li>
                    </ul>
                    <ul class="subnav_list submenu9">
                       <li><h5>할인정보</h5></li>
					   <li><a href="#">음식점</a></li>
					   <li><a href="#">패션,뷰티</a></li>
					   <li><a href="#">놀이동산,테마파크</a></li>
					   <li><a href="#">생생정보</a></li>
                    </ul>
                    <ul class="subnav_list submenu10">
                       <li><h5>무료운세</h5></li>
					   <li><a href="#">사주,운세</a></li>
					   <li><a href="#">꿈해몽,태몽</a></li>
					   <li><a href="#">궁합,애정</a></li>
					   <li><a href="#">심심풀이운세</a></li>
                    </ul>
                 </div>
             </div>
             <!--서브  2Depth ALL 메뉴 끝-->


           </div>
</div>
