$(document).ready(function(){

   if($('.datepicker').length){
      $('.datepicker').datetimepicker({
         minDate:new Date()
      });
   }

   if($('.nice-select').length){
      $('.nice-select').niceSelect();
   }


	$(document).on('click','.clone-btn', function(){
		let _this = $(this);
		let quantity = parseInt($('#quantity').val());
		let id = [];
		$('.checkbox-item:checked').each(function(){
			let _this = $(this);
		 	id.push(_this.val());
		});
		if(quantity > 0){
			if(id.length > 0){
				swal({
					title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
					text: 'Sao chép các bản ghi được chọn',
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Thực hiện!",
					cancelButtonText: "Hủy bỏ!",
					closeOnConfirm: false,
					closeOnCancel: false },
				function (isConfirm) {
					if (isConfirm) {
						var formURL = 'ajax/dashboard/clone_all';
						$.post(formURL, {
							id: id, module: _this.attr('data-module'), quantity: $('#quantity').val()},
							function(data){
								if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									swal("Sao chép thành công!", "Các bản ghi đã được sao chép.", "success");
									window.location.reload()
								}
							});
					} else {
						swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
					}
				});
			}
			else{
				sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
			}
		}else{
			sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải nhập số lượng để thực hiện chức năng này');
		}
		return false;
	});

	$(document).ready(function(){
		let star_val = $('.data-rate').val()
		$("input[name=data-rate][value=" + star_val + "]").attr('checked', 'checked');
	})
	jQuery(document).ready(function() {
	  	jQuery("time.timeago").timeago();
	});
	$( function() {
		$( ".sortui" ).sortable();
		$( ".sortui" ).disableSelection();
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
		$( ".ui-sortable" ).sortable();
		$( ".ui-sortable" ).disableSelection();
		$( ".sort-modal" ).sortable();
		$( ".sort-modal" ).disableSelection();
	});
	if($('input[name="daterange"]').length > 0){
 		$('input[name="daterange"]').daterangepicker();
	}
	if($('.tagsinput').length > 0){
		$('.tagsinput').tagsinput({
	        tagClass: 'label label-primary',
	        confirmKeys: [13, 188],
	        cancelConfirmKeysOnEmpty: false,
	    });
	}

	$(document).on('click','.ui-state-default .thumb .fa-trash', function(){
		let _this = $(this);
		_this.parents('.ui-state-default').remove();
		if($('#sortable li').length == 0){
			$('.click-to-upload').show();
   		 	$('.upload-list').hide();
		}
	});


	$('.datetimepicker').datepicker({
		todayBtn: "linked",
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true,
		dateFormat: "yy-mm-dd"
	});




	if($('.select2').length){
		$('.select2').select2();
	}

	if($('.selectMultiple').length){
		$('.selectMultiple').each(function(){
			let _this = $(this);
			let select = _this.attr('data-select');
			let module = _this.attr('data-module');
			let join = _this.attr('data-join');
			let key = _this.attr('data-key');


			setTimeout(function(){
				if(catalogue != ''){
					$.post('ajax/dashboard/pre_select2', {
						value: catalogue, module: module, select: select, join: join, key: key},
						function(data){
							let json = JSON.parse(data);
							if(json.items!='undefined' && json.items.length){
								for(let i = 0; i< json.items.length; i++){
									var option = new Option(json.items[i].text, json.items[i].id, true, true);
									_this.append(option).trigger('change');
								}
							}
						});
				}
			}, 10);

			get_select2(_this);
		});
	}


	$('.ck-editor').each(function(){
		ckeditor5($(this).attr('id'));
	});

	$(document).on('click','.edit-seo', function(){
		$('.seo-group').toggleClass('hidden');
		return false;
	});

	$(document).ready(function(){
		$('.int').trigger('change')
	})

	$(document).on('click','.float, .int',function(){
		let data = $(this).val();
		if(data == 0){
			$(this).val('');
		}
	});
	$(document).on('keydown','.float, .int',function(e){
		let data = $(this).val();
		if(data == 0){
			let unicode=e.keyCode || e.which;
			if(unicode != 190){
				$(this).val('');
			}
		}
	});

	$(document).on('change keyup blur','.int',function(){
		let data = $(this).val();
		if(data == '' ){
			$(this).val('0');
			return false;
		}
		data = data.replace(/\./gi, "");
		$(this).val(addCommas(data));
		data = data.replace(/\./gi, "");
		if(isNaN(data)){
			$(this).val('0');
			return false;
		}
	});

	$(document).on('keyup', '.title', function(){
		let _this = $(this);
		let metaTitle = _this.val();
		get_catalogue(slug(metaTitle));
		let totalCharacter = metaTitle.length;
		console.log(totalCharacter);
		if(totalCharacter > 70){
			$('.meta-title').addClass('input-error');
		}else{
			$('.meta-title').removeClass('input-error');
		}
		$('.g-title').text(metaTitle);
		$('.meta-title').val(metaTitle);

	});

	$(document).on('change', '.get_catalogue', function(){
		let _this = $(this);
		let val = $('.title').val();
		let id = _this.val();
		let module = _this.attr('data-module')
		if(_this.val() == 0){
			val = slug(val);
			$('.canonical').val(val)
			$('.g-link').text(BASE_URL + val + '.html');
		}else{
			$.post('ajax/dashboard/get_catalogue', {
				id: id, module: module
			},
			function(data){
				val = slug(val)
				let new_text = data+'/'+val
				$('.canonical').val(new_text)
				$('.g-link').text(BASE_URL + new_text + '.html');
			});
		}
	})

	$(document).on('keyup','.canonical', function(){
		let _this = $(this);
		_this.attr('data-flag', '1');
		let slugTitle = slug(_this.val());
		$('.g-link').text(BASE_URL + slugTitle + '.html');
	});

	$(document).on('keyup change','.meta-title', function(){
		let _this = $(this);
		let totalCharacter = _this.val().length;
		$('#titleCount').text(totalCharacter);
		if(totalCharacter > 70){
			_this.addClass('input-error');
		}else{
			_this.removeClass('input-error');
		}
		$('.g-title').text(_this.val());
	});




	$(document).on('keyup change','.meta-description', function(){
		let _this = $(this);
		let totalCharacter = _this.val().length;
		$('#descriptionCount').text(totalCharacter);
		if(totalCharacter > 320){
			_this.addClass('input-error');
		}else{
			_this.removeClass('input-error');
		}
		$('.g-description').text(_this.val());
	});






	$(document).on('change', '#city', function(e, data){
		let _this = $(this);
		let id = _this.val();
		let param = {
			'id' : id,
			'text' : '[Chọn Quận/Huyện]',
			'table' : 'vn_district',
			'trigger_district': (typeof(data) != 'undefined') ? true : false,
			'where' : {'provinceid' : id},
			'select' : 'districtid as id, name',
			'object' : '#district',
		};
		get_location(param);
	});

	if(typeof(cityid) != 'undefined' && cityid != ''){
		$('#city').val(cityid).trigger('change', [{'trigger':true}]);
	}

	$(document).on('change', '#district', function(){
		let _this = $(this);
		let id = _this.val();
		let param = {
			'id' : id,
			'text' : '[Chọn Phường/Xã]',
			'table' : 'vn_ward',
			'where' : {'districtid' : id},
			'select' : 'wardid as id, name',
			'object' : '#ward',
		};
		get_location(param);
	});

	/* UPDATE ORDER */
	$(document).on('change', '.sort-order',function(){
		let _this = $(this);
		let id = [_this.attr('data-id')];

		let $module = _this.attr('data-module');
		let value = _this.val();
		let formURL = 'ajax/dashboard/update_by_field'
		setTimeout(function(){
			$.post(formURL, {
				id: id,module: $module, value:value, field : 'order'},
				function(data){

				});
		}, 200);


	});

	/* UPDATE STATUS */

	$(document).on('click','.td-status span', function(){
		let _this = $(this);
		let id = _this.parents('tr').attr('data-id');
		let field = _this.parent('td').attr('data-field');
		let $module = _this.parent('td').attr('data-module');
		var formURL = 'ajax/dashboard/update_field';
		_this.html(loading());

		setTimeout(function(){
			$.post(formURL, {
				id: id,module: $module, field:field},
				function(data){
					if(data == 0){
						sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
					}else{
						let json = JSON.parse(data);
						let text = (json.value == 1) ? '<span class="text-success">Active</span>' : '<span class="text-danger">Deactive</span>';
						_this.parent().html(text);
					}
				});
		}, 500);

		return false;
	});



	$(document).on('click','.status', function(){
		let _this = $(this);
		let param = {
			'module' : _this.attr('data-module'),
			'value' : _this.attr('data-value'),
			'field' : _this.attr('data-field'),
		};

		let id = [];
		$('.checkbox-item:checked').each(function(){
			let _this = $(this);
		 	id.push(_this.val());
		});

		if(id.length > 0){
			swal({
				title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
				text: _this.attr('data-title'),
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Thực hiện!",
				cancelButtonText: "Hủy bỏ!",
				closeOnConfirm: false,
				closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					var formURL = 'ajax/dashboard/update_by_field';
					$.post(formURL, {
						id: id,module: param.module, field:param.field, value:param.value},
						function(data){
							if(data == 0){
									sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
								}else{
									for(let i = 0; i < id.length; i++){
										let text = (param.value == 1) ? '<span class="text-success">Active</span>' : '<span class="text-danger">Deactive</span>';
										$('#post-'+id[i]).find('.td-status').html(text);
									}
									swal("Thành công!", "Thao tác thực hiện thành công!", "success");
								}
						});
				} else {
					swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
				}
			});
		}
		else{
			sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
			return false;
		}
		return false;
	});

	/* CHECKBOX - CHECKALL */
	$(document).on('click','.label-checkboxitem',function(){
		let _this = $(this);
		_this.parent().find('.checkbox-item').trigger('click');
		check(_this);
		change_background(_this);
		check_item_all(_this);
		check_setting();
	});

	$(document).on('click','.labelCheckAll',function(){
		let _this = $(this);
		_this.siblings('input').trigger('click');
		check(_this);
		checkall(_this);
		change_background();
		check_setting();
	});
});

