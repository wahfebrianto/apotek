@extends('laporan.index')

@section('child')
<div class="row">
    <div class="col-sm-12 text-center">
        <img src="/assets/logo.png" width="5%">
        <h4 class="text-navy"><b>APOTEK VALENTINO</b></h4>
        <p>
            <span>Jl. Pandugo Timur 97B/99 Surabaya</span><br/>
            <span>Telp. (031) 8783730</span><br/>
            <span>Apoteker Dra. Lusiwati .T. M Farm-Klin Apt</span><br/>
            <span><strong>SIPA : </strong>19511113/SIPA-35.78/2016/2106</span>
        </p>
        <h4 class="text-navy"><b>LAPORAN PENJUALAN</b></h4>
        <h4 class="text-navy"><b>{{$periode}}</b></h4>
    </div>
</div>

<div class="table-responsive m-t">
    <table class="table invoice-table">
        <thead>
            <tr>
                <th>Item List</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Tax</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div><strong>Admin Theme with psd project layouts</strong></div>
                    <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</small>
                </td>
                <td>1</td>
                <td>$26.00</td>
                <td>$5.98</td>
                <td>$31,98</td>
            </tr>
        </tbody>
    </table>
</div><!-- /table-responsive -->

<table class="table invoice-total">
    <tbody>
        <tr>
            <td><strong>Sub Total :</strong></td>
            <td>$1026.00</td>
        </tr>
        <tr>
            <td><strong>TAX :</strong></td>
            <td>$235.98</td>
        </tr>
        <tr>
            <td><strong>TOTAL :</strong></td>
            <td>$1261.98</td>
        </tr>
    </tbody>
</table>
@endsection
