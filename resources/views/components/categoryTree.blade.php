<div class="">
    <div class="mb-1">
        <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}"
            class="category-link">{{ $category->title }}</a>
    </div>
    @if ($category->children->isNotEmpty())
        <div class="ps-4 mb-2">
            @each('components.categoryTree', $category->children, 'category')

        </div>
    @endif
</div>
