@extends('layouts.app')
@section('page-name', 'Professional Groups')
@section('page-icon', 'compass')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xs-12 elevate p-2">
                                    <label for="">New Group</label>
                                    <hr>
                                    <br>
                                    <form id="add-group-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col">
                                                <label for="">Description</label>
                                                <input type="text" required name="name" class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" form="add-group-form"
                                            class="btn btn-primary float-right btn-sm waves-effect waves-light mr-2">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="datatable table table-stripped" width='100%' id="group-table">
                                            <thead>
                                                <tr>
                                                    <th><small>NO. </small></th>
                                                    <th><small>DESCRIPTION </small></th>
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
    @include('modules.groups.modals.edit')

    <script>
        var groupTable = $('#group-table').DataTable({
            dom: "Bfrtip",
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            ajax: {
                url: `${APP_URL}/api/groups`,
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
                    data: "name",
                },
                {
                    data: null,
                    className: 'pr-0 text-right',
                    'render': function(data, type, full, meta) {
                        var html = ``;
                        // html +=
                        //     `<button data-toggle="tooltip" data-placement="top" title="" data-original-title="Info" class="btn btn-secondary btn-sm view-btn mr-1"> <i class="fa fa-eye"></i></button>`

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
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'copy',
                    text: 'COPY',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1]
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

        const addGroupForm = document.forms["add-group-form"];
        $(addGroupForm).submit(function(e) {
            e.preventDefault();

            var formdata = new FormData(addGroupForm)
            formdata.append("createuser", CREATEUSER);
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
                    fetch(`${APP_URL}/api/groups`, {
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
                        groupTable.ajax.reload(false, null);
                        addGroupForm.reset();
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

        // Handle when edit button is clicked
        $("#group-table").on("click", ".update-btn", function() {
            let data = groupTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");

            document.getElementById("update-group-code").value = data.id;
            document.getElementById("update-group-name").value = data.name;
        });

        // Handle when delete button is clicked
        $("#group-table").on("click", ".delete-btn", function() {
            var data = groupTable.row($(this).parents("tr")).data();

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
                    fetch(`${APP_URL}/api/groups/${data.id}`, {
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
                        groupTable.ajax.reload(false, null);
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
                        'Your is safe :)',
                        'success'
                    )
                }
            })

        });
    </script>
@endsection
