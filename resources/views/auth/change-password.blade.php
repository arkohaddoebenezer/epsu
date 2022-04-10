<div class="modal fade" id="changePasswordModal1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="changePasswordForm1">
                @csrf
                <div class="modal-body">
                   <div class="row mt-2">
                        <div class="col">
                            <label for="">New Password<span style="color:red">*</span></label>
                            <input type="password" name="password" class="form-control reset" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Confirm Password<span style="color:red">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control reset" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect "
                        data-dismiss="modal">Close</button>
                    <button type="submit" form="changePasswordForm1"
                        class="btn btn-primary btn-sm waves-effect waves-light ">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const changePasswordForm1 = document.forms["changePasswordForm1"];

    $(changePasswordForm1).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(changePasswordForm1)
        formdata.append("createuser", CREATEUSER);
        Swal.fire({
            title: '',
            text: "Are you sure you want to change password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Submit'

        }).then((result) => {

            if (result.value) {
                Swal.fire({
                    text: "Changing password...",
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false
                });
                fetch(`${APP_URL}/api/change-password`, {
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
                        text: "Password updated successfully",
                        icon: "success"
                    });
                    $("#changePasswordModal1").modal('hide');
                    $('.reset').val('');
                }).catch(function(err) {
                    if (err) {
                        Swal.fire({
                            text: "An error occured while changing password, please contact admin"
                        });
                    }
                })
            }
        })
    });

</script>
