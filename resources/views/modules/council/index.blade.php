@extends('layouts.app')
@section('page-name', 'Council Members')
@section('page-icon', 'users')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xs-12 elevate p-2">
                                    <label for="">New Member</label>
                                    <hr>
                                    <br>
                                    <form id="add-executives-form" class="p-2" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <label for="">Title<span style="color:red">*</span></label>
                                                <select name="title" required class="form-control select2 drop">
                                                    <option value="">--Select--</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Dr">Dr</option>
                                                    <option value="Prof">Prof</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Name<span style="color:red">*</span></label>
                                                <input type="text" required name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Position</label>
                                                <input type="text" name="position" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Status<span style="color:red">*</span></label>
                                                <select name="status" required class="form-control select2 drop">
                                                    <option value="">--Select--</option>
                                                    <option value="0">Active</option>
                                                    <option value="1">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Phone</label>
                                                <input type="text" name="phone" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Email</label>
                                                <input type="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Start Date</label>
                                                <input type="date" name="start_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">End Date</label>
                                                <input type="date" name="end_date" class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" form="add-executives-form"
                                            class="btn btn-primary float-right btn-sm waves-effect waves-light mt-2">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 col-xs-12">
                                    <div class="table-responsive mt-2">
                                        <table class="datatable table table-stripped" width='100%' id="nec-table">
                                            <thead>
                                                <tr>
                                                    <th><small>NO. </small></th>
                                                    <th><small>NAME </small></th>
                                                    <th><small>POSITION </small></th>
                                                    <th><small>CONTACT </small></th>
                                                    <th><small>START DATE </small></th>
                                                    <th><small>END DATE </small></th>
                                                    <th><small>STATUS </small></th>
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
    @include('modules.council.modals.edit')

    <script>
        var necTable = $('#nec-table').DataTable({
            dom: "Bfrtip",
            ajax: {
                url: `${APP_URL}/api/councils`,
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
                    data: "name"
                },
                {
                    data: "position"
                },
                {
                    data: "contact"
                },
                {
                    data: "startDate"
                },
                {
                    data: "endDate"
                },
                {
                    data: "statusDesc"
                },
                {
                    data: null,
                    className: 'pr-0 text-right',
                    'render': function(data, type, full, meta) {
                        var html = ``;

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
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'copy',
                    text: 'COPY',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    attr: {
                        class: "btn btn-sm custom-button rounded-right"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
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

        const addForm = document.forms["add-executives-form"];

        $(addForm).submit(function(e) {
            e.preventDefault();

            var formdata = new FormData(addForm)
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
                    fetch(`${APP_URL}/api/councils`, {
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
                        $("#add-modal").modal('hide');
                        necTable.ajax.reload(false, null);
                        addForm.reset();
                        $(".drop").val(null).trigger('change');

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
        $("#nec-table").on("click", ".update-btn", function() {
            let data = necTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");
            $("#update-nec-code").val(data.id);
            $("#update-nec-name").val(data.name);
            $("#update-nec-title").val(data.title).trigger("change");
            $("#update-nec-phone").val(data.phone);
            $("#update-nec-position").val(data.position);
            $("#update-nec-email").val(data.email);
            $("#update-nec-startdate").val(data.start_date);
            $("#update-nec-enddate").val(data.end_date);
            $("#update-nec-status").val(data.status).trigger("change");
        });

        // Handle when delete button is clicked
        $("#nec-table").on("click", ".delete-btn", function() {
            var data = necTable.row($(this).parents("tr")).data();

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
                    fetch(`${APP_URL}/api/councils/${data.id}`, {
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
                        necTable.ajax.reload(false, null);
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
