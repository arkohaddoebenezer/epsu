<!-- Modal-->
<div class="modal fade" id="edit-modal" role="dialog" aria-labelledby="staticBackdrop"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Union</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-union-form" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="update-union-code" name="id" hidden>

                    <div class="row">
                        <div class="col">
                            <label for="">Title</label>
                            <input type="text" id="update-union-name"  required name="name"  placeholder="HO Presbytery" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                       <div class="col @if (!in_array(strtolower(Auth::user()->usertype), ['national'])) d-none @endif">
                            <label for="">Presbytery</label>
                            <select name="presbytery" id="update-union-presbytery" class="form-control select2 drop">
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
                        <div class="col @if (!in_array(strtolower(Auth::user()->usertype), ['national','presbytery'])) d-none @endif">
                             <label for="">District</label>
                             <select name="district" id="update-union-district" class="form-control select2 drop">
                                 <option value="">--Select--</option>
                                 @foreach ($districts as $item)
                                     <option value="{{ $item->id }}"
                                         {{ !in_array(strtolower(Auth::user()->usertype), ['national','presbytery']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                         {{ $item->name }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="row mt-2">
                        <div class="col @if (!in_array(strtolower(Auth::user()->usertype), ['national','presbytery','district'])) d-none @endif">
                             <label for="">Branch</label>
                             <select name="branch" id="update-union-branch" class="form-control select2 drop">
                                 <option value="">--Select--</option>
                                 @foreach ($branches as $item)
                                     <option value="{{ $item->id }}"
                                         {{ !in_array(strtolower(Auth::user()->usertype), ['national','presbytery','district']) && Auth::user()->branch === $item->id ? 'selected' : '' }}>
                                         {{ $item->name }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="update-union-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const updateUnionForm = document.forms["update-union-form"];

    $(updateUnionForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(updateUnionForm)
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
                fetch(`${APP_URL}/api/unions/update`, {
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
                    unionTable.ajax.reload(false, null);
                    $(".drop").val(null).trigger('change');
                    updateUnionForm.reset();
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
