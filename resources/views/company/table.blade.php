@extends('layouts.app')

@section('content')
<style>
    .table td, .table th{
        vertical-align: middle;
        text-align: left;
    }
</style>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="max-width:50px">No.</th>
      <th scope="col" style="max-width:300px">Nama Perusahaan</th>
      <th scope="col" style="max-width:425px">Alamat</th>
      <th scope="col" style="max-width:180px">Nama PIC</th>
      <th scope="col" style="max-width:140px">No Telephone PIC</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($companies as $company)
    <tr>
      <th scope="row" style="max-width:50px">{{$loop->index + 1}}</th>
      <td style="max-width:300px">{{$company->company_name}}</td>
      <td style="max-width:425px">{{$company->company_address ?? "-"}}</td>
      <td style="max-width:180px">{{$company->ContactPerson[0]->name ?? "-"}}</td>
      <td style="max-width:140px">{{$company->ContactPerson[0]->phone ?? "-"}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection