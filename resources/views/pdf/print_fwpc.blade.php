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

            .prices {
                border-top:1px dashed black;
                border-bottom:1px dashed black;
                text-align: center;
                font-size:12px;
                font-weight: bold;
                margin-top:1em;
                margin-bottom:1em;
            }

            footer {
                position: fixed; 
                bottom: 0; 
                left: 0px; 
                right: 0px;
                height: 250px; 
                margin-left: 1cm;
                margin-right: 1cm;
                /** Extra personal styles **/
          
       
            }

        </style>
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

    <footer>
        <div style="text-align:center;font-size:10px;font-weight:bold;">*** Note: Fleet Wholesale Price is already net of Fleet Discount. Not valid for subsidy claim. ***</div>
        <div class="prices">
            <span>TERMS AND CONDITIONS</span>
        </div>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td width="350" valign="top">
                    <table style="font-size:10px;">
                      <!--   <tr>
                            <td style="font-weight:bold;">Payment Term</td>
                            <td>:</td>
                            <td>{{ $fwpc_details->payment_terms }}</td>
                        </tr> -->
                        <tr>
                            <td style="font-weight:bold;">Witholding Tax</td>
                            <td>:</td>
                            <td align="right">{{ number_format($wht_tax,2,'.',',') }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;">Total Check Payable to IPC</td>
                            <td>:</td>
                            <td align="right">{{ number_format($check_amount,2,'.',',') }}</td>
                        </tr>
                    </table>
                </td>
                <td style="border:1px solid #000;" width="100" align="right">
                    <table style="font-size:9px;margin:0;">
                        <tr>
                            <td><strong>NOTE:</strong> All conditions stipulated on the FWPC should be strictly followed.</td>
                        </tr>
                        <tr>
                            <td align="center"><strong>CONFORME BY:</strong></td>
                        </tr>
                        <tr>
                            <td align="center"><br/><strong>____________________________</strong></td>
                        </tr>
                        <tr><td align="center"><strong>(PLS. PRINT NAME & SIGN)</strong></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="font-size:10px;">
            <tr>
                <td>Checked by:</td>
                <td>Approved by: </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"><br/></td>
            </tr>
            <tr>
                <td>___________________________</td>
                <td>___________________________</td>
                <td></td>
                <td>___________________________</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">Dealer Sales</td>
                <td style="font-weight:bold;">HIROTO NAKAGURO</td>
                <td> / </td>
                <td style="font-weight:bold;">YASUHIKO OYAMA</td>
            </tr>
            <tr>
                <td></td>
                <td style="font-weight:bold;">ADvH Sales Division</td>
                <td>/</td>
                <td style="font-weight:bold;">VP - Sales Division</td>
            </tr>
        </table>
    </footer>

    <main>
        <div>
            <h5 style="text-align:center;">FLEET WHOLESALE PRICE CONFIRMATION (FWPC)</h5>
        </div>

        <table border="0" style="border-collapse: collapse;width:100%;font-size:11px;" cellpadding="2" >
            <tr>
                <td style="font-weight:bold;">DATE</td>
                <td>:</td>
                <td>{{ $fwpc_details->creation_date }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">DEALER</td>
                <td>:</td>
                <td>{{ $fwpc_details->party_name }} - {{ $fwpc_details->account_name }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;vertical-align: top;">ATTENTION</td>
                <td style="vertical-align: top;">:</td>
                <td>
                    @foreach($sales_persons as $row)
                        {{ $row->name }} <br/>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">FLEET ACCOUNT NAME</td>
                <td>:</td>
                <td>{{ $fwpc_details->customer_name }}</td>
            </tr>  
            <tr>
                <td style="font-weight:bold;">FWPC Ref No.</td>
                <td>:</td>
                <td>{{ $fwpc_details->fwpc_ref_no }}</td>
            </tr>
        </table>  

        <div class="prices">
            <span>PRICES</span>
        </div>

        <table border="1" class="item-table" cellpadding="2" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan="2">Item</th>
                    <th rowspan="2" style="width:15%;">Model</th>
                    <th rowspan="2">Color</th>
                    <th rowspan="2">Qty</th>
                    <th rowspan="2">Approved Fleet Price per unit</th>
                    <th colspan="2">Price Breakdown</th>
                    <th rowspan="2">Fleet Wholesale per unit</th>
                    <th rowspan="2">Total Wholesale Price per model</th>
                    <th rowspan="2">Payment Term</th>
                </tr>
                <tr>
                    <th>Unit</th>
                    <th>Body, Aircon, Audio & Other Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($so_lines as $row)
                <?php 
                    $ctr            = 1;
                    $grand_total    = 0;
                    $dealers_margin = $row->fleet_price * ($row->dealers_margin/100);
                    $total_margin   = $dealers_margin + $row->lto_registration;
                    $unit_price     = $row->fleet_price + $total_margin;
                    $fwpu           = $unit_price + $row->freebies;
                    $total_fwpu     = $fwpu * $row->quantity;
                ?>
                <tr>
                    <td>{{ $ctr }}</td>
                    <td>{{ $row->sales_model }}</td>
                    <td>{{ $row->color }}</td>
                    <td align="center">{{ $row->quantity }}</td>
                    <td align="center">{{ number_format($unit_price,2) }}</td>
                    <td align="center">{{ number_format($row->fleet_price,2) }}</td>
                    <td align="center">{{ number_format($row->freebies,2) }}</td>
                    <td align="center">{{ number_format($fwpu,2) }}</td>
                    <td align="center">{{ number_format($total_fwpu,2) }}</td>
                    <td>{{ $row->term_name }}</td>
                </tr>
                <?php 
                    $grand_total += $total_fwpu;
                    $ctr++; 
                ?>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="8">Total Fleet Wholesale Price (w/ VAT)</th>
                    <th>{{ number_format($grand_total,2,'.',',') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <div class="prices" style="margin-top:2em;">
            <span>DEALER MARGIN & OTHER COST</span>
        </div>

        <table border="1" class="item-table" cellpadding="2" cellspacing="0">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Model</th>
                    <th>Color</th>
                    <th>Dealer Margin</th>
                    <th>LTO Reg. & Free Items</th>
                    <th>Total Dealer Margin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($so_lines as $row)
                <?php 
                    $ctr = 1;
                    $dealers_margin = $row->fleet_price * ($row->dealers_margin/100);
                    $total_margin   = $dealers_margin + $row->lto_registration;
                ?>
                <tr>
                    <td align="center">{{ $ctr }}</td>
                    <td align="center">{{ $row->sales_model }}</td>
                    <td align="center">{{ $row->color }}</td>
                    <td align="center">{{ number_format($dealers_margin,2) }}</td>
                    <td align="center">{{ number_format($row->lto_registration,2) }}</td>
                    <td align="center">{{ number_format($total_margin,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    
</body>
</html>