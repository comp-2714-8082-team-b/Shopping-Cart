@extends('Layout/layout')
@include('Layout/header')
@section('content')
<div class="ui fourteen column centered grid">
   <div class="row">
        <div class="three wide column">
            <div class="ui vertical menu">
                <form action="" method="POST" id='filterForm'>
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
                    <h2>Price Range</h2>
                    <div class="item">
                        <div class="ui input">
                            <input type="number" placeholder="$ Min..." id='priceMin' name='priceMin'>
                        </div>
                        <div class="ui input">
                            <input type="number" placeholder="$ Max..." id='priceMax' name='priceMax' />
                        </div>
                        <button type="button" class="ui primary button">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="eleven wide column">
            <div class="ui divided items" id="itemsSection">
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("body").on('click', '.addToCartButton', function () {
            var modelNumber = $(this).val();
            var quantityID = modelNumber + "Quantity";
            var requestedQuantity = $("#" + quantityID).val();
            $.ajax({
                url: "{{ route('addToCart') }}",
                type: "POST",
                data: {
                    modelNumber: modelNumber,
                    requestedQuantity: requestedQuantity
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response["data"] === "fail") {
                        alert("Failed to add item to cart");
                    } else {
                        alert(response["data"]);
                    }
                },
                error: function () {
                    alert("Failed to add item");
                }
            });
        });

        function sendRequest(index) {
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
                    $("#itemsSection").append(response["data"]);
                },
                error: function () {
                    //alert(data.toString());
                }
            });
        }

        $("#submitPrice").click(function () {
            sendRequest();
        })

        sendRequest(0);
    });

</script>
@endsection