<div class="modal fade" id="addEmailModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Mail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="mailForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="row mt-2">
                        <div class="col">
                            <label for="">Subject</label><span style="color:red">*</span>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <label for="">Attachment</label>
                            <input type="file" name="attachment[]" multiple class="form-control-file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect "
                        data-dismiss="modal">Close</button>
                    <button type="submit" form="mailForm"
                        class="btn btn-primary btn-sm waves-effect waves-light ">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const mailForm = document.forms["mailForm"];

    $(mailForm).submit(function(e) {
        e.preventDefault();

        var target = $('input[name="radio"]:checked').val();
        var formdata = new FormData(mailForm)
        formdata.append("createuser", CREATEUSER);
        formdata.append("target", target);
       
        Swal.fire({
            title: '',
            text: "Are you sure you want to send mail?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Submit'

        }).then((result) => {

            if (result.value) {
                Swal.fire({
                    text: "Sending mail...",
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false
                });
                fetch(`${APP_URL}/api/messaging/sendmail`, {
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
                        text: "Mail sent successfully",
                        icon: "success"
                    });
                    $("#addEmailModal").modal('hide');
                    mailForm.reset();
                    emailTable.ajax.reload(false, null);
                }).catch(function(err) {
                    if (err) {
                        Swal.fire({
                            icon: "info",
                            text: "Sending mail failed, please try again!"
                        });
                    }
                })
            }
        })
    });

</script>
