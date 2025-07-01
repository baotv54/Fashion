F1GENZ.Collection = { 
	selectedSortby: null,
	filter: new Bizweb.SearchFilter(),
	init: function(){
		this.action();
		!window.location.href.includes('?utm') && this.filterCurrent();
		if(window.F1GENZ_vars.collection.featured == "horizontal") this.horizontal();
		if(window.F1GENZ_vars.collection.featured == "vertical") this.vertical();
	},
	horizontal: function(){
		$('body').on('click', '.shop-filter h4', function(){
			$(this).parent().toggleClass('active');
			if($(window).width() > 1024){
				$('body, html').toggleClass('open-noscroll open-overplay');
			}else{
				$(this).next().slideToggle();
			}
		})
	},
	vertical: function(){
		$('body').on('click', '.shop-filter h4', function(){
			$(this).parent().toggleClass('active');
			if($(window).width() <= 1024) $(this).next().slideToggle();
		})
	},
	action: function(){
		var self = this;
		if(localStorage.getItem("view_grid") == null){
			$('.main-collection .main-collection-data').addClass('four');
			localStorage.setItem("view_grid", 'four');
		}else{
			$('.main-collection .main-collection-data').addClass(localStorage.getItem("view_grid"));
			$(`.shop-sort-style .shop-sort-item[data-show="${localStorage.getItem("view_grid")}"]`).addClass('active').siblings().removeClass('active');
		}
		// Mobile
		$('body').on('click', '.shop-filter-mobile-btn button[data-type="shop-filter-mobile-btn"]', function(){
			$('body, html').toggleClass('open-noscroll open-overplay open-filter-mobile');
		})
		
		$('body').on('click', 'button[data-type="close-filter-mobile"]', function(){
			$('body, html').removeClass('open-noscroll open-overplay open-filter-mobile');
		})
		

		// Sort type
		$('body').on('click', '.shop-sort-style .shop-sort-item[data-show]', function(){
			var show = $(this).attr('data-show');
			if(show == "four") $(this).parent().find('[data-show="three"]').removeClass('left_zero');
			if(show == "one") $(this).parent().find('[data-show="three"]').addClass('left_zero');
			$(this).addClass('active').siblings().removeClass('active');
			$('.main-collection .main-collection-data').removeClass('one two three four');
			$('.main-collection .main-collection-data').addClass(show);
			localStorage.setItem("view_grid", show);
		})

		// Sort by
		$('body').on('change', '.shop-sort-by select', function(e){
			e.preventDefault();
			self.selectedSortby = $('.shop-sort-by select').val();
			self.buildQuery(1);
		})

		// Remove All Choose 
		$('body').on('click', '.shop-filter-choose label button[data-type="shop-filter-choose-remove"]', function(){
			$('.shop-filter .shop-filter-list .shop-filter-item input:checked').prop('checked', false);
			self.filter = new Bizweb.SearchFilter();
			self.renderChoosen('reset');
			self.buildQuery(1);
		})
		
		// Remove Choose 
		$('body').on('click', '.shop-filter-choose li', function(){
			debugger;
			var group = $(this).attr("data-group");
			var field = $(this).attr("data-field");
			var value = $(this).attr("data-value"); 
			var operator = $(this).attr("data-operator");
			$(`.shop-filter .shop-filter-list .shop-filter-item input[data-group="${group}"][data-field="${field}"][value="${value}"][data-operator="${operator}"]`).trigger("click");
		})

		// Filter Query
		$('body').on('click', '.shop-filter .shop-filter-list .shop-filter-item input', function(){
			var group = $(this).attr("data-group");
			var field = $(this).attr("data-field");
			var value = $(this).attr("value");
			var operator = $(this).attr("data-operator");
			var text = $(this).attr('data-text');
			if (!$(this).is(':checked')) {
				self.filter.deleteValue(group, field, value, operator);
				self.renderChoosen('delete', group, field, value, operator, text);
			}
			else{
				self.filter.addValue(group, field, value, operator); 
				self.renderChoosen('add', group, field, value, operator, text);
			}
			self.buildQuery(1);
		})
		$('body').on('click', '.shop-pagination.filter a', function(e){
			e.preventDefault();
			var choosenPage = $(this).attr('data-page');
			self.buildQuery(choosenPage);
		})
	},
	buildQuery: function(page){
		var self = this;
		var colId = $('.main-collection').data('id');
		if(colId > 0) self.filter.addValue("collection", "collections", colId, "AND");
		self.filter.search({
			view: 'filter',
			page: page,
			sortby: self.selectedSortby,
			success: function(data){
				$('.main-collection .main-collection-data').html('').append(data);
				$('.shop-pagination').addClass('filter');
				self.pushCurrentFilterState({ sortby: self.selectedSortby, page: page });
			}
		});
	},
	renderChoosen: function(type, group, field, value, operator, text){
		var self = this;
		if(type == 'add'){
			var htmlRender = `<li data-group="${group}" data-field="${field}" data-value="${value}" data-operator="${operator}">${text} <svg class="Icon Icon--close" role="presentation" viewBox="0 0 16 14" width="15" height="15"><path d="M15 0L1 14m14 0L1 0" stroke="currentColor" fill="none" fill-rule="evenodd"></path></svg></li>`
			$('.shop-filter-choose .shop-filter-choose-data').append(htmlRender)
			$('.shop-filter-choose').slideDown();
		}else if(type == 'delete'){
			$('.shop-filter-choose .shop-filter-choose-data').find(`li[data-group="${group}"][data-field="${field}"][data-value="${value}"][data-operator="${operator}"]`).remove();
			if($('.shop-filter-choose .shop-filter-choose-data li').length == 0) $('.shop-filter-choose').slideUp();
		}else{
			$('.shop-filter-choose .shop-filter-choose-data li').remove();
			$('.shop-filter-choose').slideUp();
		}
	},
	pushCurrentFilterState: function(options) {
		var self = this;
		if(!options) options = {};
		$('.shop-sort-by select').val(options.sortby);
		var url = self.filter.buildSearchUrl(options);
		var queryString = url.slice(url.indexOf('?'));			  
		window.history.pushState({
			turbolinks: true,
			url: queryString
		}, null, queryString);
	},
	filterCurrent: function(){
		var self = this;
		var isFilter = false;
		var url = window.location.href;
		var queryString = decodeURI(window.location.search);
		var filters = queryString.match(/\(.*?\)/g);
		var page = 0;
		if(queryString){
			isFilter = true;
			$.urlParam = function(name){
				var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
				return results ? results[1] : 0;
			}
			page = $.urlParam('page');
		}
		if(filters && filters.length > 0){
			filters.forEach(function(item){
				item = item.replace(/\(\(/g, "(");
				var element = $(".shop-filter input[value='" + item + "']");
				$(".shop-filter input[value='" + item + "']").trigger('click');
			});
			isFilter = true;
		}
		var sortOrder = self.getParameter(url, "sortby");
		if(sortOrder){
			self.selectedSortby = sortOrder;
			$('.shop-sort-by select').val(sortOrder);
		}
		if(isFilter){
			self.buildQuery(page);
		}
	},
	getParameter: function(url, name){
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
};
F1GENZ.Collection.init();