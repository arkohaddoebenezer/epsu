@extends('layouts.app')
@section('page-name', 'Unions')
@section('page-icon', 'balance-scale')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-xs-12 elevate p-2">
                                    <label for="">New Union</label>
                                    <hr>
                                    <br>
                                    <form id="add-union-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row p-2">
                                            <div class="col">
                                                <label for="">Title</label>
                                                <input type="text" required name="name"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div
                                            class="row p-2 mt-2 @if (!in_array(strtolower(Auth::user()->usertype), ['national'])) d-none @endif">
                                            <div class="col">
                                                <label for="">Presbytery</label>
                                                <select name="presbytery" id="add-union-presbytery" class="form-control select2 drop">
                                                    <option value="">--Select--</option>
                                                    @foreach ($presbyteries as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ !in_array(strtolower(Auth::user()->usertype), ['national']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="row p-2 mt-2 @if (!in_array(strtolower(Auth::user()->usertype), ['national','presbytery'])) d-none @endif">
                                            <div class="col">
                                                <label for="">District</label>
                                                <select name="district" id="add-union-district" class="form-control select2 drop">
                                                    <option value="">--Select--</option>
                                                    @foreach ($districts as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery']) && Auth::user()->district === $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div
                                            class="row p-2 mt-2 @if (!in_array(strtolower(Auth::user()->usertype), ['national','presbytery','district'])) d-none @endif">
                                            <div class="col">
                                                <label for="">Branches</label>
                                                <select name="branch" id="add-union-branch" class="form-control select2 drop">
                                                    <option value="">--Select--</option>
                                                    @foreach ($branches as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery','district']) && Auth::user()->branch === $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" form="add-union-form"
                                            class="btn btn-primary float-right btn-sm waves-effect waves-light mr-2">Save
                                        </button>
                                    </form>
                                </div>
                                <div class="col-8 col-xs-12">
                                    <div
                                        class="row @if (!in_array(strtolower(Auth::user()->usertype), ['national'])) d-none @endif">
                                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype),
                                            ['national','presbytery'])) d-none @endif>
                                            <label for="">Presbytery</label>
                                            <select id="filter-presbytery" class="form-control select2">
                                                <option value="">--Select--</option>
                                                @foreach ($presbyteries as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery']))
                                            d-none @endif>
                                            <label for="">District</label>
                                            <select id="filter-district" class="form-control select2">
                                                <option value="">--Select--</option>
                                                @foreach ($districts as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery']) && Auth::user()->district === $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery', 'district']))
                                            d-none @endif>
                                            <label for="">Branch</label>
                                            <select id="filter-branch" class="form-control select2">
                                                <option value="">--Select--</option>
                                                @foreach ($branches as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery','district']) && Auth::user()->branch === $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-2">
                                        <table class="datatable table table-stripped" width='100%' id="union-table">
                                            <thead>
                                                <tr>
                                                    <th><small>NO. </small></th>
                                                    <th><small>DESCRIPTION </small></th>
                                                    <th><small>PRESBYTERY </small></th>
                                                    <th><small>DISTRICT </small></th>
                                                    <th><small>BRANCH </small></th>
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
    @include('modules.unions.modals.edit')

    <script>
        var presby = document.getElementById('filter-presbytery').value;
        presby = Boolean(presby) ? presby : 'all';
        var district = document.getElementById('filter-district').value;
        district = Boolean(district) ? district : 'all';
        var branch = document.getElementById('filter-branch').value;
        branch = Boolean(branch) ? branch : 'all';

        var unionTable = $('#union-table').DataTable({
            dom: "Bfrtip",
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            ajax: {
                url: `${APP_URL}/api/unions/${presby}/${district}/${branch}`,
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
                    data: "districtDesc",
                },
                {
                    data: "branchDesc",
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
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'copy',
                    text: 'COPY',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
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

        $('#filter-presbytery').change(function() {
            var presby = document.getElementById('filter-presbytery').value;
            presby = Boolean(presby) ? presby : 'all';
            var district = document.getElementById('filter-district').value;
            district = Boolean(district) ? district : 'all';
            var branch = document.getElementById('filter-branch').value;
            branch = Boolean(branch) ? branch : 'all';

            getChildren(null, @json($presbyteries), 'filter-presbytery', 'filter-district');

            unionTable.ajax.url(
                    `${APP_URL}/api/unions/${presby}/${district}/${branch}`
                )
                .load();
        })

        $('#filter-district').change(function() {
            var presby = document.getElementById('filter-presbytery').value;
            presby = Boolean(presby) ? presby : 'all';
            var district = document.getElementById('filter-district').value;
            district = Boolean(district) ? district : 'all';
            var branch = document.getElementById('filter-branch').value;
            branch = Boolean(branch) ? branch : 'all';

            getChildren(null, @json($districts), 'filter-district', 'filter-branch');

            unionTable.ajax.url(
                    `${APP_URL}/api/unions/${presby}/${district}/${branch}`
                )
                .load();
        })

        $('#filter-branch').change(function() {
            var presby = document.getElementById('filter-presbytery').value;
            presby = Boolean(presby) ? presby : 'all';
            var district = document.getElementById('filter-district').value;
            district = Boolean(district) ? district : 'all';
            var branch = document.getElementById('filter-branch').value;
            branch = Boolean(branch) ? branch : 'all';

            unionTable.ajax.url(
                    `${APP_URL}/api/unions/${presby}/${district}/${branch}`
                )
                .load();
        })

        $("#add-union-presbytery").on("select2:select", function(e) {
            getChildren(null, @json($presbyteries), 'add-union-presbytery', 'add-union-district');
        });

        $("#add-union-district").on("select2:select", function(e) {
            getChildren(null, @json($districts), 'add-union-district', 'add-union-branch');
        });

        $("#update-union-presbytery").on("select2:select", function(e) {
            getChildren(null, @json($presbyteries), 'update-union-presbytery', 'update-union-district');
        });

        $("#update-union-district").on("select2:select", function(e) {
            getChildren(null, @json($districts), 'update-union-district', 'update-union-branch');
        });

        const addUnionForm = document.forms["add-union-form"];
        $(addUnionForm).submit(function(e) {
            e.preventDefault();

            var formdata = new FormData(addUnionForm)
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
                    fetch(`${APP_URL}/api/unions`, {
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
                        unionTable.ajax.reload(false, null);
                        $(".drop").val(null).trigger('change');
                        addUnionForm.reset();
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
        $("#union-table").on("click", ".update-btn", function() {
            let data = unionTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");

            document.getElementById("update-union-code").value = data.id;
            document.getElementById("update-union-name").value = data.name;
            $("#update-union-presbytery").val(data.presbytery).trigger("change");
            $("#update-union-district").val(data.district).trigger("change");
            $("#update-union-branch").val(data.branch).trigger("change");
        });

        // Handle when delete button is clicked
        $("#branches-table").on("click", ".delete-btn", function() {
            var data = branchesTable.row($(this).parents("tr")).data();

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
                    fetch(`${APP_URL}/api/branches/${data.id}`, {
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
                        branchesTable.ajax.reload(false, null);
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
