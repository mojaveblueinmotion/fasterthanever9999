@extends('layouts.modal')

@section('action', route($routes.'.detailPurchaseUpdate', $detail->id))

@section('modal-body')
@method('PATCH')
<input type="hidden" name="purchase_order_id" value="{{ $detail->purchase_order_id }}">
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Struktur Aset') }}</label>
	<div class="col-md-9 parent-group">
		<select name="struktur_aset" class="form-control base-plugin--select2-ajax struktur_aset"
			placeholder="{{ __('Pilih Salah Satu') }}"
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			<option @if($detail->barang->struktur_aset == "plant") selected @endif value="plant">{{ __('Plant') }}</option>
			<option @if($detail->barang->struktur_aset == "system") selected @endif value="system">{{ __('System') }}</option>
			<option @if($detail->barang->struktur_aset == "equipment") selected @endif value="equipment">{{ __('Equipment') }}</option>
			<option @if($detail->barang->struktur_aset == "sub-unit") selected @endif value="sub-unit">{{ __('Sub Unit') }}</option>
			<option @if($detail->barang->struktur_aset == "komponen") selected @endif value="komponen">{{ __('Komponen') }}</option>
			<option @if($detail->barang->struktur_aset == "parts") selected @endif value="parts">{{ __('Parts') }}</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Aset') }}</label>
	<div class="col-md-9 parent-group">
		<input type="hidden" name="barang_id" value="{{ $detail->barang_id }}">
		<select name="barang_id" class="form-control base-plugin--select2-ajax barang_id" id="asetCtrl"
			data-url="{{ route('ajax.getAsetFromOptions', ['struktur_aset' => '']) }}"
			data-url-origin="{{ route('ajax.getAsetFromOptions') }}" placeholder="{{ __('Pilih Salah Satu') }}" disabled
			required>
			<option value="">{{ __('Pilih Salah Satu') }}</option>
			@if (!empty($detail->barang_id))
				<option value="{{ $detail->barang_id }}" selected>{{ $detail->barang->name }}</option>
			@endif
		</select>
	</div>
</div>

<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Jumlah') }}</label>
	<div class="col-md-9 parent-group">
		<div class="input-group">
			<input type="text" id="jumlahCtrl" value="{{ $detail->jumlah }}" name="jumlah" class="form-control" placeholder="{{ __('Jumlah') }}">
			<div class="input-group-prepend">
				<span class="input-group-text">Item</span>
			</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Harga Per Unit') }}</label>
	<div class="col-md-9 parent-group">
		<div class="input-group">
			<div class="input-group-prepend"><span
					class="input-group-text font-weight-bolder">Rp.</span></div>
			<input readonly value="{{ $detail->harga_per_unit }}" class="form-control base-plugin--inputmask_currency harga_per_unit" id="harga_per_unit" name="harga_per_unit" inputmode="numeric"
			placeholder="{{ __('Harga Per Unit') }}">
		</div>
	</div>
</div>
<div class="form-group row">
	<label class="col-md-3 col-form-label">{{ __('Total Harga') }}</label>
	<div class="col-md-9 parent-group">
		<div class="input-group">
			<div class="input-group-prepend"><span
					class="input-group-text font-weight-bolder">Rp.</span></div>
			<input readonly value="{{ $detail->total_harga }}" class="form-control base-plugin--inputmask_currency total_harga" id="total_harga" name="total_harga" inputmode="numeric"
			placeholder="{{ __('Total Harga') }}">
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	$(function () {
		$('.content-page')
		.on('change', '#asetCtrl', function(){
			$.ajax({
				method: 'GET',
				url: '{{ url('/ajax/getAsetOptions') }}',
				data: {
					aset_id: $(this).val()
				},
				success: function(response, state, xhr) {
					$('#harga_per_unit').val(response.harga_per_unit);
					console.log(response.harga);
				},
				error: function(a, b, c) {
					console.log(a, b, c);
				}
			});

			$('#jumlahCtrl').val(null);
			$('#total_harga').val(null);
			$('#harga_per_unit').val(null);
		});

		$('.content-page').on('change', 'select.struktur_aset', function (e) {
			var me = $(this);
			if (me.val()) {
				var objectId = $('select.barang_id');
				var urlOrigin = objectId.data('url-origin');
				var urlParam = $.param({struktur_aset: me.val()});
				objectId.data('url', decodeURIComponent(decodeURIComponent(urlOrigin+'?'+urlParam)));
				objectId.val(null).prop('disabled', false);
			}
			BasePlugin.initSelect2();
		});
	});

	$(function () {
		$('.content-page')
		.on('keyup', '#jumlahCtrl', function(){

			jumlah = $(this).val();
			console.log(jumlah);
			
			if($('#harga_per_unit').val() != null)
			{
				$('#total_harga').val($('#harga_per_unit').val().split(",").join("") * jumlah);
			}
			
		});
	});
</script>
@endpush