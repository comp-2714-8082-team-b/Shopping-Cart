@foreach ($items as $item)
<div class="item">
    <div class="image">
        <div class="ui placeholder">
            @if ($item->pictures[0])
                <div class="square image" style="background-image: url('{{ asset('storage/app/public/' . $item->pictures[0]) }}');background-size: cover;"></div>
            @else
                <div class="square image" style="background-image: url('{{ asset('public/img/placeholder.png') }}');background-size: cover;"></div>
            @endif
        </div>
    </div>
    <div class="content">
        <a href="{{ route('getDescription', ['modelNumber' => $item->modelNumber ]) }}" class="header">{{ $item->itemName }}</a>
        <div class="meta">
            <span class="modelNumber">{{ $item->modelNumber }}</span>
            @if (is_null($item->salePrice))
                <span class="price">Price: ${{ $item->itemPrice }}</span>
            @else
                <span class="price">Price: <strike>${{ $item->itemPrice }}</strike> ${{ $item->salePrice }}</span>
            @endif

            <span class="brandName">Brand: {{ $item->brandName }}</span>
            <span class="stockQuantity">In Stock: {{ $item->stockQuantity }}</span>
        </div>
        <div class="description" style='overflow:hidden;'>
            <p>{!! nl2br($item->description) !!}</p>
        </div>
        <div class="extra">
            @foreach ($item->categories as $category)
                <div class="ui label">{{ $category }}</div>
            @endforeach
        </div>
        @if (\Auth::check())
            <div class="footer">
                <form action="" method="POST" class="ui form">
                    <div class="fields right floated">
                        <div class="field">
                            <div class="ui input">
                                <input type="number" placeholder="Quantity" name='quantity' />
                            </div>
                        </div>
                        <div class="field">
                            <button type="button" value="{{ $item->modelNumber }}" class="ui right floated icon green button deleteItem">
                                <i class="cart plus icon"></i> Add to Cart
                            </button>
                        </div>
                        @if (\Auth::user()->type != "user")
                            <div class="field">
                                <a href="{{ route('itemForm', ['modelNumber' => $item->modelNumber]) }}">
                                    <button type="button" value="Edit" class="ui right floated icon blue button">
                                        <i class="edit icon"></i> Edit
                                    </button>
                                </a>
                            </div>
                            <div class="field">
                                <button type="button" value="{{ $item->modelNumber }}" class="ui right floated icon red button deleteItem">
                                    <i class="x icon"></i> Delete
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endforeach
