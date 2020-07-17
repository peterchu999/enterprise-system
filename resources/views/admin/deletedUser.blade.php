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
        <h1 class="m-2 col">Restore Deleted User</h1>
    </div>
    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th scope="col" style="text-align: left">No</th>
            <th scope="col">Nama Sales</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($users as $sales)
            @if($sales->role != "admin")
            <tr>
                <th scope="row" style="text-align: left">{{ $loop->index + 1 }}</th>
                <td>{{$sales->name}}</td>
                <td>{{$sales->email}}</td>
                <td> 
                    <form action="{{route('Admin.restore', $sales->id)}}" method="POST">
                        @csrf
                        @method('patch')
                        <button type="submit" class="btn btn-success">Restore Access</button>
                    </form>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection