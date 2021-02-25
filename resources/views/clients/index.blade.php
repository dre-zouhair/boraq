@extends('layouts.admin')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" id="alert-body">
            </div>
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="col-md-12">
                            <h4 class="card-title">
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="data-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajaxModel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-lg">
                <div class="modal-header modal-lg">
                    <h4 class="modal-title" id="modelHeading2"></h4>
                </div>
                <div class="modal-body modal-lg">
                    <div class="col-md-12" id="alert-update">

                    </div>
                    <div class="col-md-12 modal-bills" id="modal-bills">

                            <table class="table table-bordered" id="history-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>date</th>
                                    <th>Payment method</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                    </div>
                    <div class="col-md-12 modal-hist hide" id="modal-hist">
                            <table>
                                <tr class="top">
                                    <td colspan="4">
                                        Invoice #: 123<br> Created: January 1, 2015<br> Due: February 1, 2015
                                    </td>
                                                <td class="title" colspan="4">
                                                    <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                                                </td>


                                </tr>

                                <tr class="information">

                                                <td colspan="4">
                                                    Sparksuite, Inc.<br> 12345 Sunny Road<br> Sunnyville, CA 12345
                                                </td>

                                                <td colspan="4">
                                                    Acme Corp.<br> John Doe<br> john@example.com
                                                </td>

                                </tr>
                            </table>
                            <table class="table table-bordered bill-table" id="bill-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>date</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                    </div>
                </div>
                <div class="modal-footer modal-lg">
                    <h4 class="modal-title" id="modelHeading2">
                       <button type="button" class="btn btn-primary" id="return" hidden="true">Go back</button>
                    </h4>
                </div>
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

            var table =  $('#data-table').DataTable({
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax" : "{{ route('allClients') }}",
                "columns" : [
                    { data: 'id', name: 'id' },
                    { data: 'C_name', name: 'C_name' },
                    { data: 'C_identifier', name: 'C_identifier' },
                    { data: 'C_type', name: 'C_type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]});

            $('body').on('click', '.displayClient', function () {
                var Client_id = $(this).data('id');
                $('#modelHeading2').html("Client History");
                $('#ajaxModel2').modal('show');
                var tab;
                if ( $.fn.dataTable.isDataTable( '#history-table' ) ) {
                    tab = $('#history-table').DataTable();
                }
                else {
                    tab =  $('#history-table').DataTable({
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "{{ route('clientHistory') }}",
                        "data": {
                            "Client_id": Client_id
                        }},
                        "columns" : [
                            { data: 'id', name: 'id' },
                            { data: 'user', name: 'user' },
                            { data: 'value', name: 'value' },
                            { data: 'date', name: 'date' },
                            {data:'payment_method',name:'payment_method'},
                            { data: 'action', name: 'action', orderable: false, searchable: false}]
                    });
                }
            });
            $('body').on('click', '.displayBill', function () {
                var Bill_id = $(this).data('id');
                var tab2;
                if ( $.fn.dataTable.isDataTable( '#bill-table' ) ) {
                    tab2 = $('#bill-table').DataTable();
                }
                else {
                    tab2 = $('#bill-table').DataTable({
                        "autoWidth": false,
                        "serverSide": true,
                        processing:true,
                        searching: false, paging: false,"ordering": false,
                        dom: 'Bfrtip',
                        buttons: [
                            'excel', 'pdf', 'print'
                        ],
                        "ajax": {
                            "url": "{{ route('displayBill') }}",
                            "data": {
                                "Bill_id": Bill_id
                            }},
                        "columns" : [
                            { data: 'id', name: 'id' },
                            { data: 'product_name', name: 'product_name' },
                            { data: 'Product_serial', name: 'Product_serial' },
                            { data: 'P_S_price', name: 'P_S_price' },
                        ]
                    });
                }
                $('#return').removeAttr('hidden');
                $('#modal-bills').hide();
                $('#modal-hist').show();
                console.log(Bill_id);
            });
            $('#return').on('click',function(){
                console.log('1');
                $('#modal-bills').show();
                $('#modal-hist').hide();
                $('#return').attr('hidden','true');
            });
        });
    </script>
@stop
