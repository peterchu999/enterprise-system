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
        <div class="col-10">
            <h2 class="">Check Ketersediaan Perusahaan</h2>
        </div>
        <div class="col-10 mb-3">
            <form class="row mb-3" action="{{route('Company.check')}}" method="post">
                @csrf
            <div class="col-10">
                <label for="company_name_check">Nama Perusahaan</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select name="company_prefix" id="">
                            <option value="PT.">PT.</option>
                            <option value="CV.">CV.</option>
                            <option value="TOKO">TOKO</option>
                            <option value="BPK">BPK</option>
                            <option value="IBU">IBU</option>
                        </select>
                    </div>
                    <input type="text" id="company_name_check" name="company_name_check" class="form-control" placeholder="Nama Perusahaan" value="{{old('company_name_check')}}" required>
                </div>
            </div>
            <div class="col-2 d-flex align-items-end">
                <button class="btn btn-success " type="submit">Check</button>
            </div>
            </form>
            @if(Session::get('check_company') == null)
            @elseif(Session::get('check_company') == "NON")
            <div class="alert alert-secondary col-10" role="alert">
                <h4 class="p-0">Company dengan nama <b>{{Session::get('req_company_prefix')." ".Session::get('req_company_name')}}</b> masih belum ada di database</h4>
            </div>
            @elseif(Session::get('check_company')->sales_id == null)
            <div class="alert alert-warning col-10" role="alert">
                <h4 class="p-0">Company dengan nama <b>{{Session::get('req_company_prefix')." ".Session::get('req_company_name')}}</b> sudah ada di database namun tidak ada sales yang terhubung, klik tombol di bawah untuk menghubungkannya ke dalam company list kamu</h4>
                <form action="{{Session::get('url_link')}}" method="POST">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="company_name" value="{{Session::get('req_company_prefix')." ".Session::get('check_company')->company_name}}" >
                    <button type="submit" class="btn btn-primary">Link Company</button>
                </form>
            </div>
            @elseif(Session::get('check_company')->sales_id == Auth::user()->id)
            <div class="alert alert-success col-10" role="alert">
                <h4>Company dengan nama <b>{{Session::get('req_company_prefix')." ".Session::get('req_company_name')}}</b> sudah ada di database kamu</h4>
            </div>
            @elseif(Session::get('check_company')->sales_id != null)
            <div class="alert alert-danger col-10" role="alert">
                <h4>Company dengan nama <b>{{Session::get('req_company_prefix')." ".Session::get('req_company_name')}}</b> sudah ada di database sales lain, hubungi admin bila ingin memasukkan company kedalam company list</h4>
            </div>
            @endif
            @if($message = Session::get('success_link'))
            <div class="alert alert-success col-10" role="alert">
                <h4 class="my-0 py-0">{{$message}}</h4>
            </div>
            @elseif($message = Session::get('failed_link'))
            <div class="alert alert-danger col-10" role="alert">
                <h4 class="my-0 py-0">{{$message}}</h4>
            </div>
            @endif
        </div>
        <hr class="col-12 mb-3">
        <div class="col-10">
            <h2>Tambahkan Perusahaan</h2>
        </div>
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
        <form class="col-10" action="{{ route('Company.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="company_name">Nama Perusahaan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="company_prefix" id="">
                                @if(Session::get('check_company') == "NON" && $selected = Session::get('req_company_prefix'))
                                    <option value="PT." @if($selected == "PT.") selected @endif>PT.</option>
                                    <option value="CV." @if($selected == "CV.") selected @endif>CV.</option>
                                    <option value="TOKO" @if($selected == "TOKO") selected @endif>TOKO</option>
                                    <option value="BPK" @if($selected == "BPK") selected @endif>BPK</option>
                                    <option value="IBU" @if($selected == "IBU") selected @endif>IBU</option>
                                @else
                                    <option value="PT.">PT.</option>
                                    <option value="CV.">CV.</option>
                                    <option value="TOKO">TOKO</option>
                                    <option value="BPK">BPK</option>
                                    <option value="IBU">IBU</option>
                                @endif
                            </select>
                        </div>
                        @if(Session::get('check_company') == "NON")
                            <input type="text" id="company_name" name="company_name" class="form-control is-valid" placeholder="Nama Perusahaan" value="{{Session::get('req_company_name')}}" required>
                        @else
                            <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Nama Perusahaan" value="{{old('company_name')}}" required readonly>
                        @endif  
                    </div> 
                </div>
                {{-- {{dd($industries)}} --}}
                <div class="col">
                    <label for="company_industry">Industri Perusahaan</label>
                    <select value="{{old('company_industry')}}" name="company_industry" id="company_industry" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                        <option value="" data-content="<span class='text-secondary'>Pilih Industri</span>" disabled selected>Pilih Industri</option>
                        @foreach ($industries as $industry)
                            <option data-tokens="{{$industry->name}}" data-content="<span class='text-dark myapps'>{{$industry->name}}</span>" value="{{$industry->id}}" @if(old('company_industry') == $industry->id) selected @endif>{{$industry->name}}</option>
                        @endforeach
                      </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="company_email">Email Perusahaan</label>
                    <input type="email" id="company_email" name="company_email" class="form-control" value="{{old('company_email')}}" placeholder="Email Perusahaan">
                </div>
                <div class="col">
                    <label for="company_tel">No.telepon Perusahaan</label>
                    <input type="tel" id="company_tel" name="company_tel" class="form-control" value="{{old('company_tel')}}" placeholder="no telepon perusahaan" pattern="[0-9]{10,14}" >
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="company_address">Alamat Perusahaan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">JL.</div>
                        </div>
                        <input type="text" id="company_address" name="company_address" class="form-control" value="{{old('company_address')}}" placeholder="Alamat Perusahaan">
                    </div>
                </div>
            </div>
            <div class="col d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Tambahkan Perusahaan</button>
            </div>
        </form>
        <hr class="col-12">
        <h2 class="col-10">Company List</h2>
        <div class="col-8" id="search-bar"></div>
        <div class="col-10">
            <div class="input-group my-3">
                <input type="text" id="search-bar" class="form-control" placeholder="Masukkan pencarian" aria-label="Masukkan pencarian" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button">Search</button>
                </div>
            </div>
            <div class="row container-company-card">
                
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->role == "admin")
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Menghapus perusahaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('Company.destroy','xyz') }}}}" method="POST">
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
  <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit perusahaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('Company.destroy','xyz') }}}}" method="POST">
            @method('patch')
            @csrf
            <input type="hidden" name="id" id="id_hidden" value="">
            <div class="modal-body">
              <div class="row mb-3">
                  <div class="col">
                      <label for="company_name">Nama Perusahaan</label>
                      <input type="text" id="company_name_edit" name="company_name" class="form-control" placeholder="Nama Perusahaan" value="{{old('company_name')}}" required>
                  </div>
                  <div class="col">
                      <label for="company_industry">Industri Perusahaan</label>
                      <select value="{{old('company_industry')}}" name="company_industry" id="company_industry_edit" class="selectpicker form-control" data-live-search="true" data-style="btn-outline-secondary">
                        <option value="" data-content="<span class='text-secondary'>Pilih Industri</span>" disabled selected>Pilih Industri</option>
                        @foreach ($industries as $industry)
                            <option data-tokens="{{$industry->name}}" data-content="<span class='text-dark myapps'>{{$industry->name}}</span>" value="{{$industry->id}}" @if(old('company_industry') == $industry->id) selected @endif>{{$industry->name}}</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col">
                      <label for="company_email">Email Perusahaan</label>
                      <input type="email" id="company_email_edit" name="company_email" class="form-control" value="{{old('company_email')}}" placeholder="Email Perusahaan">
                  </div>
                  <div class="col">
                      <label for="company_tel">No.telepon Perusahaan</label>
                      <input type="tel" id="company_tel_edit" name="company_tel" class="form-control" value="{{old('company_tel')}}" placeholder="no telepon perusahaan" pattern="[0-9]{10,14}">
                  </div>
              </div>
              <div class="row mb-3">
                  <div class="col">
                      <label for="company_address">Alamat Perusahaan</label>
                      <input type="text" id="company_address_edit" name="company_address" class="form-control" value="{{old('company_address')}}" placeholder="Alamat Perusahaan" >
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
<script>
    let templateGenerator = (obj) => `
        <div class="col-6">
            <div class="card bg-light mb-5 mx-auto">
                <div class="card-header d-flex justify-contents-between">
                    <b>${obj.company_name}</b>
                </div>
                <div class="card-body">
                    <p class="card-text">Email : ${obj.company_email ?? "-"}</p>
                    <p class="card-text">Phone : ${obj.company_tel ?? "-"}</p>
                    <p class="card-text">Alamat : ${obj.company_address}</p>
                    <p class="card-text">Industri : ${obj.industry == null  ? "-" : obj.industry.name}</p>
                    <div class="d-flex justify-content-between w-100">
                        <a class="btn btn-primary" href="${baseRoute+'/'+obj.id}">Lihat PIC</a>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit" data-whatever='${JSON.stringify(obj)}'>Edit</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete" data-whatever='${JSON.stringify(obj)}'>Delete</button>
                    </div>
                </div>
            </div>
        </div>
    `
