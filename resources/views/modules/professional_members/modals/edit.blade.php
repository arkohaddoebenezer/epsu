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
                <form id="update-group-form" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="update-group-code" name="id" hidden>

                    <div class="row p-2">
                        <div class="col">
                            <label for="">Title</label>
                            <select name="title" id="update-group-title" required class="form-control select2 drop">
                                <option value="">--Select--</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Dr">Dr</option>
                                <option value="Prof">Prof</option>
                            </select>
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Name</label>
                            <input type="text" name="name" id="update-group-name" required class="form-control">
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Phone</label>
                            <input type="tel" name="phone" id="update-group-phone" class="form-control">
                        </div>
                    </div>
                    <div class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Email</label>
                            <input name="email" type="email" id="update-group-email" class="form-control">
                        </div>
                    </div>
                   <div
                        class="row p-2 mt-2">
                        <div class="col">
                            <label for="">Group</label>
                            <select name="group" id="update-group-group" required class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @foreach ($groups as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="update-group-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const updateGroupForm = document.forms["update-group-form"];

    $(updateGroupForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(updateGroupForm)
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
                fetch(`${APP_URL}/api/professional_members/update`, {
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
                    groupTable.ajax.reload(false, null);
                    updateGroupForm.reset();
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
