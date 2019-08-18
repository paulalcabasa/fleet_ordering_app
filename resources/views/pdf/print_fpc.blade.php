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
                font-size:11px;
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
                <td align="right" style="vertical-align: bottom;font-size:11px;">Fleet Ordering System</td>
            </tr>
        </table>
        <hr/>
        <div class="confidential">CONFIDENTIAL</div>
    </header>

    <main>
        <div>
            <h4 style="text-align:center;">FLEET PRICE CONFIRMATION</h4>
        </div>

        <table border="0" style="border-collapse: collapse;width:50%;font-size:11px;" cellpadding="2" >
            <tr>
                <td style="font-weight:bold;">DEALER</td>
                <td>:</td>
                <td>{{ $header_data->dealer_name }}</td>
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
                <td style="font-weight:bold;">SUBJECT</td>
                <td>:</td>
                <td>{{ $header_data->customer_name }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">DATE</td>
                <td>:</td>
                <td>{{ $header_data->date_created }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">REF NO.</td>
                <td>:</td>
                <td>{{ $header_data->fpc_ref_no }}</td>
            </tr>  
        </table>  

        <hr style="border:0;height:3px;background:#000;" />
        <p style="font-size:12px;font-weight:bold;">After FSD evaluation, your request for Fleet Price Support has been approved as follows:</p>
        
        <table class="item-table" cellpadding="3" cellspacing="3">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2">MODEL</th>
                    <th rowspan="2">QTY</th>
                    <th rowspan="2">UNIT PRICE</th>
                    <th rowspan="2">BODY TYPE</th>
                    <th colspan="2">INCLUSIONS</th>
                </tr>
                <tr>
                    <th>STD</th>
                    <th>ADD'L</th>
                </tr>
            </thead>
            <tbody>
                {{ $ctr = 1 }}
                @foreach($items as $item)
                <tr>
                    <td>{{ $ctr }}</td>
                    <td class="item-data-style1">{{ $item->sales_model }}</td>
                    <td class="item-data-style2">{{ $item->quantity }}</td>
                    <td class="item-data-style2">P {{ number_format($item->fleet_price,2,'.',',') }}</td>
                    <td class="item-data-style2">{{ $item->rear_body_type }}</td>
                    <td class="item-data-style2">N\A</td>
                    <td class="item-data-style2">{{ $item->additional_items }}</td>
                </tr>
                {{ $ctr++ }}
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">****** <span style="margin:0 1em 0 1em;font-style:italic;">Nothing Follows</span> ******</td>
                </tr>
            </tfoot>
        </table>

        <div class="terms">
            <table>
                <tr>
                    <td class="text-bold">NOTE</td>
                    <td>:</td>
                    <td>{{ $header_data->note }}</td>
                </tr>
                <tr>
                    <td class="text-bold">AVAILABILITY</td>
                    <td>:</td>
                    <td>{{ $header_data->availability }}</td>
                </tr>
                <tr>
                    <td class="text-bold">VALIDITY</td>
                    <td>:</td>
                    <td>{{ $header_data->validity }}</td>
                </tr>
                <tr>
                    <td class="text-bold">PAYMENT</td>
                    <td>:</td>
                    <td>{{ $header_data->term_name   }}</td>
                </tr>
                <tr>
                    <td class="text-bold">DEALER NET COMMISSION</td>
                    <td>:</td>
                    <td>Please refer to fleet guidelines</td>
                </tr><tr>
                    <td class="text-bold">FLEET CATEGORY</td>
                    <td>:</td>
                    <td>{{ $header_data->fleet_category_name   }}</td>
                </tr>
            </table>
        </div>
        <div class="signatories" style="margin-top:3em;">
            <table>
                <tr>
                    <td>
                        <table style="font-size:11px;">
                            <tr>
                                <td><strong>Prepared by:</strong><br/><br/></td>
                            </tr>
                            <tr>
                                <td>____________________</td>
                            </tr>
                           
                            <tr>
                                <td><strong>{{ $header_data->prepared_by }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ $header_data->position_title }}</td>
                            </tr>
                            <tr>
                                <td><br/><br/><br/></td>
                            </tr>
                            @foreach($signatories['IPC_SUPERVISOR'] as $row)
                        
                            <tr>
                                <td><strong>Checked by: <br/><br/> </td>
                            </tr>
                            <tr>
                                <td>____________________<br/></td>
                            </tr>
                            <tr>
                                <td><strong>{{ $row->name_prefix}}. {{ $row->first_name }} {{ $row->last_name }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ $row->position_title }}</td>
                            </tr>
                        
                            @endforeach
                        </table>
                    </td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="vertical-align: top;">
                        <table style="font-size:11px;">
                            @foreach($signatories['IPC_MANAGER'] as $row)
                        
                            <tr>
                                <td><strong>Noted by: <br/><br/> </td>
                            </tr>
                            <tr>
                                <td>____________________<br/></td>
                            </tr>
                            <tr>
                                <td><strong>{{ $row->name_prefix}}. {{ $row->first_name }} {{ $row->last_name }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ $row->position_title }}</td>
                            </tr>
                          
                            @endforeach
                            <tr>
                                <td><br/><br/><br/></td>
                            </tr>
                            <tr>
                                <td><strong>Approved by: <br/><br/> </td>
                            </tr>
                            <tr>
                                @foreach($signatories['IPC_EXPAT'] as $row)
                                <td>____________________<br/></td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($signatories['IPC_EXPAT'] as $row)
                                <td><strong>{{ $row->name_prefix}}. {{ $row->first_name }} {{ $row->last_name }}</strong></td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($signatories['IPC_EXPAT'] as $row)
                                <td>{{ $row->position_title }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div >
            <table style="font-size:11px;width:100%;margin-top:3em;">
                <tr>
                    <td style="width:25%;"><strong>REASON FOR EXTENSION : </strong></td>
                    <td style="border-bottom:1px solid #000;width:75%;"></td>
                </tr>
                <tr>
                    <td style="width:25%;"><br/></td>
                    <td style="border-bottom:1px solid #000;width:75%;"></td>
                </tr>
            </table>
        </div>
    </main>
    
</body>
</html>