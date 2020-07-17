@extends('layouts.app')

@section('content')
<style>
html {
  scroll-behavior: smooth;
}
.custom-nav{
    transition: .5s;
    font-size: 1.2em;
}
.custom-nav > a:hover.text-reset.text-decoration-none.px-3.py-2.pt-3 {
    color: teal !important;
    border-bottom: 2px solid teal;
}
.custom-nav > a.text-reset.text-decoration-none.px-3.py-2.pt-3.active {
    color: teal !important;
    border-bottom: 2px solid teal;
}
#content > div {
    padding: 2em 0;
}
.super-text {
    font-size: 1.3em;
    margin: .5em 0;
    text-align: justify;
}
b{
    font-size: 1.1em;
}
b.ignore{
    font-size: 1em;
}
</style>
<div class="d-flex justify-content-center sticky-top bg-light custom-nav shadow-sm" id="nav">
    <a href="#Company" id="ACompany" class="text-reset text-decoration-none px-3 py-2 pt-3 active">Perusahaan</a>
    <a href="#ContactPerson" id="AContactPerson" class="text-reset text-decoration-none px-3 py-2 pt-3">Contact Person</a>
    <a href="#Report" id="AReport" class="text-reset text-decoration-none px-3 py-2 pt-3">Laporan</a>
    <a href="#Offer"  id="AOffer" class="text-reset text-decoration-none px-3 py-2 pt-3">Penawaran</a>
