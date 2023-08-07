<!DOCTYPE html>
<html>

<head>
    <title>Data Keluhan</title>
</head>

<body>
    <h1>Data Keluhan</h1>
    <table border="1">
        <tr>
            <th>ID Keluhan</th>
            <th>Tanggal Keluhan</th>
            <th>Uraian Keluhan</th>
            <!-- Tambahkan kolom-kolom lain sesuai dengan kebutuhan -->
        </tr>
        <?php $no=1 ?>
        @foreach ($dataKeluhan as $keluhan)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $keluhan->tgl_keluhan }}</td>
            <td>{{ $keluhan->nama }}</td>
            <td>{{ $keluhan->via_keluhan }}</td>
            <td>{{ $keluhan->uraian_keluhan }}</td>
            <td>{{ $keluhan->waktu_penyelesaian }}</td>
            <td>{{ $keluhan->aksi }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>