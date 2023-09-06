@extends('layouts.lists')

@section('filters')
    <div class="row">
        {{-- <div class="col-12 col-sm-6 col-xl-3 pb-2">
            <input type="text" class="filter-control form-control" data-post="code" placeholder="{{ __('Kode') }}">
        </div> --}}
        <div class="col-12 col-sm-6 col-xl-2">
            <select class="filter-control form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-asset-type', 'all') }}" data-placeholder="{{ __('Pilih Tipe Aset') }}"
                id="assetTypeFltrCtrl" data-post="asset_type_id">
            </select>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <select class="filter-control form-control base-plugin--select2-ajax"
                data-url="{{ route('ajax.select-asset', 'all') }}" data-url-origin="{{ route('ajax.select-asset', 'all') }}"
                data-placeholder="{{ __('Pilih Aset') }}" disabled id="assetFltrCtrl" data-post="asset_id">
            </select>
        </div>
    </div>
@endsection

@section('buttons-top-right')
    @if (auth()->user()->checkPerms($perms . '.create'))
        @include('layouts.forms.btnAdd', [
            'class_name'    => 'base-content--replace',
            'modal_size' => 'modal-lg',
        ])
    @endif
@endsection

@push('scripts')
    <script>
        $('.content-page')
            .on('change', '#assetTypeFltrCtrl', function() {
                let asset_type_id = $('#assetTypeFltrCtrl').val();
                if (asset_type_id) {
                    var assetFltrCtrl = $('#assetFltrCtrl');
                    var urlOrigin = assetFltrCtrl.data('url-origin');
                    var urlParam = $.param({
                        asset_type_id: asset_type_id,
                    });
                    assetFltrCtrl.data('url', decodeURIComponent(decodeURIComponent(urlOrigin + '?' + urlParam)));
                    assetFltrCtrl.val(null).prop('disabled', false);
                    BasePlugin.initSelect2();
                }
            });
    </script>
@endpush
