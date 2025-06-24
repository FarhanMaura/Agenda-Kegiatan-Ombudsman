@extends('admin.layout')

@section('content')
<style>
    h1 {
        font-size: 70px;
        font-weight: 900;
        color: #000;
        text-align: left;
        margin-bottom: 10px;
    }

    h1 span {
        color: #0093d0;
        font-size: 70px;
        font-weight: 900;
    }

    p {
        font-size: 35px;
        font-weight: 700;
        color: #000;
        line-height: 1.6;
        text-align: justify;
        margin-bottom: 20px;
    }

</style>
    <h1>Selamat datang <span>di halaman admin!</span></h1>
    <p>Ini halaman dashboard Admin Agenda Kegiatan.</p>
@endsection
