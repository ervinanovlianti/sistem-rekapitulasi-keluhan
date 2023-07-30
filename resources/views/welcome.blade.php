@extends('template')
@section('content')
    <p>Pembayaran Sudah Lunas tapi pada saat e-tiket muncul pesan error “failed to confirm payment”</p>
    {{-- Upload Gambar --}}

    {{-- Proses upload gambar (jika ada) hanya dilakukan untuk pelanggan karena upload gambar tidak support jika data tidak langsung di upload kedalam database
    if ($request->hasFile('gambar')) {
    'gambar' => 'mimes:jpeg,png,jpg,gif|max:2048', // Hanya menerima file gambar dengan maksimal 2MB
        $gambarKeluhan = $request->file('gambar');
        $gambarName = time() . '_' . $gambarKeluhan->getClientOriginalName();
        $gambarKeluhan->move(public_path('gambar_keluhan'), $gambarName);
    } else {
        $gambarName = null; // Jika tidak ada gambar di-upload, set nilai gambarName menjadi null
    } --}}
@endsection