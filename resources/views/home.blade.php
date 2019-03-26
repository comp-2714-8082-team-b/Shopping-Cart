@extends('Layout/layout', ['showHeader' => true, 'title' => 'Home'])
@section('content')
<div class="ui bottom attached pushable stackable grid">
    <div class="row">
        <div class="four wide column">
            <div class="ui visible inverted left vertical sidebar menu form inverted">
                <form action="" method="POST" id='filterForm'>
                    <input type="hidden" name="searchKey" value="{{ $searchKey }}" />
                    <div class="item">
                        <h2>Category</h2>
                        @foreach ($categories as $row)
                        <div class="ui checkbox">
                            <input type="checkbox" name="category[]" value="{{ $row->categoryName }}" id='category{{ $row->categoryName }}' checked>
                            <label for="category{{ $row->categoryName }}">{{ $row->categoryName }}</label>
                        </div>
                        <br>
                        @endforeach
                    </div>
                    <div class="item">
                        <h2>Brand</h2>
                        @foreach ($brandNames as $row)
                        <div class="ui checkbox">
                            <input type="checkbox" name="brand[]" value="{{ $row->brandName }}" id="category{{ $row->brandName }}" checked>
                            <label for="category{{ $row->brandName }}">{{ $row->brandName }}</label>
                        </div>
                        <br>
                        @endforeach
                    </div>
                    <div class="item">
                        <h2>Price Range</h2>
                        <div class="ui form">
                            <div class="two wide fields">
                                <div class="field">
                                    <div class="ui input">
                                        <input max="9999" type="number" placeholder="$ Min" id='priceMin' name='priceMin'>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="ui input">
                                        <input max="9999" type="number" placeholder="$ Max" id='priceMax' name='priceMax' />
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="ui red button">Apply</button>
                        </div>
                    </div>
                    <div class="item">
                        <h2>Sort By:</h2>
                        <div class="ui radio checkbox">
                            <input type="radio" name = "sortBy" value="itemPrice ASC" id='priceLowToHigh' checked="checked">
                            <label for="priceLowToHigh">Price (Low - High)</label>
                        </div>
                        <div class="ui radio checkbox">
                            <input type="radio" name="sortBy" value="itemPrice DESC" id='priceHighToLow'>
                            <label for="priceHighToLow">Price (High - Low)</label>
                        </div>
                        <div class="ui radio checkbox">
                            <input type="radio" name="sortBy" value="itemName ASC" id='alphabeticalAtoZ'>
                            <label for="alphabeticalAtoZ">Alphabetical (A - Z)</label>
                        </div>
                        <div class="ui radio checkbox">
                            <input type="radio" name="sortBy" value="itemName DESC" id='alphabeticalZtoA'>
                            <label for="alphabeticalZtoA">Alphabetical (Z - A)</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="twelve wide column">
            <div class="ui basic segment">
                @if ($searchKey)
                     <h1>Results for "{{ $searchKey }}"</h1>
                @endif
                <div class="ui divided items" id="itemsSection">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("body").on('click', '.addToCartButton', function () {
            var modelNumber = $(this).val();
            var quantity = $(this).closest('.fields').find('.quantity').val();
            $.ajax({
                url: "{{ route('addToCart') }}",
                type: "POST",
                data: {
                    modelNumber: modelNumber,
                    quantity: quantity
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response["data"] === "fail") {
                        alert("Failed to add item to cart");
                    } else {
                        alert(response["data"]);
                        updateTotalInCart();
                    }
                },
                error: function () {
                    alert("Failed to add item");
                }
            });
        });
        
        $("body").on('click', '.deleteItem', function () {
            var modelNumber = $(this).val();
            $.ajax({
                url: "{{ route('deleteItem') }}",
                type: "POST",
                data: {
                    modelNumber: modelNumber
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    //alert("Deleted Item");
                }
            });
            $(this).closest(".item").remove();
        });
        
        $("form :input").change(function() {
            sendRequest(0);
        });
        
        function sendRequest(index) {
            $("#itemsSection").html("");
            $("#itemsSection").html($("#loadingClone").html());
            
            $.ajax({
                url: "{{ route('getItems') }}/" + index,
                type: "POST",
                processData: false,
                contentType: false,
                data: new FormData($('#filterForm')[0]),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $("#itemsSection").html("");
                    $("#itemsSection").append(response["data"]);
                    shortenItemDescriptions();
                    $('.ui.selection.dropdown').dropdown({
                      clearable: true
                    });
                },
                error: function () {
                    //alert(data.toString());
                }
            });
        }
        
        $("#submitPrice").click(function () {
            sendRequest(0);
        })
        
        sendRequest(0);
    });
    
    
    $('.message .close').on('click', function() {
        $(this)
            .closest('#ajaxResultBox')
            .slideUp(transitionSpeed)
        ;
    });
</script>
<div id="loadingClone" style="display:none">
    <div class="ui active inverted dimmer">
        <div class="ui large text loader">Loading</div>
    </div>
    <p></p>
    <p></p>
    <p></p>
</div>
@endsection