@extends('layouts.app')
@section('page-name', 'Users')
@section('page-icon', 'user-secret')
@section('page-content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="table-responsive mt-2">
                                <table class="datatable table table-stripped" width='100%' id="user-table">
                                    <thead>
                                        <tr>
                                            <th><small>NO. </small></th>
                                            <th><small>NAME </small></th>
                                            <th><small>EMAIL </small></th>
                                            <th><small>PHONE </small></th>
                                            <th><small>USER TYPE </small></th>
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
    @include('modules.users.modals.add_member')
    @include('modules.users.modals.edit_member')
    {{-- @include('modules.users.modals.add_priv') --}}
    
    <script>
        var userTable = $('#user-table').DataTable({
            dom: 'Bfrtip',
            ajax: {
                url: `${APP_URL}/api/users`,
                type: "GET",
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },{
                    data: "name"
                },
                {
                    data: "email"
                },
                {
                    data: "phone"
                },
                {
                    data: "role"
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
                    defaultContent: `
                    
                    <button type='button' data-row-transid='$this->transid'
                    rel='tooltip' class='btn btn-outline-success btn-sm edit-btn'>
                       <i class='fas fa-edit'></i>
                    </button>
    
                    <button type='button' data-row-transid='$this->transid'
                    rel='tooltip' class='btn btn-outline-danger btn-sm delete-btn'>
                       <i class='fas fa-trash'></i>
                    </button>
                    `
                },
            ],
            buttons: [{
                    extend: 'print',
                    text: 'PRINT',
                    attr: {
                        class: "btn btn-sm custom-button rounded-left"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6,7,8]
                    }
                },
                {
                    extend: 'copy',
                    text: 'COPY',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4,5,6,7,8]
                    }
                },
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    attr: {
                        class: "btn btn-sm custom-button"
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7,8]
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
                        $("#memberModal").modal("show")
                    },
                },
            ],
        });
    
        //Script to update member
        $("#user-table").on("click", ".edit-btn", function () {
            let data = userTable.row($(this).parents('tr')).data();
            $("#editMemberModal").modal("show");
            $("#update-member-id").val(data.id);
            $("#update-member-name").val(data.name);
            $("#update-member-lname").val(data.lname);
            $("#update-member-mname").val(data.mname);
            $("#update-member-phone").val(data.phone);
            $("#update-member-email").html(data.email);
            $("#update-member-type").val(data.role).trigger("change");
            
            if(data.role === 'presbytery'){
                document.getElementById("update-presby").classList.remove('d-none');
                $("#update-member-pres").val(data.presbytery).trigger("change");
            }

            if(data.role === 'district'){
                document.getElementById("update-presby").classList.remove('d-none');
                document.getElementById("update-district").classList.remove('d-none');
                $("#update-member-pres").val(data.presbytery).trigger("change");
                $("#update-member-district").val(data.district).trigger("change");
            }

            if(data.role === 'branch'){
                document.getElementById("update-presby").classList.remove('d-none');
                document.getElementById("update-district").classList.remove('d-none');
                document.getElementById("update-branch").classList.remove('d-none');
                $("#update-member-pres").val(data.presbytery).trigger("change");
                $("#update-member-district").val(data.district).trigger("change");
                $("#update-member-branch").val(data.branch).trigger("change");
          }

            if(data.role === 'union'){
                document.getElementById("update-presby").classList.remove('d-none');
                document.getElementById("update-district").classList.remove('d-none');
                document.getElementById("update-branch").classList.remove('d-none');
                document.getElementById("update-union").classList.remove('d-none');
                $("#update-member-pres").val(data.presbytery).trigger("change");
                $("#update-member-district").val(data.district).trigger("change");
                $("#update-member-branch").val(data.branch).trigger("change");
                $("#update-member-union").val(data.union).trigger("change");
          }

        });
    
        $("#user-table").on("click", ".delete-btn", function () {
            var data = userTable.row($(this).parents("tr")).data();
    
            Swal.fire({
                text: "Are you sure you want to delete this member?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete"
    
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        text: "Deleting...",
                        showConfirmButton: false,
                        allowEscapeKey: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: `${APP_URL}/api/users/${data.id}`,
                        type: "DELETE",
                    }).done(function (data) {
                        if (!data.ok) {
                            Swal.fire({
                                text: data.msg,
                                type: "error"
                            });
                            return;
                        }
                        Swal.fire({
                            text: "User deleted successfully",
                            type: "success"
                        });
                        userTable.ajax.reload(false, null);
    
                    }).fail(() => {
                        alert('Processing failed');
                    })
                }
            })
    
    
        });
    

        //add
        $("#add-member-type").on("change", function(e) {
            var targetElement = document.getElementById("presbytery");

            if (this.value !== 'national') {
                targetElement.classList.remove('d-none'); 
                document.getElementById("add-member-presbytery").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("add-member-presbytery").removeAttribute('required', 'required');
            }
        });

        $("#add-member-presbytery").on("select2:select", function(e) {
            var targetElement = document.getElementById("district");
            var addMemberType = document.getElementById("add-member-type");

            if (Boolean(this.value) && this.value !== 'all' && addMemberType.value !== 'presbytery') {
                targetElement.classList.remove('d-none');
                getChildren(null, @json($presbyteries), 'add-member-presbytery', 'add-member-district');
                document.getElementById("add-member-district").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("branch").classList.add('d-none');
                document.getElementById("add-member-district").removeAttribute('required', 'required');
            }
        });

        $("#add-member-district").on("select2:select", function(e) {
            var targetElement = document.getElementById("branch");
            var addMemberType = document.getElementById("add-member-type");

            if (Boolean(this.value) && this.value !== 'all' && addMemberType.value !== 'district') {
                targetElement.classList.remove('d-none');
                getChildren(null, @json($districts), 'add-member-district', 'add-member-branch');
                document.getElementById("add-member-branch").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("add-member-branch").removeAttribute('required', 'required');
            }
        });

        $("#add-member-branch").on("select2:select", function(e) {
            var targetElement = document.getElementById("union");
            var addMemberType = document.getElementById("add-member-type");

            if (Boolean(this.value) && this.value !== 'all' && addMemberType.value !== 'branch') {
                targetElement.classList.remove('d-none');
                getChildren(null, @json($branches), 'add-member-branch', 'add-member-union');
                document.getElementById("add-member-union").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("add-member-union").removeAttribute('required', 'required');
            }
        });

        //update
        $("#update-member-type").on("change", function(e) {
            var targetElement = document.getElementById("update-presbytery");

            if (this.value !== 'national') {
                targetElement.classList.remove('d-none'); 
                document.getElementById("update-member-presbytery").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("update-member-presbytery").removeAttribute('required', 'required');
            }
        });

        $("#update-member-presbytery").on("select2:select", function(e) {
            var targetElement = document.getElementById("update-district");
            var addMemberType = document.getElementById("update-member-type");

            if (Boolean(this.value) && this.value !== 'all' && addMemberType.value !== 'presbytery') {
                targetElement.classList.remove('d-none');
                getChildren(null, @json($presbyteries), 'update-member-presbytery', 'update-member-district');
                document.getElementById("update-member-district").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("update-branch").classList.add('d-none');
                document.getElementById("update-member-district").removeAttribute('required', 'required');
            }
        });

        $("#update-member-district").on("select2:select", function(e) {
            var targetElement = document.getElementById("update-branch");
            var addMemberType = document.getElementById("add-member-type");

            if (Boolean(this.value) && this.value !== 'all' && addMemberType.value !== 'district') {
                targetElement.classList.remove('d-none');
                getChildren(null, @json($districts), 'update-member-district', 'update-member-branch');
                document.getElementById("update-member-branch").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("update-member-branch").removeAttribute('required', 'required');
            }
        });

        $("#update-member-branch").on("select2:select", function(e) {
            var targetElement = document.getElementById("update-union");
            var addMemberType = document.getElementById("add-member-type");

            if (Boolean(this.value) && this.value !== 'all' && addMemberType.value !== 'branch') {
                targetElement.classList.remove('d-none');
                getChildren(null, @json($branches), 'update-member-branch', 'update-member-union');
                document.getElementById("update-member-union").setAttribute('required', 'required');
            } else {
                targetElement.classList.add('d-none');
                document.getElementById("update-member-union").removeAttribute('required', 'required');
            }
        });
    </script>
@endsection