$(document).on('click','.open-window', function(){
	let _this = $(this);
	let target = _this.attr('target');
	js_open_windown(this, _this, target);
	return false;
});


function get_location(param){
	if(districtid == '' || param.trigger_district == false) districtid = 0;
	if(wardid == ''  || param.trigger_ward == false) wardid = 0;

	let formURL = 'ajax/dashboard/get_location';
	$.post(formURL, {
		param: param},
		function(data){
			let json = JSON.parse(data);
			if(param.object == '#district'){
				$(param.object).html(json.html).val(districtid).trigger('change');
			}else if(param.object == '#ward'){
				$(param.object).html(json.html).val(wardid);
			}

		});
}

function get_catalogue(val = ''){
	let data ='';
	val = slug(val);
	let id = $('.get_catalogue').val();
	let module = $('.get_catalogue').attr('data-module');
	let canonical = $('.canonical');
	if(id == 0 || id == undefined){
		val = slug(val)
		$('.g-link').text(BASE_URL + val + '.html');
		$('.canonical').val(val)
	}else{
		$.post('ajax/dashboard/get_catalogue', {
			id: id, module: module
		},
		function(data){
			val = slug(val)
			let new_text = data+'/'+val
			$('.canonical').val(new_text)
			$('.g-link').text(BASE_URL + new_text + '.html');

		});
	}


}


