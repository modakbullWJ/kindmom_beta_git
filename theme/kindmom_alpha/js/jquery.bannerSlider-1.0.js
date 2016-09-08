/**
 * rolling banner 1.0.2
 * http://www.shinyongjun.co.kr
 *
 * Copyright (C) 2015 shinyongjun.co.kr
 */

(function($){
	$.fn.bannerSlider = function(options){

		var area = this;

		options = $.extend({
			type	: 'slide',
			imgs	: area.find('.imgs'),
			prev	: area.find('.btn_prev'),
			next	: area.find('.btn_next'),
			navi	: area.find('.navi'),
			auto	: false,
			speed	: 350,
			delay	: 5000,
			arrive	: function(i){return;},
			leave	: function(i){return;}

		}, options);

		var type		= options.type,
			imgs		= options.imgs,
			img			= imgs.children('li'),
			prev		= options.prev,
			next		= options.next,
			navi		= options.navi,
			max			= img.length,
			speed		= options.speed,
			delay		= options.delay,
			size		= img.width(),
			iFlag		= 0,
			iBoolean	= true,
			sInterval	= null,
			clip		= null,
			_this		= null,
			_index		= null;


		for(n = 0; n < max; n++)
			navi.append('<a href="#self"></a>');

		var nav	= navi.children('a');
		nav.each(function(i){this.num = i});
		nav.eq(0).addClass('on');
		options.arrive(img.eq(iFlag), iFlag);

		function navAc(navNum){
			nav.removeClass('on');
			nav.eq(navNum).addClass('on');
		}

		var nextAc = function(nFlag){
			if (!iBoolean){return;}
			iBoolean = false;
			navAc(nFlag);

			switch(type){
				case('slide'):
					clip = iFlag;
					img.eq(iFlag).css({'display':'block','left':size});
					img.eq(nFlag).css({'display':'block','left':size*2});
					imgs.stop().animate({'left':-(size*2)}, speed, function(){
						imgs.css({'left':-size});
						img.eq(iFlag).css({'display':'none'});
						img.eq(nFlag).css({'left':size});
						iFlag = nFlag;
						options.leave(img.eq(clip), iFlag);
						options.arrive(img.eq(iFlag), iFlag);
						iBoolean = true;						
					});
					break;
				case('fade'):
					clip = iFlag;
					img.eq(iFlag).stop().fadeOut(speed);
					img.eq(nFlag).stop().fadeIn(speed, function(){
						iFlag = nFlag;
						options.leave(img.eq(clip), iFlag);
						options.arrive(img.eq(iFlag), iFlag);
						iBoolean = true;
					});
					break;
				default:
					break;
			}
		}

		var prevAc = function(pFlag){
			if (!iBoolean){return;}
			iBoolean = false;
			navAc(pFlag);

			switch(type){
				case('slide'):
					clip = iFlag;
					img.eq(iFlag).css({'display':'block','left':size});
					img.eq(pFlag).css({'display':'block','left':0});
					imgs.stop().animate({'left':0}, speed, function(){
						imgs.css({'left':-size});
						img.eq(iFlag).css({'display':'none'});
						img.eq(pFlag).css({'left':size});
						iFlag = pFlag;
						options.leave(img.eq(clip), iFlag);
						options.arrive(img.eq(iFlag), iFlag);
						iBoolean = true;
					});
					break;
				case('fade'):
					clip = iFlag;
					img.eq(iFlag).stop().fadeOut(speed);
					img.eq(pFlag).stop().fadeIn(speed, function(){
						iFlag = pFlag;
						options.leave(img.eq(clip), iFlag);
						options.arrive(img.eq(iFlag));
						iBoolean = true;
					});
					break;
				default:
					break;
			}
		}

		var start = function(){
			sInterval = setInterval(function(){
				if(iFlag < max-1){
					nextAc(iFlag+1);
				}else{
					nextAc(0);
				}
			}, delay);
		}

		var stop = function(){
			clearInterval(sInterval);
		}

		if(options.auto)
			start();

		area.mouseover(function(){stop();});
		area.mouseleave(function(){
			if(options.auto)
				start();
			else
				return;
		});

		next.click(function(){
			if(iFlag < max-1)
				nextAc(iFlag+1);
			else
				nextAc(0);
		});

		prev.click(function(){
			if(iFlag > 0)
				prevAc(iFlag-1);
			else
				prevAc(max-1);
		});

		nav.click(function(){
			if(this.num == iFlag)
				return;
			else if(this.num > iFlag)
				nextAc(this.num);
			else
				prevAc(this.num);
		});
	}	
})(jQuery);