</script>
@else
<script>
    let templateGenerator = (obj) => `
        <div class="col-6">
            <div class="card bg-light mb-5 mx-auto">
                <div class="card-header d-flex justify-contents-between">
                    <b>${obj.company_name}</b>
                </div>
                <div class="card-body">
                    <p class="card-text">Email : ${obj.company_email ?? "-"}</p>
                    <p class="card-text">Phone : ${obj.company_tel ?? "-"}</p>
                    <p class="card-text">Alamat : ${obj.company_address}</p>
                    <p class="card-text">Industri : ${obj.industry == null  ? "-" : obj.industry.name}</p>
                    <div class="d-flex justify-content-between w-100">
                        <a class="btn btn-primary" href="${baseRoute+'/'+obj.id}">Lihat PIC</a>
                    </div>
                </div>
            </div>
        </div>
    `
</script>
@endif
<script>
    let datas = @json($companies);
    let timeout = setTimeout(()=>{},1);
    console.log(datas);
    let Cardcontainer =  document.querySelector('div.container-company-card')
    let baseRoute = window.location.href
    
    let generateCard =  (datas, template, query = "", container) => {
        console.log('called');
        let stringHTML = ""
        let i = 0
        datas.forEach(data => {
            let flag = false
            for (const attr in data) {
                if(String(data[attr]).toUpperCase().includes(query.toUpperCase())) {
                    flag = true;
                    break;
                }
            }
            if (data.industry != null && data.industry.name.includes(query.toUpperCase())){
                flag = true;
            }
            if(flag) {
                stringHTML += template(data);
            }
            i++;
        })
        container.innerHTML = stringHTML.length < 2 ? '<h1 class="mx-auto mt-3">Hasil Tidak ditemukan</h1>' : stringHTML
    }

    $('input#search-bar').on('input',function(){
        let spinner = document.querySelector('div.w-100#spinnerXUHD')
        if(spinner == null) {
            spinner = document.createElement('div')
            spinner.classList.add('w-100');
            spinner.classList.add('my-3');
            spinner.id = "spinnerXUHD"
            spinner.innerHTML = `<div class="spinner-border d-block mx-auto my-3" role="status">
                                        <span class="sr-only ">Loading...</span>
                                    </div>`
            Cardcontainer.prepend(spinner)
        }
        inputValue = this.value
        clearTimeout(timeout);
        timeout = setTimeout(function(){
            generateCard(datas, templateGenerator, inputValue, Cardcontainer)
        },800);
    })

    generateCard(datas,templateGenerator, "",Cardcontainer)
