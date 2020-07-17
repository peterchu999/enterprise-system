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
<div class="container">
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
    <div class="row d-flex align-items-center justify-content-center mb-5">
        <h1 class="m-2 col">Sales</h1>
        <a class="btn btn-success col mx-2" href="{{route('Admin.restoreView')}}">Restore Sales</a>
        <a class="btn btn-primary col" href="{{route('register')}}">Create Sales</a>
    </div>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nama Sales</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($users as $sales)
            @if($sales->role != "admin")
            <tr>
                <td>{{$sales->name}}</td>
                <td>{{$sales->email}}</td>
                <td> <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete_sales" data-route="{{route('Admin.destroy',$sales->id)}}">Revoke Access</button></td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="delete_sales" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Hapus Sales dari DB</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST">
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
      <script>
            $(document).ready(function(){
                $('#delete_sales').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
                    var recipient = button.data('route') 
                    var modal = $(this)
                    modal.find('form').attr("action",recipient);
                })
            })
      </script>
@endsection