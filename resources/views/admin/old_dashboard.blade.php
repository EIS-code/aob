@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')
<link href="{{SYSTEM_SITE_URL}}assets/css/timeline.css" rel="stylesheet">
<link href="{{SYSTEM_SITE_URL}}assets/css/morris.css" rel="stylesheet">
@endsection

@section('content')

<div id="wrapper">

    @include('user.layouts.navbar')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if($errors->any())
                        <div class="text-center alert alert-danger">
                            <ul style="list-style-type: none;">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session()->has('succ_msg'))
                        <div class="text-center alert alert-success">{{session()->get('succ_msg')}}</div>
                    @endif

                    @if(session()->has('fail_msg'))
                        <div class="text-center alert alert-danger">{{session()->get('fail_msg')}}</div>
                    @endif

                </div>
            </div>

            <!-- LEADS -->
            <div class="row">
                <div class="col-lg-12">
                    @if($data['leads'])
                        @foreach($data['leads'] as $lead)
                        <a href="{{SYSTEM_SITE_URL}}followlead?lead={{sp_encryption($lead->id)}}">
                            <div class="text-left alert alert-warning">
                                <ul style="list-style-type: none;">
                                    <li> Follow the {{$lead->firstname}} {{$lead->lastname}} leads</li>
                                </ul>
                            </div>
                        </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6">

                    <div class="panel panel-primary">

                        <div class="panel-heading">

                            <div class="row">

                                <div class="col-xs-3">

                                    <i class="fa fa-comments fa-5x"></i>

                                </div>

                                <div class="col-xs-9 text-right">

                                    <div class="huge">26</div>

                                    <div>Sent Emails</div>

                                </div>

                            </div>

                        </div>

                        <a href="{{SYSTEM_SITE_URL}}viewsentemails">

                            <div class="panel-footer">

                                <span class="pull-left">View Details</span>

                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>



                                <div class="clearfix"></div>

                            </div>

                        </a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="panel panel-green">

                        <div class="panel-heading">

                            <div class="row">

                                <div class="col-xs-3">

                                    <i class="fa fa-tasks fa-5x"></i>

                                </div>

                                <div class="col-xs-9 text-right">

                                    <div class="huge">12</div>

                                    <div>Active Leads</div>

                                </div>

                            </div>

                        </div>

                        <a href="{{SYSTEM_SITE_URL}}leads">

                            <div class="panel-footer">

                                <span class="pull-left">View Details</span>

                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>



                                <div class="clearfix"></div>

                            </div>

                        </a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="panel panel-yellow">

                        <div class="panel-heading">

                            <div class="row">

                                <div class="col-xs-3">

                                    <i class="fa fa-shopping-cart fa-5x"></i>

                                </div>

                                <div class="col-xs-9 text-right">

                                    <div class="huge">124</div>

                                    <div>Groups</div>

                                </div>

                            </div>

                        </div>

                        <a href="{{SYSTEM_SITE_URL}}groups">

                            <div class="panel-footer">

                                <span class="pull-left">View Details</span>

                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>



                                <div class="clearfix"></div>

                            </div>

                        </a>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="panel panel-red">

                        <div class="panel-heading">

                            <div class="row">

                                <div class="col-xs-3">

                                    <i class="fa fa-support fa-5x"></i>

                                </div>

                                <div class="col-xs-9 text-right">

                                    <div class="huge">13</div>

                                    <div>Clients</div>

                                </div>

                            </div>

                        </div>

                        <a href="{{SYSTEM_SITE_URL}}clients">

                            <div class="panel-footer">

                                <span class="pull-left">View Details</span>

                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>



                                <div class="clearfix"></div>

                            </div>

                        </a>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-lg-8">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <i class="fa fa-bar-chart-o fa-fw"></i> Area Chart Example

                            <div class="pull-right">

                                <div class="btn-group">

                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle"

                                            data-toggle="dropdown">

                                        Actions

                                        <span class="caret"></span>

                                    </button>

                                    <ul class="dropdown-menu pull-right" role="menu">

                                        <li><a href="#">Action</a>

                                        </li>

                                        <li><a href="#">Another action</a>

                                        </li>

                                        <li><a href="#">Something else here</a>

                                        </li>

                                        <li class="divider"></li>

                                        <li><a href="#">Separated link</a>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                        <div class="panel-body">

                            <div id="morris-area-chart"></div>

                        </div>

                    </div>

                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <i class="fa fa-bar-chart-o fa-fw"></i> Bar Chart Example

                            <div class="pull-right">

                                <div class="btn-group">

                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle"

                                            data-toggle="dropdown">

                                        Actions

                                        <span class="caret"></span>

                                    </button>

                                    <ul class="dropdown-menu pull-right" role="menu">

                                        <li><a href="#">Action</a>

                                        </li>

                                        <li><a href="#">Another action</a>

                                        </li>

                                        <li><a href="#">Something else here</a>

                                        </li>

                                        <li class="divider"></li>

                                        <li><a href="#">Separated link</a>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-lg-4">

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-hover table-striped">

                                            <thead>

                                            <tr>

                                                <th>#</th>

                                                <th>Date</th>

                                                <th>Time</th>

                                                <th>Amount</th>

                                            </tr>

                                            </thead>

                                            <tbody>

                                            <tr>

                                                <td>3326</td>

                                                <td>10/21/2013</td>

                                                <td>3:29 PM</td>

                                                <td>$321.33</td>

                                            </tr>

                                            <tr>

                                                <td>3325</td>

                                                <td>10/21/2013</td>

                                                <td>3:20 PM</td>

                                                <td>$234.34</td>

                                            </tr>

                                            <tr>

                                                <td>3324</td>

                                                <td>10/21/2013</td>

                                                <td>3:03 PM</td>

                                                <td>$724.17</td>

                                            </tr>

                                            <tr>

                                                <td>3323</td>

                                                <td>10/21/2013</td>

                                                <td>3:00 PM</td>

                                                <td>$23.71</td>

                                            </tr>

                                            <tr>

                                                <td>3322</td>

                                                <td>10/21/2013</td>

                                                <td>2:49 PM</td>

                                                <td>$8345.23</td>

                                            </tr>

                                            <tr>

                                                <td>3321</td>

                                                <td>10/21/2013</td>

                                                <td>2:23 PM</td>

                                                <td>$245.12</td>

                                            </tr>

                                            <tr>

                                                <td>3320</td>

                                                <td>10/21/2013</td>

                                                <td>2:15 PM</td>

                                                <td>$5663.54</td>

                                            </tr>

                                            <tr>

                                                <td>3319</td>

                                                <td>10/21/2013</td>

                                                <td>2:13 PM</td>

                                                <td>$943.45</td>

                                            </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                    <!-- /.table-responsive -->

                                </div>

                                <!-- /.col-lg-4 (nested) -->

                                <div class="col-lg-8">

                                    <div id="morris-bar-chart"></div>

                                </div>

                                <!-- /.col-lg-8 (nested) -->

                            </div>

                            <!-- /.row -->

                        </div>

                    </div>

                    

                </div>

                <div class="col-lg-4">


                    <div class="panel panel-default">

                        <div class="panel-heading">

                            <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example

                        </div>

                        <div class="panel-body">

                            <div id="morris-donut-chart"></div>

                            <a href="#" class="btn btn-default btn-block">View Details</a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection





@section('js')

<!-- Morris Charts JavaScript -->

<script src="{{SYSTEM_SITE_URL}}assets/js/raphael.min.js"></script>

<script src="{{SYSTEM_SITE_URL}}assets/js/morris.min.js"></script>

<script src="{{SYSTEM_SITE_URL}}assets/js/morris-data.js"></script>

@endsection