</div>
<div class="container" id="content">
    <div id="Company" class="pt-5">
        <h1>Perusahaan</h1>
        Dapat diakses dengan mengklik tombol <button class="btn btn-dark text-link mx-2" >Perusahaan</button> pada Bar Navigasi
        <h2 class="mt-5">Cara Memasukkan Perusahaan</h2>
        <ol class="px-2">
            <li class="super-text">
                Cek ketersediaan perusahaan, dengan memasukkan nama perusahaan yang ingin di input kedalam kolom yang telah 
                tersedia di bawah tulisan <b>Cek Ketersediaan Perusahaan</b>, pastikan awalan perusahaan(cth: PT. CV.) <b>dipilih menggunakan 
                menu</b> yang telah disediaakan dan bukan di input manual, bila awalan perusahaan yang diinginkan <b>tidak tersedia bisa menghubungi admin</b>
                 . Pastikan juga nama perusahaan yang <b> diinput tidak <i>typo</i> atau salah pengejaan</b>. 
                Kemudian klik tombol &nbsp;<button class="btn btn-success" >Check</button>&nbsp;
            </li>
            <li class="super-text">
                Berikut adalah respon yang mungkin didapat dari sistem :
                <ul>
                    <li class="mb-4">
                        <div class="alert alert-secondary col-10 mt-0 my-1" role="alert">
                            <h5 class="p-0 m-0">Company dengan nama <b class="ignore">NAMA PERUSAHAAN</b> masih belum ada di database</h5>
                        </div>
                        Respon ini berartikan nama perusahaan belum ada di database dan <b>siap untuk diinput</b>. Cara menginput dapat dilihat pada instruksi selanjutnya.
                    </li>
                    <li class="mb-4">
                        <div class="alert alert-success col-10 mt-0 my-1" role="alert">
                            <h5 class="p-0 m-0">Company dengan nama <b class="ignore">NAMA PERUSAHAAN</b> sudah ada di database kamu</h5>
                        </div>
                        Respon ini berartikan nama perusahaan sudah pernah kamu input, sehingga <b>tidak perlu diinput</b> kembali.
                    </li class="mb-4">
                    <li class="mb-4">
                        <div class="alert alert-danger col-10 mt-0 my-1" role="alert">
                            <h5 class="p-0 m-0">Company dengan nama <b class="ignore">NAMA PERUSAHAAN</b> sudah ada di database sales lain, hubungi admin bila ingin memasukkan company kedalam company list</h5>
                        </div>
                        Respon ini berartikan nama perusahaan sudah pernah diinput oleh sales lain, sehingga kita <b>tidak bisa menginput perusahaan</b> yang sama. 
                        Bila memang kamu perlu menggunakan nama perusahaan, <b>kamu dapat menghubungi admin</b>.
                    </li>
                    <li class="mb-4">
                        <div class="alert alert-warning col-10 mt-0 my-1" role="alert">
                            <h5 class="p-0 m-0">Company dengan nama <b class="ignore">NAMA PERUSAHAAN</b> sudah ada di database namun tidak ada sales yang terhubung, klik tombol di bawah untuk menghubungkannya ke dalam company list kamu</h5>
                            <button class="btn btn-primary">Link Company</button>
                        </div>
                        Respon ini berartikan nama perusahaan sudah ada di database, namun tidak berhubungan dengan sales manapun,
                        sehingga kita bisa mengklik <button class="btn btn-primary">Link Company</button>
                        untuk <b>memasukkan perusahaan</b> kedalam list perusahaan kita.
                    </li>
                </ul>
            </li>
            <li class="super-text">
                Input perusahaan, di bawah tulisan <b>Tambahkan Perusahaan</b> terdapat beberapa kolom yang dapat kita isi berikut adalah ketentuan untuk mengisi kolom tersebut :
                <ul>
                    <li class="mb-2">
                        <b>Nama Perusahaan</b> : kalau kita telah mengecek nama perusahaan seperti pada tahap sebelumnya, 
                        kolom ini akan secara otomatis terisi. Tapi, selalu <b> pastikan awalan perusahaan </b> (PT. CV. TOKO) telah terisi dengan benar.
                    </li>
                    <li class="mb-2">
                        <b>Industri Perusahaan</b> : Dapat dipilih dengan menekan 
                        <button type="button" class="btn dropdown-toggle btn-outline-secondary bs-placeholder mx-2" style="width: 12em;" title="Pilih Industri">
                            <span class="text-secondary" style="width: 12em;">Pilih Industri</span>
                        </button> 
                        selanjutnya, pilihlah industri dari perusahaan yang diinput. 
                        Bila pilihan <b>industri tidak ada yang cocok</b> dengan perusahaan, 
                        dapat menghubungi admin untuk menambahkan industri baru pada list industri.
                    </li>
                    <li class="mb-2">
                        <b>Email Perusahaan</b> : Masukkan <b>email perusahaan yang valid</b> (contohnya : Example@gmail.com). 
                        Kolom ini bersifat opsional atau tidak wajib diisi.
                    </li>
                    <li class="mb-2">
                        <b>No.telepon Perusahaan</b> : Masukkan <b>nomor telepon </b> yang valid (dimulai dengan 0 dan tidak +62, contohnya : 08272374871). 
                        Kolom ini bersifat opsional atau tidak wajib diisi.
                    </li>
                    <li class="mb-2">
                        <b>Alamat Perusahaan</b> : Masukkan alamat perusahaan <b>tanpa imbuhan atau awalan seperti (Jalan, Jln. Jl.)</b>.
                    </li>
                </ul>
                Setelah menginput semua data perusahaan kita dapat mengklik <button class="btn btn-primary mx-2">Tambahkan Perusahaan</button> untuk menambahkan perusahaan
            </li>
        </ol>
        <h2 class="mt-5">Melihat List Perusahaan</h2>
        <p class="super-text">
            List perusahaan dapat dilihat di bawah label <b>Company List</b>, terdapat kolom yang dapat diisi untuk mencari perusahaan. 
            bentuk dari tampilan perusahaan adalah sebagai berikut :
        </p>
        <div class="card bg-light mb-3 w-50">
            <div class="card-header d-flex justify-contents-between">
                <b>NAMA PERUSAHAAN</b>
            </div>
            <div class="card-body">
                <p class="card-text">Email : EMAIL PERUSAHAAN</p>
                <p class="card-text">Phone : NO TELEPON PERUSAHAAN</p>
                <p class="card-text">Alamat : ALAMAT PERUSAHAAN</p>
                <p class="card-text">Industri : INDUSTRI PERUSAHAAN</p>
                <div class="d-flex justify-content-between w-100">
                    <button class="btn btn-primary">Lihat PIC</button>
                </div>
            </div>
        </div>
        <p class="super-text mt-3">
            Tombol <button class="btn btn-primary mx-2">Lihat PIC</button> digunakan untuk melihat Contact Person 
            dari perusahaan tersebut. 
            Cara untuk menambahkan dan tampilannnya akan dibahas pada bagian <b>Contact Person</b>.
        </p>
    </div>
    <div id="ContactPerson" class="pt-5">
        <h1>Contact Person</h1>
        Dapat diakses dengan mengklik tombol <button class="btn btn-primary mx-2">Lihat PIC</button> pada perusahaan
        <h2 class="mt-5">Cara Memasukkan PIC / Contact Person</h2>
        <ol class="px-2">
            <li class="super-text">
                Klik tombol <button class="btn btn-info mx-3">Tambahkan kontak</button> untuk memunculkan <b>kolom Menambahkan Kontak</b>
            </li>
            <li class="super-text">
                Berikut adalah kolom yang tersedia dalam menambahkan kontak :
                <ul>
                    <li class="mb-2">
                        <b>Nama</b> : Masukkan <b>Nama</b> PIC dari perusahaan tersebut (contohnya : Pak Karta).
                    </li>
                    <li class="mb-2">
                        <b>Email </b> : Masukkan <b>email yang valid</b> (contohnya : Example@gmail.com).
                    </li>
                    <li class="mb-2">
                        <b>No.telepon </b> : Masukkan <b>nomor telepon </b> yang valid (dimulai dengan 0 dan tidak +62, contohnya : 08272374871).
                    </li>
                </ul>
            </li>
        </ol>
    </div>
    <div id="Report" class="pt-5">
        <h1>Laporan</h1>
        Dapat diakses dengan mengklik tombol <button class="btn btn-dark text-link mx-2" >Laporan</button> pada Bar Navigasi
        <h2 class="mt-5">Cara Memasukkan Laporan</h2>
        <ol class="px-2">
            <li class="super-text">
                Klik tombol 
                <button class="btn btn-primary mx-3">Buat Laporan</button> untuk berpindah ke halaman <b>Tambahkan Laporan</b>
            </li>
            <li class="super-text">
                Berikut adalah kolom yang tersedia dalam menambahkan laporan :
                <ul>
                    <li class="mb-2">
                        <b>Tanggal Laporan</b> : klik simbol kalender pada 
                        <input type="date"> untuk memunculkan kalender untuk memilih tanggal.
                    </li>
                    <li class="mb-2">
                        <b>Perusahaan </b> : klik 
                        <button type="button" class="btn dropdown-toggle btn-outline-secondary bs-placeholder mx-2" style="width: 12em;" title="Pilih Industri">
                            <span class="text-secondary" style="width: 12em;">Pilih Perusahaan</span>
                        </button> untuk memunculkan list perusahaan yang tersedia untuk dipilih, 
                        bila perusahaan pada laporan kita belum tersedia pada list tersebut,
                         kita dapat menambahkan perusahaan terlebih dahulu pada bagian perusahaan.
                    </li>
                    <li class="mb-2">
                        <b>Keteragan </b> : diisi dengan keterangan mengenai laporan kita (cth: telah melakukan kunjungan). minimal memasukkan 3 kata kedalam kolom keterangan.
                    </li>
                    <li class="mb-2">
                        Penawaran bersifat opsional, dan bisa ditambahkan setelah selesai membuat laporan, namun jika ingin menambahkan penawaran secara langsung bersama laporan, 
                        tombol <button class="btn btn-primary mx-3">klik untuk menambahkan penawaran</button> digunakan untuk menambah kolom penawaran yang berisi :
                        <ul>
                            <li class="mb-2">
                                <b>Nama Item</b> : diisi dengan nama barang yang ditawarkan.
                            </li>
                            <li class="mb-2">
                                <b>Qty / Kuantiti</b> : diisi dengan jumlah / kuantiti barang yang ditawarkan
                            </li>
                            <li class="mb-2">
                                <b>Price</b> : diisi dengan harga (satuan) produk, <b>diisi tanpa (Rp dan '.')</b>, '.' akan ditambahkan secara otomatis oleh sistem oleh sistem.
                            </li>
                            <li class="mb-4">
                                <button class="btn btn-danger">Hapus kolom</button> digunakan untuk menghapus kolom penawaran.
                            </li>
                        </ul>
                        <b>NOTE: </b>tombol <button class="btn btn-primary mx-3">klik untuk menambahkan penawaran</button> dapat digunakan untuk menambahkan beberapa kolom penawaran bila penawaran terdapat lebih dari 1 produk.
                    </li>
                </ul>
            </li>
        </ol>
        <h2 class="mt-5">Melihat laporan</h2>
        <p class="super-text"> berikut adalah tampilan halaman laporan bila kita sudah menambahkan laporan :</p>
        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Customer</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hari, DD-MM-YYYY</td>
                    <td> <a href="http://192.168.100.5/WS/companies/19" class="text-dark">Nama Perusahaan</a></td>
                    <td>
                        <button class="btn btn-info">Informasi</button>
                    </td>
                    <td>
                        <span class="badge  badge-secondary  "> - </span>
                    </td>
                    <td><button class="btn btn-success">Detail</button></td>
                </tr>
            </tbody>
        </table>
        <ul>
            <li class="super-text">
                <button class="btn btn-info mx-3">Informasi</button> bila di klik akan memunculkan keterangan yang telah kita masukkan pada laporan
            </li>
            <li class="super-text">
                <span class="badge  badge-secondary  mx-3"> - </span> menunjukkan status laporan. Macam - macam status dapat dilihat <a href="text-link" href="#status">disini</a>
            </li>
            <li class="super-text">
                <button class="btn btn-success mx-3">Detail</button> bila di klik maka kita akan berpindah ke halaman detail laporan, yang berguna untuk meng-edit laporan dan menambahkan penawaran.
            </li>
        </ul>
        <h2 class="mt-5">Meng-edit Laporan</h2>
        <ol class="px-2">
            <li class="super-text">
                Agar kita dapat meng-edit laporan kita harus pergi ke halaman detail terlebih dahulu dengan mengklik <button class="btn btn-success mx-3">Detail</button> pada kolom action
            </li>
            <li class="super-text">
                Lalu klik <button class="btn btn-primary mx-3">Edit Laporan</button> untuk memunculkan kolom untuk mengubah laporan kita.
            </li>
            <li class="super-text">
                Agar kita dapat meng-edit laporan kita harus pergi ke halaman detail terlebih dahulu dengan mengklik <button class="btn btn-success mx-3">Detail</button> pada kolom action
            </li>
            <li class="super-text">
                Berikut adalah kolom yang tersedia jika kita <b> belum </b> menambahkan penawaran :
                <ul>
                    <li class="mb-2">
                        <b>Tanggal Laporan</b> : klik simbol kalender pada 
                        <input type="date"> untuk memunculkan kalender untuk memilih tanggal.
                    </li>
                    <li class="mb-2">
                        <b>Perusahaan </b> : klik 
                        <button type="button" class="btn dropdown-toggle btn-outline-secondary bs-placeholder mx-2" style="width: 12em;" title="Pilih Industri">
                            <span class="text-secondary" style="width: 12em;">Pilih Perusahaan</span>
                        </button> untuk memunculkan list perusahaan yang tersedia untuk dipilih, 
                        bila perusahaan pada laporan kita belum tersedia pada list tersebut,
                         kita dapat menambahkan perusahaan terlebih dahulu pada bagian perusahaan.
                    </li>
                    <li class="mb-2">
                        <b>Keteragan </b> : diisi dengan keterangan mengenai laporan kita (cth: telah melakukan kunjungan). minimal memasukkan 3 kata kedalam kolom keterangan.
                    </li>
                </ul>
            </li>
            <li class="super-text">
                Berikut adalah kolom yang tambahan bila kita <b> telah </b>menambahkan penawaran  :
                <ul>
                    <li class="mb-2">
                        <b>No. Purchase Order</b> : diisi dengan nomor PO bila penawaran sukses.
                    </li>
                    <li class="mb-2">
                        <b>Status </b> : klik 
                        <button type="button" class="btn dropdown-toggle btn-outline-secondary bs-placeholder mx-2" style="width: 8em;" title="Pilih Industri">
                            <span class="text-secondary" style="width: 8em;">
                                <span class="badge badge-secondary">-</span>
                            </span>
                        </button> untuk menganti status menjadi status terbaru. list status beserta artinya dapat diakses <a href="text-link" href="#status">disini</a>
                    </li>
                </ul>
            </li>
            <li class="super-text">
                Setelah selesai mengganti data klik tombol <button class="btn btn-success mx-3">Save</button> untuk menyimpan perubahan.
            </li>
        </ol>
    </div>
    <div id="Offer" class="pt-5">
        <h1>Penawaran</h1>
        Dapat ditambahkan ketika menambahkan laporan, dan diakses dengan mengklik tombol <button class="btn btn-success mx-3">Detail</button> pada kolom action di halaman <b> laporan </b>
        <h2 class="mt-5">Cara Memasukkan Penawaran</h2>
        <ol class="px-2">
            <li class="super-text">
                Pada halaman <b>detail laporan</b> klik tombol <button class="btn btn-primary mx-3">Tambahkan Penawaran</button> untuk memunculkan kolom item penawaran,
                tombol dapat diklik berkali-kali untuk menambah jumlah kolom item.
            </li>
            <li class="super-text">
                Kolom yang tersedia adalah sebagai berikut:
                <ul>
                    <li class="mb-2">
                        <b>Nama Item</b> : diisi dengan nama barang yang ditawarkan.
                    </li>
                    <li class="mb-2">
                        <b>Qty / Kuantiti</b> : diisi dengan jumlah / kuantiti barang yang ditawarkan
                    </li>
                    <li class="mb-2">
                        <b>Price</b> : diisi dengan harga (satuan) produk, <b>diisi tanpa (Rp dan '.')</b>, '.' akan ditambahkan secara otomatis oleh sistem oleh sistem.
                    </li>
                    <li class="mb-4">
                        <button class="btn btn-danger">Hapus kolom</button> digunakan untuk menghapus kolom penawaran.
                    </li>
                </ul>
            </li>
            <li class="super-text">
                Setelah semuanya selesai diisi klik tombol <button class="btn btn-success mx-2">save</button> untuk menambahkan penawaran.
            </li>
            <li class="super-text">
                Setelah membuat penawaran <b>Nomor Penawaran</b> akan dibuat secara otomatis oleh sistem, kita bisa milhatnya pada halaman detail Laporan di bawah tulisan <b>Detail Laporan</b>
            </li>
            <li class="super-text">
                Setelah menambahkan penawaran maka secara otomatis status di laporan akan berubah menjadi 
                <span class="badge  badge-warning ">Waiting</span>. Untuk list lengkap status dapat dilihat <a href="text-link" href="#status">disini</a>
            </li>
            <li class="super-text">
                Secara menambahkan penawaran secara otomatis sistem akan membuat <b>status PPN menjadi Ada PPN </b>, kita dapat menggantinya dengan mengklik tombol 
                <button class="btn btn-warning ml-2">ganti ke non PPN</button>
            </li>
        </ol>
        <h2 class="mt-5">Meng-edit atau menghapus item penawaran</h2>
        <p class="super-text">
            Setelah membuat penawaran, maka penawaran akan terlihat seperti ini:
        </p>
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
                <tr>
                    <th scope="row" style="text-align: left">1</th>
                    <td>NAMA BARANG</td>
                    <td>KUANTITI</td>
                    <td>HARGA SATUAAN</td>
                    <td colspan="3">HARGA TOTAL</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger mb-2" >Hapus</button>
                        <button type="button" class="btn btn-sm btn-primary" >Edit</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: left">2</th>
                    <td>NAMA BARANG</td>
                    <td>KUANTITI</td>
                    <td>HARGA SATUAAN</td>
                    <td colspan="3">HARGA TOTAL</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger mb-2" >Hapus</button>
                        <button type="button" class="btn btn-sm btn-primary" >Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <ul class="px-2">
            <li class="super-text">
                <button type="button" class="btn btn-sm btn-danger mx-2" >Hapus</button>: digunakan menghapus 1 item pada baris tersebut.
            </li>
            <li class="super-text">
                <button type="button" class="btn btn-sm btn-primary mx-2" >Edit</button>: digunakan untuk menampilkan kolom untuk mengubah nilai dalam tabel
            </li>
        </ul>
    </div>
    <div id="Status" class="pt-5">
        <h2 class="mt-5">List status beserta artinya :</h2>
        <ul class="px-2">
            <li class="super-text">
                <span class="badge badge-secondary">-</span> : Berarti Laporan tidak memiliki penawaran
            </li>
            <li class="super-text">
                <span class="badge badge-warning">Waiting</span> : Berartikan Laporan telah memiliki penawaran dan menunggu status untuk di update
            </li>
            <li class="super-text">
                <span class="badge badge-danger">Ditolak</span> : Berartikan Penawaran yang diberikan telah ditolak
            </li>
            <li class="super-text">
                <span class="badge badge-success">PO</span> : Berartikan Penawaran telah disetujui dan sedang proses pembuatan PO
            </li>
        </ul>
     </div>
