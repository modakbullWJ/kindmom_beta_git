
<div id="footer">

		<div class="foot_info">
				<ul class="slink">
						<li><a href="#">착한엄마소개 &nbsp;&nbsp;| &nbsp;&nbsp;</a></li>
						<li><a href="#">가맹점 개설문의 &nbsp;&nbsp;| &nbsp;&nbsp;</a></li>
						<li><a href="#">사회공헌 활동 &nbsp;&nbsp;| &nbsp;&nbsp;</a></li>
						<li><a href="#">사이트 이용약관 &nbsp;&nbsp;| &nbsp;&nbsp;</a></li>
						<li><a href="#">개인정보 처리방침 &nbsp;&nbsp;| &nbsp;&nbsp;</a></li>
						<li><a href="#">시스템 오류신고</a></li>
				</ul>
				<div class="info_bottom">

					<!-- 쇼핑몰 공지사항 최신글 WJ -->
					<div class="notice">
						 <?php echo latest('theme/shop_notice', 'notice', 4, 25); ?>
					</div>

						<div class="contact_us">
								<h3>고객지원센터 이용안내<strong>070-555-5555</strong></h3>
								<ul>
										<li>토/일요일 및 공휴일은 1:1 문의하기를 이용해주세요.</li>
										<li>업무가 시작되면 바로 처리해드리겠습니다.</li>
										<li>오프라인 매장, 서비스 관련 고객센터 02-555-5555</li>
										<li>제품/트러블 관련 고객센터 : 070-555-5555(수신자부담)</li>
								</ul>
								<div class="contact_btn"><a href="#"><img src="<?php echo G5_THEME_URL ?>/img/main/contackus.png" alt="1:1문의바로가기" /><br/>1:1 문의</a></div>
						</div>
				</div>
		</div>
    <!-- /.foot_info -->

		<div class="addr">
				<div class="addr_txt">
						<p>
							착한엄마 대표 : 이명자 Ι 서울특별시 광진구 동일로60길 15, 1층(군자동) Ι 사업자등록번호 : 512-88-00350 <span>사업자정보확인</span><br/>
							통신판매업신고번호 : 서울가나구-0000호(서울 가나구청) 건강기능식품판매업 영업신고증 제 0호<br/>
							전자메일주소 : Ι 호스팅제공자 : (주) 엔젤리또<br/>
							 CORPORATION. ALL RIGHTS RESERVED.
							 <?php
								if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
								 <a href="<?php echo get_device_change_url(); ?>" id="device_change">모바일 버전으로 보기</a>
								<?php }?>
						</p>
					

				</div>
		</div>
    <!-- /.addr -->

</div>
<!-- /#footer  -->

</div>
<!-- main_Wrap? -->
