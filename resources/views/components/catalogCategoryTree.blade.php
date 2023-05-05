<div class="">
    <div class="mb-1">
        <div class="accordion d-flex align-items-center mb-2">
            <a href="{{ route('catalog.search', ['title_eng' => $treeItem->title_eng]) }}"
                class="category-link @if (isset($category) && $treeItem->id == $category->id) active @endif">{{ $treeItem->title }}</a>
            @if ($treeItem->children->isNotEmpty())
                <button class="accordion-button @if (!$parentCategories->contains('id', $treeItem->id)) collapsed @endif " type="button"
                    data-bs-toggle="collapse" data-bs-target="#category-collapse-{{ $treeItem->id }}">
                </button>
            @endif
        </div>
    </div>
    @if ($treeItem->children->isNotEmpty())
        <div class="collapse @if ($parentCategories->contains('id', $treeItem->id)) show @endif" id="category-collapse-{{ $treeItem->id }}">
            <div class="ps-4">
                @foreach ($treeItem->children as $treeItem)
                    @include('components.catalogCategoryTree')
                @endforeach
            </div>
        </div>
    @endif
</div>
