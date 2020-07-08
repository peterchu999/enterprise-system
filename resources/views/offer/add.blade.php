@extends('layouts.app')

@section('content')
<style>
    ul.dropdown-menu > li {
        padding: .5em 1em;
        transition: .5s;
    }
    ul.dropdown-menu > li:hover {
        background: teal;
        color: white;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="col-10">Tambahkan Laporan</h2>
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
        <form action="{{route('Offer.store')}}" method="POST" class="col-10">
            @csrf
            <input type="hidden" name="id" id="id_hidden" value="">
            <div class="modal-body">
              <div class="row mb-3">
                  <div class="col">
                      <label for="offer_date">Tanggal penawaran</label>
                      <input type="date" id="offer_date" name="offer_date" class="form-control" placeholder="Nama Perusahaan" value="{{old('offer_date')}}" required>
                  </div>
                  <div class="col">
                      <label for="company_industry">Perusahaan</label>
                      <select value="{{old('company_id')}}" name="company_id" id="company" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                        <option value="" data-content="<span class='text-secondary'>Pilih perusahaan</span>" disabled selected>pilih Perusahaan</option>
                        @foreach ($companies as $company)
                            <option data-tokens="{{$company->company_name}}" data-content="<span class='text-dark myapps'>{{$company->company_name}}</span>" value="{{$company->id}}" @if(old('company_id') == $company->id) selected @endif>{{$company->company_name}}</option>
                        @endforeach
                      </select>                      
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col">
                      <label for="purchase_order">Nomor purchase order</label>
                      <input type="text" id="purchase_order" name="purchase_order" value="{{old('purchase_order')}}" class="form-control" placeholder="Boleh dikosongkan">
                  </div>
                  <div class="col" id="status-container">
                      <label for="status">status</label>
                      <select id="status" name="status" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                        <option value="" disabled selected>pilih status</option>
                        <option data-tokens="Sudah Deal" data-content="<span class='badge badge-success'>Sudah Deal</span>" value="1" @if(old('status') == 1) selected @endif>Sudah Deal</option>
                        <option data-tokens="Waiting" data-content="<span class='badge badge-warning'>Waiting</span>" value="2" @if(old('status') == 2) selected @endif >Waiting</option>
                        <option data-tokens="Ditolak" data-content="<span class='badge badge-danger'>Ditolak</span>" value="3" @if(old('status') == 3) selected @endif >Ditolak</option>
                      </select>
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col">
                      <label for="information">Keteragan</label>
                      <textarea class="form-control" id="information" name="information" rows="4" required>{{old('information')}}</textarea>
                  </div>
              </div>
                <div class="row mb-3">
                <div class="col-12 mb-3 d-flex justify-content-between">
                    <label for="information">Penawaran</label>
                    <button type="button" class="btn btn-secondary" id="add-item">klik untuk tambahkan kolom penawaran</button>
                </div>
              <div class="col-12" id="product-container">
                    @if(old('product') != null)
                        @foreach (old('product') as $item)
                            <div class="row d-flex mb-2 justify-content-between product-item">
                                <input type="text" name="" data-name="name" value="{{$item["name"]}}" class="col-3 product_name" placeholder="Nama barang" required>
                                <input type="text" name="" data-name="qty" value="{{$item["qty"]}}" class="col-3 product_qty" placeholder="Kuantiti" required>
                                <input type="text" name="" data-name="price" value=" {{$item["price"]}}" class="col-3 product_price" placeholder="Harga" required>
                                <button class="btn btn-danger" onclick="deleteOnClick(this)">Hapus kolom</button>
                            </div>
                        @endforeach
                    @endif
                </div>
              </div>
            </div>
            <button type="submit" id="btn-submit" class="btn btn-primary col-10 offset-1">Tambahkan penawaran</button>
        </form>
    </div>
</div>

<script type="text/javascript">
    $.fn.selectpicker.Constructor.BootstrapVersion = '4';
    $('select#company').selectpicker();
    $('select#status').selectpicker();
    
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
    setBootstrapSelect('select#status');
    setBootstrapSelect('select#company')
    function deleteOnClick(item) {
        $(item).parent().remove();
        if($('#product-container').children().length < 1) {
            $('#status-container').hide()    
        } 
    }
    let generateTemplate = (obj = {name:"",qty:"",price:""}) => `
        <div class="row d-flex mb-2 justify-content-between product-item">
            <input type="text" name="" data-name="name" value="${obj.name}" class="col-3 product_name" placeholder="Nama barang" required>
            <input type="text" name="" data-name="qty" value="${obj.qty}" class="col-3 product_qty" placeholder="Kuantiti" required>
            <input type="text" name="" data-name="price" value="${obj.price}" class="col-3 product_price" placeholder="Harga" required>
            <button class="btn btn-danger" onclick="deleteOnClick(this)">Hapus kolom</button>
        </div>
    `
    $('button#add-item').click(function() {
        $('#status-container').show()
        $('#product-container').append(generateTemplate())
    })
    $(document).ready(function() {
        if($('#product-container').children().length < 1){
            $('#status-container').hide();
        } else {
            $('#status-container').show();
        }
    })
    $("form").submit(function(e){
        e.preventDefault();
        let items = $('div.row.d-flex.mb-2.justify-content-between.product-item')
        if (items.length > 0) {
            items.each(function(index){
                $(this).find('input').each(function(){
                    let val = $(this).attr('data-name')
                    $(this).attr('name',`product[${index}][${val}]`)
                })
            })
        }
        if($('#status-container').is(":hidden")){
            $('#status-container').remove()
        } 
        this.submit()
    });
    
</script>
@endsection