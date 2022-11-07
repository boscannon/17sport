@extends('layouts.backend')

@section('css_before')
    <link rel="stylesheet" href="/js/plugins/slick/slick.css">
    <link rel="stylesheet" href="/js/plugins/slick/slick-theme.css">
@endsection

@section('content')
    <div class="content">
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            <div class="col-6 col-xl-4">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-bag fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="1500">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">錢包總數(啟用中)</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-4">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-wallet fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600">$<span data-toggle="countTo" data-speed="1000" data-to="780">0</span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">會員總數(啟用中)</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-xl-4">
                <a class="block block-link-shadow text-right" href="javascript:void(0)">
                    <div class="block-content block-content-full clearfix">
                        <div class="float-left mt-10 d-none d-sm-block">
                            <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
                        </div>
                        <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">不重複的會員總數(啟用中)</div>
                    </div>
                </a>
            </div>
            <!-- END Row #1 -->
        </div>
        <div class="row invisible" data-toggle="appear">
            <!-- Row #2 -->
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">
                            會員人數分析
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">近一年</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-bell mr-5"></i>近一年
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-envelope-o mr-5"></i>近半年
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-envelope-o mr-5"></i>近三個月
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-envelope-o mr-5"></i>近一個月
                                    </a>
                                </div>
                            </div>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option">
                                <i class="si si-wrench"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="pull-all">
                            <!-- Lines Chart Container functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
                            <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                            <canvas class="js-chartjs-dashboard-lines"></canvas>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row items-push">
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Month</div>
                                <div class="font-size-h4 font-w600">720</div>
                                <div class="font-w600 text-success">
                                    <i class="fa fa-caret-up"></i> +16%
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Week</div>
                                <div class="font-size-h4 font-w600">160</div>
                                <div class="font-w600 text-danger">
                                    <i class="fa fa-caret-down"></i> -3%
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Average</div>
                                <div class="font-size-h4 font-w600">24.3</div>
                                <div class="font-w600 text-success">
                                    <i class="fa fa-caret-up"></i> +9%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header">
                        <h3 class="block-title">
                            發行總量分析
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success dropdown-toggle" id="btnGroupDrop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">近一年</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-bell mr-5"></i>近一年
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-envelope-o mr-5"></i>近半年
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-envelope-o mr-5"></i>近三個月
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-envelope-o mr-5"></i>近一個月
                                    </a>
                                </div>
                            </div>
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option">
                                <i class="si si-wrench"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="pull-all">
                            <!-- Lines Chart Container functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _js/pages/be_pages_dashboard.js -->
                            <!-- For more info and examples you can check out http://www.chartjs.org/docs/ -->
                            <canvas class="js-chartjs-dashboard-lines2"></canvas>
                        </div>
                    </div>
                    <div class="block-content bg-white">
                        <div class="row items-push">
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Month</div>
                                <div class="font-size-h4 font-w600">$ 6,540</div>
                                <div class="font-w600 text-success">
                                    <i class="fa fa-caret-up"></i> +4%
                                </div>
                            </div>
                            <div class="col-6 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">This Week</div>
                                <div class="font-size-h4 font-w600">$ 1,525</div>
                                <div class="font-w600 text-danger">
                                    <i class="fa fa-caret-down"></i> -7%
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 text-center text-sm-left">
                                <div class="font-size-sm font-w600 text-uppercase text-muted">Balance</div>
                                <div class="font-size-h4 font-w600">$ 9,352</div>
                                <div class="font-w600 text-success">
                                    <i class="fa fa-caret-up"></i> +35%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Row #2 -->
        </div>
    </div>
@endsection

@section('js_after')
    <script src="/js/plugins/chartjs/Chart.bundle.min.js"></script>
    <script src="/js/plugins/slick/slick.min.js"></script>
    <script src="/js/pages/be_pages_dashboard.js"></script>
@endsection
