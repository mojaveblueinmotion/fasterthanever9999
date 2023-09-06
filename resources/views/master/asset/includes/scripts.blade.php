<script>
	$(function () {
		$('.content-page').on('change', 'select.aspect_id', function (e) {
			var me = $(this);
			if (me.val()) {
				var docItemId = $('select.document_item_id');
				var urlOrigin = docItemId.data('url-origin');
				var urlParam = $.param({
					aspect_id: me.val(),
				});
				docItemId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
				docItemId.val(null).prop('disabled', false);
			}
			BasePlugin.initSelect2();
		});

		$('.content-page').on('change', 'select.document_item_id', function (e) {
			var me = $(this);
			if (me.val()) {
				var docItemDec = $('textarea.description');
				var urlOrigin = docItemDec.data('url-origin');
				var urlParam = $.param({
					id: me.val(),
				});
				docItemDec.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));

				$.ajax({
					type: 'POST',
					url: docItemDec.data('url'),
					data: {
						_token: BaseUtil.getToken(),
					},
					success: function (resp) {
						docItemDec.val(resp.description).removeClass('is-invalid');
						docItemDec.closest('.parent-group').find('.is-invalid-message').remove();
					},
					error: function (resp) {
						docItemDec.val('');
					}
				});
			}
		});
	});
</script>
