<!-- Modal-->
<div class="modal fade" id="edit-modal" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-member-form" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="update-member-code" name="id" hidden>

                    <div class="row p-2">
                        <div class="col">
                            <label for="">First Name</label>
                            <input type="text" name="fname" id="update-member-fname" required class="form-control">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col">
                            <label for="">Last Name</label>
                            <input type="text" name="lname" id="update-member-lname" required class="form-control">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col">
                            <label for="">Other Names</label>
                            <input type="text" name="mname" id="update-member-mname" class="form-control">
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Phone</label>
                            <input type="tel" name="phone" id="update-member-phone" required class="form-control">
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Email</label>
                            <input name="email" type="email" id="update-member-email"  class="form-control">
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Union</label>
                            <select name="union" class="form-control select2 drop" id="update-member-union" required>
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
                            <select name="congress" class="form-control select2 drop" id="update-member-congress" required>
                                <option value="">--Select--</option>
                                @foreach ($congresses as $item)
                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="update-member-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const updateMemberForm = document.forms["update-member-form"];

    $(updateMemberForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(updateMemberForm)
        formdata.append("createUser", CREATEUSER);
        Swal.fire({
            text: 'Are you sure you want to update record?',
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
                fetch(`${APP_URL}/api/congress_members/update`, {
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
                    $("#edit-modal").modal('hide');
                    $(".drop").val(null).trigger('change');
                    memberTable.ajax.reload(false, null);
                    updateMemberForm.reset();
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

</script>
