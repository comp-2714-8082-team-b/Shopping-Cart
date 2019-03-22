<style type="text/css">
    body {
      background-color: white;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }

    button {
        background: none;
	    color: inherit;
	    border: none;
	    padding: 0;
	    font: inherit;
	    cursor: pointer;
	    outline: inherit;
    }

</style>
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/login_background.css') }}">
<style>
/* Google Fonts */
@import url(https://fonts.googleapis.com/css?family=Anonymous+Pro);

.line-1{
    position: relative;
    top: 50%;  
    width: 24em;
    margin: 0 auto;
    border-right: 2px solid rgba(255,255,255,.75);
    font-size: 180%;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    transform: translateY(-50%);    
}

/* Animation */
.anim-typewriter{
  animation: typewriter 2s steps(35) 1s 1 normal both,
             blinkTextCursor 500ms steps(44) infinite normal;
}
@keyframes typewriter{
  from{width: 0;}
  to{width: 11.5em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.75);}
  to{border-right-color: transparent;}
}
</style>
<section class="main">


<div class="absolute cloud_left">
    <ul class="inline-list">
      <li class="cloud"></li>
      <li class="cloud"></li>
      <li class="cloud"></li>
    </ul>
</div>

<div class="absolute cloud_right">
    <ul class="inline-list">
      <li class="cloud"></li>
      <li class="cloud"></li>
      <li class="cloud"></li>
    </ul>
</div>

<span class="absolute sun"></span>


<div class="absolute landscape left_m">

    <span class="grass gl">
        <span class="land_tree leftt-gras">
            <ul class="inline-list">
              <li class="t_grass"></li>
              <li class="t_grass"></li>
              <li class="t_grass"></li>
            </ul>
        </span>
    </span>

    <span class="absolute tree1"></span>
    <span class="absolute tree2"></span>
</div>

<div class="absolute landscape max_right">

    <span class="grass">
        <span class="land_tree">
            <ul class="inline-list">
              <li class="t_grass"></li>
              <li class="t_grass"></li>
              <li class="t_grass"></li>
            </ul>
        </span>
    </span>

    <div class="mountain">
        <div class="r-mountain"></div>
        <ul class="snow inline-list">
                <li></li>
                <li></li>
                <li></li>
        </ul>
    </div>

</div>

<div class="absolute boat">
    <ul class="no-bullet">
        <ul class="no-bullet fume">
            <li class="fume4"></li>
            <li class="fume3"></li>
            <li class="fume2"></li>
            <li class="fume1"></li>
        </ul>
        <li class="smokestack"></li>
        <li class="white-body">
            <ul class="windows inline-list">
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
            </ul>
        </li>
        <li class="boat-body"></li>
    </ul>
</div>

<div class="absolute dark-back"></div>

<div class="absolute plane">
    <ul class="no-bullet">
        <li class="plane-body">
            <ul class="windows inline-list">
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
                <li class="circle"></li>
            </ul>
        </li>

        <li class="wing1"></li>
        <li class="wing1 flipwing"></li>
        <li class="absolute teal"></li>
    </ul>
</div>

<div class="absolute sea">
    <span class="wave1"></span>
    <span class="wave2"></span>
    <span class="wave3"></span>
    <span class="wave4"></span>
</div>

</section>