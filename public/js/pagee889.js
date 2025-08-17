F1GENZ.page_contact = {
	init: function(){
		$('body').on('click', '.page-about-new form button', function(e){
			e.preventDefault();
			F1GENZ.Helper.postForm('.page-about-new', window.F1GENZ_vars.shop.url + '/postcontact');
			swal({
				title: "Cảm ơn bạn!",
				text: "Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất",
				type: "success"
			}, function() {
				window.location.href = "/";
			});
		})
	}
}
F1GENZ.page_contact.init();