<!-- Modal-->
<div class="modal fade" id="edit-modal" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Institution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-institution-form" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="update-institution-code" name="id" hidden>

                    <div class="row">
                        <div class="col">
                            <label for="">Title</label>
                            <input type="text" id="update-institution-name" required name="name"
                                placeholder="HO Presbytery" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Presbytery</label>
                            <select name="presbytery" id="update-institution-presbytery"
                                class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @foreach ($presbyteries as $item)
                                    <option value="{{ $item->id }}"
                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Country</label>
                            <select name="country" class="form-control select2 drop" id="update-institution-country">
                                <option value="">--Select--</option>
                                <option value="GHANA">GHANA</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Region</label>
                            <select name="region" id="update-institution-region" class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @foreach ($regions as $item)
                                    <option value="{{ $item->code }}">{{ $item->desc }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="update-institution-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const updateInstitutionForm = document.forms["update-institution-form"];

    $(updateInstitutionForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(updateInstitutionForm)
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
                fetch(`${APP_URL}/api/institutions/update`, {
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
                    institutionTable.ajax.reload(false, null);
                    updateInstitutionForm.reset();
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
