{{-- base-content--replace --}}
<a href="{{ $urlAdd ?? (\Route::has($routes . '.create') ? route($routes . '.create') : 'javascript:;') }}"
    class="btn btn-info  {{ isset($class_name) ? $class_name : 'base-modal--render' }}" data-modal-backdrop="false"
    data-modal-size="{{ isset($modal_size) ? $modal_size : 'modal-md' }}" data-modal-v-middle="false">
    <i class="fa fa-plus"></i> Data
</a>
