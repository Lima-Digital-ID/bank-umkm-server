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
    <form action="{{ route('kriteria.store') }}" method="POST">
      @csrf
      <label>Nama Kriteria</label>
      <input type="text" class="form-control {{ $errors->has('nama_kriteria') ? ' is-invalid' : '' }}" value="{{ old('nama_kriteria') }}" autofocus name="nama_kriteria" placeholder="Nama Kriteria">
      @if ($errors->has('nama_kriteria'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('nama_kriteria') }}</strong>
          </span>
      @endif

      <br>

      <label>Kategori Kriteria</label>
      <select name="id_kategori" id="id_kategori" class="form-control select2 {{ $errors->has('id_kategori') ? ' is-invalid' : '' }}">
        <option value="">- Pilih Kategori -</option>
        @foreach ($kategoriKriteria as $item)
            <option value="{{$item->id}}" {{$item->id == old('id_kategori') ? 'selected' : ''}}>{{$item->nama_kategori}}</option>
        @endforeach
      </select>
      @if ($errors->has('id_kategori'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('nama_kriteria') }}</strong>
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
