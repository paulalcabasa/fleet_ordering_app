<!DOCTYPE html>
<html>
<head>
    <title>FPC</title>
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
                font-size:9.5px;
                width:100%;
                border-collapse: collapse;
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
                <td align="right" style="vertical-align: bottom;font-size:11px;">Fleet Registration System</td>
            </tr>
        </table>
        <hr/>
        <div class="confidential">CONFIDENTIAL</div>
    </header>

    <main>
        <div>
            <h4 style="text-align:center;">FLEET PRICE CONFIRMATION</h4>
        </div>
        <p class="header-text">PROJECT DETAILS</p>
        <table border="0" style="border-collapse: collapse;width:50%;font-size:11px;" cellpadding="2" >
            
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
                <td style="font-weight:bold;">Date </td>
                <td>:</td>
                <td>{{ $project_details->date_created }}</td>
            </tr>
              
        </table>  
        
        
        @foreach($fpc_data as $fpc)
        <p class="header-text">{{ $fpc['fpc_header']->vehicle_type }}</p>
        <table style="font-size:11px;width:100%;">
           
            <tr>
                <td style="width:50%;vertical-align: top;">
                    <table style="width:100%;">
                        <tr>
                            <td class="text-bold">Ref No.</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->fpc_project_id }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Date Created</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->date_created }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Prepared by</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->prepared_by }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Status</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->status_name }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%;">
                    <table style="width:100%">
                        <tr>
                            <td class="text-bold">Note</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->note }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Availability</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->availability }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Validity</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->validity }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Payment</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->term_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Fleet Category</td>
                            <td>:</td>
                            <td>{{ $fpc['fpc_header']->fleet_category_name }}</td>
                        </tr>
                    </table>  
                </td>
            </tr>
        </table>
        <table class="item-table" cellpadding="2" cellspacing="0" border="1" >
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2">MODEL</th>
                    <th rowspan="2">COLOR</th>
                    <th rowspan="2">QTY</th>
                    <th rowspan="2">UNIT PRICE</th>
                    <th rowspan="2">FREEBIES</th>
                    <th rowspan="2">BODY TYPE</th>
                    <th>INCLUSIONS</th>
                </tr>
                <tr>
                    <!-- <th>STD</th> -->
                    <th>ADD'L</th>
                </tr>
            </thead>
            <tbody>
            {{ $ctr = 1 }}
            {{ $qty_total = 0 }}
            {{ $price_total = 0}}
            @foreach($fpc['fpc_lines'] as $item)
            {{ $fleet_price  = $item->suggested_retail_price - $item->discount - $item->promo }}
                <tr>
                    <td>{{ $ctr }}</td>
                    <td>{{ $item->sales_model }}</td>
                    <td>{{ $item->color }}</td>
                    <td align="right">{{ $item->quantity }}</td>
                    <td align="right">{{ number_format($fleet_price,2,',','.')  }}</td>
                    <td align="right">{{ number_format($item->freebies,2,',','.')  }}</td>
                    <td>{{ $item->rear_body_type }}</td>
                    <!-- <td>N/A</td> -->
                    <td>{{ $item->additional_items }}</td>
                </tr>
                {{ $qty_total += $item->quantity }}
                {{ $price_total += $item->quantity * ($fleet_price - $item->freebies) }}
                {{ $ctr++ }}
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">{{ $qty_total }}</td>
                    <td colspan="2" align="right">{{ number_format($price_total,2,',','.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
        <p style="font-size:10px;margin:.5em 0 .5em 0;text-align:center;">****** <span style="margin:0 1em 0 1em;font-style:italic;">Nothing Follows</span> ******</p>
        
        @endforeach
        
    </main>
    
</body>
</html>