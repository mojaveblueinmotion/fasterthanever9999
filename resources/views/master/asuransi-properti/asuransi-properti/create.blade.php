@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
	@method('POST')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Perusahaan') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="perusahaan_asuransi_id" class="form-control base-plugin--select2-ajax branch_id"
				data-url="{{ route('ajax.selectPerusahaanAsuransi', 'all') }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama Asuransi') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Asuransi') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Pembayaran') }}</label>
		<div class="col-md-8 parent-group">
			<div class="input-group">
				<div class="parent-group input-group-prepend"><span
					class="input-group-text font-weight-bolder">Rp.</span>
				</div>
					<input class="form-control base-plugin--inputmask_currency pembayaran_persentasi" id="pembayaran_persentasi" name="pembayaran_persentasi"
						placeholder="{{ __('Pembayaran') }}">
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Interval Pembayaran') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="interval_pembayaran_id" class="form-control base-plugin--select2-ajax branch_id"
				data-url="{{ route('ajax.selectIntervalPembayaran', 'all') }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Fitur') }}</label>
		<div class="col-md-8 parent-group">
			<select name="to[]" class="form-control base-plugin--select2-ajax"
				data-url="{{ route('ajax.selectFiturAsuransi', [
					'search'=>'all',
				]) }}"
				multiple
				placeholder="{{ __('Pilih Beberapa') }}">
				<option value="">{{ __('Pilih Beberapa') }}</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Call Center') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" name="call_center" class="form-control" placeholder="{{ __('Call Center') }}">
		</div>
	</div>
@endsection

@push('scripts')
<script>
	$('.modal-dialog').removeClass('modal-md').addClass('modal-lg');
</script>
@endpush