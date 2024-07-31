<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Perawatan;
use App\Models\Pendinasan;
use App\Models\Stamformasi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function export(Request $request)
    {

        // Ambil tahun dan bulan dari request
        $tahun = $request->input('tahun_perawatan');
        $bulan = $request->input('bulan_perawatan');

        $perawatan = Perawatan::join('lrvs', 'perawatans.lrv_id', '=', 'lrvs.id')
            ->whereMonth('tgl_perawatan', $bulan)
            ->whereYear('tgl_perawatan', $tahun)
            ->select('perawatans.*', 'lrvs.lrv', 'lrvs.nomor_ka')
            ->orderBy('perawatans.tgl_perawatan', 'asc')
            ->get();

        if ($perawatan->count() <= 0) {
            Notification::make()
                ->title('Alert')
                ->body('Data tidak ada !')
                ->warning()
                ->send();

            return redirect()->back();
        } else {
            $data = [
                'date' => date('d-m-Y'),
                'perawatan' => $perawatan,

            ];
        }
        $pdf = Pdf::loadView('pdf/perawatan', ['data' => $data]);

        return new Response(
            $pdf->download('Report Perawatan -' . $tahun . '.pdf'),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="Report Perawatan -' . $bulan . " " . $tahun . '.pdf"'
            ]
        );
    }

    public function exportpendinasan(Request $request)
    {
        // Change from year to month
        $bulan = $request->input('bulan_perawatan');
        $tahun = $request->input('tahun_perawatan');

        $pendinasan = Pendinasan::join('lrvs', 'pendinasans.lrv_id', '=', 'lrvs.id')
            ->whereMonth('tgl_pendinasan', $bulan)
            ->whereYear('tgl_pendinasan', $tahun)
            ->select('pendinasans.*', 'lrvs.lrv', 'lrvs.nomor_ka')
            ->orderBy('pendinasans.tgl_pendinasan', 'asc')
            ->get();

        if ($pendinasan->count() <= 0) {
            Notification::make()
                ->title('Alert')
                ->body('Data tidak ada !')
                ->warning()
                ->send();

            return redirect()->back();
        } else {
            $data = [
                'date' => date('d-m-Y'),
                'pendinasan' => $pendinasan,
            ];

            $pdf = Pdf::loadView('pdf/pendinasan', ['data' => $data]);

            return new Response(
                $pdf->stream('Report Pendinasan -' . $bulan . '.pdf'),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="Report Pendinasan -' . $bulan . " " . $tahun . '.pdf"'
                ]
            );
        }
    }
    public function exportstatuslrv(Request $request)
    {
        // Change from year to month
        $bulan = $request->input('bulan_stamformasi');
        $tahun = $request->input('tahun_stamformasi');

        $statuslrv = Stamformasi::join('lrvs', 'stamformasis.lrv_id', '=', 'lrvs.id')
            ->join('users', 'stamformasis.user_id', '=', 'users.id')
            ->whereMonth('tgl_stamformasi', $bulan)
            ->whereYear('tgl_stamformasi', $tahun)
            ->select('stamformasis.*', 'lrvs.lrv', 'lrvs.nomor_ka', 'users.name')
            ->orderBy('stamformasis.tgl_stamformasi', 'asc')
            ->get();

        if ($statuslrv->count() <= 0) {
            Notification::make()
                ->title('Alert')
                ->body('Data tidak ada !')
                ->warning()
                ->send();

            return redirect()->back();
        } else {
            $data = [
                'date' => date('d-m-Y'),
                'statuslrv' => $statuslrv,
            ];

            $pdf = Pdf::loadView('pdf/statuslrv', ['data' => $data]);

            return new Response(
                $pdf->stream('Report Status LRV -' . $bulan . '.pdf'),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="Report Status LRV -' . $bulan . " " . $tahun . '.pdf"'
                ]
            );
        }
    }

    public function exportperawatanequipment(Request $request)
    {
        // Change from year to month
        $bulan = $request->input('bulan_perawatan');
        $tahun = $request->input('tahun_perawatan');


        $perawatanequipment = DB::table('perawatan_equipment')
            ->join('equipment', 'perawatan_equipment.equipment_id', '=', 'equipment.id')
            ->whereMonth('tgl_perawatan', $bulan)
            ->whereYear('tgl_perawatan', $tahun)
            ->select('perawatan_equipment.*', 'equipment.equipment')
            ->orderBy('perawatan_equipment.tgl_perawatan', 'asc')
            ->get();

        if ($perawatanequipment->count() <= 0) {
            Notification::make()
                ->title('Alert')
                ->body('Data tidak ada !')
                ->warning()
                ->send();

            return redirect()->back();
        } else {
            $data = [
                'date' => date('d-m-Y'),
                'perawatanequipment' => $perawatanequipment,
            ];

            $pdf = Pdf::loadView('pdf/perawatanequipment', ['data' => $data]);

            return new Response(
                $pdf->stream('Report Perawatan Equipment -' . $bulan . '.pdf'),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="Report Perawatan Equipment -' . $bulan . " " . $tahun . '.pdf"'
                ]
            );
        }
    }
}
