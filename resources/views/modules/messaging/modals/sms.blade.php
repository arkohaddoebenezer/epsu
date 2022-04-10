<div class="modal fade" id="addSMSModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send SMS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="smsForm">
                @csrf
                <div class="modal-body">
                  <div class="row">
                        <div class="col mt-2">
                            <label for="">Message</label>
                            <textarea name="message" class="form-control" required cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect "
                        data-dismiss="modal">Close</button>
                    <button type="submit" form="smsForm"
                        class="btn btn-primary btn-sm waves-effect waves-light ">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const smsForm = document.forms["smsForm"];

    $(smsForm).submit(function(e) {
        e.preventDefault();

        var target = $('input[name="radio"]:checked').val();
        var formdata = new FormData(smsForm)
        formdata.append("createuser", CREATEUSER);
        formdata.append("target", target);
       
        Swal.fire({
            title: '',
            text: "Are you sure you want to send SMS?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Submit'

        }).then((result) => {

            if (result.value) {
                Swal.fire({
                    text: "Sending SMS...",
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false
                });
                fetch(`${APP_URL}/api/messaging/sendsms`, {
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
                    $("#addSMSModal").modal('hide');
                    smsForm.reset();
                    smsTable.ajax.reload(false, null);
                }).catch(function(err) {
                    if (err) {
                        Swal.fire({
                            icon: "info",
                            text: "Sending SMS failed, please try again!"
                        });
                    }
                })
            }
        })
    });

</script>
