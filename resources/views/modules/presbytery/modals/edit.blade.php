<!-- Modal-->
<div class="modal fade" id="edit-modal" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Presbytery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-presbytery-form" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="update-presbytery-code" name="id" hidden>

                    <div class="row">
                        <div class="col">
                            <label for="">Description</label>
                            <input type="text" id="update-presbytery-name"  required name="name"  placeholder="HO Presbytery" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="update-presbytery-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const updatePresbyteryForm = document.forms["update-presbytery-form"];

    $(updatePresbyteryForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(updatePresbyteryForm)
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
                fetch(`${APP_URL}/api/presbyteries/update`, {
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
                    presbyteryTable.ajax.reload(false, null);
                    updatePresbyteryForm.reset();
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
