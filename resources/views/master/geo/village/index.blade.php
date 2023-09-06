@extends('layouts.lists')

@section('filters')
	<div class="row">
		<div class="col-12 col-sm-6 col-xl-3 pb-2">
			<input type="text" class="form-control filter-control" data-post="name" placeholder="{{ __('Nama') }}">
		</div>
	</div>
@endsection

@section('buttons-top-right')
	@if (auth()->user()->checkPerms($perms.'.create'))
		{{-- @include('layouts.forms.btnAddImport') --}}
		{{-- @include('layouts.forms.btnAdd') --}}
	@endif
@endsection

@push('scripts')
    <script>
        $(document)
            .on('change', '#provinceCtrl', function($e) {
                console.log(38, $(this).val());
                $.ajax({
                    method: 'GET',
                    url: '{{ url('ajax/city-options') }}',
                    data: {
                        province_id: $(this).val()
                    },
                    success: function(response, state, xhr) {
                        // let options = `<option value='' selected disabled></option>`;
                        let options = ``;
                        for (let item of response) {
                            options += `<option value='${item.id}'>${item.name}</option>`;
                        }
                        $('#cityCtrl').select2('destroy');
                        $('#cityCtrl').html(options);
                        $('#cityCtrl').select2();
                        console.log(54, response, options);
                    },
                    error: function(a, b, c) {
                        console.log(a, b, c);
                    }
                });
            });
    </script>
@endpush
