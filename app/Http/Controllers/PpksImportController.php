<?php

namespace App\Http\Controllers;

use App\Models\Ppks;
use App\Services\GoogleSheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PpksImportController extends Controller
{
    /**
     * Menampilkan halaman import.
     */
    public function index(): View
    {
        $totalImported = Ppks::count();

        return view('ppks.import', compact('totalImported'));
    }

    /**
     * Mengimport 100 data berikutnya dari Google Sheets.
     */
    public function import(
        GoogleSheetService $googleSheetService
    ): JsonResponse {
        $spreadsheetId = '1uWDJthPz5yW61BPWG5v1FhcyAHekXpSfWsFGBxJr1pM';
        $sheetName = 'Form Responses 1';

        $batchSize = 100;

        $lastImportedRow = Ppks::max('sheet_row');

        $startRow = $lastImportedRow
            ? $lastImportedRow + 1
            : 2;

        $rows = $googleSheetService->getRows(
            $spreadsheetId,
            $sheetName,
            $startRow,
            $batchSize
        );

        $imported = 0;
        $skipped = 0;

        foreach ($rows as $index => $row) {
            if (empty($row)) {
                continue;
            }

            $sheetRow = $startRow + $index;

            if (Ppks::where('sheet_row', $sheetRow)->exists()) {
                $skipped++;
                continue;
            }

            Ppks::create([
                'sheet_row' => $sheetRow,
                'data' => $row,
                'imported_at' => now(),
            ]);

            $imported++;
        }

        return response()->json([
            'message' => 'Import selesai.',
            'start_row' => $startRow,
            'imported' => $imported,
            'skipped' => $skipped,
            'total_in_database' => Ppks::count(),
        ]);
    }
}
