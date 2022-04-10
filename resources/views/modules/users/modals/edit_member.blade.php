<div class="modal fade" id="editMemberModal" role="dialog" aria-labelledby="chapterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Update User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="update-member-form">
                    @csrf
                    <input type="text" name="id" id="update-member-id" hidden required>
                    {{-- First row --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="update-member-name" class="form-control form-control-sm"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="update-member-phone"
                                class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <label for="exampleFormControlInput1">User role <span class="text-danger">*</span></label>
                            <select name="usertype" id="update-member-type"
                                class="form-control form-control-sm select2 drop" required>
                                <option value="">--Select--</option>
                                <option value="national">National</option>
                                <option value="presbytery">Presbytery</option>
                                <option value="district">District</option>
                                <option value="branch">Branch</option>
                                <option value="union">Union</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-none" id="update-presbytery">
                            <label for="exampleFormControlInput1">Presbytery</label>
                            <select name="presbytery" class="form-control form-control-sm select2 drop"
                                id="update-member-presbytery">
                                <option value="">--Select--</option>
                                @foreach ($presbyteries as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-none" id="update-district">
                            <label for="exampleFormControlInput1">District</label>
                            <select name="district" id="update-member-district"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-none" id="update-branch">
                            <label for="exampleFormControlInput1">Branch</label>
                            <select name="branch" id="update-member-branch"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col d-none" id="update-union">
                            <label for="exampleFormControlInput1">Union</label>
                            <select name="union" id="update-member-union"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="update-member-form" name="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    var updateMem = document.getElementById("update-member-form");
    $(updateMem).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(updateMem)
        Swal.fire({
            text: 'Are you sure you want to update user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Submit'

        }).then((result) => {

            if (result.value) {
                Swal.fire({
                    text: "Updating...",
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false
                });
                fetch(`${APP_URL}/api/users/update`, {
                    method: "POST",
                    body: formdata,
                }).then(function(res) {
                    return res.json()
                }).then(function(data) {
                    if (!data.ok) {
                        Swal.fire({
                            text: data.msg,
                            type: "error"
                        });
                        return;
                    }
                    Swal.fire({
                        text: "User updated  successfully",
                        type: "success"
                    });
                    $("#editMemberModal").modal('hide');
                    userTable.ajax.reload(false, null);
                    $(".drop").val(null).trigger('change');
                    updateMem.reset();
                    document.getElementById("update-presbytery").classList.add('d-none');
                    document.getElementById("update-district").classList.add('d-none');
                    document.getElementById("update-branch").classList.add('d-none');
                    document.getElementById("update-union").classList.add('d-none');

                    document.getElementById("update-member-presbytery").removeAttribute(
                        'required',
                        'required');
                    document.getElementById("update-member-district").removeAttribute(
                        'required',
                        'required');
                    document.getElementById("update-member-branch").removeAttribute('required',
                        'required');

                    document.getElementById("update-member-union").removeAttribute('required',
                        'required');

                }).catch(function(err) {
                    if (err) {
                        Swal.fire({
                            text: "Updating user failed"
                        });
                    }
                })
            }
        })
    });

</script>
