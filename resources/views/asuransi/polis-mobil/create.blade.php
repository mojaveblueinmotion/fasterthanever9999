@extends('layouts.modal')

@section('action', route($routes.'.store'))

@section('modal-body')
@method('POST')
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('No Asuransi') }}</label>
	<div class="col-sm-8 parent-group ">
		<input type="hidden" value="{{ $noAsuransi->no_max }}" name="no_max">
		<input type="text" readonly value="{{ $noAsuransi->no_asuransi }}" name="no_asuransi" class="form-control" placeholder="{{ __('No Asuransi') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-md-4 col-form-label">{{ __('Tanggal') }}</label>
	<div class="col-md-8 parent-group">
		<input type="text" name="tanggal"
		class="form-control base-plugin--datepicker tanggal" 
		data-options='@json([
			"startDate" => "",
			"endDate"=> now()->format('d/m/Y')
		])'
		placeholder="{{ __('Tanggal') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Agent') }}</label>
	<div class="col-sm-8 parent-group">
		<select required name="agent_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ route('ajax.selectAgent', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Asuransi Mobil') }}</label>
	<div class="col-sm-8 parent-group">
		<select required name="asuransi_id" class="form-control base-plugin--select2-ajax"
			data-url="{{ route('ajax.selectAsuransiMobil', 'all') }}" placeholder="{{ __('Pilih Salah Satu') }}">
			<option value="">{{ __('Pilih Salah Satu') }}</option>
		</select>
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Nama Client') }}</label>
	<div class="col-sm-8 parent-group ">
		<input type="text" name="name" class="form-control" placeholder="{{ __('Nama Client') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('No. Telepon') }}</label>
	<div class="col-sm-8 parent-group ">
		<input type="number" name="phone" class="form-control" placeholder="{{ __('No. Telepon') }}">
	</div>
</div>
<div class="form-group row">
	<label class="col-sm-4 col-form-label">{{ __('Email') }}</label>
	<div class="col-sm-8 parent-group ">
		<input type="text" name="email" class="form-control" placeholder="{{ __('Email') }}">
	</div>
</div>
@endsection


