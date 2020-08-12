@extends('_layouts.metronic')

@section('page-title', 'Dashboard')
  
@section('content')

<div id="app">
<div class="row">

    <div class="col-xl-6">
    <!--STATISTICS-->
        <div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
            <div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                            Statistics
                    </h3>
                </div>
                
            </div>
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-widget17">
                    <div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #66b4e7">
                       <div class="kt-widget17__chart" style="height:120px;">
                            <!-- <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="kt_chart_activities" style="display: block; width: 1034px; height: 216px;" width="1034" height="216" class="chartjs-render-monitor"></canvas> -->
                        </div>
                    </div>
                    <div class="kt-widget17__stats">
                        <div class="kt-widget17__items">
                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" id="Combined-Shape" fill="#000000"></path>
                                        <rect id="Rectangle-Copy-2" fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
                                    </g>
                                    </svg>                      
                                </span> 
                                <span class="kt-widget17__subtitle">
                                    Projects
                                </span> 
                                <span class="kt-widget17__desc">
                                    {{$project_ctr}} fleet projects
                                </span>  
                            </div>

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--success">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon id="Bound" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" id="Shape" fill="#000000" fill-rule="nonzero"></path>
                                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" id="Path" fill="#000000" opacity="0.3"></path>
                                    </g>
                                    </svg>
                                </span>  
                                <span class="kt-widget17__subtitle">
                                    Pending transactions
                                </span> 
                                <span class="kt-widget17__desc">
                                    {{ $open_project_ctr }} open projects
                                </span>  
                            </div>                  
                        </div>
                        <div class="kt-widget17__items">
                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--warning">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                            <path d="M12.7037037,14 L15.6666667,10 L13.4444444,10 L13.4444444,6 L9,12 L11.2222222,12 L11.2222222,14 L6,14 C5.44771525,14 5,13.5522847 5,13 L5,3 C5,2.44771525 5.44771525,2 6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,13 C19,13.5522847 18.5522847,14 18,14 L12.7037037,14 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                            <path d="M9.80428954,10.9142091 L9,12 L11.2222222,12 L11.2222222,16 L15.6666667,10 L15.4615385,10 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 L9.80428954,10.9142091 Z" id="Combined-Shape" fill="#000000"></path>
                                        </g>
                                    </svg>                      
                                </span>  
                                <span class="kt-widget17__subtitle">
                                    Price Confirmation
                                </span> 
                                <span class="kt-widget17__desc">
                                    {{ $pending_fpc_projects }} pending for price confirmations
                                </span>  
                            </div>  

                            <div class="kt-widget17__item">
                                <span class="kt-widget17__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--danger">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" id="Combined-Shape" fill="#000000" opacity="0.3"></path>
                                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" id="Rectangle-102-Copy" fill="#000000"></path>
                                        </g>
                                    </svg>                      
                                </span>  
                                <span class="kt-widget17__subtitle">
                                    Purchase Orders
                                </span> 
                                <span class="kt-widget17__desc">
                                    {{ $purchase_orders }} submitted purchase orders
                                </span>  
                            </div>              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-6">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon kt-hidden">
                        <i class="la la-gear"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{ $year }} Fleet Registrations
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div id="kt_amcharts_1" style="height: 300px;"></div>
            </div>
        </div>
    </div>    

</div>

<div class="row">
    <div class="col-xl-6">
        <div class="row">
            <div class="col-md-6">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header kt-margin-b-30">
                            <h3 class="kt-widget14__title">
                                {{ $month_name }} {{ $year }}              
                            </h3>
                            <span class="kt-widget14__desc">
                                Daily registrations for this month
                            </span>
                        </div>
                        <div class="kt-widget14__chart" style="height:120px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="kt_chart_daily_sales" style="display: block; width: 984px; height: 120px;" width="984" height="120" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-6">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header">
                            <h3 class="kt-widget14__title">
                                Transactions
                            </h3>
                            <span class="kt-widget14__desc">
                                Summary of transactions
                            </span>
                        </div>
                        <div class="kt-widget14__content">
                            <div class="kt-widget14__chart">
                                <div id="kt_chart_revenue_change" style="height: 150px; width: 150px;"></div>
                            </div>
                            <div class="kt-widget14__legends">
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-brand"></span>
                                    <span class="kt-widget14__stats">Registration</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-warning"></span>
                                    <span class="kt-widget14__stats">Fleet Price Confirmation</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-danger"></span>
                                    <span class="kt-widget14__stats">Purchase Order</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-success"></span>
                                    <span class="kt-widget14__stats">Fleet Wholesale Price Confirmation</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    
    <div class="col-xl-6">  
        <!--begin:: Widgets/Notifications-->
        @if(!empty($recent_activities)):
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Recent activities
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_widget6_tab1_content" aria-expanded="true">
                        <div class="kt-notification">
                            @foreach($recent_activities as $activity)
                            <a href="#" class="kt-notification__item">
                                <div class="kt-notification__item-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                            <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" id="Combined-Shape" fill="#000000"></path>
                                            <rect id="Rectangle-Copy-2" fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) " x="16.3255682" y="2.94551858" width="3" height="18" rx="1"></rect>
                                        </g>
                                    </svg>                        
                                </div>
                                <div class="kt-notification__item-details">
                                    <div class="kt-notification__item-title">
                                        <?php echo $activity->content; ?>
                                    </div>
                                    <div class="kt-notification__item-time">
                                        <?php echo $activity->creation_date?>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    
                
                </div>
            </div>
        </div>
        @endif
        <!--end:: Widgets/Notifications-->    
    </div>
