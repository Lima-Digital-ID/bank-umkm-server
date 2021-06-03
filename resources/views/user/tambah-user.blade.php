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
    <form action="{{ route('user.store') }}" method="POST">
      @csrf
      <label>Nama</label>
      <input type="text" class="form-control {{ $errors->has('nama') ? ' is-invalid' : '' }}" value="{{ old('nama') }}" autofocus name="nama" placeholder="Nama User">
      @if ($errors->has('nama'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('nama') }}</strong>
          </span>
      @endif

      <br>

      <label>Username</label>
      <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}" autofocus name="username" placeholder="Username">
      @if ($errors->has('username'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('username') }}</strong>
          </span>
      @endif

      <br>

      <label>Email</label>
      <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" placeholder="Email">
      @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
          </span>
      @endif
        <br>
      <label for="">Level</label>
      <br>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Administrator" value="Administrator" {{ old('level') == 'Administrator' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Administrator">Administrator</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Verificator" value="Verificator" {{ old('level') == 'Verificator' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Verificator">Verificator</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input {{ $errors->has('level') ? ' is-invalid' : '' }}" type="radio" name="level" id="Pencairan" value="Pencairan" {{ old('level') == 'Pencairan' ? 'checked' : '' }}>
        <label class="form-check-label {{ $errors->has('level') ? ' is-invalid' : '' }}" for="Pencairan">Pencairan</label>
      </div>
      @if ($errors->has('level'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('level') }}</strong>
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
