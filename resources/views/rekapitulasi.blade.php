@extends('layouts.main')
@section('content')
<div class="row">
    <!-- Striped rows -->
    <div class="col-md-12">
        <h2 class="h4 mb-1 text-center">Rekapitulasi Keluhan Pengguna Jasa Berdasarkan Kategori</h2>
        <div class="card shadow">
        <div class="card-body">
        <!-- table -->
            <table class="table table-hover table-borderless border-v">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kategori Keluhan</th>
                        <th colspan="4">Via Keluhan</th>
                        <th colspan="2">Status Keluhan</th>
                        <th colspan="2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1 ?>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pembayaran</td>
                        <td>23</td>
                        <td>12</td>
                        <td>15</td>
                        <td>18</td>
                        <td>27</td>
                        <td>19</td>
                        <td>16</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Penerimaan</td>
                        <td>23</td>
                        <td>12</td>
                        <td>15</td>
                        <td>18</td>
                        <td>27</td>
                        <td>19</td>
                        <td>16</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Pengiriman</td>
                        <td>23</td>
                        <td>12</td>
                        <td>15</td>
                        <td>18</td>
                        <td>27</td>
                        <td>19</td>
                        <td>16</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Administrasi</td>
                        <td>23</td>
                        <td>12</td>
                        <td>15</td>
                        <td>18</td>
                        <td>27</td>
                        <td>19</td>
                        <td>16</td>
                    </tr>
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>Lainnya</td>
                        <td>23</td>
                        <td>12</td>
                        <td>15</td>
                        <td>18</td>
                        <td>27</td>
                        <td>19</td>
                        <td>16</td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Table Paging" class="mb-0 text-muted">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
            </nav>
        </div>
        </div>
    </div> <!-- simple table -->
    </div> <!-- end section -->
@endsection