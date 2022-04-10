@extends("layouts.app")
@section('page-name', 'Dashboard')
@section('page-icon', 'home')
@section('page-content')
    @php
    use Carbon\Carbon;
    $date = Carbon::now();

    $weekNumber = $date->weekOfYear;
    $years = range(1900, strftime('%Y', time()));
    @endphp
    <div class="page-body">
        <div class="row">

            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-red">
                    <div class="card-body">
                        <div class="row align-items-center m-b-30">
                            <div class="col">
                                <h6 class="m-b-5 text-white">Presbyteries</h6>
                                <h3 class="m-b-0 f-w-700 text-white">{{$presbyteries}}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database text-c-red f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-blue">
                    <div class="card-body">
                        <div class="row align-items-center m-b-30">
                            <div class="col">
                                <h6 class="m-b-5 text-white">Members</h6>
                                <h3 class="m-b-0 f-w-700 text-white">{{$members}}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database text-c-blue f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-green">
                    <div class="card-body">
                        <div class="row align-items-center m-b-30">
                            <div class="col">
                                <h6 class="m-b-5 text-white">Districts</h6>
                                <h3 class="m-b-0 f-w-700 text-white">{{$districts}}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database text-c-green f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card prod-p-card card-yellow">
                    <div class="card-body">
                        <div class="row align-items-center m-b-30">
                            <div class="col">
                                <h6 class="m-b-5 text-white">Local Unions</h6>
                                <h3 class="m-b-0 f-w-700 text-white">{{$unions}}</h3>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-database text-c-yellow f-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>General Informations</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i></li>
                                <li><i class="feather icon-refresh-cw reload-card"></i></li>
                                <li><i class="feather icon-trash close-card"></i></li>
                                <li><i class="feather icon-chevron-left open-card-option"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block p-b-0">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>Modules</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            Members
                                        </th>
                                        <td>
                                            {{$members}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            Presbyteries
                                        </th>
                                        <td>
                                            {{$presbyteries}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            Districts
                                        </th>
                                        <td>
                                            {{$districts}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            Branches
                                        </th>
                                        <td>
                                            {{$branches}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            Unions
                                        </th>
                                        <td>
                                            {{$unions}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            Professional Groups
                                        </th>
                                        <td>
                                            {{$professional_groups}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row d-none">
            <div class="col-md-12 col-xl-4">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5>Artists</h5>
                    </div>
                    <div class="card-block">
                        <div id="artist_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-8">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5>Top 3</h5>
                    </div>
                    <div class="card-block">
                        <div id="stock_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none">
            <div class="col-md-12 col-xl-8">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5 style="color:rgb(9, 172, 9)">Daily Votes Count []
                            ({{ date('jS F, Y', strtotime(gmdate('Y-m-d'))) }})</h5>
                    </div>
                    <div class="card-block">
                        <div id="daily_votes_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5>Stage Votes Count</h5>
                    </div>
                    <div class="card-block">
                        <div id="stages_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none">
            <div class="col-md-12 col-xl-12">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5>All Votes [Stage]</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select id="itemType" class="select2 form-control">
                                    {{-- @foreach ($types as $type)
                                        <option value="{{ $type->typeno }}">
                                            {{ $type->typename }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div id="votes_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none">
            <div class="col-md-12 col-xl-12">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5>Daily Artist Votes Chart</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select id="shopItemCat" class="select2 form-control">
                                    {{-- @foreach ($categories as $category)
                                        <option value="{{ $category->catno }}">
                                            {{ $category->catname }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div id="daily_votes_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none">
            <div class="col-md-12 col-xl-12">
                <div class="card sale-card">
                    <div class="card-header">
                        <h5>Group Chart</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <select id="warehouseItemCat" class="select2 form-control">
                                    {{-- @foreach ($categories as $category)
                                        <option value="{{ $category->catno }}">
                                            {{ $category->catname }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div id="group_chart" class="chart-shadow" style="height:380px; width:100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-none">
            <div class="col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>League Table</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i>
                                </li>
                                <li><i class="feather icon-maximize full-card"></i></li>
                                <li><i class="feather icon-minus minimize-card"></i>
                                </li>
                                <li><i class="feather icon-refresh-cw reload-card" id="reload-cheques"></i>
                                </li>
                                <li><i class="feather icon-trash close-card"></i></li>
                                <li><i class="feather icon-chevron-left open-card-option"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block p-b-0">
                        <div class="card-body">
                            <div class="row mt-2 elevate p-3">
                                <div class="col">
                                    <label for="">Customer</label>
                                    <select id="customer_filter" class="form-control select2">
                                        <option value="All">All</option>
                                        {{-- @foreach ($customers as $customer)
                                            <option value="{{ $customer->cust_code }}">
                                                {{ $customer->cust_name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="">From</label>
                                    <input type="date" value="{{ date('Y-01-01') }}" id="dateFromCheque"
                                        class="form-control" />
                                </div>
                                <div class="col">
                                    <label for="">To</label>
                                    <input type="date" value="{{ date('Y-m-d') }}" id="dateToCheque"
                                        class="form-control" />
                                </div>
                                <div class="col">
                                    <button class="btn btn-sm btn-default filter-button" id="filterCheques"
                                        style="margin-top:32px"><i class="fa fa-filter"></i> FILTER</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="chequesTable" class="datatable table table-hover m-b-0">
                                    <thead>
                                        <tr>
                                            <th width="5px"><small>NO.</small></th>
                                            <th width="80px"><small>DATE</small></th>
                                            <th><small>CHEQUE NO.</small></th>
                                            <th><small>CUSTOMER</small></th>
                                            <th><small>DRAWER</small></th>
                                            <th><small>DRAWEE</small></th>
                                            <th><small>BENEFICIARY</small></th>
                                            <th width="80px"><small>AMOUNT</small></th>
                                            <th width="80px"><small>PURPOSE</small></th>
                                            <th width="80px"><small>STATUS</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
@endsection
