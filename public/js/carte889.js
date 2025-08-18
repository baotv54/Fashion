F1GENZ.Cart = {
	init: function(){
		this.none_item();
		this.full_item();
		this.invoice();
	},
	full_item: function(){
		// Change quantity
		$('body').on('change', '.main-cart .main-cart-data-full-item input[name*="quantity_"]', function(){ 
			var data = {};
			$('.main-cart .shop-quantity input').each(function(){
				data[$(this).attr('data-vid')] = $(this).val();
			})
			$.ajax({
				type: 'POST',
				url: '/cart/update.js',
				dataType: 'json',
				data: {
					updates: data
				},
				success: function(cart){
					$(".main-cart-data-full-total-sub-price span").html(Bizweb.formatMoney(cart.total_price, window.F1GENZ_vars.formatMoney));
				},
				error: function(error){}
			})
		});
		// Checkout
		$('body').on('click', 'a[href="/checkout"]', function(e){
			e.preventDefault(); 
			let object_cart = {};
			if($('input#main-cart-data-full-invoice').is(':checked')){
				var flagAttr = {};
				flagAttr[$("#main-cart-data-full-invoice-data-company").attr('name')] = $("#main-cart-data-full-invoice-data-company").val();
				flagAttr[$("#main-cart-data-full-invoice-data-tax").attr('name')] = $("#main-cart-data-full-invoice-data-tax").val();
				flagAttr[$("#main-cart-data-full-invoice-data-address").attr('name')] = $("#main-cart-data-full-invoice-data-address").val();
				flagAttr[$("#main-cart-data-full-invoice-data-name").attr('name')] = $("#main-cart-data-full-invoice-data-name").val();
				object_cart = {
					note: $("textarea#main-cart-data-full-note").val(),
					attributes: flagAttr
				}
			}else object_cart.note = $("textarea#main-cart-data-full-note").val();
			$.ajax({
				type: 'POST',
				url: '/cart/update.js',
				async: false,
				data: object_cart,
				dataType: 'json',
				success: (cart) => { window.location.href = '/checkout'; },
				error: (XMLHttpRequest, textStatus) => { swal("Oppz..", "Vui lòng thử lại sau", "error") }
			});
		});
	},
	invoice: function(){
		$('body').on('change', 'input#main-cart-data-full-invoice', function(e){
			var $dom = $(this).parent().next();
			e.currentTarget.checked ? $dom.slideDown(300) : $dom.slideUp(300);
		})
	},
	none_item: function(){
		if($('.main-cart .main-cart-data .main-cart-data-none').length > 0){
			$('.main-cart .main-cart-data .main-cart-data-none form input[name="q"]').placeholderTypewriter({
				text: ["Tìm kiếm sản phẩm ...", "Bạn cần tìm gì ...?", "Nhập tên sản phẩm cần tìm ..."]
			});

			$('body').on('submit', '.main-cart .main-cart-data .main-cart-data-none form', function(e){
				e.preventDefault();
				var value = $(this).find('input[name="q"]').val();
				window.location.href = '/search?q=filter=((collectionid:product>=0)%26%26(title:product%20contains%20' + encodeURIComponent(value) + '))';
			})
		}
	},
}
F1GENZ.Cart.init();