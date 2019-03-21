@extends('Layout/layout', ['showHeader' => true, 'title' => 'Home'])
@section('content')
<div class="ui stackable fourteen column centered grid">
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
                    <div class="item">
                        <h2>Price Range</h2>
                        <div class="ui form">
                            <div class="two wide fields">
                            <div class="field">
                                <div class="ui input">
                                    <input max="9999" type="number" placeholder="$ Min..." id='priceMin' name='priceMin'>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui input">
                                    <input max="9999" type="number" placeholder="$ Max..." id='priceMax' name='priceMax' />
                                </div>
                            </div>
                        </div>
                            <button type="button" class="ui primary button">
                                Save
                            </button>
                        
                        
                        </div>
                    </div>
                    <div class="item">
                    <h2>Sort By:</h2>
                    <div class="ui radio checkbox">
                        <input type="radio" name = "sortBy" value="itemPrice ASC" id='priceLowToHigh' checked="checked">
                        <label for="priceLowToHigh">Price(Low to High)</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input type="radio" name="sortBy" value="itemPrice DESC" id='priceHighToLow'>
                        <label for="priceHighToLow">Price(High to Low)</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input type="radio" name="sortBy" value="itemName ASC" id='alphabeticalAtoZ'>
                        <label for="alphabeticalAtoZ">Alphabetical(A to Z)</label>
                    </div>
                    <div class="ui radio checkbox">
                        <input type="radio" name="sortBy" value="itemName DESC" id='alphabeticalZtoA'>
                        <label for="alphabeticalZtoA">Alphabetical(Z to A)</label>
                    </div>
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

    var transitionSpeed = 300;
    var transitionDelay = 2000;
    $(".deleteItem")
    function saveOrDeleteUser(saveOrDelete, formNumber)
    {
        var url = "";
        if (saveOrDelete === 0)
        {
            url = "{{ route('updateUser') }}";
        }
        else
        {
            url = "{{ route('deleteUser') }}";
        }
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            data: new FormData($('.itemForm')[formNumber]),
            success: function(response) {
                if (response["result"] == "success")
                {
                    $("#ajaxResultHeader").html(response["data"]);
                    $("#ajaxResultMessage").html("");
                    $("#ajaxResultBox").removeClass("red");
                    $("#ajaxResultBox").addClass("green");
                    $("#ajaxResultBox").slideDown(transitionSpeed).delay(transitionDelay).slideUp(transitionSpeed);
                    if (saveOrDelete == 1)
                    {
                        $('.itemForm')[formNumber].remove();
                    }
                }
                else
                {
                    $("#ajaxResultHeader").html("Request Failed");
                    $("#ajaxResultMessage").html("<ul>");
                    var arr = $.parseJSON(JSON.stringify(response["data"]));
                    $.each(arr, function(index, value) {
                        $("#ajaxResultMessage").append("<li>" + value + "</li>");
                    });
                    $("#ajaxResultMessage").append("</ul>");
                    $("#ajaxResultBox").removeClass("green");
                    $("#ajaxResultBox").addClass("red");
                    $("#ajaxResultBox").slideDown(transitionSpeed);
                }
            }
        });
    }
    
    
    $('.message .close').on('click', function() {
        $(this)
            .closest('#ajaxResultBox')
            .slideUp(transitionSpeed)
        ;
     });
</script>
@endsection