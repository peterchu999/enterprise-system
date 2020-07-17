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
                      <label for="offer_date">Tanggal Laporan</label>
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
                      <label for="information">Keteragan</label>
                      <textarea class="form-control" id="information" name="information" rows="4" required>{{old('information')}}</textarea>
                  </div>
              </div>
                <div class="row mb-3">
                <div class="col-12 mb-3 d-flex justify-content-between">
                    <label for="information">Penawaran</label>
                    <button type="button" class="btn btn-primary" id="add-item">klik untuk menambahkan penawaran</button>
                </div>
              <div class="col-12" id="product-container">
                  <div id="header-product-add">
                            <div class="row d-flex mb-2 justify-content-between product-item" >
                                <div class="col-5"> <h3>Nama Item</h3></div>
                                <div class="col-1"> <h3>Qty</h3></div>
                                <div class="col-3"> <h3>Price</h3></div>
                                <div class="text-light px-3">Hapus kolom</div>
                            </div>
                        </div>
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
            <button type="submit" id="btn-submit" class="btn btn-success col-10 offset-1">Save</button>
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
    setBootstrapSelect('select#company');
    $(document).ready(function() {
     if($('#product-container').children().length < 2){
            $('#submit-add-button').hide();
            $('#header-product-add').hide();
        } else {
            $('#submit-add-button').show();
            $('#header-product-add').show();
        }
    })
    function deleteOnClick(item) {
        $(item).parent().remove();
        if($('#product-container').children().length < 2) {
            $('#submit-add-button').hide(); 
            $('#header-product-add').hide();
        } 
    }
    function priceHandler(dom){
        value = dom.value;
        length == null ? 0:length;
        value = value.replace(/[.]/g,"");
        length = value.length
        value = value.split("");
        if(length > 9) {
            value.splice(length - 9,0,".")
            length++;
        } 
        if(length > 6) {
            value.splice(length - 6,0,".")
            length++;
        } 
        if(length > 3) {
            value.splice(length - 3,0,".");
            length++;
        } 
        dom.value = value.join("")
        length = dom.value.length
    }
    let generateTemplate = (obj = {name:"",qty:"",price:""}) => `
        <div class="row d-flex mb-2 justify-content-between product-item">
            <input type="text" name="" data-name="name" value="${obj.name}" class="col-5 product_name" placeholder="Nama barang" required>
            <input type="text" name="" data-name="qty" value="${obj.qty}" class="col-1 product_qty" placeholder="qty" required>
            <input type="text" name="" data-name="price" oninput="priceHandler(this)" value="${obj.price}" class="col-3 product_price" placeholder="Harga" required>
            <button class="btn btn-danger" onclick="deleteOnClick(this)">Hapus kolom</button>
        </div>
    `
    $('button#add-item').click(function() {
        $('#header-product-add').show();
        $('#product-container').append(generateTemplate())
    })
    $("form").submit(function(e){
        e.preventDefault();
        let items = $('div.row.d-flex.mb-2.justify-content-between.product-item')
        if (items.length > 0) {
            items.each(function(index){
                $(this).find('input').each(function(idx,input){
                    let val = $(this).attr('data-name')
                    if(val == "price") { input.value = input.value.replace(/[.]/g, ""); }
                    $(this).attr('name',`product[${index-1}][${val}]`)
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