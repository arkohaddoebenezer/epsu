<div class="modal fade" id="memberModal" role="dialog" aria-labelledby="chapterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Add User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="add-member-form">
                    @csrf
                    {{-- First row --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm"
                                required>
                        </div>
                    </div>


                    {{-- Second row --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="add-member-email" class="form-control form-control-sm"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="add-member-phone" class="form-control form-control-sm"
                                required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlInput1">User role <span class="text-danger">*</span></label>
                            <select name="usertype" id="add-member-type"
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
                        <div class="col d-none" id="presbytery">
                            <label for="exampleFormControlInput1">Presbytery</label>
                            <select name="presbytery" class="form-control form-control-sm select2 drop"
                                id="add-member-presbytery">
                                <option value="">--Select--</option>
                                @foreach ($presbyteries as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">               
                        <div class="col d-none" id="district">
                            <label for="exampleFormControlInput1">District</label>
                            <select name="district" id="add-member-district"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">               
                        <div class="col d-none" id="branch">
                            <label for="exampleFormControlInput1">Branch</label>
                            <select name="branch" id="add-member-branch"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">               
                        <div class="col d-none" id="union">
                            <label for="exampleFormControlInput1">Union</label>
                            <select name="union" id="add-member-union"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="add-member-form" name="submit" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<script>
    var addMem = document.getElementById("add-member-form");
    $(addMem).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(addMem)
        Swal.fire({
            text: 'Are you sure you want to add user?',
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
                fetch(`${APP_URL}/api/users`, {
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
                        text: "User added successfully",
                        type: "success"
                    });
                    $("#memberModal").modal('hide');
                    userTable.ajax.reload(false, null);
                    addMem.reset();
                    $(".drop").val(null).trigger('change');
                    document.getElementById("presbytery").classList.add('d-none');
                    document.getElementById("district").classList.add('d-none');
                    document.getElementById("branch").classList.add('d-none');
                    document.getElementById("union").classList.add('d-none');

                    document.getElementById("add-member-presbytery").removeAttribute('required',
                        'required');
                    document.getElementById("add-member-district").removeAttribute('required',
                        'required');
                    document.getElementById("add-member-branch").removeAttribute('required',
                        'required');
                    document.getElementById("add-member-union").removeAttribute('required',
                        'required');

                }).catch(function(err) {
                    if (err) {
                        Swal.fire({
                            text: "Adding user failed"
                        });
                    }
                })
            }
        })
    });

</script>
