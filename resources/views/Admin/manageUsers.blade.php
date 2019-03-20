@extends('Layout/layout')
@include('Layout/header')
@section('content')
<h1>Manage Users Page</h1>
<div class="ui message hidden" id="ajaxResultBox">
    <i class="close icon"></i>
    <div class="header" id="ajaxResultHeader"></div>
    <p id="ajaxResultMessage"></p>
</div>
<div class="ui six column grid">
@for ($i = 0; $i < count($users); $i++)
    <form class="ui large form row userForm">
        <div class="column ui input middle aligned">
            <input type="text" name="email" value="{{ $users[$i]->email }}" readonly="readonly">
        </div>
        <div class="column ui input middle aligned">
            <input type="text" name="userName" value="{{ $users[$i]->userName }}">
        </div>
        <div class="column ui input middle aligned">
            <input type="text" name="firstName" value="{{ $users[$i]->firstName }}">
        </div>
        <div class="column ui input middle aligned">
            <input type="text" name="lastName" value="{{ $users[$i]->lastName }}">
        </div>
        <div class="column middle aligned">
            <select name="type" class="ui dropdown">
                @if ($users[$i]->type == "user")
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                @elseif ($users[$i]->type == "admin")
                    <option value="user">User</option>
                    <option value="admin" selected>Admin</option>
                @else
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="master" selected>Master</option>
                @endif
            </select>
        </div>
        <div class="column middle aligned">
            <button type="button" value="Update" class="ui icon blue button" onclick="saveOrDeleteUser(0, {{ $i }})">
                <i class="save icon"></i> Save
            </button>
            <button type="button" value="Delete" class="ui icon red button" onclick="saveOrDeleteUser(1, {{ $i }})">
                <i class="x icon"></i> Delete
            </button>
        </div>
    </form>
@endfor
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
            data: new FormData($('.userForm')[formNumber]),
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
                        $('.userForm')[formNumber].remove();
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