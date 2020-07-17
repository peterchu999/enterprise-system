@extends('layouts.app')

@section('content')
<div class="container">
    @if($errors->any())
            <div class="alert alert-danger col-12" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @elseif($message = Session::get('success'))
            <div class="alert alert-success col-12" role="alert">
                {{$message}}
            </div>
        @elseif($message = Session::get('warning'))
            <div class="alert alert-warning col-12" role="alert">
                {{$message}}
            </div>
        @elseif($message = Session::get('failed'))
            <div class="alert alert-danger col-12" role="alert">
                {{$message}}
            </div>
        @endif
    <div class="row d-flex align-items-center justify-content-center mb-3">
        <h1 class="m-2 col">Industri</h1>
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Tambahkan Industry
            </button>
        </div>
        <div class="collapse col-12 mt-3" id="collapseExample">
            <form action="{{route('Industry.store')}}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" id="industry_name" name="industry_name" class="form-control" value="{{old('industry_name')}}" placeholder="Industry" required>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button class="col-10 btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nama Industri</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($industries as $industry)
            <tr>
                <td>{{$industry->name}}</td>
                <td class="text-center">
                    <button class="btn btn-primary" data-route="{{route('Industry.destroy',$industry->id)}}" data-whatever="{{$industry->name}}" data-toggle="modal" data-target="#edit_industry">Edit</button>
                    <button class="btn btn-danger" data-route="{{route('Industry.destroy',$industry->id)}}" data-toggle="modal" data-target="#delete_industry">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="delete_industry" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Industry</h5>
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
<div class="modal fade" id="edit_industry" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Industry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="POST">
            @method('patch')
            @csrf
            <div class="modal-body">
                <div class="col">
                    <label for="#industry_name_edit">Nama Industry</label>
                    <input type="text" id="industry_name_edit" name="industry_name" class="form-control" value="{{old('industry_name')}}" placeholder="Industry" required>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">SAVE</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#delete_industry').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('route') 
            var modal = $(this)
            modal.find('form').attr("action",recipient);
        })
        $('#edit_industry').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('route')
            var name = button.data('whatever') 
            var modal = $(this)
            modal.find('form').attr("action",recipient);
            modal.find('input#industry_name_edit').val(name)
        })
    })
</script>
@endsection