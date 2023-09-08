<table id="dataFilters" class="width-full">
	<tbody>
		<tr>
			<td class="text-right td-btn-create width-200px">
				@if(request()->route()->getName() != $routes.'.detail.show' && request()->route()->getName() != $routes.'.approval')
				<a href="{{ route($routes.'.detailPurchase', $record->id) }}"
					class="btn btn-info ml-2 {{ empty($baseContentReplace) ? 'base-modal--render' : 'base-content--replace' }}"
					data-modal-backdrop="false" data-modal-v-middle="false">
					<i class="fa fa-plus"></i> Tambah
				</a>
				@endif
			</td>
		</tr>
	</tbody>
</table>

<div class="table-responsive">
	@if(isset($tableStruct2['datatable_2']))
	<table id="datatable_2" class="table table-bordered is-datatable" style="width: 100%;"
		data-url="{{ $tableStruct2['url'] }}" data-paging="{{ $paging ?? true }}" data-info="{{ $info ?? true }}">
		<thead>
			<tr>
				@foreach ($tableStruct2['datatable_2'] as $struct)
				<th class="text-center v-middle" data-columns-name="{{ $struct['name'] ?? '' }}"
					data-columns-data="{{ $struct['data'] ?? '' }}" data-columns-label="{{ $struct['label'] ?? '' }}"
					data-columns-sortable="{{ $struct['sortable'] === true ? 'true' : 'false' }}"
					data-columns-width="{{ $struct['width'] ?? '' }}" data-columns-class-name="{{ $struct['className'] ?? '' }}"
					style="{{ isset($struct['width']) ? 'width: '.$struct['width'].'; ' : '' }}">
					{{ $struct['label'] }}
				</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	@endif
</div>