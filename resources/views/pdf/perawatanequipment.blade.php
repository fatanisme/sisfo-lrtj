<!DOCTYPE html>
<html>

<head>
    <title>Report Perawatan Equipment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* Menghapus margin default */
            padding: 0;
            /* Menghapus padding default */
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            /* Relative positioning untuk header */
        }

        .header img {
            position: absolute;
            /* Mengatur posisi absolut untuk logo */
            top: 0;
            left: 0;
            width: 150px;
            /* Adjust as needed */
        }

        .header h2,
        .header h4 {
            margin: 10px 0 5px;
        }

        .header h4 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot tr td {
            border: none;
            padding-top: 30px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
        <h2>Report Perawatan Equipment</h2>
        <h4>Tahun: {{ $data['perawatanequipment']->first() ? \Carbon\Carbon::parse($data['perawatanequipment']->first()->tgl_perawatan)->format('F Y') : '' }}</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Equipment</th>
                <th>Jenis Perawatan Equipment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['perawatanequipment'] as $equipment)
            <tr>
                <td>{{ \Carbon\Carbon::parse($equipment->tgl_perawatan)->format('d F Y') }}</td>
                <td>{{ $equipment->equipment }}</td>
                <td>{{ $equipment->jenis_perawatan }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Created by: {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td colspan="3">Checked by: ___________________</td>
            </tr>
            <tr>
                <td colspan="3">Approved by: ___________________</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>