@extends('layouts.app')
@section('page-name', 'Congress')
@section('page-icon', 'cubes')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xs-12 elevate p-2">
                                    <label for="">New Congress</label>
                                    <hr>
                                    <br>
                                    <form id="add-congress-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col ">
                                                <label for="">Description</label>
                                                <input type="text" required name="description" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2 p-2">
                                            <div class="col">
                                                <label for="">Start Date</label>
                                                <input type="date" required name="start_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2 p-2">
                                            <div class="col">
                                                <label for="">End Date</label>
                                                <input type="date" required name="end_date" class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" form="add-congress-form"
                                            class="btn btn-primary float-right btn-sm waves-effect waves-light mr-2">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 col-xs-12">
                                    <div class="table-responsive mt-2">
                                        <table class="datatable table table-stripped" width='100%' id="congress-table">
                                            <thead>
                                                <tr>
                                                    <th><small>NO. </small></th>
                                                    <th><small>NAME </small></th>
                                                    <th><small>PHONE </small></th>
                                                    <th><small>EMAIL </small></th>
                                                    <th><small>GROUP </small></th>
                                                    <th><small>ACTION</small></th>
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
                </div>
            </div>
        </div>
    </div>
    @include('modules.congress.modals.edit')

    <script>
        var congressTable = $('#congress-table').DataTable({
            dom: "Bfrtip",
            ajax: {
                url: `${APP_URL}/api/congress`,
                type: "GET"

            },
            pageLength: 10,
            reponsive: false,
            processing: true,
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "description"
                },
                {
                    data: "startDate"
                },
                {
                    data: "endDate"
                },
                {
                    data: "status"
                },
                {
                    data: null,
                    className: 'pr-0 text-right',
                    'render': function(data, type, full, meta) {
                        var html = ``;
                        html +=
                            `<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Info" class="btn btn-secondary btn-sm view-btn mr-1"> <i class="fa fa-eye"></i></button>`

                        html +=
                            `<button   data-toggle="tooltip" data-placement="top" title="" data-original-title="Modify" class="btn btn-info btn-sm update-btn mr-1"> <i class="fa fa-edit"></i></button>`

                        html +=
                            `<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" class="btn btn-danger btn-sm delete-btn mr-1"> <i class="fa fa-trash"></i></button>`

                        return html
                    },
                },
            ],
            buttons: [{
                    extend: 'print',
                    text: 'PRINT',
                    attr: {
                        class: "btn btn-sm custom-button rounded-left"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'copy',
                    text: 'COPY',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    attr: {
                        class: "btn btn-sm custom-button rounded-right"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    text: "REFRESH",
                    attr: {
                        class: "btn btn-sm custom-button rounded-right"
                    },
                    action: function(e, dt, node, config) {
                        dt.ajax.reload(false, null);
                    }
                },
            ],
        });

        const addCongressForm = document.forms["add-congress-form"];

        $(addCongressForm).submit(function(e) {
            e.preventDefault();

            var formdata = new FormData(addCongressForm)
            formdata.append("createUser", CREATEUSER);
            Swal.fire({
                text: 'Are you sure you want to add record?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Submit'

            }).then((result) => {

                if (result.value) {
                    Swal.fire({
                        text: "Adding...",
                        showConfirmButton: false,
                        allowEscapeKey: false,
                        allowOutsideClick: false
                    });
                    fetch(`${APP_URL}/api/congress`, {
                        method: "POST",
                        body: formdata,
                    }).then(function(res) {
                        return res.json()
                    }).then(function(data) {
                        if (!data.ok) {
                            Swal.fire({
                                text: data.msg,
                                icon: "error"
                            });
                            return;
                        }
                        Swal.fire({
                            text: data.msg,
                            icon: "success"
                        });
                        congressTable.ajax.reload(false, null);
                        addCongressForm.reset();
                    }).catch(function(err) {
                        if (err) {
                            Swal.fire({
                                text: "failed"
                            });
                        }
                    })
                }
            })
        });

        //Script to update chapters
        $("#congress-table").on("click", ".update-btn", function() {
            let data = congressTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");
            $("#update-congress-code").val(data.id);
            $("#update-congress-title").val(data.description);
            $("#update-congress-startdate").val(data.start_date);
            $("#update-congress-enddate").val(data.end_date);
        });

        // Handle when delete button is clicked
        $("#congress-table").on("click", ".delete-btn", function() {
            var data = congressTable.row($(this).parents("tr")).data();

            Swal.fire({
                text: "Are you sure you want to remove this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        text: "Deleting...",
                        showConfirmButton: false,
                        allowEscapeKey: false,
                        allowOutsideClick: false
                    });
                    fetch(`${APP_URL}/api/congress/${data.id}`, {
                        method: "DELETE",
                    }).then(function(res) {
                        return res.json()
                    }).then(function(data) {
                        if (!data.ok) {
                            Swal.fire({
                                text: data.msg,
                                icon: "error"
                            });
                            return;
                        }
                        Swal.fire({
                            text: "Record deleted successfully",
                            icon: "success"
                        });
                        congressTable.ajax.reload(false, null);
                    }).catch(function(err) {
                        if (err) {
                            Swal.fire({
                                text: "Deleting failed"
                            });
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Cancelled',
                        'Your record is safe :)',
                        'success'
                    )
                }
            })

        });

    </script>
@endsection
