<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.css">
</head>
<body> -->
@extends('layout')
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
                        <input type="number" placeholder="$ Min..." id='priceMin' name='priceMin'>
                    </div>
                    Up To
                    <div class="ui input">
                        <input type="number" placeholder="$ Max..." id='priceMax' name='priceMax' />
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
@endsection
<!-- </body>
</html> -->
