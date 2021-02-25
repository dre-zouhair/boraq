@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">

                        <table class="table"></table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var columnData = [{
            // Select the first column ...
            select: 0,

            // ...add a random number (age) to the cells
            render: function (data) {
                return data + " (" + (~~(Math.random() * (70 - 18) + 18)) + ")";
            }
        }, {
            // select the fourth column ...
            select: 3,

            // ... let the instance know we have datetimes in it ...
            type: "date",

            // ... pass the correct datetime format ...
            format: "YYYY/MM/DD",

            // ... sort it ...
            sort: "desc",
        }];

        // Customise our labels
        var labelData = {
            placeholder: "Search students...",
            perPage: "Show {select} students per page",
            noRows: "No students to display",
            info: "Showing {start} to {end} of {rows} students (Page {page} of {pages} pages)"
        };

        // Instantiate
        var datatable = new DataTable("table", {
            ajax: "https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/datatable.json",
            columns: columnData,
            labels: labelData
        });

        // Wait for the instance to finish rendering
        // and add a new column
        datatable.on("datatable.init", function () {

            var url = "https://s3-us-west-2.amazonaws.com/s.cdpn.io/86186/datatable.column.json";

            fetch(url).then(function (response) { return response.json(); })
                .then(function (column) {

                    // Render a button
                    column.render =  function (data, cell, row) {
                        // the dataIndex property is the correct index of the row in the data array, not the rowIndex
                        // which will be -1 if not rendered or wrong if the we're not on page 1
                        if(data == "2%")return data;
                        return data + "<button type='button' data-id='" + row.dataIndex + "' class='btn btn-sm btn-primary pull-right notify'>Click Me</button>";
                    };

                    datatable.columns().add(column);
                });
        });

        var notify = function (e) {

            if (e.target.nodeName === "BUTTON") {

                var index = parseInt(e.target.getAttribute("data-id"), 10);
                var row = datatable.activeRows[index];
                var message = [
                    "This is row ",
                    (row.rowIndex),
                    " of ",
                    datatable.options.perPage,
                    " rendered rows and row ",
                    (index + 1),
                    " of ",
                    datatable.data.length,
                    " total rows."
                ];

                var data = [].slice.call(row.cells).map(function (cell) {
                    return cell.data;
                });

                message = message.join("");

                message = message + "\n\nThe row data is:\n" + JSON.stringify(data);

                alert(message);
            }
        };

        datatable.body.addEventListener("click", notify);

        datatable.on("datatable.sort", function() {
            // Update the ids on eh buttons
            this.activeRows.forEach(function(row) {
                console.log(row)
                row.cells[row.cells.length - 1].lastElementChild.setAttribute("data-id", row.dataIndex);
            });
        });
    </script>
@endsection
@if (Route::has('register'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
    </li>
@endif
