F1GENZ.Customer = { 
	init: function(){
		this.loginTabs();
		this.sidebar();
		this.addresses();
	},
	loginTabs: function(){
		switch(window.location.hash){
			case '#recover':
				$('#auth-form').removeClass('login-layout recover-layout').addClass('recover-layout');
				break;
			case '#login':
				$('#auth-form').removeClass('login-layout recover-layout').addClass('login-layout');
				break;
		}
		$('body').on('click', '.auth-layout-trigger', function(e){
			e.preventDefault();
			var layout = $(this).attr('data-layout');
			$('#auth-form').removeClass('login-layout recover-layout').addClass(layout);
		})
	},
	sidebar: function(){
		var path = window.location.pathname;
		var s = window.location.search;
		$('.account-sidebar-menu a[href="'+path+s+'"]').addClass('active');
		if(path.indexOf('/account/orders/') !== -1){
			$('.account-sidebar-menu a[href="/account?view=orders"]').addClass('active');
		}
	},
	addresses: function(){

		(function (window) {
			var allProvince = [];
			var allDistrict = [];
			var allWard = [];
			var loadedData = false;

			function setProvince(zone, province) {
				$province = $("select[data-address-type='province'][data-address-zone='" + zone + "']");
				if (!$province) {
					return;
				}
				var list = ['<option value="" hidden>---</option>'];
				for (var i = 0; i < allProvince.length; i++) {
					var p = allProvince[i];
					if (p.name == province) {
						list.push("<option value='" + p.name + "' selected>" + p.name + "</option>");
						continue;
					}
					list.push("<option value='" + p.name + "'>" + p.name + "</option>");
				}

				$province.html(list.join(''));
			};

			function setDistrict(zone, province, district) {
				var $district = $("select[data-address-type='district'][data-address-zone='" + zone + "']");
				if (!$district) {
					return;
				}
				if (!province) {
					$district.val('');
					$district.attr('disabled', 'disabled');
					$district.html('');
					return;
				}
				var provinceObj = allProvince.find(function(p) { return p.name == province; });
				var districts = allDistrict.filter(function (d) { return d.province_id == provinceObj.id; });
				var list = ['<option value="" hidden>---</option>'];
				for (var i = 0; i < districts.length; i++) {
					var d = districts[i];
					if (d.name == district) {
						list.push("<option value='" + d.name + "' selected>" + d.name + "</option>");
						continue;
					}
					list.push("<option value='" + d.name + "'>" + d.name + "</option>");
				}
				$district.removeAttr('disabled');
				$district.html(list.join(''));
			};

			function setWard(zone, district, ward) {
				var $ward = $("select[data-address-type='ward'][data-address-zone='" + zone + "']");
				if (!$ward) {
					return;
				}
				if (!district) {
					$ward.val('');
					$ward.attr('disabled', 'disabled');
					$ward.html('');
					return;
				}
				var list = ['<option value="" hidden>---</option>'];
				var districtObj = allDistrict.find(function(d) { return d.name == district; });
				var wards = allWard.filter(function (w) { return w.district_id == districtObj.id; });
				for (var i = 0; i < wards.length; i++) {
					var w = wards[i];
					if (w.name == ward) {
						list.push("<option value='" + w.name + "' selected>" + w.name + "</option>");
						continue;
					}
					list.push("<option value='" + w.name+ "'>" + w.name + "</option>");
				}
				$ward.removeAttr('disabled');
				$ward.html(list.join(''));
			};


			function loadData() {
				if (loadedData) {
					return {
						then: function (f) {
							return f();
						}
					};
				}
				return fetch('/checkout/addresses.json')
					.then(function (rs) { return rs.json(); })
					.then(function (rs) {
					allProvince = rs.provinces;
					allDistrict = rs.districts;
					allWard = rs.wards;
					loadedData = true;
				});
			};

			function Address() {

			}

			function triggerChange(zone, type) {
				$('select[data-address-type="' + type + '"][data-address-zone="' + zone + '"]').trigger('address:change');
			}

			Address.prototype.bind = function () {
				$('body')
					.on('change', 'select[data-address-type]', function (e) {
					var type = e.target.getAttribute('data-address-type');
					var zone = e.target.getAttribute('data-address-zone');
					if (type === 'province') {
						triggerChange(zone, 'province');
						setDistrict(zone, e.target.value, undefined);
						triggerChange(zone, 'district');
						setWard(zone, '', undefined);
						triggerChange(zone, 'ward');
					} else if (type === 'district') {
						triggerChange(zone, 'district');
						setWard(zone, e.target.value, undefined);
						triggerChange(zone, 'ward');
					}
				})
				return this;
			};

			Address.prototype.refresh = function (callback) {
				var zones = {};
				$('[data-address-zone]').each(function () {
					var $this = $(this);
					var type = $this.data('address-type');
					if (!type) {
						return;
					}
					var zoneName = $this.data('address-zone');
					var zone = zones[zoneName] || (zones[zoneName] = {});
					zone[type] = $this.val() || $this.attr('value');
				});
				var zoneNames = Object.keys(zones);
				if (zoneNames.length == 0) {
					return;
				}
				loadData().then(function () {
					zoneNames.forEach(function (zoneName) {
						var zone = zones[zoneName];
						setProvince(zoneName, zone.province);
						triggerChange(zoneName, 'province');
						setDistrict(zoneName, zone.province, zone.district);
						triggerChange(zoneName, 'district');
						setWard(zoneName, zone.district, zone.ward);
						triggerChange(zoneName, 'ward');
					});
					if (callback) {
						callback();
					}
				});
			};

			window.Address = new Address();

		})(window)

		$('body').on('click', '#acc-edit', function(){
			var formID = $(this).attr('data-form');
			$(`#${formID}`).modal();
			$('.mySelect2').each(function(){
				var old = $(this).attr('data-default');			  
				$(this).val(old);
				$(this).change();
			})
			if($(`#${formID} select[name='Country'] option:selected`).val() != 'Vietnam'){
				$('.not-vn').addClass('d-none');
			}else {
				$('.not-vn').removeClass('d-none');
			}
			Address.bind().refresh();
		})
		$('body').on('click', '#acc-remove', function(){
			var id = $(this).parents('.addresses-item').attr('data-id');
			swal({
				title: "",
				text: "Bạn có chắc muốn xóa địa chỉ này chứ?",
				confirmButtonText: 'Xác nhận',
				showCancelButton: true,
				cancelButtonText: 'Hủy bỏ!',
			}, (result) => {
				if(result){
					Bizweb.postLink(`/account/deleteAddress/${id}`);
				}
			});
		})

		$('body').on('click', '#acc-new', function(){
			$('#addresses-new-modal').modal();
			$('.mySelect2').each(function(){
				var old = $(this).attr('data-default');			  
				$(this).val(old);
				$(this).change();
			})
			if($("#addresses-new-modal select[name='Country'] option:selected").val() != 'Vietnam'){
				$('.not-vn').addClass('d-none');
			}else {
				$('.not-vn').removeClass('d-none');
			}
			Address.bind().refresh();
		})

		$("select[name='Country']").change(function(){
			if( $(this).val() != 'Vietnam'){
				$('.not-vn').addClass('d-none');
			}else {
				$('.not-vn').removeClass('d-none');
			}
		}); 

		$('.field').click(function(){
			$(this).find('input').focus();
		});

		$('#addresses-new-modal select').val("Vietnam");
	}
};
F1GENZ.Customer.init();