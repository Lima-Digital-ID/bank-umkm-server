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
    <form action="{{ route('user.update', $user->id) }}" method="POST">
      @csrf
      @method('PUT')
      <label>Nama</label>
      <input type="text" class="form-control {{ $errors->has('nama') ? ' is-invalid' : '' }}" value="{{ old('nama', $user->nama) }}" autofocus name="nama" placeholder="ex : Anthony Davis">
      @if ($errors->has('nama'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('nama') }}</strong>
          </span>
      @endif

      <br>

      <label>Username</label>
      <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username', $user->username) }}" autofocus name="username" placeholder="ex : Anthony Davis">
      @if ($errors->has('username'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('username') }}</strong>
          </span>
      @endif

      <br>

      <label>Email</label>
      <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $user->email) }}" name="email" placeholder="ex : anthonydavis@mail.test">
      @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
          </span>
      @endif

      <br>

      <br>
      <label for="">Level</label>
      <br>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Administrator" value="Administrator" {{ old('level', $user->level) == 'Administrator' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Administrator">Administrator</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Verificator" value="Verificator" {{ old('level', $user->level) == 'Verificator' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Verificator">Verificator</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Pencairan" value="Pencairan" {{ old('level', $user->level) == 'Pencairan' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Pencairan">Pencairan</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Survei" value="Survei" {{ old('level', $user->level) == 'Survei' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Survei">Survei</label>
      </div>
      @if ($errors->has('level'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('level') }}</strong>
          </span>
      @endif
      <br>

        <br>
        <label for="">Kantor Cabang</label>
        <select name="id_kantor_cabang" id="id_kantor_cabang" class="form-control select2 {{ $errors->has('id_kantor_cabang') ? ' is-invalid' : '' }}">
            <option value="">--Pilih Kantor Cabang--</option>
            @foreach ($kantorCabang as $item)
                <option value="{{$item->id}}" {{old('id_kantor_cabang', $user->id_kantor_cabang) == $item->id ? 'selected' : ''}} >{{$item->kecamatan->nama}}</option>
            @endforeach
        </select>
        @if ($errors->has('id_kantor_cabang'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('id_kantor_cabang') }}</strong>
            </span>
        @endif

      <div class="mt-4">
          <button type="reset" class="btn btn-default"> <span class="fa fa-times"></span> Cancel</button>
          &nbsp;
          <button type="submit" class="btn btn-primary"> <span class="fa fa-save"></span> Save</button>
      </div>
    </form>
  </div>
</div>
@endsection
