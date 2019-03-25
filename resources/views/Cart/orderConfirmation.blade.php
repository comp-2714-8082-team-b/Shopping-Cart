@extends('Layout/layout', ['showHeader' => true, 'title' => 'Order Confirmation'])
@section('content')
<h1>Thank you for your order!</h1>
<h2>Subtotal: ${{ $subtotal }}</h2>
<h2>Delivery Address: {{ $address }}</h2>
<h2>Est. Delivery Date: {{ $estDeliveryDate->estDeliveryDate }}</h2>
<div class="ui divided items" id="itemsSection">
    @include('item', ['items' => $items, 'canBeAddedToCart' => false, 'quantityChangable' => false])
</div>
<script>
    shortenItemDescriptions();
</script>
@endsection