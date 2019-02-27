@extends('layout')
@section('content')
<h1>This is the Inventory Page</h1>
<div id='filterSection'>
    <form action="" method="POST" id='filterForm'>
        <h2>Category</h2>
        <input type="checkbox" name="category" value="Kitchenware" id='categoryKitchenware' /><label for="categoryKitchenware"> Kitchenware</label><br>
        <input type="checkbox" name="category" value="Automobile" id='categoryAutomobile' ><label for="categoryAutomobile"> Automobile</label><br>
        <input type="checkbox" name="category" value="Clothing" id='categoryClothing' ><label for="categoryClothing"> Clothing</label><br>
        <input type="checkbox" name="category" value="Computer" id='categoryComputer' ><label for="categoryComputer"> Computer</label><br>
        <h2>Brand</h2>
        <input type="checkbox" name="brand" value="Apple" id='categoryApple' /><label for="categoryApple"> Apple</label><br>
        <input type="checkbox" name="brand" value="Nike" id='categoryNike' ><label for="categoryNike"> Nike</label><br>
        <input type="checkbox" name="brand" value="KitchenAid" id='categoryKitchenAid' ><label for="categoryKitchenAid"> Kitchen Aid</label><br>
        <h2>Price Range</h2>
        $<input type="number" placeholder="min" id='priceMin' name='priceMin'/> - <input type="number" placeholder="max" id='priceMax' name='priceMax'/><button id='submitPrice' type='button'>Go</button>
   </form>
</div>
<div id='itemsSection'>
    Stuff
</div>
<script>
    $(document).ready(function() {
        function sendRequest()
        {
            $.ajax({
                url: "{{ route('getItems', ['index' => 0]) }}",
                type:"POST",
                processData: false,
                contentType: false,
                data: new FormData($('#filterForm')[0]),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    $("#itemsSection").append(response["data"]);
                },error:function() {
                    //alert(data.toString());
                }
            });
        }
        
        $("#submitPrice").click(function() {
            sendRequest();
        })
    });
</script>
@endsection