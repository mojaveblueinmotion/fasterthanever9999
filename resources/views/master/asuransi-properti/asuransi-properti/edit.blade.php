@extends('layouts.modal')

@section('action', route($routes.'.update', $record->id))

@section('modal-body')
	@method('PATCH')
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Perusahaan') }}</label>
		<div class="col-sm-8 parent-group">
			<select name="perusahaan_asuransi_id" class="form-control base-plugin--select2-ajax branch_id"
				data-url="{{ route('ajax.selectPerusahaanAsuransi', 'all') }}"
				data-placeholder="{{ __('Pilih Salah Satu') }}">
				@if (!empty($record->perusahaan_asuransi_id))
					<option value="{{ $record->perusahaan_asuransi_id }}" selected>{{ $record->perusahaanAsuransi->name }}</option>
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Nama Asuransi') }}</label>
		<div class="col-sm-8 parent-group">
			<input type="text" value="{{ $record->name }}" name="name" class="form-control" placeholder="{{ __('Nama Asuransi') }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4 col-form-label">{{ __('Pembayaran') }}</label>
		<div class="col-md-8 parent-group">
			<div class="input-group">
				<div class="parent-group input-group-prepend"><span
					class="input-group-text font-weight-bolder">Rp.</span>
				</div>
					<input value="{{ $record->pembayaran_persentasi }}" class="form-control base-plugin--inputmask_currency pembayaran_persentasi" id="pembayaran_persentasi" name="pembayaran_persentasi"
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
				@if (!empty($record->interval_pembayaran_id))
					<option value="{{ $record->interval_pembayaran_id }}" selected>{{ $record->intervalPembayaran->name }}</option>
				@endif
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
				@if (!empty($record->fiturs))
				@foreach ($record->fiturs as $value)
					<option value="{{ $record->interval_pembayaran_id }}" selected>{{ $record->intervalPembayaran->name }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-4 col-form-label">{{ __('Call Center') }}</label>
		<div class="col-sm-8 parent-group">
			<input value="{{ $record->call_center }}" type="text" name="call_center" class="form-control" placeholder="{{ __('Call Center') }}">
		</div>
	</div>
@endsection
