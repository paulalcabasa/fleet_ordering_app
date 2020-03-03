<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <head>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;

            }

            /** Define now the real margins of every page in the PDF **/
            body {
                font-family:'Calibri','Sans-serif','Arial';
                margin-top: 2cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 0cm;
            }

            header {
                position: fixed;
                top: 0px;
                left: 0px;
                right: 0px;
                height: 50px;
                padding:2.5em 1em 1em 1em;

                font-size:12px;
                margin-left: 1cm;
                margin-right: 1cm;

            }

            main {
                margin-left: 0.3cm;
                margin-right: 0.3cm;
            }

            .confidential {
                width:11%;
                background-color:#000;
                color:#fff;
                margin:0;
                font-size:11px;
                padding:.5em 1em;
                font-weight:bold;
            }

            .item-table {
                font-size:10px;
                width:100%;
            }

            .item-table thead tr th {
                text-align: center;
            }

            .item-table tfoot {
                text-align: center;
            }

            .item-data-style1 {
                border-bottom:1px solid #000;
            }

            .item-data-style2 {
                border-bottom:1px solid #000;
                text-align: center;
            }

            .terms {
                font-size:11px;
                margin-top:1em;
            }

            .text-bold {
                font-weight: bold;
            }

            .text-center {
                text-align:center;
            }

            .header-text {
                width:100%;
                background-color:#ccc;
                font-weight:bold;
                text-align:center;
                font-size:12px;
                padding: .3em 0 .3em 0;
                margin-bottom:0;
                margin-top:0;
            }

            .show {
                display:block;
            }

            .hide {
                display:none;
            }
            
        </style>
        <link rel="stylesheet" type="text/css" href="">
    </head>
