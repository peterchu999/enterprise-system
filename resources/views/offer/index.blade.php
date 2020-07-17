@extends('layouts.app')

@section('content')
<style>
    .table td, .table th{
        vertical-align: middle;
        text-align: center;
    }
    ul.dropdown-menu > li {
        padding: .5em 1em;
        transition: .5s;
    }
    ul.dropdown-menu > li:hover {
        background: teal;
        color: white;
    }
    .table td, .table th{
        vertical-align: middle;
        text-align: center;
    }
</style>
<div class="container-fluid mx-auto" style="max-width: 1400px">
  @if($errors->any())
            <div class="alert alert-danger col-10" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @elseif($message = Session::get('success'))
            <div class="alert alert-success col-10" role="alert">
                {{$message}}
            </div>
        @elseif($message = Session::get('warning'))
            <div class="alert alert-warning col-10" role="alert">
                {{$message}}
            </div>
        @elseif($message = Session::get('failed'))
            <div class="alert alert-danger col-10" role="alert">
                {{$message}}
            </div>
        @endif
  <div class="row mb-5">
    <h2 class="col-3">List Laporan  : </h2>
    <button class="btn btn-success col-2 offset-1" data-toggle="modal" data-target="#filter-modal">Filter Laporan</button>
    <a href="{{route('Offer.index_view','add')}}" class="btn btn-primary col-2 offset-3">Buat Laporan</a>
  </div>
  <div class="row mb-3 container">
    <h4 class="col-6">Jumlah Data : {{ $offers->total() }}</h4>
    <h4 class="col-6 text-right">Data Per Halaman : {{ $offers->perPage() }}</h4>
  </div>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Tanggal</th>
            <th scope="col">Customer</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
            @if(Auth::user()->role == "admin")
              <th scope="col">Sales</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
            <tr>
                <td>{{date_format(date_create($offer->offer_date),'D, d-M-Y')}}</td>
                <td> <a href="{{route('Company.show',$offer->Company->id)}}" class="text-dark">{{$offer->Company->company_name}} </a></td>
                <td>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#information_modal" data-whatever="{{$offer->information}}">Informasi</button>
                </td>
                <td>
                    <span class='badge @if($offer->status == 1) badge-success @elseif($offer->status == 2) badge-warning @elseif($offer->status == 3) badge-danger @else badge-secondary  @endif'>
                        @if($offer->status == 1) PO @elseif($offer->status == 2) Waiting @elseif($offer->status == 3) Ditolak @else - @endif
                    </span>
                </td>
                <td><a class="btn btn-success"  href="{{route('Offer.show',$offer->id)}}">Detail</a></td>
                @if(Auth::user()->role == "admin")
                  <td>{{$offer->Sales->name}}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $offers->appends($_GET)->links() }}
</div>
<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Filter table</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('Offer.index') }}" method="GET">
            <div class="modal-body">
              <div class="row mb-3">
                  <div class="col">
                      <label for="mulai">Dari</label>
                      <input type="date" value="{{app('request')->input('start')}}" id="mulai" name="start" class="form-control" placeholder="Nama Perusahaan" value="">
                  </div>
                  <div class="col">
                      <label for="sampai">Sampai</label>
                      <input type="date" value="{{app('request')->input('end')}}" id="sampai" name="end" class="form-control" placeholder="Nama Perusahaan" value="">
                  </div>
              </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="company_industry">Perusahaan</label>
                        <select value="" name="company_id" id="company" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                          <option value="" data-content="<span class='text-secondary'>Pilih perusahaan</span>" disabled selected>pilih Perusahaan</option>
                          @foreach ($companies as $company)
                              <option data-tokens="{{$company->company_name}}" data-content="<span class='text-dark myapps'>{{$company->company_name}}</span>" value="{{$company->id}}" @if(app('request')->input('company_id') == $company->id) selected @endif>{{$company->company_name}}</option>
                          @endforeach
                        </select>                      
                    </div>
                    <div class="col" id="status-container">
                        <label for="company_tel">status</label>
                        <select id="status" name="status" value="" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                          <option value="" disabled selected>Pilih status</option>
                          <option data-tokens="PO" data-content="<span class='badge badge-success'>PO</span>" value="1" @if(app('request')->input('status')==1) selected @endif >PO</option>
                          <option data-tokens="Waiting" data-content="<span class='badge badge-warning'>Waiting</span>" value="2" @if(app('request')->input('status')==2) selected @endif>Waiting</option>
                          <option data-tokens="Ditolak" data-content="<span class='badge badge-danger'>Ditolak</span>" value="3" @if(app('request')->input('status')==3) selected @endif>Ditolak</option>
                          <option data-tokens="-" data-content="<span class='badge badge-secondary'>-</span>" value="4" @if(app('request')->input('status')==4) selected @endif>-</option>
                        </select>
                    </div>
                </div>
                @if(Auth::user()->role == "admin")
                <div class="row mb-3">
                   <div class="col">
                        <label for="sales">Sales</label>
                        <select value="" name="sales" id="sales" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                          <option value="" data-content="<span class='text-secondary'>Pilih sales</span>" disabled selected>pilih sales</option>
                          @foreach ($sales as $sls)
                              <option data-tokens="{{$sls->name}}" data-content="<span class='text-dark myapps'>{{$sls->name}}</span>" value="{{$sls->id}}" @if(app('request')->input('sales') == $sls->id) selected @endif>{{$sls->name}}</option>
                          @endforeach
                        </select>                      
                    </div>
                </div>
                @endif
              </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="button-reset">Reset</a>
                <button type="submit" class="btn btn-success">Filter</button>
            </div>
        </form>
        </div>
      </div>
    </div>
<div class="modal fade" id="information_modal" tabindex="-1" role="dialog" aria-labelledby="information_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Informasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body-modal">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  <script>
    $.fn.selectpicker.Constructor.BootstrapVersion = '4';
    $('select#company').selectpicker();
    $('select#status').selectpicker();
    $('select#sales').selectpicker();
    $(document).ready(function(){
        $('#information_modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever') 
            var modal = $(this)
            modal.find('#body-modal').text(recipient)
        })
    })
    function setBootstrapSelect (query){
        let flag = true;
        $(query).parent().find('button.btn.dropdown-toggle').click(function() {
            if (flag) {
                $(query).parent().find('li').each(function(index){
                    $(this).click(function() {
                        if(!$(this).hasClass('disabled')){
                            $(query).prop('selectedIndex', index);
                            let badge = $(this).find('span.text').html();
                            $(query).parent().find('div.filter-option-inner-inner').html(badge)
                        }
                    })
                })
            }
            flag = false
        })
    }
    const resetOption = (query,message = "Pilih ...") => {
      $(query).val("");
      $(query).parent().find('div.filter-option-inner-inner').html(message)
    }
    $('button#button-reset').click(function(){
      // location.href = location.href.split("?")[0];
      resetOption('select#status',"Pilih status")
      resetOption('select#company',"Pilih perusahaan")
      resetOption('select#sales',"Pilih sales")
      $('input#mulai').val(null);
      $('input#sampai').val(null);
    })

    setBootstrapSelect('select#status');
    setBootstrapSelect('select#company');
    setBootstrapSelect('select#sales');

  </script>
  
@endsection