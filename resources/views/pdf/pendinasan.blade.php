<!DOCTYPE html>
<html>

<head>
    <title>Report Pendinasan</title>
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
        <h2>Report Pendinasan</h2>
        <h4>Tahun: {{ $data['pendinasan']->first() ? \Carbon\Carbon::parse($data['pendinasan']->first()->tgl_pendinasan)->format('F Y') : '' }}</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>LRV</th>
                <th>Status Pendinasan</th>
                <th>Lokasi LRV</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pendinasan'] as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tgl_pendinasan)->format('d F Y') }}</td>
                <td>{{ $item->lrv }}</td>
                <td>{{ $item->status_pendinasan }}</td>
                <td>{{ $item->location }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Created by: {{ auth()->user()->name }}</td>
            </tr>
            <tr>
                <td colspan="4">Checked by: ___________________</td>
            </tr>
            <tr>
                <td colspan="4">Approved by: ___________________</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>