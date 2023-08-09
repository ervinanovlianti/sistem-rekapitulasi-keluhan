@extends('layouts.main')
@section('content')
<div class="row">
  <div class="row justify-content-center">
    <div class="col-12">
      <h3 class="page-title">Detail Keluhan {{ $keluhan->id_keluhan }}</h3>
      @if (Session::has('success'))
      <div class="alert alert-success">
        {{ Session::get('success') }}
      </div>
      @endif
      @if (Session::has('error'))
      <div class="alert alert-danger">
        {{ Session::get('error') }}
      </div>
      @endif
      @if ( Auth::user()->hak_akses == 'admin' && $keluhan->status_keluhan == 'menunggu verifikasi')
      <div class="row">
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Nama Pelapor : {{ $keluhan->nama }}</p>
              <p>Costumer : {{ $keluhan->jenis_pengguna }}</p>
              <p>Tanggal Laporan : {{ date('d/m/Y H:i:s', strtotime($keluhan->tgl_keluhan)) }}</p>
              <p>Via Laporan : {{ $keluhan->via_keluhan }}</p>
              @if ($keluhan->gambar)
              <p>Gambar : <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#gambarModal{{ $keluhan->id }}">Lihat</button>
              </p>
              @endif
            </div>
          </div>
        </div>
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan : <strong>{{ $keluhan->uraian_keluhan }}</strong> </p>
              <p>Kategori : {{ $keluhan->kategori_keluhan }}</p>
              <p>Status Keluhan : {{ $keluhan->status_keluhan }}</p>
              {{-- <p>Aksi : {{ $keluhan->aksi }}</p> --}}
              <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a>
              {{-- <a href="" class="btn btn-danger m-auto">Tolak</a> --}}
              <button type="button" class="btn btn-success m-auto" data-toggle="modal" data-target="#verifikasiModal" data-whatever="@mdo">Verifikasi</button>
            </div>
          </div>
        </div>
      </div>
      @elseif ( Auth::user()->hak_akses == 'customer_service' && $keluhan->status_keluhan == 'dialihkan ke cs')
      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Nama Pelapor : {{ $keluhan->nama }}</p>
              <p>Costumer : {{ $keluhan->jenis_pengguna }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan : {{ $keluhan->via_keluhan }}</p>
              @if ($keluhan->gambar)
              <p>Gambar : <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#gambarModal{{ $keluhan->id }}">Lihat</button>
              </p>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan : <strong>{{ $keluhan->uraian_keluhan }}</strong> </p>
              <p>Kategori : {{ $keluhan->kategori_keluhan }}</p>
              <p>Status : {{ $keluhan->status_keluhan }}</p>
              <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a>
              <a href="/terima-keluhan/{{ $keluhan->id_keluhan }}" class="btn btn-success m-auto">Terima</a>
            </div>
          </div>
        </div>
      </div>
      @elseif ( Auth::user()->hak_akses == 'customer_service' && $keluhan->status_keluhan == 'ditangani oleh cs')
      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Nama Pelapor : {{ $keluhan->nama }}</p>
              <p>Costumer : {{ $keluhan->jenis_pengguna }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan : {{ $keluhan->via_keluhan }}</p>
              @if ($keluhan->gambar)
              <p>Gambar : <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#gambarModal{{ $keluhan->id }}">Lihat</button>
              </p>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan : <strong>{{ $keluhan->uraian_keluhan }}</strong></p>
              <p>Kategori : {{ $keluhan->kategori_keluhan }}</p>
              <p>Penangungjawab : {{ $namaCS->nama }}</p>
              <p>Status : {{ $keluhan->status_keluhan }}</p>
              {{-- <p>Aksi : {{ $keluhan->aksi }}</p> --}}
              <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a>
              <button type="button" class="btn btn-success m-auto" data-toggle="modal" data-target="#konfirmasiModal" data-whatever="@mdo">Konfirmasi</button>
            </div>
          </div>
        </div>
      </div>
      @elseif(Auth::user()->hak_akses == 'admin' && $keluhan->status_keluhan == 'ditangani oleh cs' || 'dialihkan ke cs'
      || 'selesai')
      <div class="row">
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Nama Pelapor : {{ $keluhan->nama }}</p>
              <p>Costumer : {{ $keluhan->jenis_pengguna }}</p>
              <p>Tanggal Laporan : {{ $keluhan->tgl_keluhan }}</p>
              <p>Via Laporan : {{ $keluhan->via_keluhan }}</p>
              @if ($keluhan->gambar)
              <p>Gambar : <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#gambarModal{{ $keluhan->id }}">Lihat</button>
              </p>
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <p>Uraian Keluhan : <strong> {{ $keluhan->uraian_keluhan }}</strong></p>
              <p>Kategori : {{ $keluhan->kategori_keluhan }}</p>
              <p>Penangungjawab : {{ $namaCS->nama }}</p>
              <p>Status : {{ $keluhan->status_keluhan }}</p>
              @if (!empty($keluhan->waktu_penyelesaian))
              <p>Waktu Penyelesaian : {{ $keluhan->waktu_penyelesaian }}</p>
              @endif
              @if (!empty($keluhan->aksi))
                <p>Aksi : {{ $keluhan->aksi }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>

    {{-- Modal Lihat Gambar --}}
    <div class="modal fade" id="gambarModal{{ $keluhan->id }}" tabindex="-1" role="dialog" aria-labelledby="gambarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gambarModalLabel">Gambar Keluhan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                @if ($keluhan->gambar)
                  <img src="{{ asset('gambar_keluhan/' . $keluhan->gambar) }}" alt="Gambar Keluhan" style="max-width: 100%; height: auto;">
                @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Verifkasi --}}
    <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Keluhan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Kembali">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="/verifikasi-keluhan">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                <label for="example-select"></label>
                <select class="form-control" id="example-select" name="penanggungjawab">
                  <option selected>--Pilih--</option>
                  @foreach ($cs as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Kembali</button>
              <button type="submit" class="btn mb-2 btn-success">Verifikasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="varyModalLabel">New message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Kembali">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" action="/konfirmasi-selesai">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                <label for="message-text" class="col-form-label">Keterangan Aksi Penyelesaian:</label>
                <textarea class="form-control" name="aksi"></textarea>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Kembali</button>
              <button type="submit" class="btn mb-2 btn-success">Konfirmasi</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection