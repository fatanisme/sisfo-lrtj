<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});

Route::get('admin/perawatan/export/', [\App\Http\Controllers\ExportController::class, 'export'])->name('export.perawatan');
Route::get('admin/pendinasan/export/', [\App\Http\Controllers\ExportController::class, 'exportpendinasan'])->name('export.pendinasan');
Route::get('admin/statuslrv/export/', [\App\Http\Controllers\ExportController::class, 'exportstatuslrv'])->name('export.statuslrv');
Route::get('admin/perawatanequipment/export/', [\App\Http\Controllers\ExportController::class, 'exportperawatanequipment'])->name('export.perawatanequipment');
