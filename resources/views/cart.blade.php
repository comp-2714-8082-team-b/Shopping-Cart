@extends('Layout/layout', ['showHeader' => true, 'title' => 'Home'])
@section('content')
@if (!$items)
<h1>You currently have no items</h1>
@else
<div class="ui divided items" id="itemsSection">
    @include('item', ['items' => $items, 'canBeAddedToCart' => false, 'canRemoveFromCart' => true])
</div>
<form action="{{ route('checkout') }}" method="POST" class="ui form">
    @csrf
    <div class="ui error message"></div>
    @if ($errors->any())
    <div class="ui red message">
        {!! implode('', $errors->all(':message</br>')) !!}
    </div>
    @endif
    <h2>Payment Method</h2>
    <hr>
    <h2>Shipping Information</h2>
    <div class="fields">
        <div class="field">
            <label>Country</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="country" value="{{ old('country', 'Canada') }}" class="country">
                <i class="dropdown icon"></i>
                <div class="text">{{ old('country', 'Canada') }}</div>
                <div class="menu">
                    <div class="item" data-value="Canada">Canada</div>
                    <div class="item" data-value="USA">USA</div>
                </div>
            </div>
        </div>
        <div class="field">
            <label>State/Province</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="stateOrProvince" class="stateOrProvince" value="{{ old('stateOrProvince', $canadaProvinces[0]) }}">
                <i class="dropdown icon"></i>
                <div class="text">{{ old('stateOrProvince', $canadaProvinces[0]) }}</div>
                <div class="menu" id="stateOrProvinceMenu">
                </div>
            </div>
        </div>
        <div class="field">
            <label>City</label>
            <input type="text" name="city" value="{{ old('city') }}"/>
        </div>
        <div class="field">
            <label>Street Address</label>
            <input type="text" name="streetAddress" value="{{ old('streetAddress') }}"/>
        </div>
        <div class="field">
            <label>Postal Code</label>
            <input type="text" name="postalCode" value="{{ old('postalCode') }}"/>
        </div>
    </div>
    <hr>
    <div class="fields">
        <div class="field">
            <strong>Total: </strong>$<span id="totalBeforeTaxes"></span>
        </div>
    </div>
    <span id="taxInformation">
    </span>
    <div class="fields">
        <div class="field">
            <div class="ui left action input">
                <button class="ui blue labeled icon button" type="submit">
                    <i class="cart icon"></i> Checkout
                </button>
                <input type="text" id="totalPrice">
            </div>
        </div>
    </div>
</form>
<script>
    shortenItemDescriptions();
        
    var canadaProvinces = [{!! "'" . implode("', '", $canadaProvinces) . "'" !!}];

    var usaStates = [{!! "'" . implode("', '", $usaStates) . "'" !!}];
    
    $(document).ready(function() {
        $('.ui.selection.dropdown').dropdown();
        
        function updateTotal()
        {
            var total = 0;
            var taxes = 0;
            var tax;
            $("#taxInformation").html("");
            $( ".quantity" ).each(function( index ) {
                var quantity = $(this).val();
                var price = $(this).closest(".item").find(".price").html();
                total += price * quantity;
            });
            switch ($('[name="country"]').val() + "," + $('[name="stateOrProvince"]').val()) {
                @foreach ($taxes as $tax)
                case ("{{ $tax->location }}"):
                    $("#totalBeforeTaxes").html(Math.round(100 * total) / 100);
                    @for ($i = 0; $i < count($tax->amountPercentage); $i++)
                        $("#taxInformationClone").find(".taxName").html("+{{ $tax->taxNames[$i] }}: ");
                        tax = total * ({{ $tax->amountPercentage[$i] }} / 100);
                        tax = Math.round(100 * tax) / 100;
                        $("#taxInformationClone").find(".taxPercentage").html(tax);
                        taxes += {{ $tax->amountPercentage[$i] }} / 100;
                        $("#taxInformation").append($("#taxInformationClone").html());
                    @endfor
                    total *= 1 + taxes;
                    break;
                @endforeach
                default:
                    total = taxInformation(0.00, 0.00, total);
                    break;
            }
            
            total = Math.round(100 * total) / 100;
            
            $("#totalPrice").val("$" + total);
        }
        
        $(".quantity").change(function() {
            updateTotal();
        });
        
        $(":input").change(function() {
            updateTotal();
        });
        
        function updateStateOrProvince(arr) {
            $("#stateOrProvinceMenu").html("");
            arr.forEach(function(element) {
                $("#stateOrProvinceMenu").append("<div class=\"item\" data-value=\"" + element + "\">" + element + "</div>");
            });
            $("#stateOrProvinceMenu").parent().find(".text").html(arr[0]);
            $('[name="stateOrProvince"]').val(arr[0]);
            updateTotal();
        }
        
        updateStateOrProvince(canadaProvinces);
        $('[name="country"]').change(function() {
            switch ($(this).val()) {
                case ("Canada"):
                    updateStateOrProvince(canadaProvinces);
                    break;
                case ("USA"):
                    updateStateOrProvince(usaStates);
                    break;
                default:
                    break;
            }
        });
        
        $('.ui.form').form({
            fields: {
                country         : 'empty',
                stateOrProvince : 'empty',
                city            : 'empty',
                streetAddress   : 'empty',
                postalCode      : 'empty'
            }
        });
    });
</script>
<span id="taxInformationClone" style="display: none">
    <div class="fields">
        <div class="field">
            <strong class="taxName">+GST: </strong>$<span class="taxPercentage"></span>
        </div>
    </div>
</span>
<span id="stateOrProvinceItemClone" style="display: none">
    <div class="item" data-value=""></div>
</span>
@endif
@endsection