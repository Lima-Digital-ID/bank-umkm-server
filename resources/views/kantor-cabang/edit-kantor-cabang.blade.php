@extends('template')
@section('container')

<div class="card shadow py-2">
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <a href="{{$btnRight['link']}}" class="btn btn-primary mb-3"> <span class="fa fa-arrow-alt-circle-left"></span> {{$btnRight['text']}}</a>
        <hr>
        <form action="{{ route('kantor-cabang.update', $kantorCabang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="">Kecamatan</label>
            <label for="">Saat ini : {{ $kantorCabang->nama_kecamatan }}</label>
            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2 {{ $errors->has('id_kecamatan') ? ' is-invalid' : '' }}">
                <option value="0">--Pilih disini untuk mengganti--</option>
                @foreach ($kecamatan as $item)
                    <option value="{{$item->id}}" {{old('id_kecamatan') == $item->id ? 'selected' : ''}} >{{ $item->nama_kabupaten }} - Kec. {{$item->nama}}</option>
                @endforeach
            </select>
            @if ($errors->has('id_kecamatan'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('id_kecamatan') }}</strong>
                </span>
            @endif
            <br>

            <br>
            <label>Nama Kantor Cabang</label>
            <input type="text" class="form-control {{ $errors->has('nama') ? ' is-invalid' : '' }}" value="{{ old('nama', $kantorCabang->nama) }}" autofocus name="nama" placeholder="ex : Nama Kantor Cabang">
            @if ($errors->has('nama'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama') }}</strong>
                </span>
            @endif

            <br>

            <label>Alamat Kantor Cabang</label>
            <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control">{{ $kantorCabang->alamat }}</textarea>
            @if ($errors->has('alamat'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('alamat') }}</strong>
                </span>
            @endif

            <br>

            <label>No. Telp.</label>
            <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone', $kantorCabang->phone) }}" autofocus name="phone" placeholder="ex : 08186712xxxx">
            @if ($errors->has('phone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif

            <br>

            <div class="mt-4">
                <button type="reset" class="btn btn-default"> <span class="fa fa-times"></span> Cancel</button>
                &nbsp;
                <button type="submit" class="btn btn-primary"> <span class="fa fa-save"></span> Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