</script>
@if (Auth::user()->role == "admin")
<script>
$(document).ready(function(){
        // delete modal
        $('#delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever')
            var modal = $(this)
            modal.find('.modal-message').html('Apakah kamu yakin untuk menghapus <b>' + recipient.company_name + '</b> ?')
            modal.find('form').attr('action',(index,value) => {
                return baseRoute+'/'+recipient.id
            })
        })

        //edit modal
        $('#edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var obj = button.data('whatever')
            var modal = $(this)
            modal.find('input#id_hidden').val(obj.id)
            modal.find('input#company_name_edit').val(obj.company_name)
            modal.find('input#company_email_edit').val(obj.company_email)
            modal.find('input#company_tel_edit').val(obj.company_tel)
            modal.find('input#company_address_edit').val(obj.company_address)
            modal.find('.modal-title').html('Edit perusahaan <b>' + obj.company_name + '</b> ?')
            modal.find('select#company_industry_edit').val(obj.company_industry)
            let option = modal.find('select').find('option').filter(function(){
                return $(this).val() == obj.company_industry;
            })[0]
            modal.find('div.filter-option-inner-inner').html($(option).data('content'))
            modal.find('form').attr('action',(index,value) => {
                return baseRoute+'/'+obj.id
            })
        })
    });
    $.fn.selectpicker.Constructor.BootstrapVersion = '4';
    $('select#company_industry').selectpicker();
    $('select#company_industry_edit').selectpicker();
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
    setBootstrapSelect('select#company_industry');
    setBootstrapSelect('select#company_industry_edit');
</script>
@endif
<script>
        $.fn.selectpicker.Constructor.BootstrapVersion = '4';
    $('select#company_industry').selectpicker();
    $('select#company_industry_edit').selectpicker();
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
    setBootstrapSelect('select#company_industry');
    setBootstrapSelect('select#company_industry_edit');
</script>
@endsection