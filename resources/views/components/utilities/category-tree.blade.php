<div>
    <ul class="list-style-none pl-3">
        @foreach ($categoryNodes as $node)
        <li class="list-style-none">
            <div class="d-inline-block">
                @if (count($node->children))
                <a data-toggle="collapse" class="text-muted toggle-plus-minus-icon {{ $node->isCollapsed ? 'collapsed' : '' }}" href="#category-toggle-{{ $node->category->id }}">
                    <i class="fa fa-minus-square minus" {{ $node->isCollapsed ? '' : "style=display:none" }}></i>
                    <i class="fa fa-plus-square plus" {{ $node->isCollapsed ? "style=display:none" : '' }}></i>
                </a>
                @endif

                <input type="checkbox" class="" wire:model="selectedItems" id="treewise-category-{{ $node->category->id }}"
                    value="{{ $node->category->id }}" {{ $node->isSelected ? 'checked' : '' }}
                    wire:change="updateSelectedCategories" >

                <label for="treewise-category-{{ $node->category->id }}">{{ $node->category->name }}</label>

                <div class="collapse {{ $node->isCollapsed ? 'show' : '' }}" id="category-toggle-{{ $node->category->id }}">
                    @if (count($node->children))
                        <x-utilities.category-tree :type="$type" :parent-id="$node->category->id" :selected-items="$selectedItems" />
                    @endif
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
