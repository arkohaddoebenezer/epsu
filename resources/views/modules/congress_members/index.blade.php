@extends('layouts.app')
@section('page-name', 'Congress Members')
@section('page-icon', 'user')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xs-12 elevate p-2">
                                    <label for="">New Registration</label>
                                    <hr>
                                    <br>
                                    <form id="add-member-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col">
                                                <label for="">First Name</label>
                                                <input type="text" name="fname" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col">
                                                <label for="">Last Name</label>
                                                <input type="text" name="lname" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row p-2">
                                            <div class="col">
                                                <label for="">Other Names</label>
                                                <input type="text" name="mname" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row p-2 mt-2">
                                            <div class="col">
                                                <label for="">Phone</label>
                                                <input type="tel" name="phone" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row p-2 mt-2">
                                            <div class="col">
                                                <label for="">Email</label>
                                                <input name="email" type="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row p-2 mt-2">
                                            <div class="col">
                                                <label for="">Union</label>
                                                <select name="union" class="form-control select2 drop" required>
                                                    <option value="">--Select--</option>
                                                    @foreach ($unions as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row p-2 mt-2">
                                            <div class="col">
                                                <label for="">Congress</label>
                                                <select name="congress" class="form-control select2 drop" required>
                                                    <option value="">--Select--</option>
                                                    @foreach ($congresses as $item)
                                                        <option value="{{ $item->id }}">{{ $item->description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" form="add-member-form"
                                            class="btn btn-primary float-right btn-sm waves-effect waves-light mr-2">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 col-xs-12">
                                    <div class="row">
                                        <div class="col-6 col-xs-12">
                                            <label for="">Congress</label>
                                            <select id="filter-congress" class="form-control select2">
                                                <option value="">--Select--</option>
                                                @foreach ($congresses as $item)
                                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6 col-xs-12">
                                            <label for="">Union</label>
                                            <select id="filter-union" class="form-control select2">
                                                <option value="">--Select--</option>
                                                @foreach ($unions as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="datatable table table-stripped" width='100%' id="member-table">
                                            <thead>
                                                <tr>
                                                    <th><small>NO. </small></th>
                                                    <th><small>NAME </small></th>
                                                    <th><small>PHONE </small></th>
                                                    <th><small>EMAIL </small></th>
                                                    <th><small>UNION </small></th>
                                                    <th><small>CONGRESS </small></th>
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
    @include('modules.congress_members.modals.edit')

    <script>
        var congress = document.getElementById('filter-congress').value;
        congress = Boolean(congress) ? congress : 'all';

        var union = document.getElementById('filter-union').value;
        union = Boolean(union) ? union : 'all';

        var memberTable = $('#member-table').DataTable({
            dom: "Bfrtip",
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            ajax: {
                url: `${APP_URL}/api/congress_members/${union}/${congress}`,
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
                    data: "fullName",
                },
                {
                    data: "phone",
                },
                {
                    data: "email",
                },
                {
                    data: "unionDesc",
                },
                {
                    data: "congressDesc",
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
                        class: "btn btn-sm custom-button"
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

        const addMemberForm = document.forms["add-member-form"];
        $(addMemberForm).submit(function(e) {
            e.preventDefault();

            var formdata = new FormData(addMemberForm)
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
                    fetch(`${APP_URL}/api/congress_members`, {
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
                        memberTable.ajax.reload(false, null);
                        $(".drop").val(null).trigger('change');
                        addMemberForm.reset();
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
        $("#member-table").on("click", ".update-btn", function() {
            let data = memberTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");

            document.getElementById("update-member-code").value = data.id;
            document.getElementById("update-member-fname").value = data.fname;
            document.getElementById("update-member-mname").value = data.mname;
            document.getElementById("update-member-lname").value = data.lname;
            document.getElementById("update-member-phone").value = data.phone;
            document.getElementById("update-member-email").value = data.email;
            $("#update-member-union").val(data.union).trigger("change");
            $("#update-member-congress").val(data.congress).trigger("change");

        });

        // Handle when delete button is clicked
        $("#member-table").on("click", ".delete-btn", function() {
            var data = memberTable.row($(this).parents("tr")).data();

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
                    fetch(`${APP_URL}/api/congress_members/${data.id}`, {
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
                        memberTable.ajax.reload(false, null);
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