</div>
<script>
$(document).ready(function() {
    let company = $("#Company")
    let nav = $("#nav")
    let contact_person = $("#ContactPerson")
    let report = $("#Report")
    let offer = $("#Offer")
    let companyRegion = {
        start: company.offset().top,
        end: company.offset().top + company.height()
    }
    let contactPersonRegion = {
        start: contact_person.offset().top,
        end: contact_person.offset().top + contact_person.height()
    }
    let reportRegion = {
        start: report.offset().top,
        end: report.offset().top + report.height()
    }
    let offerRegion = {
        start: offer.offset().top,
        end: offer.offset().top + offer.height()
    }
    function checkIsInRegion(curr,{start, end}){
        return curr >= start && curr <= end
    }
    let currRegion = "company"
    function changeActiveClass(region = "company"){
        if (region != currRegion){
            nav.find(".active").removeClass("active")
            switch (region) {
                case "company": 
                    nav.find("#ACompany").addClass("active") 
                    console.log("Company") 
                    break;
                case "contact_person": 
                    nav.find("#AContactPerson").addClass("active") 
                    console.log("CP") 
                    break;
                case "report": 
                    nav.find("#AReport").addClass("active") 
                    console.log("RPT") 
                    break;
                case "offer": 
                    nav.find("#AOffer").addClass("active") 
                    console.log("OFF") 
                    break;
            }
        }
    }
    $(window).scroll(function(e){
        let curr= window.pageYOffset
        if(checkIsInRegion(curr,companyRegion)){
            changeActiveClass("company")
            currRegion = "company"
        } else if (checkIsInRegion(curr,contactPersonRegion)) {
            changeActiveClass("contact_person")
            currRegion = "contact_person"
        } else if (checkIsInRegion(curr, reportRegion)) {
            changeActiveClass("report")
            currRegion = "report"
        } else if (checkIsInRegion(curr, offerRegion)) {
            changeActiveClass("offer")
            currRegion = "offer"
        }
    })
})
</script>
@endsection
