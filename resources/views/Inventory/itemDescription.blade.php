@extends('Layout/layout', ['showHeader' => true, 'title' => 'Item Description'])
@section('content')
    <h1 class="mid">Apple IPhone 15 svg</h1>
    <div class="cont">
        <div class="slider-outer">
            <img src="images/arrow-left.png" class="prev" alt="Prev">
            <div class="slider-inner">
                <img src="public/images/image1.jpg" class="active">
                <img src="images/image2.jpg">
                <img src="images/image3.jpg">
                <img src="images/image4.jpg">
            </div>
            <img src="images/arrow-right.png" class="next" alt="Next">
        </div>
    </div>
    <div class="ui raised  padded container segment">

        <div class="ui  four tablet stackable steps">
            <div class="step">
                <i class="tags icon"></i>
                <div class="content">
                    <div class="title">Price</div>
                    <div class="description"><p><span class="discount">$150</span> $180</p></div>
                </div>
            </div>
            <div class="step">
                <i class="warehouse icon"></i>
                <div class="content">
                    <div class="title">Quantity</div>
                    <div class="description">20s</div>
                </div>
            </div>
            <div class="step">
                <i class="building icon"></i>
                <div class="content">
                    <div class="title">Brand Name</div>
                    <div class="description">Apple</div>
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
            <div class="left floated left aligned eight wide column">
                    <button class="positive ui button">Buy</button>
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
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores obcaecati provident reprehenderit tempora? Animi at aut, dicta et hic ipsam molestiae possimus provident veniam voluptatum. Delectus est id illo illum?</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, doloribus esse exercitationem impedit nobis provident sed unde! Asperiores beatae debitis deleniti eaque esse excepturi molestias ratione reiciendis repudiandae voluptatem! Quae!</p>
        <ul>
            <li>Cheap</li>
            <li>Fast</li>
            <li>Safe</li>
            <li>Supported by ted!</li>
            <li>Powered by Davo</li>
        </ul>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A blanditiis nesciunt nihil repellat totam. Corporis deserunt dolores itaque odit! Assumenda deleniti fugit iste laborum libero magni, quo quod temporibus! Deleniti!</p>
@endsection
