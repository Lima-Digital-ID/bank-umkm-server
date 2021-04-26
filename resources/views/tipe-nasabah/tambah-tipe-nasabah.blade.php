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
    <form action="{{ route('tipe-nasabah.store') }}" method="POST">
      @csrf
      <label>Tipe Nasabah</label>
      <input type="text" class="form-control {{ $errors->has('tipe') ? ' is-invalid' : '' }}" value="{{ old('tipe') }}" autofocus name="tipe" placeholder="Tipe Nasabah">
      @if ($errors->has('tipe'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('tipe') }}</strong>
          </span>
      @endif

      <br>

      <label>Limit Pinjaman</label>
      <input type="number" class="form-control {{ $errors->has('limit_pinjaman') ? ' is-invalid' : '' }}" value="{{ old('limit_pinjaman') }}" autofocus name="limit_pinjaman" placeholder="Limit Pinjaman">
      @if ($errors->has('limit_pinjaman'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('limit_pinjaman') }}</strong>
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
