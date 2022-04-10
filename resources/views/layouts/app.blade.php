<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head.blade -->
    @include("includes.head")
</head>

<body>

    <div class="loader-bg">
        <div class="loader-bar"></div>
    </div>

    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <!-- top nav -->
            @include("includes.navbar")

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <!-- sidebar nav -->
                    @include("includes.sidebar")

                    <div class="pcoded-content">

                        <div class="page-header card">
                            <div class="row align-items-end">
                                <div class="col-lg-8">
                                    <div class="page-header-title">
                                        <i class="fas fa-@yield("page-icon") bg-c-blue"></i>
                                        <div class="d-inline">
                                            <h5>@yield("page-name")</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="page-header-breadcrumb">
                                        <ul class=" breadcrumb breadcrumb-title">
                                            <li class="breadcrumb-item">
                                                <a href="{{ config('app.url') }}"><i class="fas fa-home"></i></a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a href="{{ config('app.url') }}">Home</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <a class="active">@yield("page-name")</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pcoded-inner-content">

                            <div class="main-body">
                                <div class="page-wrapper">

                                    <!-- body goes here -->
                                    @yield("page-content")

                                </div>
                            </div>

                            <div id="styleSelector">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scripts -->
    @include("includes.scripts")
</body>

</html>