</div>

</div>
@stop

@push('scripts')
<script>

"use strict";

// Class definition
var KTDashboard = function() {

    var project_ctr_year = {!! json_encode($project_ctr_year) !!};
    var last_day = {!! json_encode($last_day) !!};
    var monthly_projects = {!! json_encode($monthly_projects) !!};

    // Daily Sales chart.
    // Based on Chartjs plugin - http://www.chartjs.org/
    var dailySales = function() {
        var chartContainer = KTUtil.getByID('kt_chart_daily_sales');

        if (!chartContainer) {
            return;
        }
        var day_labels = [];
        for(var i = 1; i <= last_day; i++){
            day_labels[i] = i + 1;
        }
        
        var data_values = monthly_projects;
      //  console.log(monthly_projects);
        var chartData = {
            labels: day_labels,
            datasets: [{
                //label: 'Dataset 1',
                backgroundColor: KTApp.getStateColor('success'),
                data: data_values
            }, {
                //label: 'Dataset 2',
                backgroundColor: '#f3f3fb',
                data: data_values
            }]
        };

        var chart = new Chart(chartContainer, {
            type: 'bar',
            data: chartData,
            options: {
                title: {
                    display: false,
                },
                tooltips: {
                    intersect: false,
                    mode: 'nearest',
                    xPadding: 10,
                    yPadding: 10,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false,
                barRadius: 4,
                scales: {
                    xAxes: [{
                        display: false,
                        gridLines: false,
                        stacked: true
                    }],
                    yAxes: [{
                        display: false,
                        stacked: true,
                        gridLines: false
                    }]
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                }
            }
        });
    }

    var revenueChange = function() {
        if ($('#kt_chart_revenue_change').length == 0) {
            return;
        }

        Morris.Donut({
            element: 'kt_chart_revenue_change',
            data: [ 
                {
                    label: "PO",
                    value: 25
                },
                {
                    label: "FPC",
                    value: 30
                },
                {
                    label: "Regs",
                    value: 40
                },
                {
                    label: "FWPC",
                    value: 15
                },
                
            ],
            colors: [
                KTApp.getStateColor('danger'),
                KTApp.getStateColor('warning'),
                KTApp.getStateColor('brand'),
                KTApp.getStateColor('success'),
            ],
        });
    }


    return {
        // Init demos
        init: function() {
            // init charts
            dailySales();
            revenueChange();
     
        }
    };
}();

// Class initialization on page load
jQuery(document).ready(function() {
    KTDashboard.init();
});
    var vm =  new Vue({
        el : "#app",
        data: {
            annual_fleet_reg : {!! json_encode($annual_fleet_reg) !!}
        },
        created: function () {
            var self = this;
            // `this` points to the vm instance
            AmCharts.makeChart("kt_amcharts_1", {
                "rtl": KTUtil.isRTL(),
                "type": "serial",
                "theme": "light",
                "dataProvider": [
                    {
                        "month": "JAN",
                    //    "registrations": self.annual_fleet_reg.jan,
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "FEB",
                    //    "registrations": self.annual_fleet_reg.feb
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "MAR",
                    //    "registrations": self.annual_fleet_reg.mar
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "APR",
                      //  "registrations": self.annual_fleet_reg.apr
                       "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "MAY",
                    //    "registrations": self.annual_fleet_reg.may
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "JUN",
                   //     "registrations": self.annual_fleet_reg.jun
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "JUL",
                    //    "registrations": self.annual_fleet_reg.jul
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "AUG",
                    //    "registrations": self.annual_fleet_reg.aug
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "SEP",
                    //    "registrations": self.annual_fleet_reg.sep
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "OCT",
                    //    "registrations": self.annual_fleet_reg.oct
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "NOV",
                    //    "registrations": self.annual_fleet_reg.nov
                        "registrations": Math.floor(Math.random() * 200)
                    }, {
                        "month": "DEC",
                    //   "registrations": self.annual_fleet_reg.dec
                        "registrations": Math.floor(Math.random() * 200)
                    }
                ],
                "valueAxes": [{
                    "gridColor": "#FFFFFF",
                    "gridAlpha": 0.2,
                    "dashLength": 0
                }],
                "gridAboveGraphs": true,
                "startDuration": 1,
                "graphs": [{
                    "balloonText": "[[category]]: <b>[[value]]</b>",
                    "fillAlphas": 0.8,
                    "lineAlpha": 0.2,
                    "type": "column",
                    "valueField": "registrations"
                }],
                "chartCursor": {
                    "categoryBalloonEnabled": false,
                    "cursorAlpha": 0,
                    "zoomable": false
                },
                "categoryField": "month",
                "categoryAxis": {
                    "gridPosition": "start",
                    "gridAlpha": 0,
                    "tickPosition": "start",
                    "tickLength": 20
                },
                "export": {
                    "enabled": false
                }

            });
        },
        mounted : function () {
       
        }
    });
</script>
@endpush