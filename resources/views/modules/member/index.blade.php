@extends('layouts.app')
@section('page-name', 'Members')
@section('page-icon', 'compass')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row @if (!in_array(strtolower(Auth::user()->usertype), ['national'])) d-none @endif">
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
                                <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national',
                                    'presbytery']))
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
                                <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national',
                                    'presbytery', 'district']))
                                    d-none @endif>
                                    <label for="">Branch</label>
                                    <select id="filter-branch" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @foreach ($branches as $item)
                                            <option value="{{ $item->id }}"
                                                {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery', 'district']) && Auth::user()->branch === $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national',
                                    'presbytery', 'district','branch']))
                                    d-none @endif>
                                    <label for="">Union</label>
                                    <select id="filter-union" class="form-control select2">
                                        <option value="">--Select--</option>
                                        @foreach ($unions as $item)
                                            <option value="{{ $item->id }}"
                                                {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery', 'district','branch']) && Auth::user()->union === $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
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
                                            <th><small>CONTACT </small></th>
                                            <th><small>PRESBYTERY </small></th>
                                            <th><small>DISTRICT </small></th>
                                            <th><small>BRANCH </small></th>
                                            <th><small>UNION </small></th>
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
    @include('modules.member.modals.add')
    @include('modules.member.modals.edit')
    @include('modules.member.modals.view')

    <script>
        var presbytery = document.getElementById('filter-presbytery').value;
        presbytery = Boolean(presbytery) ? presbytery : 'all';
        var district = document.getElementById('filter-district').value;
        district = Boolean(district) ? district : 'all';
        var branch = document.getElementById('filter-branch').value;
        branch = Boolean(branch) ? branch : 'all';
        var union = document.getElementById('filter-union').value;
        union = Boolean(union) ? union : 'all';

        var memberTable = $('#member-table').DataTable({
            dom: "Bfrtip",
            lengthMenu: [
                [10, 25, 50, 100, -1],
                ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
            ],
            ajax: {
                url: `${APP_URL}/api/members/${presbytery}/${district}/${branch}/${union}`,
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
                    data: "contact"
                },
                {
                    data: "presbyteryDesc"
                },
                {
                    data: "districtDesc"
                },
                {
                    data: "branchDesc"
                },
                {
                    data: "unionDesc"
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
                        class: "btn btn-sm custom-button"
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
                {
                    text: "NEW MEMBER",
                    attr: {
                        class: `ml-2 custom-button btn btn-sm rounded`
                    },
                    action: function(e, dt, node, config) {
                        $("#add-modal").modal("show")
                    },
                },
            ],
        });

        $('#filter').click(function() {
            var presbytery = document.getElementById('filter-presbytery').value;
            presbytery = Boolean(presbytery) ? presbytery : 'all';
            var district = document.getElementById('filter-district').value;
            district = Boolean(district) ? district : 'all';
            var branch = document.getElementById('filter-branch').value;
            branch = Boolean(branch) ? branch : 'all';
            var union = document.getElementById('filter-union').value;
            union = Boolean(union) ? union : 'all';

            memberTable.ajax.url(
                    `${APP_URL}/api/members/${presbytery}/${district}/${branch}/${union}`
                )
                .load();
        })

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
                    fetch(`${APP_URL}/api/members/${data.transid}`, {
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
                        'Your presbytery is safe :)',
                        'success'
                    )
                }
            })

        });

        //Script to update member
        $("#member-table").on("click", ".update-btn", function() {
            let data = memberTable.row($(this).parents('tr')).data();
            $("#edit-modal").modal("show");
            $("#update-member-mid").val(data.id);
            $("#update-member-fname").val(data.fname);
            $("#update-member-lname").val(data.lname);
            $("#update-member-mname").val(data.mname);
            $("#update-member-phone").val(data.phone);
            $("#update-member-email").val(data.email);
            $("#update-member-curr-level").val(data.current_level);
            $("#update-member-dob").val(data.dob);
            $("#update-member-pob").val(data.pob);
            $("#update-member-hometown").val(data.hometown);
            $("#update-member-emp-status").val(data.employment_status).trigger("change");
            $("#update-member-profession").val(data.profession);
            $("#update-member-pow").val(data.place_of_work);
            $("#update-member-programme").val(data.programme);
            $("#update-member-room").val(data.room_details);
            $("#update-member-residence").val(data.residence);
            $("#update-member-emerg-contact").val(data.emergency_contact);
            $("#update-member-mother-church").val(data.mother_church);;
            $("#update-member-emerg-person").val(data.emergency_person);
            $("#update-member-type").val(data.member_type).trigger("change");
            $("#update-member-region").val(data.region).trigger("change");
            $("#update-member-title").val(data.title).trigger("change");
            $("#update-member-inst").val(data.institution).trigger("change");
            $("#update-member-gender").val(data.gender).trigger("change");
            $("#update-member-nat").val(data.nationality).trigger("change");
            $("#update-member-marital-status").val(data.marital_status).trigger("change");
            
            $("#update-member-presbytery").val(data.presbytery).trigger("change");
            $("#update-member-union").val(data.union).trigger("change");
            $("#update-member-district").val(data.district).trigger("change");
            $("#update-member-branch").val(data.branch).trigger("change");

            if (data.member_type == 'STU') {
                document.getElementById("update-education").removeAttribute('class', 'd-none');
            } else {
                document.getElementById("update-education").setAttribute('class', 'd-none');
            }

            if (data.emp_status == 'employed') {
                document.getElementById("update-profession").removeAttribute('class', 'd-none');
            } else {
                document.getElementById("update-profession").setAttribute('class', 'd-none');
            }
        });

        $("#member-table").on("click", ".view-btn", function() {
            let data = memberTable.row($(this).parents('tr')).data();
            $("#view-modal").modal("show");
            $("#view-member-name").html(data.name);
            $("#view-member-contact").html(data.contact);
            $("#view-member-curr-level").html(data.current_level);
            $("#view-member-dob").html(data.dob);
            $("#view-member-pob").html(data.pob);
            $("#view-member-hometown").html(data.hometown);
            $("#view-member-emp-status").html(data.employment_status);
            $("#view-member-profession").html(data.profession);
            $("#view-member-pow").html(data.place_of_work);
            $("#view-member-programme").html(data.prog);
            $("#view-member-room").html(data.room_details);
            $("#view-member-residence").html(data.residence);
            $("#view-member-emerg-contact").html(data.emergency_contact);
            $("#view-member-mother-church").html(data.mother_church);
            $("#view-member-emerg-person").html(data.emergency_person);
            $("#view-member-chapter").html(data.chapterDesc);
            $("#view-member-type").html(data.member_type);
            $("#view-member-presbytery").html(data.presbyteryDesc);
            $("#view-member-region").html(data.region);
            $("#view-member-district").html(data.districtDesc);
            $("#view-member-branch").html(data.branchDesc);
            $("#view-member-union").html(data.unionDesc);
            $("#view-member-inst").html(data.institutionDesc);
            $("#view-member-gender").html(data.gender);
            $("#view-member-nat").html(data.nationality);
            $("#view-member-marital-status").html(data.marital_status);
            $("#view-member-image").attr("src", data.picture);

            if (data.member_type == 'STU') {
                document.getElementById("view-education").removeAttribute('class', 'd-none');
            } else {
                document.getElementById("view-education").setAttribute('class', 'd-none');
            }

            if (data.emp_status == 'employed') {
                document.getElementById("view-profession").removeAttribute('class', 'd-none');
            } else {
                document.getElementById("view-profession").setAttribute('class', 'd-none');
            }
        });



        $("#add-member-type").on("change", function(e) {
            var targetElement = document.getElementById("education");

            if (this.value == 'STU') {
                targetElement.removeAttribute('class', 'd-none');
            } else {
                targetElement.setAttribute('class', 'd-none');
            }
        });

        $("#add-member-emp-status").on("change", function(e) {
            var targetElement = document.getElementById("profession");

            if (this.value == 'employed') {
                targetElement.removeAttribute('class', 'd-none');
            } else {
                targetElement.setAttribute('class', 'd-none');
            }
        });

        $("#update-member-type").on("change", function(e) {
            var targetElement = document.getElementById("update-education");

            if (this.value == 'STU') {
                targetElement.removeAttribute('class', 'd-none');
            } else {
                targetElement.setAttribute('class', 'd-none');
            }
        });

        $("#update-member-emp-status").on("change", function(e) {
            var targetElement = document.getElementById("update-profession");

            if (this.value == 'employed') {
                targetElement.removeAttribute('class', 'd-none');
            } else {
                targetElement.setAttribute('class', 'd-none');
            }
        });

        //*******************************
        // filter 
        

    </script>
@endsection
