<div class="row form-group">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <th>#</th>
                <th>{{ trans('form.featured_image') }}</th>
                <th>{{ trans('form.title') }}</th>
                <th>{{ trans('form.attribute_values') }}</th>
                <th>{{ trans('product.price') }}</th>
                <th>{{ trans('table-messages.action') }}</th>

                @for ($i = 0, $sl = 0; $i < count($variations); $i++)
                @php
                    $variation = $variations[$i];
                    $isDeleted = $variation['is_deleted'] ?? 0;

                    if ($isDeleted)
                        continue;

                    $image = \App\Models\Media::find($variation['image_id']);

                    $attributes = $variation['_attributes'] ?? [];
                    $attributeValues = '';

                    foreach ($attributes as $attr) {
                        if (empty($attr))
                            continue;

                        $attrArr = explode(':', $attr);
                        $attribute = App\Models\Term::find($attrArr[0]);
                        $attributeValues .= $attribute->name . ": " . $attrArr[1];
                        $attributeValues .= "<br>";
                    }

                    $sl++;
                @endphp
                <tr>
                    <td>{{ ($sl) }}</td>
                    <td>
                        @if ($image)
                            <x-admin.media.media-icon-preview :media="$image" :show-title="false" />
                        @endif
                    </td>
                    <td>{{ $variation['title'] }}</td>
                    <td>{!! $attributeValues !!}</td>
                    <td>{{ config('currency.symbol') . number_format($variation['price'], 2) }}</td>
                    <td>
                        <a class="btn btn-xs btn-warning mr-2"
                            href="javascript:;"
                            wire:click="editVariation({{ $i }}, {{ $variation['id'] ?? 0 }})"><i class="fa fa-edit"></i> {{ trans('form-actions.edit') }}</a>

                        <a class="btn btn-xs btn-danger" wire:click="removeVariation({{ $i }}, {{ $variation['id'] ?? 0 }})"
                            href="javascript:;"><i class="fa fa-trash"></i> {{ trans('form-actions.delete') }}</a>
                    </td>
                </tr>
                @endfor
            </table>
        </div>
    </div>
</div>
