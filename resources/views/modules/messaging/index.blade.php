@extends("layouts.app")
@section('page-name', 'Messaging')
@section('page-icon', 'comments')
@section('page-content')

    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active text-info" id="notifications-tab"
                                                    data-toggle="pill" href="#notifications" role="tab"
                                                    aria-controls="profile" aria-selected="false">SMS</a>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link text-info " id="home-tab" data-toggle="tab"
                                                    href="#email-ads-tab" role="tab" aria-controls="home"
                                                    aria-selected="true">Email</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content" id="myTabContent">
                                            {{-- SMS tab --}}
                                            <div class="tab-pane fade show active mt-1" id="notifications" role="tabpanel"
                                                aria-labelledby="notifications-tab">

                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active text-info" id="notifications-tab"
                                                            data-toggle="pill" href="#single-sms" role="tab"
                                                            aria-controls="profile" aria-selected="false"> Single SMS</a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link text-info " id="home-tab" data-toggle="tab"
                                                            href="#bulk-sms" role="tab" aria-controls="home"
                                                            aria-selected="true">Bulk SMS</a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content" id="myTab">

                                                    <div class="tab-pane fade show active" id="single-sms" role="tabpanel"
                                                        aria-labelledby="notifications-tab">


                                                        <div class="row">
                                                            <div class="col p-3 rounded   shadow-sm">
                                                                <form id="single-notification-form">
                                                                    <div class="row">
                                                                        <!-- Notification types -->
                                                                        <div class="col-6 MT-2 d-none">
                                                                            <h5 class="border-bottom">Select Message Type
                                                                            </h5>
                                                                            <!-- Bulk SMS notification -->
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio"
                                                                                    id="single-sms-type" required checked
                                                                                    form="single-notification-form"
                                                                                    name="notificationType"
                                                                                    value="single-sms">
                                                                                <label class="form-check-label"
                                                                                    for="sms-notification-type">Single
                                                                                    SMS</label>
                                                                            </div>
                                                                        </div>

                                                                        <!-- SMS recipients -->
                                                                        <div class="col">
                                                                            <div id="sms-recipients-holder"
                                                                                class="p-1 rounded">

                                                                                <select name="recipient"
                                                                                    id="single-sms-recipient"
                                                                                    class="form-control select2">
                                                                                    <option value="">--Select Recipient --
                                                                                    </option>
                                                                                    @foreach ($users as $user)
                                                                                        <option value="{{ $user->id }}">
                                                                                            {{ $user->name }}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                             </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                    <div
                                                                            class="col-3 mt-5 p-3 border border-default rounded shadow">
                                                                            <form id="single-notification-form">

                                                                                <!-- Notification body -->
                                                                                <div class="form-group">
                                                                                    <label class="text-dark"
                                                                                        for="notification-body">Content</label>
                                                                                    <textarea required
                                                                                        placeholder="Enter the content of the sms here"
                                                                                        rows="8" col="5"
                                                                                        class="form-control"
                                                                                        name="notificationBody"></textarea>
                                                                                </div>

                                                                                <button
                                                                                    class="btn btn-sm btn-block btn-primary">Send</button>
                                                                            </form>
                                                                        </div>

                                                                        <div
                                                                            class="col-8 p-3 mt-5 border border-default mx-auto">
                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="table table-bordered table-sm table-hover dataTable js-exportable"
                                                                                    id="previous-single-sms-table"
                                                                                    cellspacing="0" width="100%">
                                                                                    <thead class="thead-dark">
                                                                                        <tr>
                                                                                            <th>Recipient</th>
                                                                                            <th>Date Sent</th>
                                                                                            <th>SMS Details</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    <div class="tab-pane fade" id="bulk-sms" role="tabpanel"
                                                        aria-labelledby="notifications-tab">

                                                        <div class="row shadow-sm  border  p-2 rounded">
                                                            <!-- Notification types -->
                                                            <div class="row p-3">
                                                                <div class="form-check  form-check-inline d-none">
                                                                    <input class="form-check-input" type="radio"
                                                                        id="sms-notification-type" required checked
                                                                        form="bulk-sms-form" name="notificationType"
                                                                        value="bulk-sms">
                                                                    <label class="form-check-label "
                                                                        for="sms-notification-type">Bulk
                                                                        SMS</label>


                                                                </div>

                                                                <div class="form-check  form-check-inline ">
                                                                    <label class="radio-inline ml-2">
                                                                        <input type="radio" form="bulk-sms-form"
                                                                            value="presbytery" name="recipientGroup">
                                                                        Presbytery
                                                                    </label>
                                                                    <label class="radio-inline ml-2">
                                                                        <input type="radio" form="bulk-sms-form"
                                                                            name="recipientGroup" value="chapter"> Local
                                                                        Institution
                                                                    </label>
                                                                    <label class="radio-inline ml-2">
                                                                        <input type="radio" form="bulk-sms-form"
                                                                            value="congregation" name="recipientGroup">
                                                                        Local Union
                                                                    </label>
                                                                </div>
                                                                <div class="border-right"></div>


                                                            </div>

                                                            <!-- SMS recipients -->
                                                            <div class="row p-3">
                                                                <label class="text-info">
                                                                    Select option corresponding to recepient group chosen

                                                                </label>

                                                                <div id="recipients-holder" class="p-1 rounded">

                                                                    <div class="row">
                                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                                            <label for="">Presbytery</label>
                                                                            <select name="recipientSelection2"
                                                                                form="bulk-sms-form"
                                                                                class="form-control select2">
                                                                                <option value="">--Select Option--</option>
                                                                                {{-- @foreach ($presbytries as $item)
                                                                                    <option
                                                                                        value="{{ $item->pres_code }}">
                                                                                        {{ $item->pres_desc }}</option>
                                                                                @endforeach --}}

                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                                            <label for="">Local Institution</label>
                                                                            <select name="recipientSelection1"
                                                                                form="bulk-sms-form"
                                                                                class="form-control select2">
                                                                                <option value="">--Select Option--</option>
                                                                                {{-- @foreach ($chapters as $chapter)
                                                                                    <option value="{{ $chapter->code }}">
                                                                                        {{ $chapter->desc }}</option>
                                                                                @endforeach --}}
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                                            <label for="">Local Union</label>

                                                                            <select name="recipientSelection3"
                                                                                form="bulk-sms-form"
                                                                                class="form-control select2">
                                                                                <option value="">--Select Option--</option>
                                                                                {{-- @foreach ($congregations as $item)
                                                                                    <option value="{{ $item->cong_ode }}">
                                                                                        {{ $item->cong_desc }}</option>
                                                                                @endforeach --}}
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <!-- Notification content -->
                                                        <div class="row">
                                                            <div
                                                                class="col-3 mx-auto p-3 border border-default rounded shadow">
                                                                <form id="bulk-sms-form">

                                                                    <!-- Notification body -->
                                                                    <div class="form-group">
                                                                        <label class="text-dark"
                                                                            for="notification-body">Content:</label>
                                                                        <textarea required
                                                                            placeholder="Enter the content of the sms here"
                                                                            rows="8" col="5" class="form-control"
                                                                            name="notificationBody"></textarea>
                                                                    </div>

                                                                    <button
                                                                        class="btn btn-sm btn-block btn-primary">Send</button>
                                                                </form>
                                                            </div>
                                                            <!-- Notification content -->

                                                            <!-- Previous Notifications -->
                                                            <div class="col-8 p-3 border border-default mx-auto">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        class="table table-bordered table-sm table-hover dataTable js-exportable"
                                                                        id="previous-bulk-sms-table" cellspacing="0"
                                                                        width="100%">
                                                                        <thead class="thead-dark">
                                                                            <tr>
                                                                                <th>Recipient</th>
                                                                                <th>Date Sent</th>
                                                                                <th>SMS Details</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- Previous Notifications -->
                                                        </div>

                                                    </div>

                                                </div>


                                            </div>





                                            {{-- Email tab --}}
                                            <div class="tab-pane fade mt-1" id="email-ads-tab" role="tabpanel"
                                                aria-labelledby="home-tab">


                                                <ul class="nav nav-tabs" id="myEmailTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active text-info" id="notifications-tab"
                                                            data-toggle="pill" href="#single-email-tab" role="tab"
                                                            aria-controls="profile" aria-selected="false"> Single Email</a>
                                                    </li>

                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link text-info " id="home-tab" data-toggle="tab"
                                                            href="#bulk-email-tab" role="tab" aria-controls="home"
                                                            aria-selected="true">Bulk Email</a>
                                                    </li>
                                                </ul>


                                                <div class="tab-content" id="myEmailTab">
                                                    {{-- SINGLE EMAIL TAB --}}
                                                    <div class="tab-pane fade show active" id="single-email-tab"
                                                        role="tabpanel" aria-labelledby="notifications-tab">

                                                        <div class="row">
                                                            <div class="col p-3 rounded   shadow-sm">
                                                                <form id="single-email-form">
                                                                    <div class="row shadow-sm  border  p-2 rounded">
                                                                        <!-- Notification types -->
                                                                        <div class="col-6 MT-2 d-none">
                                                                            <h5 class="border-bottom">Select Message Type
                                                                            </h5>
                                                                            <!-- Bulk EMAIL notification -->
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio"
                                                                                    id="single-email-type" required
                                                                                    form="email-form" name="emailType"
                                                                                    value="single-email">
                                                                                <label class="form-check-label"
                                                                                    for="email-notification-type">Single
                                                                                    Email</label>
                                                                            </div>
                                                                        </div>

                                                                        <!-- EMAIL recipients -->
                                                                        <div class="col">
                                                                            <div id="email-recipients-holder"
                                                                                class="p-1 rounded">

                                                                                <select name="recipient"
                                                                                    id="single-email-recipient"
                                                                                    class="form-control select2">
                                                                                    <option value="">--Select Option--
                                                                                    </option>
                                                                                    {{-- @foreach ($users as $user)
                                                                                        <option
                                                                                            value="{{ $user->mid }}">
                                                                                            {{ $user->fname }}
                                                                                            {{ $user->mname }}
                                                                                            {{ $user->lname }}</option>
                                                                                    @endforeach --}}
                                                                                </select>



                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">


                                                                        <div
                                                                            class="col-3 mt-5  p-3 border border-default rounded shadow">

                                                                            <form id="notification-form">

                                                                                <label class="text-dark"
                                                                                    for="email-description">Subject</label>
                                                                                <input name="subject"
                                                                                    class="form-control form-control-sm"
                                                                                    id="email-form-subject">

                                                                                <label class="text-dark"
                                                                                    for="email-description">Message</label>
                                                                                <textarea name="email"
                                                                                    placeholder="Enter the content of the sms here"
                                                                                    class="form-control" id="" cols="30"
                                                                                    rows="10"></textarea>

                                                                                <button
                                                                                    class="btn btn-sm btn-block btn-primary mt-3">Send</button>
                                                                            </form>
                                                                        </div>

                                                                        <div
                                                                            class="col-8 mt-5 p-3 border border-default mx-auto">
                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="datatable table-bordered table table-stripped"
                                                                                    width='100%' id="single-email-table">
                                                                                    <thead class="thead-dark">
                                                                                        <tr>
                                                                                            <th>Recipient</th>
                                                                                            <th>Subject</th>
                                                                                            <th>Body</th>
                                                                                            <th>Date Sent</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        {{-- Data is fetched here using ajax --}}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>


                                                    {{-- BULK EMAIL TAB --}}
                                                    <div class="tab-pane fade" id="bulk-email-tab" role="tabpanel"
                                                        aria-labelledby="notifications-tab">

                                                        <div class="row shadow-sm  border  p-2 rounded">
                                                            <div class="row p-3">
                                                                <form id="bulk-email-form">
                                                                    <!-- Notification types -->
                                                                    <div class="form-check form-check-inline d-none">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="email-notification-type" required checked
                                                                            form="email-form" name="emailType"
                                                                            value="bulk-email">
                                                                        <label class="form-check-label"
                                                                            for="email-notification-type">Bulk
                                                                            Email</label>
                                                                    </div>

                                                                    <div class="form-check  form-check-inline">

                                                                        <label class="radio-inline ml-2">
                                                                            <input type="radio" form="bulk-email-form"
                                                                                value="presbytery" name="recipientGroup1">
                                                                            Presbytery
                                                                        </label>
                                                                        <label class="radio-inline ml-2">
                                                                            <input type="radio" form="bulk-email-form"
                                                                                value="institution" name="recipientGroup1">
                                                                            Local Institution
                                                                        </label>
                                                                        <label class="radio-inline ml-2">
                                                                            <input type="radio" form="bulk-email-form"
                                                                                value="union" name="recipientGroup1">
                                                                            Local Union
                                                                        </label>

                                                                    </div>
                                                                    <div class="border-right"></div>


                                                                    <!-- EMAIL recipients -->
                                                                    <div class="row p-3">
                                                                        <label class="text-info">
                                                                            Select option corresponding to recepient
                                                                            group chosen</label>

                                                                        <div id="email-recipients-holder"
                                                                            class="p-1 rounded">


                                                                            <div class="row">
                                                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                                                    <label for="">Presbytery</label>
                                                                                    <select name="emailrecipientSelection1"
                                                                                        form="bulk-email-form"
                                                                                        class="form-control select2">
                                                                                        <option value="">--Select
                                                                                            Option--</option>
                                                                                        {{-- @foreach ($presbytries as $item)
                                                                                            <option
                                                                                                value="{{ $item->pres_code }}">
                                                                                                {{ $item->pres_desc }}</option>
                                                                                        @endforeach --}}

                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                                                    <label for="">Local Institution</label>
                                                                                    <select name="emailrecipientSelection2"
                                                                                        form="bulk-email-form"
                                                                                        class="form-control select2">
                                                                                        <option value="">--Select
                                                                                            Option--</option>
                                                                                        {{-- @foreach ($chapters as $chapter)
                                                                                            <option value="{{ $chapter->code }}">
                                                                                                {{ $chapter->desc }}</option>
                                                                                        @endforeach --}}

                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                                                    <label for="">Local Union</label>

                                                                                    <select name="emailrecipientSelection3"
                                                                                        form="bulk-email-form"
                                                                                        class="form-control select2">
                                                                                        <option value="">--Select
                                                                                            Option--</option>
                                                                                        {{-- @foreach ($congregations as $item)
                                                                                            <option value="{{ $item->cong_ode }}">
                                                                                                {{ $item->cong_desc }}</option>
                                                                                        @endforeach --}}

                                                                                    </select>
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="form-row">


                                                                        <div
                                                                            class="col-3 mt-5  p-3 border border-default rounded shadow">
                                                                            <label class="text-dark"
                                                                                for="notification-body">Content:</label>
                                                                            <br>
                                                                            <div>
                                                                                <p id="feedback-message">
                                                                                </p>
                                                                            </div>

                                                                            <label for="email-description"
                                                                                class="text-dark">Subject</label>
                                                                            <input name="subject"
                                                                                class="form-control form-control-sm"
                                                                                id="bulk-email-form-subject">

                                                                            <label for="email-description"
                                                                                class="text-dark">Message</label>
                                                                            <textarea name="email"
                                                                                placeholder="Enter the content here"
                                                                                class="form-control" id="" cols="30"
                                                                                rows="10"></textarea>

                                                                            <button
                                                                                class="btn btn-sm btn-block btn-primary mt-3">Send</button>
                                                                        </div>

                                                                </form>
                                                                <div class="col-8 mt-5 p-3 border border-default mx-auto">
                                                                    <div class="table-responsive">
                                                                        <table class="datatable table-bordered table"
                                                                            width='100%' id="bulk-email-table">
                                                                            <thead class="thead-dark">
                                                                                <tr>
                                                                                    <th>Recipient</th>
                                                                                    <th>Subject</th>
                                                                                    <th>Body</th>
                                                                                    <th>Date Sent</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                {{-- Data is fetched here using ajax --}}
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include("modules.messaging.modals.sms")
    @include("modules.messaging.modals.email") --}}

    <script>
        // send single sms
        let notificationForm = document.forms["single-notification-form"];
        notificationForm.addEventListener("submit", function(e) {
            e.preventDefault();

            let formdata = new FormData();
            formdata.append("notificationType", this.notificationType.value);
            formdata.append("recipient", document.getElementById('single-sms-recipient').value);
            formdata.append("notificationBody", this.notificationBody.value);


            fetch(`${APP_URL}/api/send_single_sms`, {
                    method: "POST",
                    body: formdata,
                }).then(res => res.json())
                .then(data => {
                    console.log(data);
                    // previousNotificationsTable.ajax.reload(false, null);
                })

            Swal.fire({
                title: "",
                text: "The sms will be delivered to the recipient",
                timer: 2800,
                icon: "success",
                showConfirmButton: false,
            });
            notificationForm.reset();
            singlesmsTable.ajax.reload(false, null);

        });

        // send emal sms
        let singleemailForm = document.forms["single-email-form"];
        singleemailForm.addEventListener("submit", function(e) {
            e.preventDefault();

            let formdata = new FormData();
            formdata.append("recipient", document.getElementById('single-email-recipient').value);
            formdata.append("emailType", document.getElementById('single-email-type').value);
            formdata.append("email", this.email.value);
            formdata.append("subject", this.subject.value);


            fetch(`${APP_URL}/api/send_single_email`, {
                method: "POST",
                body: formdata,
                // headers: {
                //     "Authorization": "d16xA0oqWRi2barEd1Ru3JVM3uveym6nw2ntVsfSUl0kf8T5XNVhSykpoqswweeJI7OjiYTc1rtkDTKE",
                // }
            });
            feedback.innerHTML = "<span class='alert alert-success'>Message sent </span>";
            setTimeout(() => {
                feedback.innerHTML = null;
                emailForm.reset();
            }, 3000);
            singleemailForm.ajax.reload(false, null);
        });

        // send bulk sms
        let bulknotificationForm = document.forms["bulk-sms-form"];
        bulknotificationForm.addEventListener("submit", function(e) {
            e.preventDefault();

            let formdata = new FormData();
            formdata.append("notificationType", this.notificationType.value);
            formdata.append("notificationBody", this.notificationBody.value);
            formdata.append("recipientSelection1", this.recipientSelection1.value);
            formdata.append("recipientSelection2", this.recipientSelection2.value);
            formdata.append("recipientSelection3", this.recipientSelection3.value);
            formdata.append("recipientSelection4", this.recipientSelection4.value);
            formdata.append("recipientGroup", this.recipientGroup.value);


            fetch(`${APP_URL}/api/send_bulk_sms`, {
                    method: "POST",
                    body: formdata,
                }).then(res => res.json())
                .then(data => {
                    console.log(data);
                    // previousNotificationsTable.ajax.reload(false, null);
                })

            Swal.fire({
                title: "",
                text: "The sms will be delivered to all recipients",
                timer: 2800,
                icon: "success",
                showConfirmButton: false,
            });
            bulknotificationForm.reset();
            bulksmsTable.ajax.reload(false, null);

        });



        // ############################################ SMS Table ###################
        var singlesmsTable = $("#previous-single-sms-table").DataTable({
            dom: "Bfrtip",
            buttons: [],
            ordering: true,
            order: [],
            ajax: {
                url: `${APP_URL}/api/previous_single_sms`,
                type: "GET",
                // headers: {
                //     "Authorization": "d16xA0oqWRi2barEd1Ru3JVM3uveym6nw2ntVsfSUl0kf8T5XNVhSykpoqswweeJI7OjiYTc1rtkDTKE"
                // }
            },
            columns: [{
                    data: "recipient"
                },
                {
                    data: "date_sent"
                },
                {
                    data: "details"
                },

            ],
        });

        var bulksmsTable = $("#previous-bulk-sms-table").DataTable({
            dom: "Bfrtip",
            buttons: [],
            ordering: true,
            order: [],
            ajax: {
                url: `${APP_URL}/api/previous_bulk_sms`,
                type: "GET",
                // headers: {
                //     "Authorization": "d16xA0oqWRi2barEd1Ru3JVM3uveym6nw2ntVsfSUl0kf8T5XNVhSykpoqswweeJI7OjiYTc1rtkDTKE"
                // }
            },
            columns: [{
                    data: "recipient"
                },
                {
                    data: "date_sent"
                },
                {
                    data: "details"
                },

            ],
        });


        //#################### EMAIL SCRIPT ######################################
        var bulkemailTable = $("#bulk-email-table").DataTable({
            dom: "Bfrtip",
            buttons: [],
            ordering: true,
            order: [],
            ajax: {
                url: `${APP_URL}/api/previous_bulk_email`,
                type: "GET",
                headers: {
                    "Authorization": "d16xA0oqWRi2barEd1Ru3JVM3uveym6nw2ntVsfSUl0kf8T5XNVhSykpoqswweeJI7OjiYTc1rtkDTKE"
                }
            },
            columns: [{
                    data: "recipient"
                },
                {
                    data: "subject"
                },
                {
                    data: "details"
                },
                {
                    data: "date_sent"
                },

            ],
        });

        var singleemailTable = $("#single-email-table").DataTable({
            dom: "Bfrtip",
            buttons: [],
            ordering: true,
            order: [],
            ajax: {
                url: `${APP_URL}/api/previous_single_email`,
                type: "GET",
                headers: {
                    "Authorization": "d16xA0oqWRi2barEd1Ru3JVM3uveym6nw2ntVsfSUl0kf8T5XNVhSykpoqswweeJI7OjiYTc1rtkDTKE"
                }
            },
            columns: [{
                    data: "recipient"
                },
                {
                    data: "subject"
                },
                {
                    data: "details"
                },
                {
                    data: "date_sent"
                },

            ],
        });

        let bulkemailForm = document.forms["bulk-email-form"];
        bulkemailForm.addEventListener("submit", function(e) {
            e.preventDefault();



            let formdata = new FormData();
            formdata.append("subject", document.getElementById('bulk-email-form-subject').value);
            formdata.append("emailType", document.getElementById('email-notification-type').value);
            formdata.append("email", this.email.value);
            formdata.append("recipientSelection1", this.emailrecipientSelection1.value);
            formdata.append("recipientSelection2", this.emailrecipientSelection2.value);
            formdata.append("recipientSelection3", this.emailrecipientSelection3.value);
            formdata.append("recipientSelection4", this.emailrecipientSelection4.value);
            formdata.append("recipientGroup", this.recipientGroup1.value);


            fetch(`${APP_URL}/api/send_bulk_email`, {
                method: "POST",
                body: formdata,
                // headers: {
                //     "Authorization": "d16xA0oqWRi2barEd1Ru3JVM3uveym6nw2ntVsfSUl0kf8T5XNVhSykpoqswweeJI7OjiYTc1rtkDTKE",
                // }
            });
            Swal.fire({
                title: "",
                text: "The email will be delivered to all recipients",
                timer: 2800,
                icon: "success",
                showConfirmButton: false,
            });
            bulkemailForm.reset();
            bulkemailTable.ajax.reload(false, null);
        });




    </script>
@endsection
