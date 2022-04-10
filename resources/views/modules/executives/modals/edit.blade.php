<!-- Modal-->
<div class="modal fade" id="edit-modal" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden name="id" id="update-nec-code" />
                    <div class="row">
                        <div class="col">
                            <label for="">Title<span style="color:red">*</span></label>
                            <select name="title" id="update-nec-title" required class="form-control select2 drop">
                                <option value="">--Select--</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Dr">Dr</option>
                                <option value="Prof">Prof</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="">Name<span style="color:red">*</span></label>
                            <input type="text" id="update-nec-name" required name="name"  class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Position</label>
                            <input type="text"  name="position" id="update-nec-position"  class="form-control">
                        </div>
                        <div class="col">
                            <label for="">Status<span style="color:red">*</span></label>
                            <select name="status" id="update-nec-status"  required class="form-control select2 drop">
                                <option value="">--Select--</option>
                                <option value="0">Active</option>
                                <option value="1">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Phone</label>
                            <input type="text" id="update-nec-phone"  name="phone"  class="form-control">
                        </div>
                        <div class="col">
                            <label for="">Email</label>
                            <input type="email" id="update-nec-email"  name="email"  class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Start Date</label>
                            <input type="date"  name="start_date" id="update-nec-startdate" class="form-control">
                        </div>
                        <div class="col">
                            <label for="">End Date</label>
                            <input type="date"  name="end_date" id="update-nec-enddate" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="edit-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const editForm = document.forms["edit-form"];

    $(editForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(editForm)
        formdata.append("createuser", CREATEUSER);
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
                fetch(`${APP_URL}/api/executives/update`, {
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
                    necTable.ajax.reload(false, null);
                    editForm.reset();
                    $(".drop").val(null).trigger('change');

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