/* CHECKBOX */
function check(object){
	if(object.hasClass('checked')){
		object.removeClass('checked');
	}else{
		object.addClass('checked');
	}
}



function checkall(_this){
	let table = _this.parents('table');
	if($('#checkbox-all').length){
		if(table.find('#checkbox-all').prop('checked')){
			table.find('.checkbox-item').prop('checked', true);
			table.find('.label-checkboxitem').addClass('checked');

		}
		else{
			table.find('.checkbox-item').prop('checked', false);
			table.find('.label-checkboxitem').removeClass('checked');
		}
	}
	check_setting();
}

function check_item_all(_this){
	let table = _this.parents('table');
	if(table.find('.checkbox-item').length) {
		if(table.find('.checkbox-item:checked').length == table.find('.checkbox-item').length) {
			table.find('#checkbox-all').prop('checked', true);
			table.find('.labelCheckAll').addClass('checked');
		}
		else{
			table.find('#checkbox-all').prop('checked', false);
			table.find('.labelCheckAll').removeClass('checked');
		}
	}
}

function check_setting(){
	if($('.checkbox-item').length) {
		if($('.checkbox-item:checked').length > 0) {
			$('.fa-cog').addClass('text-pink');
		}
		else{
			$('.fa-cog').removeClass('text-pink');
		}
	}
}

function check_setting(){
	if($('.checkbox-item').length) {
		if($('.checkbox-item:checked').length > 0) {
			$('.fa-wrench').addClass('text-pink');
		}
		else{
			$('.fa-wrench').removeClass('text-pink');
		}
	}
}

function change_background() {
	$('.checkbox-item').each(function() {
		if($(this).is(':checked')) {
			$(this).parents('tr').addClass('bg-active');
		}else {
			$(this).parents('tr').removeClass('bg-active');
		}
	});
}

function pre(param){
}

