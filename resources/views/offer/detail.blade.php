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
    .table td, .table th{
        vertical-align: middle;
        text-align: center;
    }
</style>
<div class="container-fluid">
    <div class="row justify-content-center">
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
        <div class="col-10">
            <div class="row d-flex justify-content-between align-items-center">
                <h1 class="mb-3 text-secondary font-weight-bold col-6"> Detail Laporan</h1>
                @if(Auth::user()->role == "admin")<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_offer">Hapus Laporan</button>@endif
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_offer">Edit Laporan</button>
            </div>
            @if($offer->offer_number != null)
            <div class="row d-flex justify-content-between align-items-center">
                <h1 class="mb-3 text-primary font-weight-bold col-6">No Penawaran: <b> {{$offer->OfferNumber()->first()->offer_number ?? "-"}} </b> 
                    <button data-toggle="modal" data-target="#edit_offer_number" class="btn btn-primary">Edit No.Penawaran</button> 
                </h1>
            </div>
            @endif
            <hr class="col-12">
            <div class="row">
                <h4 class="mb-3 col-6">
                    Tanggal penawaran :<b> {{date_format(date_create($offer->offer_date),'D, d-M-Y')}}</b>
                </h4>
                <h4 class="mb-3 col-6">
                    Status penawaran : @if($offer->status != null)<span class='badge @if($offer->status == 1) badge-success @elseif($offer->status == 2) badge-warning @else badge-danger @endif'>
                        @if($offer->status == 1) PO @elseif($offer->status == 2) Waiting @else Ditolak @endif
                    </span> @else
                    -
                    @endif
                </h4>
                <h4 class="mb-3 col-6">
                    Customer : <b> <a href="{{route('Company.show',$offer->Company->id)}}" class="text-dark">{{$offer->Company->company_name}} </a> </b>
                </h4>
                <h4 class="mb-3 col-6">
                    Purchase Order : <b> {{$offer->purchase_order == null ? "-" : $offer->purchase_order}} </b>
                </h4>
                <h4 class="mb-1 col-12"> <b>Keterangan</b> :</h4>
                <h5 class="mb-3 col-12">{{$offer->information}}</h5>
                @if($offer->offer_number != null)
                <h5 class="mb-3 col-12"><b>PPN :</b> 
                    @if($offer->OfferNumber()->first()->ppn == true)
                    Ada <a href="{{route('Offer.PPN',$offer->id)}}" class="btn btn-warning ml-2">ganti ke non PPN</a>
                    @else
                    Non PPN <a href="{{route('Offer.PPN',$offer->id)}}" class="btn btn-success ml-2">ganti ke PPN</a>
                    @endif
                </h5>
                @endif
            </div>
        </div>
        <hr class="col-10">
        <div class="row col-10 d-flex justify-content-between">
            <h2 class="col-6">List item:</h2>
            <button type="button" class="btn btn-primary" id="add-item">Tambahkan Penawaran</button>
        </div>
        <div class="col-10 mt-4" style="">
            <form action="{{route('Product.store')}}" id="product-add" method="POST">
                @csrf
                <input type="hidden" name="offer_id" value="{{$offer->id}}">
                <div class="row mb-3">
                    @if($offer->offer_number == null)
                    <div class="col mb-2" id="noPenawaranContainer">
                        <label for="noPenwaran">Nomor Penawaran</label>
                        <input type="text" id="noPenawaran" name="no_penawaran" class="form-control" placeholder="No.Penawaran" value="{{old('no_penawaran')}}" >
                    </div>
                    @endif
                    <div class="col-12 mb-2" id="product-container">
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
                                <input type="text" name="" data-name="name" value="{{$item["name"]}}" class="col-5 product_name" placeholder="Nama barang" required>
                                <input type="text" name="" data-name="qty" value="{{$item["qty"]}}" class="col-1 product_qty" placeholder="Kuantiti" required>
                                <input type="text" name="" data-name="price" value=" {{$item["price"]}}" class="col-3 product_price" placeholder="Harga" required>
                                <button class="btn btn-danger" onclick="deleteOnClick(this)">Hapus kolom</button>
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <button type="submit" class="btn btn-success col" id="submit-add-button">save</button>
                </div>
            </form>
        </div>
        @if(count($offer->Product) <1)
        <h1 class="text-secondary d-block col-12 text-center">Tidak ada item</h1>
        @else
        <div class="container-fluid mx-auto col-10 mt-1">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" style="text-align: left">No</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Kuantiti</th>
                    <th scope="col">Harga</th>
                    <th scope="col" colspan="3">Total</th>
                    <th scope="col" style="width: 50px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @php
                      $totalCounter = 0;
                      $total = 0;
                    @endphp
                    @foreach ($offer->Product as $product)
                    <tr>
                        <th scope="row" style="text-align: left">{{$loop->index + 1}}</th>
                        <td class="text-left">{{$product->name}}</td>
                        <td>{{$product->qty}}</td>
                        @php
                            $total =  $product->qty * $product->price;
                            $totalCounter += $total;
                        @endphp
                        <td>{{number_format($product->price,0,',','.')}}</td>
                        <td colspan="3">{{number_format($total,0,',','.')}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger mb-2" data-toggle="modal" data-target="#delete_product" data-whatever="{{route('Product.destroy',$product->id)}}">Hapus</button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_product" data-whatever="{{$product}}" data-route="{{route('Product.update',$product->id)}}">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="bg-dark text-light" colspan="4">Total</td>
                        <td class="bg-success text-light" colspan="3">Rp. {{number_format($totalCounter,0,',','.')}}</td>
                    </tr>
                    @if($offer->offer_number != null)
                        @if($offer->OfferNumber()->first()->ppn == true)
                        <tr>
                            <td class="bg-dark text-light" colspan="4">PPN 10%</td>
                            <td class="bg-secondary text-light" colspan="3">Rp. {{number_format(($totalCounter * 10/100),0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td class="bg-dark text-light" colspan="4">Grand Total</td>
                            <td class="bg-success text-light" colspan="3">Rp. {{number_format(($totalCounter * 10/100) + $totalCounter,0,',','.')}}</td>
                        </tr>
                        @endif
                    @endif
                </tfoot>
            </table>
        </div>
        @endif
    </div>
@if($offer->offer_number != null)
<div class="modal fade" id="edit_offer_number" tabindex="-1" role="dialog" aria-labelledby="editOfferNumber" aria-hidden="true">
    <input type="hidden" id="old_offer_number" value="{{old('offer_number') != null}}">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit No. Penawaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('OfferNumber.update',$offer->offer_number) }}" method="POST">
        @method('patch')
        @csrf
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <label for="offer_date">No Penawaran</label>
                    <input type="text" id="offer_number" name="offer_number" class="form-control" placeholder="Nama Perusahaan" value="{{$offer->OfferNumber()->first()->offer_number}}" required>
                </div>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
    </div>
    </div>
</div>
@endif
<div class="modal fade" id="delete_offer" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Penawaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('Offer.destroy',$offer->id) }}" method="POST">
          @method('delete')
          @csrf
          <div class="modal-body">
              <h5 class="modal-message">Apakah kamu yakin untuk menghapus ?</h5>
          </div>
          <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
         </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit_offer" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <input type="hidden" id="old_offer" value="{{old('offer_date') != null}}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Penawaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('Offer.update',$offer->id) }}" method="POST">
            @method('patch')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="offer_date">Tanggal penawaran</label>
                        <input type="date" id="offer_date" name="offer_date" class="form-control" placeholder="Nama Perusahaan" value="{{ date_format(date_create($offer->offer_date),'Y-m-d') }}" required>
                    </div>
                    <div class="col">
                        <label for="company_industry">Perusahaan</label>
                        <select value="{{$offer->company_id}}" name="company_id" id="company" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                          <option value="" data-content="<span class='text-secondary'>Pilih perusahaan</span>" disabled selected>pilih Perusahaan</option>
                          @foreach ($companies as $company)
                              <option data-tokens="{{$company->company_name}}" data-content="<span class='text-dark myapps'>{{$company->company_name}}</span>" value="{{$company->id}}" @if($offer->company_id == $company->id) selected @endif>{{$company->company_name}}</option>
                          @endforeach
                        </select>                      
                    </div>
                </div>
                <div class="row mb-3">
                    @if(count($offer->Product) > 0)
                    <div class="col">
                        <label for="purchase_order">Nomor purchase order</label>
                        <input type="text" id="purchase_order" name="purchase_order" value="{{$offer->purchase_order}}" class="form-control" placeholder="Boleh dikosongkan">
                    </div>
                    <div class="col" id="status-container">
                        <label for="company_tel">status</label>
                        <select id="status" name="status" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                          <option value="" disabled selected>pilih status</option>
                          <option data-tokens="PO" data-content="<span class='badge badge-success'>PO</span>" value="1" @if($offer->status == 1) selected @endif>PO</option>
                          <option data-tokens="Waiting" data-content="<span class='badge badge-warning'>Waiting</span>" value="2" @if($offer->status == 2) selected @endif >Waiting</option>
                          <option data-tokens="Ditolak" data-content="<span class='badge badge-danger'>Ditolak</span>" value="3" @if($offer->status == 3) selected @endif >Ditolak</option>
                        </select>
                    </div>
                    @endif
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="information">Keteragan</label>
                        <textarea class="form-control" id="information" name="information" rows="4" required>{{$offer->information}}</textarea>
                    </div>
                </div>
              </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('Offer.destroy',$offer->id) }}}}" method="POST">
              @method('delete')
              @csrf
              <div class="modal-body">
                  <h5 class="modal-message">Apakah kamu yakin untuk menghapus ?</h5>
              </div>
              <div class="modal-footer d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
             </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <input type="hidden" id="old_product" value="{{old('modal_edit') != null}}">
        <input type="hidden" name="modal_edit" value="tes">
          <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Penawaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('Offer.update',$offer->id) }}" method="POST">
                @method('patch')
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger col-10 mx-auto" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <input type="hidden" name="offer_id" value="{{$offer->id}}">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" id="edit_name" name="name" class="form-control" value="{{old('name')}}" placeholder="Nama Product" required>
                        </div>
                        <div class="col">
                            <input type="text" id="edit_qty" name="qty" class="form-control" value="{{old('qty')}}" placeholder="Kuantiti" required>
                        </div>
                        <div class="col">
                            <input type="text" id="edit_price" name="price" class="form-control" value="{{old('price')}}" placeholder="Harga" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Edit Penawaran</button>
                </div>
            </form>
            </div>
          </div>
        </div>
