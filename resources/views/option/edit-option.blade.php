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
    <form action="{{ route('option.update', $option->id) }}" method="POST">
      @csrf
      @method('PUT')
      <label>Nama Option</label>
      <input type="text" class="form-control {{ $errors->has('option') ? ' is-invalid' : '' }}" value="{{ old('option', $option->option) }}" autofocus name="option" placeholder="Nama Option">
      @if ($errors->has('option'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('option') }}</strong>
          </span>
      @endif

      <br>
      <label>Skor</label>
      <input type="number" class="form-control {{ $errors->has('skor') ? ' is-invalid' : '' }}" value="{{ old('skor', $option->skor) }}" autofocus name="skor" placeholder="Nama Option">
      @if ($errors->has('skor'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('skor') }}</strong>
          </span>
      @endif

      <br>

      <label>Kriteria</label>
      <select name="id_kriteria" id="id_kriteria" class="form-control select2 {{ $errors->has('id_kriteria') ? ' is-invalid' : '' }}">
        <option value="">- Pilih Kategori -</option>
        @foreach ($kriteria as $item)
            <option value="{{$item->id}}" {{$item->id == old('id_kriteria', $option->id_kriteria) ? 'selected' : ''}}>{{$item->nama_kriteria}}</option>
        @endforeach
      </select>
      @if ($errors->has('id_kriteria'))
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
