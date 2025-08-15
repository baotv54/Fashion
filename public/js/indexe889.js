/* JS Cookies v3.14.1. */
!function(e){var n;if("function"==typeof define&&define.amd&&(define(e),n=!0),"object"==typeof exports&&(module.exports=e(),n=!0),!n){var t=window.Cookies,o=window.Cookies=e();o.noConflict=function(){return window.Cookies=t,o}}}(function(){function e(){for(var e=0,n={};e<arguments.length;e++){var t=arguments[e];for(var o in t)n[o]=t[o]}return n}function n(e){return e.replace(/(%[0-9A-Z]{2})+/g,decodeURIComponent)}return function t(o){function r(){}function i(n,t,i){if("undefined"!=typeof document){"number"==typeof(i=e({path:"/"},r.defaults,i)).expires&&(i.expires=new Date(1*new Date+864e5*i.expires)),i.expires=i.expires?i.expires.toUTCString():"";try{var c=JSON.stringify(t);/^[\{\[]/.test(c)&&(t=c)}catch(e){}t=o.write?o.write(t,n):encodeURIComponent(String(t)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),n=encodeURIComponent(String(n)).replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent).replace(/[\(\)]/g,escape);var f="";for(var u in i)i[u]&&(f+="; "+u,!0!==i[u]&&(f+="="+i[u].split(";")[0]));return document.cookie=n+"="+t+f}}function c(e,t){if("undefined"!=typeof document){for(var r={},i=document.cookie?document.cookie.split("; "):[],c=0;c<i.length;c++){var f=i[c].split("="),u=f.slice(1).join("=");t||'"'!==u.charAt(0)||(u=u.slice(1,-1));try{var a=n(f[0]);if(u=(o.read||o)(u,a)||n(u),t)try{u=JSON.parse(u)}catch(e){}if(r[a]=u,e===a)break}catch(e){}}return e?r[e]:r}}return r.set=i,r.get=function(e){return c(e,!1)},r.getJSON=function(e){return c(e,!0)},r.remove=function(n,t){i(n,"",e(t,{expires:-1}))},r.defaults={},r.withConverter=t,r}(function(){})});
F1GENZ.Index = {
	init: function(){
		if(!window.noPS) return false;
		F1GENZ.Helper.productSlider('#home-slider .home-slider-main', 1, 1, 1, 1, {	infinite: true, autoplay: true, fade: true });
		F1GENZ.Helper.productSlider('.home-fSale .home-fSale-body .home-fSale-body-data', 4, 3, 2, 1, { autoplay: true, infinite: false }); 
		F1GENZ.Helper.productSlider('.home-product-slider .home-product-slider-wrap-body', 4, 3, 2, 2, { infinite: true, autoplay: true });
		F1GENZ.Helper.productSlider('.home-blog .home-blog-body', 3, 2, 2, 1, { infinite: true, autoplay: true });
		F1GENZ.Helper.productSlider('.home-insta .home-insta-mid', 4.5, 3.5, 2.5, 1.5);
		this.homeFSale();
		this.homeCoupon();
		this.homeLetter();
	},
	homeFSale: function(){
		var listItems = [];
		if(Cookies.getJSON('hasfSale') == null){ 
			$('.home-fSale .product-item.special').each(function(){
				var listItem = {
					countItem: Math.floor(Math.random() * 10) + 90,
					countRest: Math.floor(Math.random() * 141) + 60,
					countPercent: Math.floor(Math.random() * 36) + 60,
				}
				listItems[listItems.length] = listItem;
				if($(this).find('.fSale_chayhang').length > 0) {
					$(this).find('.product-item-sold label span').html(`Sắp cháy hàng!!!`)
					$(this).find('.product-item-sold-wrap span').attr('style', `--percent: ${listItem.countItem}%`);
				}else{
					$(this).find('.product-item-sold label span').html(`Còn lại ${listItem.countRest} sản phẩm`);
					$(this).find('.product-item-sold-wrap span').attr('style', `--percent: ${listItem.countPercent}%`);
				}
			})
			Cookies.set('hasfSale', listItems, { expires: 0.04, sameSite: 'None', secure: true });
		}else{
			var data = Cookies.getJSON('hasfSale');
			$('.home-fSale .product-item.special').each(function(i, v){
				if($(this).find('.fSale_chayhang').length > 0) {
					$(this).find('.product-item-sold label span').html(`Sắp cháy hàng!!!`)
					$(this).find('.product-item-sold-wrap span').attr('style', `--percent: ${data[i].countItem}%`);
				}else{
					$(this).find('.product-item-sold label span').html(`Còn lại ${data[i].countRest} sản phẩm`);
					$(this).find('.product-item-sold-wrap span').attr('style', `--percent: ${data[i].countPercent}%`);
				}
			})
		}
	},
	homeCoupon: function(){
		$('body').on('click','button[data-type="coupon-policy"]', function() {
			const code = $(this).data('coupon')
			const info = $(this).find('.home-coupon-content-info').html() || ''
			const title = $(this).parents('.home-coupon-item').find('.home-coupon-content-head h3').text() || ''
			const couponHtml = `
<a href="javascript:void(0);"  data-dismiss="modal" aria-label="Close" class="closeModal"><i class="lni lni-close"></i></a>
<div class="coupon-title">${title}</div>
<div class="coupon-label">Mã khuyến mãi:<span class="code">${code}</span></div>
<div class="coupon-content">Điều kiện:<div class="coupon-info">${info}</div></div>
<div class="coupon-action">
<button type="button" class="btn btn-main" data-dismiss="modal" data-backdrop="false" aria-label="Close" style="z-index: 9;">Đóng</button>
<button type="button" class="btn btn-main" data-type="coupon-copy" data-coupon="${code}">
<span>Sao chép mã</span></button>
</div>
`
			$('#modal-coupon .modal-content').html(couponHtml)
			$("#modal-coupon").modal();
		})
		$('body').on('click','button[data-type="coupon-copy"]', function() {
			const copyText = "Sao chép mã";
			const copiedText = "Đã sao chép";
			const coupon = $(this).data().coupon;
			const _this = $(this);
			_this.html(`<span>${copiedText}</span>`);
			_this.addClass('disabled');
			setTimeout(function() {
				_this.html(`<span>${copyText}</span>`);
				_this.removeClass('disabled');
			}, 3000)
			navigator.clipboard.writeText(coupon);
		})
	},
	homeLetter: function(){
		$('.home-newletter #mc-form10 input[type="email"]').placeholderTypewriter({
			text: ["Bạn cần tư vấn?", "Nhập địa chỉ email của bạn..."]
		});
		$('.home-newletter #mc-form10').ajaxChimp({
			language: 'en',
			callback: mailChimpResponse,
			url: $(this).attr('action')
		});
		function mailChimpResponse(resp) {
			if (resp.result === 'success') {
				if(resp.msg == 'Thank you for subscribing!'){
					swal("", "Cảm ơn bạn đã đăng ký nhận tin", "success");
				}else{
					swal("", String(resp.msg), "success");
				}
				$('.home-newletter #mc-form10 input').val("");
			} else if (resp.result === 'error') {
				debugger;
				if(resp.msg == '0 - Please enter a value'){
					swal("Oppz...", "Vui lòng nhập các trường thông tin", "error");
				}else if(resp.msg == '0 - An email address must contain a single @.'){
					swal("Oppz...", "Địa chỉ email phải chứa ký tự @", "error");
				}else if(resp.msg == 'This email cannot be added to this list. Please enter a different email address.'){
					swal("Oppz...", "Email này không thể được thêm vào danh sách này. Vui lòng nhập một địa chỉ email khác.", "error");
				}else if(resp.msg.includes('0 - The domain portion of the email address is invalid')){
					swal("Oppz...", "Phần tên miền của địa chỉ email không hợp lệ", "error");
				}else if(resp.msg.includes('0 - The username portion of the email address is empty')){
					swal("Oppz...", "Phần tên người dùng của địa chỉ email trống", "error");
					$('.mailchimp-error').html('Phần tên người dùng của địa chỉ email trống').fadeIn(900);
				}else if(resp.msg == 'Thank you for subscribing!'){
					swal("", "Cảm ơn bạn đã đăng ký!", "success");
				}else{
					swal("Oppz...", String(resp.msg), "error");
				}
			}
		};
	} 
};
F1GENZ.Index.init();