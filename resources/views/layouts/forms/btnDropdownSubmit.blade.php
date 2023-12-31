<div class="btn-group dropup">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false"><i class="mr-1 fa fa-save"></i> {{ __('Simpan') }}</button>
    <div class="dropdown-menu dropdown-menu-right">
        <button type="submit"
            class="dropdown-item align-items-center base-form--submit-{{ isset($submit_type) ? $submit_type : 'page' }}"
            data-submit="0">
            <i class="mr-1 flaticon2-list-3 text-primary"></i>
            {{ __('Simpan Sebagai Draft') }}
            <span class=""></span>
        </button>
        <button type="submit"
            class="dropdown-item align-items-center base-form--submit-{{ isset($submit_type) ? $submit_type : 'page' }}"
            data-submit="1">
            <i class="mr-1 flaticon-interface-10 text-success"></i>
            {{ __('Simpan & Submit') }}
        </button>
    </div>
</div>
