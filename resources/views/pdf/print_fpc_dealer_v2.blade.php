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
            footer {
                position: fixed; 
                bottom: 0px; 
                left: 0px; 
                right: 2px;
                height: 50px; 

                /** Extra personal styles **/
                color: #000;
                text-align: right;
                line-height: 35px;
                font-size:10px;
                margin-right:4.5em;
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
            Print date : <?php echo date("M, d Y H:m A");?> 
        </footer>

    <main>
        <div>
            <h4 style="text-align:center;">FLEET PRICE CONFIRMATION</h4>
        </div>

        <table border="0" style="border-collapse: collapse;width:100%;font-size:11px;" cellpadding="2" >
            <tr>
                <td style="font-weight:bold;width:20%;">DEALER</td>
                <td style="width:5%;">:</td>
                <td style="width:75%;">{{ $header_data->dealer_name }} {{ $header_data->dealer_account}}</td>
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
        <p style="font-size:12px;font-weight:bold;">After Dealer Sales evaluation, your request for Fleet Price Support has been approved as follows:</p>
        
        <table class="item-table" cellpadding="3" cellspacing="3">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2">MODEL</th>
                    <th rowspan="2">COLOR</th>
                    <th rowspan="2">QTY</th>
                    <th rowspan="2">UNIT PRICE</th>
                    <th rowspan="2">BODY TYPE</th>
                    <th>INCLUSIONS</th>
                </tr>
                <tr>
                  <!--   <th>STD</th> -->
                    <th>ADD'L</th>
                </tr>
            </thead>
            <tbody>
                {{ $ctr = 1 }}
                @foreach($items as $item)
                <?php 
                    $fleet_price = $item['header']->suggested_retail_price - ($item['header']->discount + $item['header']->promo);
                ?>
                <tr>
                    <td>{{ $ctr }}</td>
                    <td class="item-data-style1">{{ $item['header']->sales_model }}</td>
                    <td class="item-data-style1">{{ $item['header']->color }}</td>
                    <td class="item-data-style2">{{ $item['header']->quantity }}</td>
                    <td class="item-data-style2">P {{ number_format($fleet_price,2) }}</td>
                    <td class="item-data-style2">{{ $item['header']->rear_body_type }}</td>
                    <!-- <td class="item-data-style2">
                        <?php 
                            $index = 1;
                            $total_items = count($item['other_items'])
                        ?>
                        @foreach($item['other_items'] as $freebie)
                        <span>{{ $freebie->description }}</span>
                            @if($index != $total_items)
                            ,
                            @endif
                            <?php $index++; ?>
                        @endforeach
                    </td> -->
                    <td class="item-data-style2">{{ $item['header']->lto_registration != 0 ? "Complete 3 Years LTO Registration" : "" }}</td>
                </tr>
                {{ $ctr++ }}
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">****** <span style="margin:0 1em 0 1em;font-style:italic;">Nothing Follows</span> ******</td>
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
                    <td valign="top">
                        <table style="font-size:11px;">
                            <tr>
                                <td><strong>Prepared by:</strong><br/><br/></td>
                            </tr>
                            <tr>
                                <td>____________________</td>
                            </tr>
                           
                            <tr>
                                <td><strong>{{ ucwords(strtolower($header_data->prepared_by)) }}</strong></td>
                            </tr>
                            <tr>
                                <td>Dealer Sales</td>
                            </tr>
                            <tr>
                                <td><br/><br/><br/></td>
                            </tr>
                          
                            <tr>
                                <td><strong>Checked by: <br/><br/> </td>
                            </tr>
                            <tr>
                                @foreach($signatories['CHECKED_BY'] as $row)
                                <td>____________________<br/></td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($signatories['CHECKED_BY'] as $row)
                                <td><strong>{{ ucwords(strtolower($row->name_prefix . ' ' . $row->first_name . ' ' . $row->last_name)) }}</strong></td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($signatories['CHECKED_BY'] as $row)
                                <td>{{ $row->position_title }}</td>
                                @endforeach
                            </tr>
                                
                        </table>
                    </td>
                    <td style="width:100px;">&nbsp;</td>
                    <td style="vertical-align: top;">
                        <table style="font-size:11px;">
                            <tr>
                                <td><strong>Noted by: <br/><br/> </td>
                            </tr>
                            @foreach($signatories['NOTED_BY'] as $row)
                        
                            
                            <tr>
                                <td>____________________<br/></td>
                            </tr>
                            <tr>
                                <td><strong>{{ $row->name_prefix}}. {{ $row->first_name }} {{ $row->last_name }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ $row->position_title }}</td>
                            </tr>
                            <tr>
                                <td style="font-size:14px;">&nbsp;</td>
                            </tr>
                          
                            @endforeach
                            <tr>
                                <td><br/><br/><br/></td>
                            </tr>
                            <tr>
                                <td><strong>Approved by: <br/><br/> </td>
                            </tr>
                            <tr>
                                @foreach($signatories['EXPAT'] as $row)
                                <td>____________________<br/></td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($signatories['EXPAT'] as $row)
                                <td><strong>{{ $row->name_prefix}}. {{ $row->first_name }} {{ $row->last_name }}</strong></td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($signatories['EXPAT'] as $row)
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