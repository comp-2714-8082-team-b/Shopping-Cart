@extends('Layout/layout')
@include('Layout/header')
@section('content')
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