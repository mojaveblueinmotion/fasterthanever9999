@extends('layouts.page')

@section('content-body')
<div class=" flex-column-fluid">
	<form action="{{ route($routes.'.submitSave', $record->id)}}" method="POST" autocomplete="off">
		<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
		<div class="container-fluid">
			<div class="card card-custom">
				<div class="card-header">
					<h3 class="card-title">Purchase Order</h3>
					<div class="card-toolbar">
						@section('card-toolbar')
						@include('layouts.forms.btnBackTop')
						@show
					</div>
				</div>
				<div class="card-body">
					@include($views.'.includes.notes')
					@include($views.'.includes.header')
					<hr>
				</div>
			</div>
		</div>
		<div class="container-fluid mt-5">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-custom">
						<div class="card-header">
							<h3 class="card-title">Daftar Aset</h3>
							<div class="card-toolbar">
							</div>
						</div>
						<div class="card-body">
							@include($views.'.detail.detail-grid-laporan')
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid mt-5">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-custom">
						<div class="card-body">
							<div class="form-group row">
								<label class="col-md-2 col-form-label">{{ __('Catatan') }}</label>
								<div class="col-md-10 parent-group">
									<textarea @if(request()->route()->getName() == $routes.'.detail.show') disabled @endif required name="catatan" class="form-control" placeholder="{{ __('Catatan') }}">{{ $record->catatan }}</textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label">{{ __('Lampiran') }}</label>
								<div class="col-sm-10 parent-group">
									<div class="custom-file">
										<input type="hidden" name="attachments[uploaded]" class="uploaded" value="0">
										<input @if(request()->route()->getName() == $routes.'.detail.show') disabled @endif type="file" multiple class="custom-file-input base-form--save-temp-files" data-name="attachments"
											data-container="parent-group" data-max-size="20024" data-max-file="100" accept="*">
										<label class="custom-file-label" for="file">Choose File</label>
									</div>
									<div class="form-text text-muted">*Maksimal 20MB</div>
									@foreach ($record->files($module)->where('flag', 'attachments')->get() as $file)
									<div class="progress-container w-100" data-uid="{{ $file->id }}">
										<div class="alert alert-custom alert-light fade show py-2 px-4 mb-0 mt-2 success-uploaded" role="alert">
											<div class="alert-icon">
												<i class="{{ $file->file_icon }}"></i>
											</div>
											<div class="alert-text text-left">
												<input type="hidden" name="attachments[files_ids][]" value="{{ $file->id }}">
												<div>Uploaded File:</div>
												<a href="{{ $file->file_url }}" target="_blank" class="text-primary">
													{{ $file->file_name }}
												</a>
											</div>
											<div class="alert-close">
												<button type="button" class="close base-form--remove-temp-files" data-toggle="tooltip"
													data-original-title="Remove">
													<span aria-hidden="true">
														<i class="ki ki-close"></i>
													</span>
												</button>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@if(request()->route()->getName() != $routes.'.detail.show')
		<div class="container-fluid mt-5">
			<div class="row">
				<div class="col-md-6">
					<div class="card card-custom">
						<div class="card-header">
							<h3 class="card-title">Alur Persetujuan</h3>
							<div class="card-toolbar">
							</div>
						</div>
						<div class="card-body text-center">
							@php
							$colors = [
							1 => 'primary',
							2 => 'info',
							];
							@endphp
							@if ($menu = \App\Models\Setting\Globals\Menu::where('module',
							'purchasing.purchase-order')->first())
							@if ($menu->flows()->get()->groupBy('order')->count() == null)
							<span class="label label-light-info font-weight-bold label-inline" data-toggle="tooltip">Belum
								memiliki Alur Persetujuan.</span>
							@else
							@foreach ($orders = $menu->flows()->get()->groupBy('order') as $i => $flows)
							@foreach ($flows as $j => $flow)
							<span class="label label-light-{{ $colors[$flow->type] }} font-weight-bold label-inline"
								data-toggle="tooltip" title="{{ $flow->show_type }}">{{ $flow->role->name }}</span>
							@if (!($i === $orders->keys()->last() && $j === $flows->keys()->last()))
							<i class="mx-2 fas fa-angle-double-right text-muted"></i>
							@endif
							@endforeach
							@endforeach
							@endif
							@endif
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-custom">
						<div class="card-header">
							<h3 class="card-title">Aksi</h3>
							<div class="card-toolbar">
							</div>
						</div>
						<div class="card-body">
							<div class="d-flex justify-content-end">
								Sebelum submit, pastikan isian data sudah lengkap dan alur persetujuan sudah benar.
								@include('layouts.forms.btnDropdownSubmit')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>
</div>
@endsection
@section('buttons')
@endsection