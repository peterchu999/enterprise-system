@extends('layouts.app')

@section('content')
@php
    $user = Auth::user();
@endphp
<div class="container-fluid">
    <div class="row justify-content-center">
        <h2 class="col-10">Detail Perusahaan</h2>
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
            <h1 class="mb-3 text-primary font-weight-bold">{{$company->company_name}}</h1>
            <div class="row">
                <h4 class="mb-3 col-6">
                    <a style="cursor:pointer" class="text-dark" target="_blank"  href="mailto:{{$company->company_email}}">
                        Email :<b class="font-weight-bold"> {{$company->company_email ?? "-"}}</b>
                    </a>
                </h4>
                <h4 class="mb-3 col-6">
                    <a style="cursor:pointer" class="text-dark" target="_blank" href="tel:{{$company->company_tel}}">
                        No Tlpn : <b class="font-weight-bold">{{$company->company_tel ?? "-"}}</b>
                    </a>
                </h4>
                <h4 class="mb-3 col-6">
                    <a style="cursor:pointer" class="text-dark" target="_blank"  href="https://www.google.com/maps/search/{{$company->company_address}}">
                        Alamat : <b class="font-weight-bold">{{$company->company_address}}</b>
                    </a>
                </h4>
                <h4 class="mb-3 col-6">
                    Industri : <b class="font-weight-bold">{{$company->Industry->name ?? "-" }}</b>
                </h4>
            </div>
        </div>
        <hr class="col-12">
        <div class="collapse col-10 mb-4 @if($errors->any())show @endif" id="collapseForm">
            <h2>Tambahkan Kontak</h2>
            <form action="{{route('ContactPerson.store')}}" method="POST">
                @csrf
                <input type="hidden" name="company_id" value="{{$company->id}}">
                <div class="row mb-3">
                    <div class="col">
                        <label for="contact_person[name]">Nama Kontak</label>
                        <input type="text" id="contact_person[name]" name="contact_person[name]" class="form-control" value="{{old('contact_person.name')}}" placeholder="Nama kontak" required>
                    </div>
                </div>
                <div class="row mb-3">
                     <div class="col">
                        <label for="contact_person[email]">Email</label>
                        <input type="email" id="contact_person[email]" name="contact_person[email]" class="form-control" value="{{old('contact_person.email')}}" placeholder="Email">
                    </div>
                    <div class="col">
                        <label for="contact_person[phone]">No.telepon</label>
                        <input type="tel" id="contact_person[phone]" name="contact_person[phone]" class="form-control" value="{{old('contact_person.phone')}}" placeholder="no telepon" pattern="[0-9]{10,14}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="contact_person[phone]">Departemen</label>
                        <input type="text" id="contact_person[department]" name="contact_person[department]" class="form-control" value="{{old('contact_person.department')}}" placeholder="Departemen" >
                    </div>
                    <div class="col">
                        <label for="contact_person[email]">Jabatan</label>
                        <input type="text" id="contact_person[position]" name="contact_person[position]" class="form-control" value="{{old('contact_person.position')}}" placeholder="Jabatan">
                    </div>
                </div>
                <button class="btn btn-primary">Tambahkan Kontak</button>
            </form>
            <hr>
        </div>
        <h3 class="mb-3 text-info font-weight-bold col-10 row">
            <div class="col-6">
                List Contact yang kamu data :
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-info" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">Tambahkan kontak</button>
            </div>
        </h3>
        <div class="col-10">
            <div class="row container-company-card">
                @foreach($company->ContactPerson()->get() as $cp)
                    @if( $cp->Sales()->first()->id == $user->id || $user->role == "admin")
                    <div class="col-6">
                        <div class="card bg-light mb-5 mx-auto">
                            <div class="card-header d-flex justify-content-between">
                                <b>{{$cp->name}}</b>
                            </div>
                            <div class="card-body">
                                <a style="cursor:pointer" class="text-dark card-text d-block mb-3" target="_blank"  href="tel:{{$cp->phone}}">
                                    No. Tlpn :<b class="font-weight-bold"> {{$cp->phone ?? "-"}}</b>
                                </a>
                                <a style="cursor:pointer" class="text-dark card-text d-block mb-3" target="_blank"  href="mailto:{{$company->company_email}}">
                                    Email :<b class="font-weight-bold"> {{$cp->email ?? "-"}}</b>
                                </a>
                                @if(
                                    substr($company->company_name, 0, 3) === "PT." || 
                                    substr($company->company_name, 0, 3) === "CV."
                                )
                                <span class="text-dark card-text d-block mb-3" >
                                    Departemen :<b class="font-weight-bold"> {{$cp->department ?? "-"}}</b>
                                </span>
                                <span class="text-dark card-text d-block">
                                    Jabatan :<b class="font-weight-bold"> {{$cp->position ?? "-"}}</b>
                                </span>
                                @endif
                                <div class="d-flex justify-content-between w-100">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit" data-whatever='{{$cp}}'>Edit</button>
                                    @if(Auth::user()->role == "admin")
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete" data-whatever='{{$cp}}'>Delete</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div> 
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit perusahaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('ContactPerson.destroy','xyz') }}" method="POST">
            @method('patch')
            @csrf
            <input type="hidden" name="id" id="id_hidden" value="">
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <label for="contact_person_name">Nama Kontak</label>
                        <input type="text" id="contact_person_name" name="contact_person[name]" class="form-control" value="{{old('contact_person.name')}}" placeholder="Nama kontak" required>
                    </div>
                    <div class="col">
                        <label for="contact_person_email]">Email</label>
                        <input type="email" id="contact_person_email" name="contact_person[email]" class="form-control" value="{{old('contact_person.email')}}" placeholder="Email">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="contact_person_phone">No.telepon</label>
                        <input type="tel" id="contact_person_phone" name="contact_person[phone]" class="form-control" value="{{old('contact_person.phone')}}" placeholder="no telepon" pattern="[0-9]{10,14}">
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-warning">Edit</button>
            </div>
           </form>
        </div>
      </div>
    </div>
@if( Auth::user()->role == "admin")
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Menghapus kontak</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('ContactPerson.destroy','xyz') }}}}" method="POST">
          @method('delete')
          @csrf
          <div class="modal-body">
              <h5 class="modal-message">Apakah kamu yakin untuk menghapus</h5>
          </div>
          <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
         </form>
      </div>
    </div>
  </div>
<script>
    $(document).ready(function(){
        // delete modal
        $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever') 
            var modal = $(this)
            console.log(recipient)
            modal.find('.modal-message').html('Apakah kamu yakin untuk menghapus <b>' + recipient.name + '</b> ?')
            modal.find('form').attr('action',(index,value) => {
                return value.replace('xyz',recipient.id)
            })
        })

        //edit modal
        $('#edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var obj = button.data('whatever')
            var modal = $(this)
            console.log(obj)
            modal.find('input#id_hidden').val(obj.id)
            modal.find('input#contact_person_name').val(obj.name)
            modal.find('input#contact_person_email').val(obj.email)
            modal.find('input#contact_person_phone').val(obj.phone)
            modal.find('.modal-title').html('Edit kontak <b>' + obj.name + '</b> ?')
            modal.find('form').attr('action',(index,value) => {
                return value.replace('xyz',obj.id)
            })
        })
    });
</script>
@endif
@endsection