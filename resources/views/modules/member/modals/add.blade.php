<!-- Modal-->
<div class="modal fade" id="add-modal" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog" style="max-width: 80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-member-form" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="">Title<span class="text-danger">*</span></label>
                            <select name="title" id="add-member-title" required class="form-control select2 drop">
                                <option value="">--Select--</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Dr">Dr</option>
                                <option value="Prof">Prof</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="fname" id="add-member-fname" class="form-control form-control-sm"
                                required>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Middle Name</label>
                            <input type="text" name="mname" id="add-member-mname" class="form-control form-control-sm">
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lname" id="add-member-lname" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Email</label>
                            <input type="text" name="email" id="add-member-email" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="add-member-phone" class="form-control form-control-sm"
                                required>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Gender <span class="text-danger">*</span></label>
                            <select name="gender" id="add-member-gender"
                                class="form-control form-control-sm select2 drop" required>
                                <option value="">--Select--</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Nationality</label>
                            <select name="nationality" id="add-member-nat" class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                                <option value="GHANA">Ghana</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Marital Status</label>
                            <select name="marital_status" id="add-member-marital-status"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Date Of Birth</label>
                            <input type="date" name="dob" id="add-member-dob" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Place Of Birth</label>
                            <input type="text" name="pob" id="add-member-pob" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Hometown</label>
                            <input type="text" name="hometown" id="add-member-hometown"
                                class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Region</label>
                            <select name="region" id="add-member-region"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                                @foreach ($regions as $item)
                                    <option value="{{ $item->code }}">{{ $item->desc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Residence</label>
                            <input type="text" name="residence" id="add-member-residence"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Mother Church</label>
                            <input type="mother_church" id="add-member-mother-church" name="motherChurch"
                                class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype),['national','presbytery'])) d-none @endif>
                            <label for="">Presbytery<span class="text-danger">*</span></label>
                            <select id="add-member-presbytery" name="presbytery" class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @foreach ($presbyteries as $item)
                                    <option value="{{ $item->id }}"
                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national']) && Auth::user()->presbytery === $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national','presbytery']))
                            d-none @endif>
                            <label for="">District<span class="text-danger">*</span></label>
                            <select id="add-member-district" name="district" class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @if (Auth::user()->usertype === 'district')
                                @foreach ($districts as $item)
                                    <option value="{{ $item->id }}"
                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery']) && Auth::user()->district === $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national',
                            'presbytery', 'district']))
                            d-none @endif>
                            <label for="">Branch<span class="text-danger">*</span></label>
                            <select id="add-member-branch" name="branch" class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @if (Auth::user()->usertype === 'branch')
                                @foreach ($branches as $item)
                                    <option value="{{ $item->id }}"
                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery', 'district']) && Auth::user()->branch === $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col" @if (!in_array(strtolower(Auth::user()->usertype), ['national',
                            'presbytery', 'district','branch']))
                            d-none @endif>
                            <label for="">Union<span class="text-danger">*</span></label>
                            <select id="add-member-union" name="union" class="form-control select2 drop">
                                <option value="">--Select--</option>
                                @if (Auth::user()->usertype === 'union')
                                @foreach ($unions as $item)
                                    <option value="{{ $item->id }}"
                                        {{ !in_array(strtolower(Auth::user()->usertype), ['national', 'presbytery', 'district','branch']) && Auth::user()->union === $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <hr>
                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Member Type<span class="text-danger">*</span></label>
                            <select name="member_type" id="add-member-type" required
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                                <option value="STU">Student</option>
                                <option value="ALU">Alumini</option>
                                <option value="REG">Regular</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Employment Status<span
                                    class="text-danger">*</span></label>
                            <select type="text" name="employment_status" required id="add-member-emp-status"
                                class="form-control form-control-sm select2 drop">
                                <option value="">--Select--</option>
                                <option value="employed">Employed</option>
                                <option value="unemployed">Unemployed</option>
                            </select>
                        </div>
                    </div>

                    {{-- education --}}
                    <div id="education" class="d-none">
                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label for="exampleFormControlInput1">Institution</label>
                                <select name="institution" id="add-member-inst"
                                    class="form-control form-control-sm select2 drop">
                                    <option value="">--Select--</option>
                                    @foreach ($institutions as $item)
                                        <option value="{{ $item->desc }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label for="exampleFormControlInput1">Programme</label>
                                <input type="text" name="programme" id="add-member-programme"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label for="exampleFormControlInput1">Current Level</label>
                                <input type="text" name="current_level" id="add-member-curr-level"
                                    class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-4 col-xs-12 education">
                                <label for="exampleFormControlInput1">Room Details</label>
                                <input name="room_details" type="text" id="update-member-room-details" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    {{-- end education --}}

                    <div id="profession" class="d-none">
                        <div class="row mt-2">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label for="exampleFormControlInput1">Profession</label>
                                <input type="text" name="profession" id="add-member-profession"
                                    class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <label for="exampleFormControlInput1">Place Of Work</label>
                                <input type="text" name="place_of_work" id="add-member-pow" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Emergency Person </label>
                            <input type="text" name="emergency_person" id="add-member-emerg-person"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Emergency Contact</label>
                            <input type="text" name="emergency_contact" id="add-member-emerg-contact"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="exampleFormControlInput1">Image</label>
                            <input type="file" name="image" class="form-control form-control-sm">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" form="add-member-form"
                    class="btn btn-primary btn-sm waves-effect waves-light ">Save
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    const addMemberForm = document.forms["add-member-form"];

    $(addMemberForm).submit(function(e) {
        e.preventDefault();

        var formdata = new FormData(addMemberForm)
        formdata.append("createuser", CREATEUSER);
        Swal.fire({
            text: 'Are you sure you want to add record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Submit'

        }).then((result) => {

            if (result.value) {
                Swal.fire({
                    text: "Adding...",
                    showConfirmButton: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false
                });
                fetch(`${APP_URL}/api/members`, {
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
                    $("#add-modal").modal('hide');
                    memberTable.ajax.reload(false, null);
                    addMemberForm.reset();
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
