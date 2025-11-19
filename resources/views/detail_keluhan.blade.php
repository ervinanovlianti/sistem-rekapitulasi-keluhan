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
      <div class="row">
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Nama Pelapor</th>
                    <td>{{ $keluhan->nama }}</td>
                  </tr>
                  <tr>
                    <th>Customer</th>
                    <td>{{ $keluhan->jenis_pengguna }}</td>
                  </tr>
                  <tr>
                    <th>Tanggal Laporan</th>
                    <td>{{ $keluhan->tgl_keluhan }}</td>
                  </tr>
                  <tr>
                    <th>Via Laporan</th>
                    <td>{{ $keluhan->via_keluhan }}</td>
                  </tr>
                  @if ($keluhan->gambar)
                  <tr>
                    <th>Gambar</th>
                    <td>
                      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                        data-target="#gambarModal{{ $keluhan->id }}">Lihat</button>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-6 my-2">
          <div class="card shadow">
            <div class="card-body">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Uraian Keluhan</th>
                    <td>{{ $keluhan->uraian_keluhan }}</td>
                  </tr>
                  <tr>
                    <th>Kategori</th>
                    <td>{{ $keluhan->kategori_keluhan }}</td>
                  </tr>
                  <tr>
                    <th>Status Keluhan</th>
                    <td>{{ $keluhan->status_keluhan }}</td>
                  </tr>
                  @if ($keluhan->waktu_penyelesaian)
                  <tr>
                    <th>Waktu Penyelesaian</th>
                    <td>{{ $keluhan->waktu_penyelesaian }}</td>
                  </tr>
                  @endif
                  @if ($keluhan->aksi)
                  <tr>
                    <th>Aksi</th>
                    <td>{{ $keluhan->aksi }}</td>
                  </tr>
                  @endif
                  <tr>
                    @if ( Auth::user()->hak_akses == 'admin' && $keluhan->status_keluhan == 'menunggu verifikasi')
                    <th>Action</th>
                    <td>
                      <a href="/keluhan" class="btn btn-sm btn-secondary m-auto">Kembali</a>
                      {{-- <a href="" class="btn btn-danger m-auto">Tolak</a> --}}
                      <button type="button" class="btn btn-sm btn-success m-auto" data-toggle="modal"
                        data-target="#verifikasiModal" data-whatever="@mdo">Verifikasi</button>
                    </td>
                    @elseif ( Auth::user()->hak_akses == 'customer_service' && $keluhan->status_keluhan == 'dialihkan ke cs')
                    <th>Action</th>
                    <td>
                      <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a>
                      <a href="/terima-keluhan/{{ $keluhan->id_keluhan }}" class="btn btn-success m-auto">Terima</a>
                    </td>
                    @elseif ( Auth::user()->hak_akses == 'customer_service' && $keluhan->status_keluhan == 'ditangani oleh cs')
                    <th>Action</th>
                    <td>
                      {{-- <a href="/keluhan" class="btn btn-secondary m-auto">Kembali</a> --}}
                      <button type="button" class="btn btn-success m-auto" data-toggle="modal"
                        data-target="#konfirmasiModal" data-whatever="@mdo">Konfirmasi</button>
                    </td>
                    @endif
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Lihat Gambar --}}
    <div class="modal fade" id="gambarModal{{ $keluhan->id }}" tabindex="-1" role="dialog"
      aria-labelledby="gambarModalLabel" aria-hidden="true">
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
            <img src="{{ asset('gambar_keluhan/' . $keluhan->gambar) }}" alt="Gambar Keluhan"
              style="max-width: 100%; height: auto;">
            @endif
          </div>
        </div>
      </div>
    </div>
    {{-- Modal Verifkasi --}}
    <div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Keluhan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Kembali">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="/verify-complaint">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <input type="hidden" name="id_keluhan" value="{{ $keluhan->id_keluhan }}">
                <label for="example-select">Pilih Customer Service</label>
                <select class="form-control" id="example-select" name="penanggungjawab">
                  <option selected>--Pilih--</option>
                  @foreach ($cs as $item)
                  <option value="{{ $item->id }}">{{ $item->nama }}</option>
                  @endforeach
                </select>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn mb-2 btn-sm btn-secondary" data-dismiss="modal">Kembali</button>
              <button type="submit" class="btn mb-2 btn-sm btn-success">Verifikasi</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog" aria-labelledby="konfirmasiModalLabel"
      aria-hidden="true">
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
