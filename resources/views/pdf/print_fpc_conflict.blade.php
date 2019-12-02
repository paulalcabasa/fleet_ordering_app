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

        <table border="0" style="border-collapse: collapse;width:100%;font-size:11px;" cellpadding="2" >
            <tr>
                <td style="font-weight:bold;width:20%;">DEALER</td>
                <td style="width:5%;">:</td>
                <td style="width:75%;">
                    @foreach($projects as $project)
                        {{ $project->dealer_name }} - {{ $project->dealer_account }}<br/>
                    @endforeach 
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;vertical-align: top;">ATTENTION</td>
                <td style="vertical-align: top;">:</td>
                <td>
                    @foreach($attention as $att)
                        @foreach($att as $person)
                        {{ $person->name }}<Br/>
                        @endforeach
                    @endforeach 
                </td>
            </tr>
            <tr>
                <td style="font-weight:bold;">SUBJECT</td>
                <td>:</td>
                <td>{{ $fpc_details->customer_name }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">DATE</td>
                <td>:</td>
                <td>{{ $fpc_details->date_created }}</td>
            </tr>
            <tr>
                <td style="font-weight:bold;">REF NO.</td>
                <td>:</td>
                <td>{{ $fpc_details->fpc_id }}</td>
            </tr>  
        </table>  

        <hr style="border:0;height:3px;background:#000;" />
        <p style="font-size:12px;font-weight:bold;">After FSD evaluation, your request for Fleet Price Support has been approved as follows:</p>
     
        <table class="item-table" cellpadding="3" cellspacing="3">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <th rowspan="2">MODEL</th>
                    <th rowspan="2">COLOR</th>
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
                <?php
                    $ctr = 1;
                ?>
                @foreach($requirements as $model)
                <tr>
                    <td>{{ $ctr }}</td>
                    <td class="item-data-style1">{{ $model->sales_model }}</td>
                    <td class="item-data-style1">{{ $model->color }}</td>
                    <td class="item-data-style2">{{ number_format($model->fleet_price,2) }}</td>
                    <td class="item-data-style2">{{ $model->rear_body_type }}</td>
                    <td class="item-data-style2">-</td>
                    <td class="item-data-style2">
                        {{ $model->lto_registration != 0 ? "Complete 3 Years LTO Registration" : "" }}
                    </td>
                </tr>
                <?php
                    $ctr++;
                ?>
                @endforeach
              
           
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">****** <span style="margin:0 1em 0 1em;font-style:italic;">Nothing Follows</span> ******</td>
                </tr>
            </tfoot>
        </table>
        @foreach($terms as $term)
        <div class="terms">
            <table>
                <tr>
                    <td class="text-bold">NOTE</td>
                    <td>:</td>
                    <td>{{ $term[0] }}</td>
                </tr>
                <tr>
                    <td class="text-bold">AVAILABILITY</td>
                    <td>:</td>
                    <td>{{ $term[1] }}</td>
                </tr>
                <tr>
                    <td class="text-bold">VALIDITY</td>
                    <td>:</td>
                    <td>{{ $term[2] }}</td>
                </tr>
                <tr>
                    <td class="text-bold">PAYMENT</td>
                    <td>:</td>
                    <td>{{ $term[3] }}</td>
                </tr>
                <tr>
                    <td class="text-bold">DEALER NET COMMISSION</td>
                    <td>:</td>
                    <td>Please refer to fleet guidelines</td>
                </tr>
               <!--  <tr>
                    <td class="text-bold">FLEET CATEGORY</td>
                    <td>:</td>
                    <td></td>
                </tr> -->
            </table>
        </div>
        @endforeach
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
                                <td><strong>{{ ucwords(strtolower($user_details->name_prefix . ' ' .$user_details->first_name . " " .    $user_details->last_name)) }}</strong></td>
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
                            @foreach($signatories['NOTED_BY'] as $row)
                        
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


        <!-- END OF PAGE 1 -->

        <!-- START OF PAGE 2 -->
        <div style="page-break-before: always"></div>
        <div>
            <h4 style="text-align:center;">FLEET PRICE COMPUTATION DETAILS</h4>
        </div>

        
        @foreach($detailed_price as $item)
        <?php
            $dealer_margin = ($item['header']->fleet_price - $item['header']->freebies) * ($item['header']->dealers_margin/100);
            $wsp           = $item['header']->suggested_retail_price - ($item['header']->suggested_retail_price * ($item['header']->dealers_margin/100));
            $cost          = $item['header']->suggested_retail_price + $dealer_margin + $item['header']->freebies;
            $net_cost      = $item['header']->wholesale_price + $dealer_margin + $item['header']->lto_registration;
            $subsidy       = $net_cost - $item['header']->fleet_price;
            $total_subsidy = $subsidy * $item['header']->quantity;
        ?>
        
        <table style="font-size:11px;" width="100%">
            <tr>
                <td valign="top" width="50%" style="margin:0;">
                    <table style="width:100%;" cellspacing="0" cellpadding="0">
                        <tr>
                            <td valign="top">
                                <table style="width:100%;">
                                    <tbody>
                                    <tr style="background-color:#ccc;">
                                        <td colspan="2" class="text-bold text-center">Details</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Dealer</td>
                                        <td>{{ $item['header']->dealer_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Model</td>
                                        <td>{{ $item['header']->sales_model }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Color</td>
                                        <td>{{ $item['header']->color }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Quantity</td>
                                        <td>{{ $item['header']->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold">Suggested Price</td>
                                        <td>{{ number_format($item['header']->suggested_retail_price,2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        
                        @if(count($item['other_items']) > 0 )
                        
                        <tr>
                            <td>
                                <table style="width:100%;" valign="top">
                                    <thead>
                                        <tr style="background-color:#ccc;">
                                            <th  colspan="4" class="text-bold text-center">Other Items</th>
                                        </tr>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item</th>
                                            <th>Cost to</th>
                                            <th align="right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $ctr = 1; 
                                            $total = 0;
                                        ?>
                                        @foreach($item['other_items'] as $row)
                                        
                                        <tr>
                                            <td>{{ $ctr }}</td>
                                            <td>{{ $row->description}}</td>
                                            <td>{{ $row->owner_name }}</td>
                                            <td align="right">{{ number_format($row->amount,2) }}</td>
                                        </tr> 
                                        <?php 
                                            $ctr++; 
                                            $total += $row->amount; 
                                        ?>
                                        @endforeach
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" align="right"> Total</th>
                                            <th align="right">{{ number_format($total,2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                       @endif
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table style="width:100%;">
                        <tr style="background-color:#ccc;">
                            <td colspan="2" class="text-bold text-center">Pricing</td>
                        </tr>
                        <tr>
                            <td class="text-bold">SRP</td>
                            <td align="right">{{ number_format($item['header']->suggested_retail_price,2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">WSP</td>
                            <td align="right">{{ number_format($wsp,2) }}<td>
                        </tr>
                        <tr>
                            <td class="text-bold">Dealers Margin</td>
                            <td align="right">{{ number_format($dealer_margin,2) }} </td>
                        </tr>
                        <tr>
                            <td class="text-bold">3 Yrs LTO Registration</td>
                            <td align="right">{{ number_format($item['header']->lto_registration,2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Other Items</td>
                            <td align="right">{{ number_format($item['header']->freebies,2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Cost</td>
                            <td align="right">{{ number_format($cost,2)}}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Net Cost</td>
                            <td align="right">{{ number_format($net_cost, 2)}}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Fleet Price</td>
                            <td align="right">{{ number_format($item['header']->fleet_price,2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Subsidy</td>
                            <td align="right">{{ number_format($subsidy,2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Total IPC Subsidy</td>
                            <td align="right">{{ number_format($total_subsidy,2)}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr />
        @endforeach
    </main>
    
</body>
</html>