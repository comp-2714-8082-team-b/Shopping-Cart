<!-- This file is for creating the layout of a single item
Get the item's column name with the following syntax:
<open parentheses><open parentheses> $item->name <closing parentheses><closing parentheses> -->
@foreach ($items as $item)
<div class="item">
    <div class="image">
        <div class="ui placeholder">
            
            @if ($item->pictures[0])
                <div class="square image" style="background-image: url('{{ asset('storage/app/' . $item->pictures[0]) }}');background-size: cover;"></div>
            @else
                <div class="square image" style="background-image: url('{{ asset('public/img/placeholder.png') }}');background-size: cover;"></div>
            @endif
        </div>
    </div>
    <div class="content">
        <a class="header">{{ $item->modelNumber . ": " . $item->itemName }}</a>
        <div class="meta">
            @if (is_null($item->salePrice))
                <span class="price">Price: ${{ $item->itemPrice }}</span>
            @else
                <span class="price">Price: <strike>${{ $item->itemPrice }}</strike> ${{ $item->salePrice }}</span>
            @endif

            <span class="brandName">Brand: {{ $item->brandName }}</span>
            <span class="stockQuantity">In Stock: {{ $item->stockQuantity }}</span>
        </div>
        <div class="description">
            <p>{{ $item->description }}</p>
        </div>
        <div class="extra">
            @foreach ($item->categories as $category)
                <div class="ui label">{{ $category }}</div>
            @endforeach
        </div>
        @if (\Auth::user()->type != "user")
        <div class="footer">
            
            <button type="button" value="Delete" class="ui right floated icon red button">
                <i class="x icon"></i> Delete
            </button>
            <a href="{{ route('itemForm', ['modelNumber' => $item->modelNumber]) }}">
                <button type="button" value="Edit" class="ui right floated icon blue button">
                    <i class="edit icon"></i> Edit
                </button>
            </a>
        </div>
        @endif
    </div>
</div>
@endforeach
