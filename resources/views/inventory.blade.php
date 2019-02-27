@extends('layout')
@section('content')
This is the Inventory Page
<script>
    $(document).ready(function() {
        $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
        $.ajax({
        url: "/getItems/0",
        type:"POST",
        success:function(data){
            alert(data);
        },error:function(){ 
            alert("error!!!!");
        }
    });
    });
</script>
@endsection