function loading(){
	let loading = '<div class="spiner-example">';
       loading = loading + ' <div class="sk-spinner sk-spinner-wave">'
           loading = loading + ' <div class="sk-rect1"></div>'
           loading = loading + ' <div class="sk-rect2"></div>'
           loading = loading + ' <div class="sk-rect3"></div>'
            loading = loading + '<div class="sk-rect4"></div>'
            loading = loading + '<div class="sk-rect5"></div>'
        loading = loading + '</div>'
    loading = loading + '</div>'

    return loading;
}

function sweet_error_alert(title, message){
	swal({
		title: title,
		text: message
	});
}

function slug(title){
	title = cnvVi(title);
	return title;
}


function cnvVi(str) {
	str = str.toLowerCase(); // chuyen ve ki tu biet thuong
	str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
	str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
	str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
	str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
	str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
	str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
	str = str.replace(/đ/g, "d");
	str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'|\–| |\"|\&|\#|\[|\]|\\|\/|~|$|_/g, "-");
	str = str.replace(/-+-/g, "-");
	str = str.replace(/^\-+|\-+$/g, "");
	return str;
}
function replace(Str=''){
	if(Str==''){
		return '';
	}else{
		Str = Str.replace(/\./gi, "");
		return Str;
	}
}

function addCommas(nStr){
	nStr = String(nStr);
	nStr = nStr.replace(/\./gi, "");
	let str ='';
	for (i = nStr.length; i > 0; i -= 3){
		a = ( (i-3) < 0 ) ? 0 : (i-3);
		str= nStr.slice(a,i) + '.' + str;
	}
	str= str.slice(0,str.length-1);
	return str;
}


function get_select2(object,lang){
	let module = object.attr('data-module');
	let select = object.attr('data-select');
	let join = object.attr('data-join');
	let key = object.attr('data-key');
	$('.selectMultiple').select2({
		minimumInputLength: 2,
		placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
			ajax: {
				url: 'ajax/dashboard/get_select2',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,
						select: select,
						join: join,
						key: key,
                  catalogueid: catalogueid,

					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}

				},
				cache: true,
			}
	});
	// $('.selectAttribute').select2({
	// 	minimumInputLength: 2,
	// 	placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
	// 		ajax: {
	// 			url: 'ajax/dashboard/get_select2',
	// 			type: 'POST',
	// 			dataType: 'json',
	// 			deley: 250,
	// 			data: function (params) {
	// 				return {
	// 					locationVal: params.term,
	// 					module:module,
	// 					select: select,
	// 					join: join,

	// 				};
	// 			},
	// 			processResults: function (data) {
	// 				return {
	// 					results: $.map(data, function(obj, i){
	// 						return obj
	// 					})
	// 				}

	// 			},
	// 			cache: true,
	// 		}
	// });
	// $('.selectMultiplePanel').select2({
	// 	minimumInputLength: 2,
	// 	placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
	// 		ajax: {
	// 			url: 'ajax/dashboard/get_select2',
	// 			type: 'POST',
	// 			dataType: 'json',
	// 			deley: 250,
	// 			data: function (params) {
	// 				return {
	// 					locationVal: params.term,
	// 					module:module,
	// 					select: select,
	// 					join: join,
	// 					language:lang
	// 				};
	// 			},
	// 			processResults: function (data) {
	// 				return {
	// 					results: $.map(data, function(obj, i){
	// 						return obj
	// 					})
	// 				}

	// 			},
	// 			cache: true,
	// 		}
	// });
}

function get_select2_multiple(object,lang){
	let module = object.attr('data-module');
	let select = object.attr('data-select');
	let join = object.attr('data-join');

	$('.selectMultiplePanel').select2({
		minimumInputLength: 2,
		placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
			ajax: {
				url: 'ajax/dashboard/get_select2',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,
						select: select,
						join: join,
						language:lang
					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}

				},
				cache: true,
			}
	});
}

function get_select2_panel(object,lang){
	let module = object.attr('data-module');
	let select = object.attr('data-select');
	let join = object.attr('data-join');
	$('.selectAttribute').select2({
		minimumInputLength: 2,
		placeholder: 'Nhập tối thiểu 2 ký tự để tìm kiếm',
			ajax: {
				url: 'ajax/dashboard/get_select2',
				type: 'POST',
				dataType: 'json',
				deley: 250,
				data: function (params) {
					return {
						locationVal: params.term,
						module:module,
						select: select,
						join: join,

					};
				},
				processResults: function (data) {
					return {
						results: $.map(data, function(obj, i){
							return obj
						})
					}

				},
				cache: true,
			}
	});
}
