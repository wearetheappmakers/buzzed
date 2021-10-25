@extends('admin.main')

@section('content')
<style>
    @media print {
        #printPageButton {
            display: none;
        }
    }
    @media print {
        #printPageButton1 {
            display: none;
        }
    }
    table, th, td {
        border: solid black;
        border-collapse: collapse;
        font-weight: bold;
        padding: 10px;
    }
</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

    <br>
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                    </span>
                    <h3 class="kt-portlet__head-title">

                    </h3>
                </div>

                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <button class="btn btn-brand btn-elevate btn-icon-sm" id="printPageButton" onclick="window.print()">Print</button>
                        </div>
                    </div>&nbsp;&nbsp;&nbsp;
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{route('admin.order.index')}}" class="btn btn-brand btn-elevate btn-icon-sm" id="printPageButton1">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">

                <table style="width:100%">
                    <thead>
                        <tr>
                            <th colspan="2"><center>Adhik Bachat Mart<br>
                               Rajkot, 360024</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Shipping Address:<br>
                                Adhik Bachat Mart,<br/>
                                Rajkot, 3025698<br/> 
                                Gujarat,<br/> 
                                India,<br/> 
                                Mo no: 9999999999,<br/> 
                               Email Id : admart@gmail.com,<br/> 
                            </td>
                            <!-- <td>Shipping Address:<br>
                                {{ $order_header->shipping_fullname }}<br>
                                {{ $address }}<br>
                                {{ $order_header->shipping_city_name }}<br>
                                {{ $order_header->shipping_state_name }}<br>
                                {{ $order_header->shipping_country_name}}&nbsp;&nbsp;&nbsp;{{ $order_header->shipping_pincode }}<br>
                                {{ $order_header->shipping_mobile }}<br>
                                {{ $order_header->customers->email }}<br>
                                @if(isset($order_header->gst_no))GST: {{ $order_header->gst_no }}<br>@endif
                            </td> -->
                            <td>Billing Address:<br>
                                {{ $order_header->billing_fullname }}<br>
                                {{ $address }}<br>
                                {{ $order_header->billing_city_name }}<br>
                                {{ $order_header->billing_state_name }}<br>
                                {{ $order_header->billing_country_name}}&nbsp;&nbsp;&nbsp;{{ $order_header->billing_pincode }}<br>
                                {{ $order_header->billing_mobile }}<br>
                                {{ $order_header->customers->email }}<br>
                                @if(isset($order_header->gst_no))GST: {{ $order_header->gst_no }}<br>@endif
                            </td>
                        </tr>
                        <tr>
                            <table style="width:100%">
                                <thead>
                                    <tr>
                                        <!-- <th>Image</th> -->
                                        <th>Product</th>
                                        <th>Size</th>								
                                        <th>Price</th>
                                        <th>Quanity</th>
                                        <th>Total Quanity</th>
                                        <th>IGST</th>
                                        <th>CGST</th>
                                        <th>SGSt</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order_header->order_lines as $line)
                                    <?php 
                                        $newigst = $line->product_tax;  
                                        // $newigst = DB::table('products')->where('id',$line->product_id)->value('igst'); 
                                        $half = $newigst/2;
                                    ?>
                                    <tr>
                                        <!-- <td><img src="{{ $line->product_image }}"></td> -->
                                        <td>
                                            Product Name : {{ $line->product_name }} <br/>
                                            Color : {{ $line->color }}
                                        </td>
                                        <td>
                                            {!! $line->size !!}
                                        </td>								
                                        <td>
                                            @if($line->product_taxtype == 0)
                                                {{ $line->price - (($line->price * $newigst)/100) }}
                                            @else
                                                {{ round((($line->price/(1+($newigst/100)))),2) }}
                                            @endif
                                           
                                        </td>
                                        <td>{{ $line->quantity }}</td>
                                        <td>{{ $line->total_quantity }}</td>
                                        @if($order_header->billing_state_name == 'Gujarat')
                                        <td>-</td>
                                        <td>{{ $half }}%</td>
                                        <td>{{ $half }}%</td>
                                        @else
                                        <td>{{ $newigst }}%</td>
                                        <td>-</td>
                                        <td>-</td>
                                        @endif
                                        <td>{{ $line->formated_total_price }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan='8' style="text-align:right;"><b>Price:</b> </td>
                                        <td>
                                            {{ $order_header->formated_price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='8' style="text-align:right;"><b>Discout:</b></td>
                                        <td>
                                            {{ $order_header->formated_discount }}
                                        </td>    
                                    </tr>
                                    <tr>
                                        <td colspan='8' style="text-align:right;"><b>Total Price:</b></td>
                                        <td>
                                            {{ $order_header->formated_total_price }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection