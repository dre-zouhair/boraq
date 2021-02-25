@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12" id="alert-body">
            </div>
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="col-md-12">
                            <div class="card-title button">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                    Create New Product
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="data-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>initial price</th>
                                <th>Quantity</th>
                                <th>Quantity en stock</th>
                                <th>Transportation cost</th>
                                <th>selling price</th>
                                <th>Administrator</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="table-content">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-add-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    {{ __('Add serials')}}
                    <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <form method="POST" name="Pform" id="ProductForm">
                <input type="hidden" name="Product_id" id="Product_id">
                <div class="modal-body">
                    <div id='alert' class='hide'></div>
                    <div class="modal-split" id="modal-split-1">
                            <div class="modal-body">
                                @csrf

                                <div class="form-group row">
                                    <label for="P_name" class="col-md-4 col-form-label text-md-right">{{ __('P_name') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_name"  type="text" class="form-control @error('P_name') is-invalid @enderror" name="P_name" value="{{ old('P_name') }}" required autocomplete="name"  autofocus>

                                        @error('P_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="P_I_price" class="col-md-4 col-form-label text-md-right">{{ __('E-P_I_price') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_I_price" type="number" min="0" class="form-control @error('P_I_price') is-invalid @enderror" name="P_I_price" value="{{ old('P_I_price') }}" required autocomplete="P_I_price">

                                        @error('P_I_price')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="P_count" class="col-md-4 col-form-label text-md-right">{{ __('P_count') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_count" type="number" min="0" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"   step="1" class="form-control @error('P_count') is-invalid @enderror" name="P_count" required autocomplete="P_count">

                                        @error('P_count')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="P_T_cost" class="col-md-4 col-form-label text-md-right">{{ __('P_T_cost') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_T_cost" type="number" min="0" class="form-control @error('P_T_cost') is-invalid @enderror" name="P_T_cost" value="{{ old('P_T_cost') }}" required autocomplete="P_T_cost" autofocus>

                                        @error('P_T_cost')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="P_S_price" class="col-md-4 col-form-label text-md-right">{{ __('-P_S_price') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_S_price" type="number" min="0" class="form-control @error('P_S_price') is-invalid @enderror" name="P_S_price" value="{{ old('P_S_price') }}" required autocomplete="P_S_price">

                                        @error('P_S_price')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                    </div>

                    <div class="modal-split" id="modal-split-2">
                        <div class="form-group row">
                            <label for="P_I_price2" class="col-md-4 col-form-label text-md-right">{{ __('Les series') }}</label>
                            <div class="col-md-6" id="field_wrapper">
                                <div class="input-group serial">
                                    <input type="text" name="field_name[]" class="form-control" id="field_name" value=""/>
                                    <a href="javascript:void(0);" id="add_button" class="add_button" title="Add field"><i class="fas fa-plus-square fa-2x ml-2 mt-1" style="color:#28a745"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--
                    <div class="modal-split">
                        3
                    </div>
                -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="backButton" style="display: none;">Back</button>
                    <button type="button" class="btn btn-primary" id="nextButton">Next</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script type="text/javascript">
        function showAlert(message,type,one) {
            $('#'+one).html('<div class="alert alert-'+type+' alert-dismissible fade show" role="alert">' +
                '  <strong>'+message+'</strong>' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '    <span aria-hidden="true">&times;</span>' +
                '  </button>' +
                '</div>');
            $('#alert').show();
        }
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
           var table = $('#data-table').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax" : "{{ route('allProducts') }}",
                "columns" : [
                    {
                        class: "details-control detail",

                        orderable:      false,
                        data: 'id',
                        name: 'id',
                       //defaultContent: "<i class=\"fas fa-plus-square fa-2x ml-2 mt-1\" id='detail' style=\"color:#28a745\"></i>"
                    },

                    { data: 'P_name', name: 'P_name' },
                    { data: 'P_I_price', name: 'P_I_price' },
                    { data: 'P_count', name: 'P_count' },
                    { data: 'en_stock', name: 'en stock' },
                    { data: 'P_T_cost', name: 'P_T_cost' },
                    { data: 'P_S_price', name: 'P_S_price' },
                    { data: 'admin', name: 'admin' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]});
           var detailRows = [];
           function format ( d ) {
                var detail = "null";
                $.ajax({
                    data: d,
                    async: false,
                    url: "{{ route('AllSerials') }}",
                    method : "GET",
                    dataType: 'json',
                    success: function (response) {
                        var res ="Serial List : ";
                        response.forEach(element => {
                            if(res == "Serial List : " ){
                                res+= '<span class="btn btn-outline-info btn-sm ml-2">'+element.P_serial+'</span>';
                            }else{
                                res+= '<span class="btn btn-outline-info btn-sm ml-2">'+element.P_serial+'</span>';
                            }
                        });
                        detail =res;
                    },
                    error: function (responseError) {
                            detail = responseError.responseText;
                    }
                });
                return detail;

           }
           $('#data-table tbody').on( 'click', 'tr td.detail', function () {

                var tr = $(this).closest('tr');
                var row = table.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
           });
            // On each draw, loop over the `detailRows` array and show any child rows
           table.on( 'draw', function () {
                $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            });
           $('#data-table').attr("style","none");

           $('body').on('click', '.editProduct', function () {
               $("#alert").hide();
                var Product_id = $(this).data('id');
               var id_count = $('[id=same]');
               if (id_count .length > 0){
                   $('[id=same]').remove();
               }

                $.ajax({
                    url:"{{route('productId')}}",
                    method:'get',
                    data:{id:Product_id},
                    dataType:'json',
                    success:function(data)
                    {

                        $('.modal-header').html('Edit Product'+'  <button type="button" class="close" id="closeModal" onclick="resetForm()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n');
                        $('#myModal').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#Product_id').val(data.id);
                        $("#P_name").val(data.P_name);
                        $("#P_I_price").val(data.P_I_price);
                        $("#P_count").val(data.P_count);
                        $("#P_count").removeAttr("min");
                        $("#P_count").attr("min",data.P_count- data.serials.length + 1);
                        $("#P_T_cost").val(data.P_T_cost);
                        $("#P_I_price").val(data.P_I_price);
                        $("#P_S_price").val(data.P_S_price);

                        var fieldHTML3 = '<div id="same" class="input-group">'
                            + '<input type="text" class="form-control" data-idOfSerial="';
                        var field3C = '" name="field_name[]"  value="';
                        var fieldHTML4 = '/><a href="javascript:void(0);" class="remove_button"><i class="fas fa-minus-square fa-2x ml-2 mt-1" style="color:#dc3545"></i></a></div>';

                        if(data.serials.length>0){
                                data.serials.forEach(element => {
                                    $('#field_wrapper').append(fieldHTML3+element.id+field3C+element.P_serial+'"'+fieldHTML4); //Add field html
                                    $('#field_name').val("");
                                });
                            }

                        if(data.disabled_serials.length > 0 ){
                            data.disabled_serials.forEach(element => {
                                $('#field_wrapper').append(fieldHTML3+element.id+field3C+element.P_serial+'" readonly />'); //Add field html
                                $('#field_name').val("");
                            });
                        }
                        $('.serial').hide();

                    },error:function (error) {
                        console.log(error.responseText);
                    }
                });
            });

           $('body').on('click', '.deleteProduct', function () {

                var Product_id = $(this).data("id");
                confirm("Are You sure want to delete !");
                $.ajax({
                    url:"{{route('deleteProduct')}}",
                    type: "GET",
                    data:{id:Product_id},
                    dataType:'json',
                    success:function(data)
                    {
                        console.log(data);
                        var table = $('#data-table').DataTable();
                        table.clear().draw();
                        showAlert('All fields are deleted','success','alert-body');
                    },
                    error: function (data) {
                         console.log('Error:', data.responseText);
                    }
                })
            });
        });

        var addButton = $('#add_button'); //Add button selector
        var wrapper = $('#field_wrapper'); //Input field wrapper
        var fieldHTML = '<div id="same" class="input-group"><input type="text" class="form-control" name="field_name[]" value="';
        var fieldHTML2 = '"/><a href="javascript:void(0);" class="remove_button"><i class="fas fa-minus-square fa-2x ml-2 mt-1" style="color:#dc3545"></i></a></div>';

        $(addButton).click(function(){
            if(document.querySelector('#field_name').value){
                if(document.querySelector('#Product_id').value == ""){
                    var id_count = $('[id=same]');
                    if (id_count.length < document.querySelector('#P_count').value){
                        $(wrapper).append(fieldHTML+document.querySelector('#field_name').value+fieldHTML2); //Add field html
                        $('#field_name').val("");
                        var test = id_count.length+1;

                        if(test ==  document.querySelector('#P_count').value){
                            $("#nextButton").removeAttr("disabled");
                            $('.serial').hide();
                        }
                    }
                }
                else{
                    var id_count = $('[id=same]');
                    if (id_count.length < document.querySelector('#P_count').value){

                        $(wrapper).append(fieldHTML+document.querySelector('#field_name').value+fieldHTML2); //Add field html
                        $('#field_name').val("");
                        var test = id_count.length+1;

                        if(test ==  document.querySelector('#P_count').value){
                            $("#nextButton").removeAttr("disabled");
                            $('.serial').hide();
                        }
                    }
                }

            }
        });
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            if(document.querySelector('#Product_id').value == ""){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                $("#nextButton").attr("disabled","true");
                $('.serial').show();
            }
            else{
                    e.preventDefault();
                    $(this).parent('div').remove(); //Remove field html
                    $("#nextButton").attr("disabled","true");
                    $('.serial').show();
            }
        });
        $('#P_count').on('focusin', function(){
            $(this).data('val', $(this).val());
        });
        $('#P_count').change(function () {
            var prev = $(this).data('val');
            var current = $(this).val();
            if(current>prev){
                $('.serial').show();
            }
            $(this).data('val', current);
        });
        $(document).ready(function() {
            prep_modal(0);
        });

        function resetForm() {
            $('#ProductForm').trigger("reset");
            $('#nextButton').removeAttr("disabled");
            $('#nextButton').text("Next");
            $('#nextButton').removeAttr("class");
            $('#nextButton').attr("class",'btn btn-primary');
            $('#nextButton').show();
            $('#backButton').click();
            $('#backButton').hide();
            $('#Product_id').removeAttr("value");
            $('#Product_id').attr("value","");
            var id_count = $('[id=same]').length;
            while(id_count > 0 ){
                $('#same').remove();
                --id_count;
            }


        }
        function prep_modal(page_track_)
        {
            $("#alert").hide();
            $(".modal").each(function() {
                var pages = $(this).find('.modal-split');
                if (pages.length != 0)
                {
                    pages.hide();
                    pages.eq(0).show();
                    var b_button = $('#backButton');
                    var n_button = $('#nextButton');
                    var page_track = page_track_;
                    $(n_button).click(function(e) {
                        if(page_track == 0 ){

                            if (document.forms["Pform"]["P_name"].value == "" || document.forms["Pform"]["P_I_price"].value == "" || document.forms["Pform"]["P_count"].value == "" || document.forms["Pform"]["P_T_cost"].value == "" || document.forms["Pform"]["P_S_price"].value == "" ){
                                showAlert('All fields are required','danger','alert');
                            }else{
                                if(document.querySelector('#Product_id').value == ""){
                                    $(n_button).text("Submit");
                                    $(n_button).removeAttr("class");
                                    $(n_button).attr("class",'btn btn-success');
                                    page_track++;
                                    pages.hide();
                                    pages.eq(page_track).show();
                                    $("#alert").hide();
                                    $(b_button).show();
                                    $(n_button).attr('disabled','true');
                                }else{
                                    $('#nextButton').attr('class',"btn btn-warning");
                                    $('#nextButton').html('Save Changes');
                                    page_track++;
                                    pages.hide();
                                    pages.eq(page_track).show();
                                    $("#alert").hide();
                                    $(b_button).show();
                                }
                            }
                        }
                        else{

                            e.preventDefault();
                            this.blur();
                            $('#nextButton').attr("disabled","true");
                            $('#nextButton').text("Saving ...");
                            $('#backButton').hide();

                            if(document.querySelector('#Product_id').value == ""){
                                $.ajax({
                                    data: $('#ProductForm').serialize(),
                                    url: "{{ route('addProduct') }}",
                                    method : "POST",
                                    dataType: 'json',
                                    success: function (data) {
                                        $('#ProductForm').trigger("reset");
                                        var table = $('#data-table').DataTable();
                                        table.clear().draw();

                                        $('#nextButton').removeAttr("disabled");
                                        $('#nextButton').text("Next");
                                        $('#nextButton').removeAttr("class");
                                        $('#nextButton').attr("class",'btn btn-primary');
                                        $('#nextButton').show();
                                        $('#backButton').hide();
                                        var id_count = $('[id=same]');
                                        if (id_count .length > 0){
                                            $('[id=same]').remove();
                                        }
                                        $('.serial').show();
                                        page_track--;
                                        pages.hide();
                                        pages.eq(page_track).show();
                                        $('#closeModal').click();
                                        showAlert('All fields are required','success','alert-body');

                                    },
                                    error: function (data) {
                                        $('#backButton').show();
                                        $('#nextButton').removeAttr("disabled");
                                        $('#nextButton').text("Submit");
                                        $('#nextButton').removeAttr("class");
                                        $('#nextButton').attr("class",'btn btn-success');
                                        showAlert('All fields are required','success','alert');

                                    }
                                });
                            }
                            else{
                                var id_count = $('[id=same]');
                                if (id_count.length < document.querySelector('#P_count').value){
                                        showAlert('not noht','danger','alert');
                                        $('.serial').show();
                                        $('#nextButton').text('save changes');
                                        $('#nextButton').removeAttr('disabled');
                                        $('nextButton').attr('disabled','true');
                                }
                                else{
                                    var serials= [];
                                    var data2 = new Array();
                                    $('#ProductForm').serializeArray().forEach(element => {
                                        if(element.name === "field_name[]" && element.name != "_token" ){
                                            if(element.value != ""){
                                                if($('input[value="'+element.value+'"]').attr('data-idofserial') === undefined){
                                                    serials.push({
                                                        "serial" : element.value,
                                                        "id" :  -1
                                                    });
                                                }else{
                                                    serials.push({
                                                        "serial" : element.value,
                                                        "id" :  $('input[value="'+element.value+'"]').attr('data-idofserial')
                                                    });
                                                }
                                            }
                                        }else{
                                                data2[element.name] = element.value;
                                        }
                                    });
                                    data2['serials']=serials;
                                    console.log(data2);
                                    $.ajax({
                                        data: {
                                                "_token" : data2["_token"],
                                                "Product_id" : data2["Product_id"],
                                                "P_name":data2["P_name"],
                                                "P_I_price":data2["P_I_price"],
                                                "P_count":data2["P_count"],
                                                "P_T_cost":data2["P_T_cost"],
                                                "P_S_price":data2["P_S_price"],
                                                "serials":data2["serials"]
                                        },
                                        url: "{{ route('updateProduct') }}",
                                        method : "POST",
                                        dataType: 'json',
                                        success: function (data) {
                                            console.log(data);
                                            $('#ProductForm').trigger("reset");
                                            var table = $('#data-table').DataTable();
                                            table.clear().draw();
                                            $('.modal-header').html('Add Product'+'  <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n');
                                            showAlert('All fields are required','success','alert-body');

                                            $('#nextButton').removeAttr("disabled");
                                            $('#nextButton').text("Next");
                                            $('#nextButton').removeAttr("class");
                                            $('#nextButton').attr("class",'btn btn-primary');
                                            $('#nextButton').show();
                                            $('#backButton').hide();
                                            var id_count = $('[id=same]');
                                            if (id_count .length > 0){
                                                $('[id=same]').remove();
                                            }
                                            $('.serial').show();
                                            page_track--;
                                            pages.hide();
                                            pages.eq(page_track).show();
                                            $('#closeModal').click();


                                        },
                                        error: function (data) {
                                            $('#backButton').show();
                                            $('#nextButton').removeAttr("disabled");
                                            $('#nextButton').text("save changes");
                                            $('#nextButton').removeAttr("class");
                                            $('#nextButton').attr("class",'btn btn-success');
                                            console.log('Error:', data.responseText);
                                            showAlert('All fields are required','success','alert');
                                        }
                                    });
                                }
                            }
                        }
                    });
                    $(b_button).click(function() {


                        if(page_track == 1)
                        {
                            $(b_button).hide();
                        }

                       if(page_track == pages.length-1)
                        {
                            $(n_button).text("Next");
                            $(n_button).removeAttr("class");
                            $(n_button).attr("class","btn btn-primary");
                        }

                        if(page_track > 0)
                        {
                            page_track--;
                            $('#nextButton').removeAttr("disabled");
                            pages.hide();
                            pages.eq(page_track).show();
                        }

                    });
                }
            });
        }


    </script>
@stop
