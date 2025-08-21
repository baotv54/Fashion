<li class="hasChild {{ request()->routeIs('products.category') ? 'active' : '' }}">
    <a href="/products" title="Converse All" aria-label="Converse All">Danh Mục<span>›</span></a>
    <ul class="menu1">
        @foreach($categories as $category)
        <li class="hasChild {{ request()->routeIs('products.category') && request()->route('slug') === $category->slug ? 'active' : '' }}">
            <a href="{{ route('products.category', $category->slug) }}">
                {{ $category->name }}<span>›</span>
            </a>

            @if($category->children->count())
            <ul class="menu2">
                @foreach($category->children as $child)
                <li class="{{ request()->routeIs('products.category') && request()->route('slug') === $child->slug ? 'active' : '' }}">
                    <a href="{{ route('products.category', $child->slug) }}">
                        {{ $child->name }}
                    </a>                
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
</li>
