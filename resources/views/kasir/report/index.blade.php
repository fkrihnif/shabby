@extends('layouts.template')
@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header justify-content-between d-flex d-inline">
          <h4 class="card-title"> Laporan Transaksi</h4>
        </div>
        <i style="color: grey; font-size:90%" class="ml-3">Secara default menampilkan penjualan hari ini, silahkan filter tanggal untuk melakukan pencarian</i>
        <div class="card-body">
          <form action="{{ route('kasir.report.index') }}">
            
            <div class="row">
                    <div class="col-4">
                        <label for="from_date">Dari Tanggal</label>
                        <input type="date" id="from_date" name="from_date" value="{{Request::get('from_date')}}" class="form-control">
                    </div>
                    <div class="col-4">
                        <label for="to_date">Hingga Tanggal</label>
                        <input type="date" id="to_date" name="to_date" value="{{Request::get('to_date')}}" class="form-control">
                    </div>
                    <div class="col-4">
                        <div class="col-4" style="margin-top: 10px;">
                            <input type="submit" value="Cari" class="btn btn-primary text-white">
                        </div>
                    </div>
            </div>
            </form>
            <form action="{{ route('kasir.report.index') }}">
                <input type="submit" value="Semua Data" class="btn btn-warning text-white">
            </form>
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
            <thead>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Online/Offline</th>
                <th>Metode Pembayaran</th>
                <th>Total Penjualan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </thead>
              <tbody>
                @php
                $totalOrder = [];
                @endphp
                  @foreach($transactions as $key => $transaction)
                  <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $transaction->transaction_code }}</td>
                      <td>{{ $transaction->method }}</td>
                      <td>
                        @if ($transaction->customer_name != null or $transaction->account_number != null)
                          {{ $transaction->payment_method }} <br>
                          {{ $transaction->customer_name ?? '' }} 
                         - {{ $transaction->account_number ?? '' }}
                          @else
                          Tunai
                        @endif
                      </td>
                      <td>@currency($transaction->purchase_order)</td>
                      <td>{{ date('d M Y H:i:s', strtotime($transaction->created_at)) }}</td>
                      <td>
                          <a href="{{ route('kasir.report.show', $transaction->id) }}"><i class="fas fa-eye"></i></a>
                      </td>
                  </tr>
                  @php
                  $totalOrder[] = $transaction->purchase_order;
                  @endphp
                  @endforeach
                  
                    @php
                    $total = array_sum($totalOrder);
                    @endphp
                    <p>Total : @currency($total)</p>
                  
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
@endpush