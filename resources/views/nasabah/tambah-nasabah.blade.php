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
    <form action="{{ route('nasabah.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label>Nama</label>
      <input type="text" class="form-control {{ $errors->has('nama') ? ' is-invalid' : '' }}" value="{{ old('nama') }}" autofocus name="nama" placeholder="Nama Nasabah">
      @if ($errors->has('nama'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('nama') }}</strong>
          </span>
      @endif

      <br>
      
      <label>Tanggal Lahir</label>
      <input type="text" class="form-control datepicker {{ $errors->has('tanggal_lahir') ? ' is-invalid' : '' }}" value="{{ old('tanggal_lahir') }}" name="tanggal_lahir" placeholder="Tanggal Lahir" autocomplete="off">
      @if ($errors->has('tanggal_lahir'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('tanggal_lahir') }}</strong>
          </span>
      @endif

      <br>

      <label for="">Jenis Kelamin</label>
      <br>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" type="radio" name="jenis_kelamin" id="Laki-laki" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" for="Laki-laki">Laki-laki</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('jenis_kelamin') ? ' is-invalid' : '' }}" for="Perempuan">Perempuan</label>
      </div>
      @if ($errors->has('jenis_kelamin'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('jenis_kelamin') }}</strong>
          </span>
      @endif
      <br>
      <br>

      <label>NIK</label>
      <input type="text" class="form-control {{ $errors->has('nik') ? ' is-invalid' : '' }}" value="{{ old('nik') }}" name="nik" placeholder="NIK">
      @if ($errors->has('nik'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('nik') }}</strong>
          </span>
      @endif

      <br>

      <label>No Handphone</label>
      <input type="number" class="form-control {{ $errors->has('no_hp') ? ' is-invalid' : '' }}" value="{{ old('no_hp') }}" name="no_hp" placeholder="No Handphone">
      @if ($errors->has('no_hp'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('no_hp') }}</strong>
          </span>
      @endif

      <br>

      <label>Email</label>
      <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" placeholder="ex : anthonydavis@mail.com">
      @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
          </span>
      @endif

      <br>

      <label>Alamat</label>
      <textarea name="alamat" class="form-control {{ $errors->has('alamat') ? ' is-invalid' : '' }}" value="{{ old('alamat') }}">{{ old('alamat') }}</textarea>
      @if ($errors->has('alamat'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('alamat') }}</strong>
          </span>
      @endif

      <br>
      <label for="">Tipe Nasabah</label>
      <select name="id_tipe" id="id_tipe" class="form-control select2 {{ $errors->has('id_tipe') ? ' is-invalid' : '' }}">
        <option value="">- Pilih Tipe -</option>
        @foreach ($tipeNasabah as $item)
            <option value="{{$item->id}}" {{$item->id == old('id_tipe') ? 'selected' : ''}}>{{$item->tipe}}</option>
        @endforeach
      </select>
      @if ($errors->has('id_tipe'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('id_tipe') }}</strong>
          </span>
      @endif

      <br>
      <br>
      <label>Scan Ktp</label>
      <input class="form-control" type="file" name="scan_ktp" id="scan_ktp">
      @if ($errors->has('scan_ktp'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('scan_ktp') }}</strong>
          </span>
      @endif

      <br>
      <label>Selfie Dengan Ktp</label>
      <input class="form-control" type="file" name="foto_dengan_ktp" id="foto_dengan_ktp">
      @if ($errors->has('foto_dengan_ktp'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('foto_dengan_ktp') }}</strong>
          </span>
      @endif

      <br>
      
      <label>Scan NPWP</label>
      <input class="form-control" type="file" name="npwp" id="npwp">
      @if ($errors->has('npwp'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('npwp') }}</strong>
          </span>
      @endif

      <br>

      <label>Scan Surat Nikah</label>
      <input class="form-control" type="file" name="surat_nikah" id="surat_nikah">
      @if ($errors->has('surat_nikah'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('surat_nikah') }}</strong>
          </span>
      @endif

      <br>
      
      <label>Scan Surat Domisili Usaha</label>
      <input class="form-control" type="file" name="surat_domisili_usaha" id="surat_domisili_usaha">
      @if ($errors->has('surat_domisili_usaha'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('surat_domisili_usaha') }}</strong>
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