<body>

    <!-- Define header and footer blocks before your content -->
    <header>
        <table width="100%" style="margin-bottom:-0.5em;">
            <tr>
                <td align="left">
                    <img src="{{ asset('public/img/isuzu_logo.jpg') }}" /><br/>
                    <span style="font-size:11px;">Isuzu Philippines Corporation</span>
                </td>
                <td align="right" style="vertical-align: bottom;font-size:11px;">{{ config('app.name')}}</td>
            </tr>
        </table>
        <hr/>
        <div class="confidential">CONFIDENTIAL</div>
    </header>

    <main>
        <div>
            <h4 style="text-align:center;">FLEET PROJECT</h4>
        </div>
        <p class="header-text">PROJECT DETAILS</p>
        <table border="0" style="border-collapse: collapse;width:100%;font-size:11px;" cellpadding="2" >
            <tr>
                <td style="font-weight:bold;">Project ID</td>
                <td>:</td>
                <td>{{ $project_details->project_id }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Dealer</td>
                <td>:</td>
                <td>{{ $project_details->dealer_name }} - {{ $project_details->dealer_account }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;vertical-align: top;">Fleet Account</td>
                <td style="vertical-align: top;">:</td>
                <td>{{ $project_details->fleet_account_name }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;vertical-align: top;">Fleet Category</td>
                <td style="vertical-align: top;">:</td>
                <td>{{ $project_details->fleet_category_name }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;vertical-align: top;">Project Source</td>
                <td style="vertical-align: top;">:</td>
                <td>{{ $project_details->project_source }}</td>
            </tr>
            
            <tr>
                <td style="font-weight:bold;">Date Created </td>
                <td>:</td>
                <td>{{ $project_details->date_created }}</td>
            </tr>

            <tr>
                <td style="font-weight:bold;">Submitted By</td>
                <td>:</td>
                <td>{{ $project_details->created_by }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Status Name</td>
                <td>:</td>
                <td>{{ $project_details->status_name }}</td>
            </tr>
              
        </table>  
  
        <p class="header-text">CONTACT DETAILS</p>
        <table style="width:100%;">
            <tr>
                <td>
                    <table border="0" style="border-collapse: collapse;width:100%;font-size:11px;" cellpadding="2" >
                        <tr>
                            <td style="font-weight:bold;">Contact No.</td>
                            <td>:</td>
                            <td>
                               
                                @foreach($contacts as $c)
                                    {{ $c->contact_number }} <br />
                                @endforeach
                           
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;">Facebook</td>
                            <td>:</td>
                            <td>{{ $project_details->facebook_url }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table border="0" style="border-collapse: collapse;width:100%;font-size:11px;" cellpadding="2" >
                        <tr>
                            <td style="font-weight:bold;">Email</td>
                            <td>:</td>
                            <td>{{ $project_details->email }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;">Website</td>
                            <td>:</td>
                            <td>{{ $project_details->website_url }}</td>
                        </tr>
                    </table>  
                </td>
            </tr>
        </table>
        <p class="header-text">CONTACT PERSONS</p>
        <table style="width:100%;font-size:11px;margin-top:1em;margin-bottom:1em;" border="1" cellpadding="3" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Contact No.</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            @foreach($contact_persons as $cp)
                <tr>
                    <td>{{ $cp->name }}</td>
                    <td>{{ $cp->position_title }}</td>
                    <td>{{ $cp->department }}</td>
                    <td>{{ $cp->contact_number }}</td>
                    <td>{{ $cp->email_address }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p class="header-text">DEALER SALES EXECUTIVES</p>
        <table style="width:100%;font-size:11px;margin-top:1em;margin-bottom:1em;" border="1" cellpadding="3" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Mobile No.</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            @foreach($sales_persons as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->position }}</td>
                    <td>{{ $row->mobile_no }}</td>
                    <td>{{ $row->email_address }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p class="header-text">REQUIREMENT</p>
        <table style="font-size:11px;width:100%;margin-top:1em;margin-bottom:1em;" border="1" cellpadding="3" cellspacing="0">
            <thead style="text-align:center;">
                <tr class="kt-font-bold bg-light-gray-1">
                    <th>Model</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Suggested Price</th>
                </tr>
            </thead>
            <?php 
                $grand_total_qty = 0;
                $grand_total_price = 0;
            ?>
            @foreach($requirement as $vehicle_type => $vehicles)
            <tbody>
                <?php 
                    $subtotal_qty = 0; 
                    $subtotal_price = 0;
                ?>
                @foreach($vehicles as $model)
                <tr>
                    <td>{{ $model->sales_model }}</td>
                    <td>{{ $model->color }}</td>
                    <td align="right">{{ $model->quantity }}</td>
                    <td align="right">{{ number_format($model->suggested_price,2) }}</td>
                </tr>

                <?php 
                    $subtotal_qty += $model->quantity;
                    $subtotal_price += $model->suggested_price;

                    $grand_total_qty += $subtotal_qty;
                    $grand_total_price += $subtotal_price;

                ?>
                @endforeach
                <tr style="font-weight:bold;">
                    <td colspan="2">{{ $vehicle_type }}</td>
                    <td align="right">{{ $subtotal_qty }}</td>
                    <td align="right">{{ number_format($subtotal_price,2) }}</td>
                </tr>
            </tbody>
                
            @endforeach
            <tfoot>
                <tr class="bg-light-gray-2">
                    <th colspan="2">Grand Total</th>
                    <th align="right">{{ $grand_total_qty }}</th>
                    <th align="right">{{ number_format($grand_total_price,2) }}</th>
                </tr>
            </tfoot>
        </table>
        
        <p class="header-text">COMPETITORS</p>
        
        @if($project_details->competitor_flag == 'N')
        <p style="font-size:11px;"><strong>With Competitor ?</strong> {{ $project_details->competitor_flag }}</p>
        <p style="font-size:11px;"><strong>Reason</strong> : {{ $project_details->competitor_remarks }}</p>
        @elseif($project_details->competitor_flag == 'Y')
        <table style="font-size:11px;width:100%;margin-top:1em;margin-bottom:1em;" border="1" cellpadding="3" cellspacing="0">
            <thead style="text-align:center;">
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
            @foreach($competitors as $c)
                <tr>
                    <td>{{ $c->brand }}</td>
                    <td>{{ $c->model }}</td>
                    <td>{{ $c->price }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </main>
    
</body>
</html>