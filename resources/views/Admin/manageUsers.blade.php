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
    <form method="POST" action="" class="ui large form row" id="userForm">
        <div class="column ui input">
            <input type="text" name="email" value="{{ $users[$i]->email }}" readonly="readonly">
        </div>
        <div class="column ui input">
            <input type="text" name="userName" value="{{ $users[$i]->userName }}">
        </div>
        <div class="column ui input">
            <input type="text" name="firstName" value="{{ $users[$i]->firstName }}">
        </div>
        <div class="column ui input">
            <input type="text" name="lastName" value="{{ $users[$i]->lastName }}">
        </div>
        <div class="column">
            <select name="type" class="ui dropdown">
                @if ($users[$i]->type == "user")
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                @else
                    <option value="user">User</option>
                    <option value="admin" selected>Admin</option>
                @endif
            </select>
        </div>
        <div class="column">
            <button type="button" value="Update" class="ui icon blue button" onclick="saveUser({{ $i }})">
                <i class="save icon"></i> Save
            </button>
            <button type="button" value="Delete" class="ui icon red button">
                <i class="x icon"></i> Delete
            </button>
        </div>
    </form>
@endfor
</div>
<script>
    function saveUser(formNumber)
    {
        $.ajax({
            type: "POST",
            url: "{{ route('updateUser') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            data: new FormData($('#userForm')[formNumber]),
            success: function(response) {
                if (response["result"] == "success")
                {
                    $("#ajaxResultHeader").html(response["data"]);
                    $("#ajaxResultBox").removeClass("red");
                    $("#ajaxResultBox").addClass("green");
                }
                else
                {
                    $("#ajaxResultHeader").html("Failed to Update User");
                    $("#ajaxResultMessage").append("<ul>");
                    var arr = $.parseJSON(JSON.stringify(response["data"]));
                    $.each(arr, function(index, value) {
                        $("#ajaxResultMessage").append("<li>" + value + "</li>");
                    });
                    $("#ajaxResultMessage").append("</ul>");
                    $("#ajaxResultBox").removeClass("green");
                    $("#ajaxResultBox").addClass("red");
                }
                $('#ajaxResultBox').transition('slide down');
            }
        });
    }
    
    
    $('.message .close').on('click', function() {
        $(this)
            .closest('#ajaxResultBox')
            .transition('slide down')
        ;
     });
</script>
@endsection