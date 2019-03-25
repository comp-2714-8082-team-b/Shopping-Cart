@php
    $canBeAddedToCart = (isset($canBeAddedToCart)) ? $canBeAddedToCart : true;
    $canRemoveFromCart = (isset($canRemoveFromCart)) ? $canRemoveFromCart : false;
    $quantityChangable = (isset($quantityChangable)) ? $quantityChangable : true;
@endphp
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
                Price: $<span class="price">{{ $item->itemPrice }}</span>
            @else
                Price: <strike>${{ $item->itemPrice }}</strike>$<span class="price">{{ $item->salePrice }}</span>
            @endif

            <span class="brandName">Brand: {{ $item->brandName }}</span>
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
                
                <div class="ui error message" style="display:none;"></div>
                <form action="" method="POST" class="ui form">
                    <div class="fields right floated">
                        <div class="field">
<!--                            <div class="ui input">
                                <input type="tel" placeholder="Quantity" name='quantity' value="{{ (isset($item->quantity)) ? $item->quantity : "0" }}" size="7" class="quantity" />
                            </div>-->
                            @if ($quantityChangable)
                            <div class="ui selection dropdown" style="min-width: 1em;">
                                <input type="hidden" name="quantity" value="{{ (isset($item->quantity)) ? $item->quantity : "0" }}" class="quantity">
                                <i class="dropdown icon"></i>
                                <div class="default text">0</div>
                                <div class="menu">
                                    @for ($i = 1; $i <= $item->stockQuantity; $i++)
                                        <div class="item" data-value="{{ $i }}">{{ $i }}</div>
                                    @endfor
                                </div>
                            </div>
                            @else
                            <strong>Quantity: </strong>{{ (isset($item->quantity)) ? $item->quantity : "0" }}
                            @endif
                        </div>
                        @if ($canBeAddedToCart)
                            <div class="field">
                                <button type="button" value="{{ $item->modelNumber }}" class="ui right floated icon red button addToCartButton">
                                    <i class="cart plus icon"></i> Add to Cart
                                </button>
                            </div>
                        @elseif ($canRemoveFromCart)
                            <div class="field">
                                <button type="button" value="{{ $item->modelNumber }}" class="ui right floated icon red button removeFromCartButton">
                                    <i class="x icon"></i> Remove From Cart
                                </button>
                            </div>
                        @endif
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
