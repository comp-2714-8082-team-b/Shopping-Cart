@extends('Layout/layout')
@include('Layout/header')
@section('content')
<div class="ui centered form">
    <form class="ui large form" action="{{ $url }}" method="POST" enctype="multipart/form-data">
        @csrf()
        <div class="ui error message"></div>
        @if ($errors->any())
            <div class="ui red message">
                {!! implode('', $errors->all(':message</br>')) !!}
            </div>
        @endif
        <div class="fields">
            <div class="five wide field">
                <label>Model Number</label>
                <input type="text" placeholder="Model Number" name="modelNumber" value="{{ old('modelNumber', $item->modelNumber)  }}">
                <input type="hidden" name="formerModelNumber" value="{{ $item->modelNumber }}">
            </div>
            <div class="five wide field">
                <label>Item Name</label>
                <input type="text" placeholder="Item Name" name="itemName" value="{{ old('itemName', $item->itemName) }}">
            </div>
            <div class="four wide field">
                <label>Brand</label>
                <div class="ui search">
                    <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="Search brands..." name="brandName" value="{{ old('brandName', $item->brandName) }}">
                    </div>
                    <div class="results"></div>
                </div>
            </div>
        </div>
        <div class="fields">
            <div class="three wide field">
                <label>Item Price</label>
                <div class="ui labeled input">
                    <label for="itemPrice" class="ui label">$</label>
                    <input type="number" placeholder="0.00" id="itemPrice" name="itemPrice" value="{{ old('itemPrice', $item->itemPrice) }}">
                </div>
            </div>
            <div class="three wide field">
                <label>Sale Price</label>
                <div class="ui labeled input">
                    <label for="salePrice" class="ui label">$</label>
                    <input type="number" placeholder="0.00" id="salePrice" name="salePrice" value="{{ old('salePrice', $item->salePrice) }}">
                </div>
            </div>
            <div class="two wide field">
                <label>Stock Quantity</label>
                <div class="ui labeled input">
                    <label for="stockQuantity" class="ui label">#</label>
                    <input type="number" placeholder="0" id="stockQuantity" name="stockQuantity" value="{{ old('stockQuantity', $item->stockQuantity) }}">
                </div>
            </div>
            <div class="six wide field">
                <label>Categories</label>
                <div class="ui fluid multiple search selection dropdown">
                    <input name="categories" type="hidden" value="{{ old('categories', $item->categories) }}">
                    <i class="dropdown icon"></i>
                    <div class="default text">Categories</div>
                    <div class="menu">
                        @foreach ($categories as $category)
                            <div class="item" data-value="{{ $category->categoryName }}">{{ $category->categoryName }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="fields">
            <div class="fourteen wide field">
                <label>Description</label>
                <textarea name="description">{{ old('description', $item->description) }}</textarea>
            </div>
        </div>
        <div class="fields">
            <div class="field">
                 <label>Add Image</label>
                <button class="ui primary button" type="button" id="addImage">Add</button>
            </div>
        </div>
        <div class="fields ui seven column grid">
            <div class="row" id="imagesSection">
                <div id="clone" style="display:none;">
                    <div class="column">
                        <div class="ui placeholder">
                            <div class="square image" style="background-image: url('{{ asset('public/img/placeholder.png') }}');background-size: cover;">
                            </div>
                        </div>
                        <input type="file" class="photos" name="files[]" accept="image/*">
                        <button class="ui red button icon removeButton" type="button">
                            <i class="close icon"></i> Remove
                        </button>
                    </div>
                </div>
                @forelse ($item->pictures as $picture)
                <div class="column">
                    <div class="ui placeholder">
                        <div class="square image" style="background-image: url('{{ asset('storage/app/public/' . $picture) }}');background-size: cover;">
                        </div>
                    </div>
                    <button class="ui red button icon deleteButton" type="button" value="{{ $picture }}">
                        <i class="close icon"></i> Delete
                    </button>
                </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="fields">
            <div class="field">
                <button class="ui button right floated icon green" type="submit">
                    <i class="check icon"></i> Submit
                </button>
                <button class="ui button right floated icon" type="reset">
                    <i class="undo icon"></i> Reset
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.ui.dropdown').dropdown({
            allowAdditions: true
        });
        $('.ui.form').form({
            fields: {
                modelNumber:    ['empty', 'maxLength[63]'],
                itemName:       ['empty', 'maxLength[63]'],
                brandName:      ['empty', 'maxLength[63]'],
                itemPrice:      ['empty', 'number'],
                salePrice:      {
                    identifier: "salePrice",
                    optional: true,
                    rules: [
                    {
                      type   : 'decimal',
                      prompt : 'Sale price must be a valid decimal'
                    }
                  ]
                },
                stockQuantity:  ['empty', 'integer'],
                description:    ['empty', 'maxLength[127]']
            }
        });
        
        
        var content = [
            @foreach ($brandNames as $brandName)
                { title: '{{ $brandName->brandName }}' },
            @endforeach
        ];
        $('.ui.search').search({source: content});

        function resetListener()
        {
            $(".photos").change(function() {
                var url = URL.createObjectURL(event.target.files[0]);
                var thumbnail = $(this).parent().find(".image");
                thumbnail.css('background-image', "url('"+ url + "')");
            });
        }
      $("#addImage").click(function(){ 
          var html = $("#clone").html();
          $("#imagesSection").append(html);
          resetListener();
      });

      $("body").on("click",".removeButton",function(){ 
          $(this).closest(".column").remove();
      });

      $("body").on("click",".deleteButton",function(){
          $.ajax({
                url: "{{ route('deleteFile') }}",
                type: "POST",
                data: {
                    filePath: $(this).val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    //alert("Deleted File");
                }
            });
          $(this).closest(".column").remove();
      });

    });
</script>
@endsection