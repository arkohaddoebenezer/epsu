<div class="modal fade" id="singleSMSModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send SMS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="singleSmsForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="recipient" name="recipient">
                    <input type="hidden" id="smsextra" name="extra">

                  <div class="row">
                        <div class="col mt-2">
                            <label for="">Message</label>
                            <textarea name="message"  id="message" class="form-control" required cols="30" rows="7"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm waves-effect "
                        data-dismiss="modal">Close</button>
                    <button type="submit" form="singleSmsForm"
                        class="btn btn-primary btn-sm waves-effect waves-light ">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const singleSmsForm = document.forms["singleSmsForm"];

    $(singleSmsForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(singleSmsForm)
        formdata.append("createuser", CREATEUSER);
        
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
                fetch(`${APP_URL}/api/messaging/send_single_sms`, {
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
                    $("#singleSMSModal").modal('hide');
                    singleSmsForm.reset();
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
