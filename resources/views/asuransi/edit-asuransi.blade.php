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
    <form action="{{ route('asuransi-pinjaman.update', $asuransiPinjaman->id) }}" method="POST">
      @csrf
      @method('PUT')
      <label>Jumlah Asuransi Pinjaman</label>
      <input type="number" class="form-control {{ $errors->has('jumlah_asuransi') ? ' is-invalid' : '' }}" value="{{ old('jumlah_asuransi', $asuransiPinjaman->jumlah_asuransi) }}" autofocus name="jumlah_asuransi" placeholder="ex : Anthony Davis">
      @if ($errors->has('jumlah_asuransi'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('jumlah_asuransi') }}</strong>
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
