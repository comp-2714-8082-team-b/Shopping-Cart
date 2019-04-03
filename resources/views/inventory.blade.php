@extends('Layout/layout')
@include('Layout/header')
@section('content')
<div class="ui top attached menu">
    <a href="./" class="item">
        {{ config('app.name', 'Laravel') }}
    </a>
    <a href="./" class="item">
        <i class="home icon"></i>
    </a>
    @if (\Auth::check())
    <a href="{{ route('login')}}" class="item">
        Login
    </a>
    <a class="item">
        <i class="rocket icon"></i>
        Categories
    </a>
    @else
    <a href="{{ route('login')}}" class="item">
        Logout
    </a>
    @endif
    <div class="right menu">
    <a href="{{ route('cart') }}" class="item">
        <i class="shopping cart icon"></i>
    </a>
        <div class="ui right aligned category search item">
            <div class="ui transparent icon input">
                <input class="prompt" type="text" placeholder="Search items...">
                <i class="search link icon"></i>
            </div>
            <div class="results"></div>
        </div>
    </div>
</div>
<div class="ui bottom attached segment">
    <p></p>
</div>
<div class="ui grid">
  <div class="row">
    <div class="three wide column">
        <div class="ui vertical menu">
            <form action="" method="POST" id='filterForm'>
                <div class="item">
                    <h2>Category</h2>
                    <div class="ui checkbox">
                        <input type="checkbox" name="category[]" value="Kitchenware" id='categoryKitchenware'>
                        <label for="categoryKitchenware">Kitchenware</label>
                    </div>
                    <div class="ui checkbox">
                        <input type="checkbox" name="category[]" value="Automobile" id='categoryAutomobile'>
                        <label for="categoryAutomobile">Automobile</label>
                    </div>
                    <div class="ui checkbox">
                        <input type="checkbox" name="category[]" value="Automobile" id='categoryClothing'>
                        <label for="categoryClothing">Clothing</label>
                    </div>
                    <div class="ui checkbox">
                        <input type="checkbox" name="category[]" value="Automobile" id='categoryComputer'>
                        <label for="categoryComputer">Computer</label>
                    </div>
                </div>
                <div class="item">
                    <h2>Brand</h2>
                    <div class="ui checkbox">
                        <input type="checkbox" name="brand[]" value="Apple" id='categoryApple'>
                        <label for="categoryApple">Apple</label>
                    </div>
                    <div class="ui checkbox">
                        <input type="checkbox" name="brand[]" value="Nike" id='categoryNike'>
                        <label for="categoryNike">Nike</label>
                    </div>
                    <div class="ui checkbox">
                        <input type="checkbox" name="brand[]" value="KitchenAid" id='categoryKitchenAid'>
                        <label for="categoryKitchenAid">Kitchen Aid</label>
                    </div>
                    <div class="ui checkbox">
                        <input type="checkbox" name="category[]" value="Automobile" id='categoryComputer'>
                        <label for="categoryComputer">Computer</label>
                    </div>
                </div>
                <div class="item">
                  <h2>Price Range</h2>
                    <div class="ui ">
                    From
                    </div>
                    <div class="ui input">
                        <input type="number" min='0' max='9999' placeholder="$ Min..." id='priceMin' name='priceMin'>
                    </div>
                    Up To
                    <div class="ui input">
                        <input type="number" max='9999' placeholder="$ Max..." id='priceMax' name='priceMax' />
                    </div>
                    <button class="ui primary button">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

<div id="ten wide column">
    <div class="ui link cards">
        <div class="card item">
            <div class="image">
                <img src="{{ asset('public/semanticUI/semantic/image/iphone.jpg') }}">
            </div>
            <div class="content">
                <div class="header">iPhone XS MAX 64GB</div>
                <div class="meta">
                    <a>Apple</a>
                </div>
                <div class="description">
                    A phone with sophisticated simplicity.
                </div>
            </div>
            <div class="extra content">
                <span class="right floated">
                    $1505
                </span>
                <span>
                    <i class="heart icon"></i>
                    75
                </span>
            </div>
        </div>
        <div class="card item">
            <div class="image">
                <img src="{{ asset('public/semanticUI/semantic/image/macbook_pro.png') }}">
            </div>
            <div class="content">
                <div class="header">MacBook Pro 15 inch</div>
                <div class="meta">
                    <span class="date">Apple</span>
                </div>
                <div class="description">
                    A beautiful piece of art.
                </div>
            </div>
            <div class="extra content">
                <span class="right floated">
                    $1823
                </span>
                <span>
                    <i class="heart icon"></i>
                    35
                </span>
            </div>
        </div>
        <div class="card item">
            <div class="image">
                <img src="{{ asset('public/semanticUI/semantic/image/apple_watch.jpeg') }}">
            </div>
            <div class="content">
                <div class="header">Apple Watch</div>
                <div class="meta">
                    <a>Apple</a>
                </div>
                <div class="description">
                    A device on your arm.
                </div>
            </div>
            <div class="extra content">
                <span class="right floated">
                    $523
                </span>
                <span>
                    <i class="heart icon"></i>
                    151
                </span>
            </div>
        </div>
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
<!-- </body>
</html> -->
<h1>Inventory Page</h1>
<div class="ui message hidden" id="ajaxResultBox">
    <i class="close icon"></i>
    <div class="header" id="ajaxResultHeader"></div>
    <p id="ajaxResultMessage"></p>
</div>
<div class="ui divided items">
@include('item', ['items' => $items ])
</div>
<script>

    var transitionSpeed = 300;
    var transitionDelay = 2000;
    function saveOrDeleteUser(saveOrDelete, formNumber)
    {
        var url = "";
        if (saveOrDelete == 0)
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
