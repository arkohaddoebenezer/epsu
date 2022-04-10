@extends('layouts.app')
@section('page-name', 'Districts')
@section('page-icon', 'list')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xs-12 elevate p-2">
                                    <label for="">New District</label>
                                    <hr>
                                    <br>
                                    <form id="add-district-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col">
                                                <label for="">Title</label>
                                                <input type="text" required name="name" placeholder="HO Presbytery"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div
                                            class="row p-2 mt-2 @if (!in_array(strtolower(Auth::user()->usertype), ['national'])) d-none @endif">
                                            <div class="col">
                                                <label for="">Presbytery</label>
                                                <select name="presbytery" class="form-control select2 drop">
                                                    <option value="">--Select--</option>
                                                    @foreach ($presbyteries as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ !in_array(strtolower(Auth::user()->usertype), ['national']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" form="add-district-form"
                                            class="btn btn-primary float-right btn-sm waves-effect waves-light mr-2">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 col-xs-12">
                                    <div
                                        class="row @if (!in_array(strtolower(Auth::user()->usertype), ['national'])) d-none @endif">
                                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national']))
                                            d-none @endif>
                                            <label for="">Presbytery</label>
                                            <select id="filter" class="form-control select2">
                                                <option value="">--Select--</option>
                                                @foreach ($presbyteries as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="datatable table table-stripped" width='100%' id="districts-table">
                                            <thead>
                                                <tr>
                                                    <th><small>NO. </small></th>
                                                    <th><small>DESCRIPTION </small></th>
                                                    <th><small>PRESBYTERY </small></th>
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
    @include('modules.districts.modals.edit')

    <script>
        var presby = document.getElementById('filter').value;
        presby = Boolean(presby) ? presby : 'all';

        var districtTable = $('#districts-table').DataTable({
            dom: "Bfrtip",
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            "columnDefs": [{
                "targets": [4],
                "visible": false,
            }],
            ajax: {
                url: `${APP_URL}/api/districts/${presby}`,
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
                    data: "presbyteryDesc",
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
                {
                    data: "presbytery"
                },
            ],
            buttons: [{
                    extend: 'print',
                    text: 'PRINT',
                    attr: {
                        class: "btn btn-sm custom-button rounded-left"
                    },
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'copy',
                    text: 'COPY',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2]
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

        const addDistrictForm = document.forms["add-district-form"];
        $(addDistrictForm).submit(function(e) {
            e.preventDefault();

            var formdata = new FormData(addDistrictForm)
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
                    fetch(`${APP_URL}/api/districts`, {
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
                        districtTable.ajax.reload(false, null);
                        $(".drop").val(null).trigger('change');
                        addDistrictForm.reset();
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

        $('#filter').change(function() {
            var presby = document.getElementById('filter').value;
            presby = Boolean(presby) ? presby : 'all';

            districtTable.ajax.url(
                    `${APP_URL}/api/districts/${presby}`
                )
                .load();
        })

        // Handle when edit button is clicked
        $("#districts-table").on("click", ".update-btn", function() {
            let data = districtTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");

            document.getElementById("update-district-code").value = data.id;
            document.getElementById("update-district-name").value = data.name;
            $("#update-district-presbytery").val(data.presbytery).trigger("change");
        });

        // Handle when delete button is clicked
        $("#districts-table").on("click", ".delete-btn", function() {
            var data = districtTable.row($(this).parents("tr")).data();

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
                    fetch(`${APP_URL}/api/districts/${data.id}`, {
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
                        districtTable.ajax.reload(false, null);
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
                        'Your presbytery is safe :)',
                        'success'
                    )
                }
            })

        });

    </script>
@endsection
