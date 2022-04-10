<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        /* float: right; */
    }

    /* Hide default HTML checkbox */
    .switch input {
        display: none;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input.default:checked+.slider {
        background-color: #444;
    }

    input.primary:checked+.slider {
        background-color: #2196F3;
    }

    input.success:checked+.slider {
        background-color: #8bc34a;
    }

    input.info:checked+.slider {
        background-color: #3de0f5;
    }

    input.warning:checked+.slider {
        background-color: #FFC107;
    }

    input.danger:checked+.slider {
        background-color: #f44336;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

</style>
<div class="modal fade" id="add-privilege-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width: 80%" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="exampleModalLabel">Assign Privilege</h5>
                <a href="#"><span class="close text-white" data-dismiss="modal" aria-label="Close"
                        aria-hidden="false">×</span></a>
            </div>
            <div class="modal-body">
                <form method="POST" action="/profile" id="ass-priv-form">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-striped table-hover dataTable js-exportable" width="100%"
                            id="priv-table">
                            <thead class="thead-dark">
                                <th>Mod ID</th>
                                <th> Module Names </th>
                                <th> View</th>
                            </thead>
                            <tbody>
                                {{-- data is fetched here using Ajax/js_fetch --}}
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function updatePrivilege(modID, userID, switchToggle) {

        let data = {
            modid: modID,
            userid: userID,
            privType: switchToggle.dataset.privType,
            status: Number(switchToggle.checked)
        };

        let status = Number(switchToggle.checked);
        let privType = switchToggle.dataset.privType;

        var formdata = new FormData()
        formdata.append("mod_id", modID);
        formdata.append("user_id", userID);
        formdata.append("status", status);
        formdata.append("privType", privType);

        fetch(`${APP_URL}/api/users/update_priv`, {
            method: "POST",
            body: formdata,
        }).then(function (res) {
            return res.json()
        }).then(function (data) {

            privTable.ajax.reload(false, null);
        });


    }

</script>