<script>
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

    
    if($('#old_offer').val()){
        $(window).on('load',function(){
            $('#edit_offer').modal('show')
        });
    } 

    $(document).ready(function(){
        $('#delete_product').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever')
            var modal = $(this)
            modal.find('form').attr('action',recipient)
        })
        $('#edit_product').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever')
            var route = button.data('route')
            var modal = $(this)
            modal.find('form').attr('action',route)
            modal.find('#edit_name').val(recipient.name)
            modal.find('#edit_qty').val(recipient.qty)
            modal.find('#edit_price').val(recipient.price)
        })
        if($('#product-container').children().length < 2){
            $('#submit-add-button').hide();
            $('#header-product-add').hide();
            $('#noPenawaranContainer').hide();
        } else {
            $('#submit-add-button').show();
            $('#header-product-add').show();
            $('#noPenawaranContainer').show();
        }
    })
    function deleteOnClick(item) {
        $(item).parent().remove();
        if($('#product-container').children().length < 2) {
            $('#submit-add-button').hide(); 
            $('#header-product-add').hide();
            $('#noPenawaranContainer').hide();
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
        $('#submit-add-button').show();
        $('#header-product-add').show();
        $('#noPenawaranContainer').show();
        $('#product-container').append(generateTemplate())
    })
    $("form#product-add").submit(function(e){
        e.preventDefault();
        let items = $('div.row.d-flex.mb-2.justify-content-between.product-item')
        if (items.length > 0) {
            items.each(function(index){
                $(this).find('input').each(function(idx,input){
                    let val = $(this).attr('data-name')
                    if(val == "price") { input.value = input.value.replace(/[.]/g, "") };
                    $(this).attr('name',`product[${index - 1}][${val}]`)
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