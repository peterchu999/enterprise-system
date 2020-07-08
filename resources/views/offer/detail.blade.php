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
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_offer">Hapus Penawaran</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit_offer">Edit Penawaran</button>
            </div>
            @if($offer->offer_number != null)
            <div class="row d-flex justify-content-between align-items-center">
                <h1 class="mb-3 text-primary font-weight-bold col-6">No Penawaran: <b> {{$offer->offer_number ?? "-"}} </b> </h1>
            </div>
            @endif
            <hr class="col-12">
            <div class="row">
                <h4 class="mb-3 col-6">
                    Tanggal penawaran :<b> {{$offer->offer_date}}</b>
                </h4>
                <h4 class="mb-3 col-6">
                    Status penawaran : @if($offer->status != null)<span class='badge @if($offer->status == 1) badge-success @elseif($offer->status == 2) badge-warning @else badge-danger @endif'>
                        @if($offer->status == 1) Sudah Deal @elseif($offer->status == 2) Waiting @else Ditolak @endif
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
            </div>
        </div>
        <hr class="col-12">
        <div class="row col-10 d-flex justify-content-between">
            <h2 class="col-6">List item:</h2>
            <button type="button" class="btn btn-secondary" id="add-item">Tambahkan product</button>
        </div>
        <div class="col-10 mt-4" style="">
            <form action="{{route('Product.store')}}" id="product-add" method="POST">
                @csrf
                <input type="hidden" name="offer_id" value="{{$offer->id}}">
                <div class="row mb-3">
                    <div class="col-12 mb-2" id="product-container">
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
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($offer->Product as $product)
                    <tr>
                        <th scope="row" style="text-align: left">{{$loop->index + 1}}</th>
                        <td>{{$product->name}}</td>
                        <td>{{$product->qty}}</td>
                        <td>{{$product->price}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete_product" data-whatever="{{route('Product.destroy',$product->id)}}">Hapus</button>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_product" data-whatever="{{$product}}" data-route="{{route('Product.update',$product->id)}}">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
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
                        <input type="date" id="offer_date" name="offer_date" class="form-control" placeholder="Nama Perusahaan" value="{{$offer->offer_date}}" required>
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
                    <div class="col">
                        <label for="purchase_order">Nomor purchase order</label>
                        <input type="text" id="purchase_order" name="purchase_order" value="{{$offer->purchase_order}}" class="form-control" placeholder="Boleh dikosongkan">
                    </div>
                    @if(count($offer->Product) > 0)
                    <div class="col" id="status-container">
                        <label for="company_tel">status</label>
                        <select id="status" name="status" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                          <option value="" disabled selected>pilih status</option>
                          <option data-tokens="Sudah Deal" data-content="<span class='badge badge-success'>Sudah Deal</span>" value="1" @if($offer->status == 1) selected @endif>Sudah Deal</option>
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
                <button type="submit" class="btn btn-warning">Edit Penawaran</button>
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
            console.log(recipient)
            var modal = $(this)
            modal.find('form').attr('action',recipient)
        })
        $('#edit_product').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var recipient = button.data('whatever')
            var route = button.data('route')
            console.log(recipient)
            var modal = $(this)
            modal.find('form').attr('action',route)
            modal.find('#edit_name').val(recipient.name)
            modal.find('#edit_qty').val(recipient.qty)
            modal.find('#edit_price').val(recipient.price)
        })
    })
    function deleteOnClick(item) {
        $(item).parent().remove();
        if($('#product-container').children().length < 1) {
            $('#submit-add-button').hide(); 
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
        $('#submit-add-button').show();
        $('#product-container').append(generateTemplate())
    })
    $(document).ready(function() {
        if($('#product-container').children().length < 1){
            $('#submit-add-button').hide();
        } else {
            $('#submit-add-button').show();
        }
    })
    $("form#product-add").submit(function(e){
        e.preventDefault();
        let items = $('div.row.d-flex.mb-2.justify-content-between.product-item')
        console.log(items);
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