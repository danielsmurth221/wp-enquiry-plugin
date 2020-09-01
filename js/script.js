(function($) {

	"use strict";

	// Submit enquiry form
	$('.enquiry-form').on('submit', function(e) {
		e.preventDefault();

		var $this = $(this);
		var serialized_data = $(this).serialize();
		
		$.ajax({
			type :		"post",
			dataType :	"json",
			url :		ajax_data.ajaxurl,
			data :		"action=send_enquiry_form&security="+ajax_data.ajax_nonce+"&"+serialized_data,
			success :	function(response) {
				if (response.result == 'success') {
					$this.parent().html('<p class="success">'+ajax_data.success_msg+'</p>');
				} else {
					$this.parent().html('<p class="error">'+ajax_data.error_message+'</p>');
				}
			}
		});

		return false;
	});

	$(document).on('click', '.inquiry-pagination a.page-numbers', function(e) {
		e.preventDefault();

		$('.enquiry-info').hide();

		const urlParams = new URLSearchParams($(this).attr('href'));
		var list_container = $(this).closest('.enquiry-list');

		$.ajax({
			type :		"post",
			dataType :	"json",
			url :		ajax_data.ajaxurl,
			data :		"action=get_enquiry_list&security="+ajax_data.ajax_nonce+"&page="+urlParams.get('page')+"&per_page="+urlParams.get('per_page'),
			success :	function(response) {
				if (response.result == 'success') {
					list_container.html(response.html);
				} else {
					list_container.html('<p class="error">'+ajax_data.error_message+'</p>');
				}
			}
		});

		return false;
	});

	$(document).on('click', '.enquiry-list .enquiry-item', function(e) {
		e.preventDefault();

		var $this = $(this);

		$.ajax({
			type :		"post",
			dataType :	"json",
			url :		ajax_data.ajaxurl,
			data :		"action=get_enquiry_info&security="+ajax_data.ajax_nonce+"&enquiry_id="+$this.data('enquiry-id'),
			success :	function(response) {
				if (response.result == 'success') {
					$('.enquiry-info').html(response.html);
				} else {
					$('.enquiry-info').html('<p class="error">'+ajax_data.error_message+'</p>');
				}

				$('.enquiry-info').show();
				$('html, body').animate({scrollTop: ($('.enquiry-info').offset().top - 50)}, 300);
			}
		});

		return;		
	});

})(window.jQuery); 
