@extends('Layout/layout', ['showHeader' => true, 'title' => 'Item Description'])
@section('content')
<style>
    .a{
    background-color: black;
    }
    .mid{
    text-align: center;
    }
    .grey{
    background-color: #0f0f0f;
    }
    .cont{
    width:540px;
    margin:40px auto;
    overflow:auto;
    }
    .discount{
    color: grey;
    text-decoration: line-through;
    }

    .slider-inner{
    width:500px;
    height:300px;
    position:relative;
    overflow:hidden;
    float:left;
    padding:3px;
    }

    .slider-inner img{
    display:none;
    width:500px;
    height:300px;
    }

    .slider-inner img.active{
    display:inline-block;
    }

    .prev,.next{
    float:left;
    margin-top:130px;
    cursor: pointer;
    }

    .prev{
    position:relative;
    margin-right:-45px;
    z-index:100;
    }

    .next{
    position:relative;
    margin-left:-45px;
    z-index:100;
    }
</style>

    <h1 class="mid">{{$item->itemName}}</h1>
    <div class="cont">
        <div class="slider-outer">
            <img src="{{asset('public/img/arrow-left.png')}}" class="prev" alt="Prev">
            <div class="slider-inner">
                @forelse ($item->pictures as $picture)
                <img src="{{Storage::disk('s3')->url($picture)}}" class="active">
                @empty
                @endforelse
            </div>
            <img src="{{asset('public/img/arrow-right.png')}}" class="next" alt="Next">
        </div>
    </div>
    <div class="ui raised  padded container segment">
        <div class="ui  four tablet stackable steps">
            <div class="step">
                <i class="tags icon"></i>
                <div class="content">
                    <div class="title">Price</div>
                    @if (is_null($item->salePrice))
                    <div class="description"><p>{{$item->itemPrice}}</p></div>
                    @else
                    <div class="description"><p><span class="discount">{{$item->itemPrice}}</span>{{$item->salePrice}}</p></div>
                    @endif
                </div>
            </div>
            <div class="step">
                <i class="warehouse icon"></i>
                <div class="content">
                    <div class="title">Quantity</div>
                    <div class="description">{{$item->stockQuantity}}</div>
                </div>
            </div>
            <div class="step">
                <i class="building icon"></i>
                <div class="content">
                    <div class="title">Category</div>
                    <div class="description">
                      @forelse ($item->categories as $category)
                      <p>{{$category}}</p>
                      @empty
                      @endforelse
                    </div>
                </div>
            </div>
            <div class="step">
                <i class="shipping fast icon"></i>
                <div class="content">
                    <div class="title">Delivery Time</div>
                    <div class="description">5 - 8 days</div>
                </div>
            </div>
        </div>
        <div class="ui right aligned grid">
            <div class="left floated left aligned four wide column">
                <button class="positive ui centered button">Buy</button>
                <div class="ui horizontal divider">
                  Or
                </div>
                <form target="_blank" action="https://bitcoinpay.com/sci/invoice/generate/" method="post">
                  <input type="hidden" name="request_str" value="l9oOn3FeQRpiby_DahU6Ojt2bqRbcJOtziqKot7N-PeERakTv54pSPD89r-FkQ3-LhPFfjc9G7lYHIfAqDiFayhe0hQKErraXVWfT4-n8R5Fsf5diMp5_cZTx2dLqP1hkju59CRHQzdkFE-hroHx2uAIK9WEZ53i6K720o8KQXtA4Rtfv2amathpagvpYpyBAzy8xGNlVwnzYdfFOF2NFwnTcwkCzoTNbOzapOC1LJWTmNNAp9kq7Q0FdQ9jwzdA3lXnYTJtJvxbq_CeeA1XFCv57c8as3Bbjpx6oXx1-xbDySnyqdvhLVUB1WiExL-SXf99zPdlLEjmYLE=">
                  <input type="hidden" name="amount" value="{{$item->itemPrice}}">
                  <input type="hidden" name="currency" value="CAD">
                  <input type="hidden" name="memo" value="{{$item->itemName}}">
                  <input type="image" src="https://bitcoinpay.com/static/img/btc-accepted-sm.png">
                </form>
            </div>
            <div class="right floated right aligned eight wide column">

                <button class="ui facebook button">
                    <i class="facebook icon"></i>
                    Facebook
                </button>
                <button class="ui twitter button">
                    <i class="twitter icon"></i>
                    Twitter
                </button>
                <button class="ui google plus button">
                    <i class="google plus icon"></i>
                    Google Plus
                </button>
            </div>
        </div>
        <h2 class="">Description</h2>
        <div class="ui divider"></div>
        <p>{!! nl2br($item->description) !!}</p>
        <script>
            $(document).ready(function(){
                $('.next').on('click', function(){
                    var currentImg = $('.active');
                    var nextImg = currentImg.next();

                    if(nextImg.length){
                        currentImg.removeClass('active').css('z-index', -10);
                        nextImg.addClass('active').css('z-index', 10);
                    }
                });

                $('.prev').on('click', function(){
                    var currentImg = $('.active');
                    var prevImg = currentImg.prev();

                    if(prevImg.length){
                        currentImg.removeClass('active').css('z-index', -10);
                        prevImg.addClass('active').css('z-index', 10);
                    }
                });
            });
        </script>
@endsection
