<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected Sheets $sheets;

    public function __construct()
    {
        $client = new Client();

        $client->setAuthConfig(
            config('services.google.credentials')
        );

        $client->addScope(
            Sheets::SPREADSHEETS_READONLY
        );

        $this->sheets = new Sheets($client);
    }

    /**
     * Ambil informasi spreadsheet.
     */
    public function getSpreadsheet(
        string $spreadsheetId
    ) {
        return $this->sheets
            ->spreadsheets
            ->get($spreadsheetId);
    }

    /**
     * Ambil values berdasarkan range.
     */
    public function getValues(
        string $spreadsheetId,
        string $range
    ): array {

        $response = $this->sheets
            ->spreadsheets_values
            ->get(
                $spreadsheetId,
                $range
            );

        return $response->getValues() ?? [];
    }

    /**
     * Ambil SEMUA baris mulai dari startRow
     * sampai baris terakhir yang memiliki data.
     *
     * Tidak ada lagi limit 5.000.
     */
    public function getRows(
        string $spreadsheetId,
        string $sheetName,
        int $startRow
    ): array {

        $range = sprintf(
            "'%s'!A%d:AO",
            $sheetName,
            $startRow
        );

        return $this->getValues(
            $spreadsheetId,
            $range
        );
    }

    /**
     * Mengambil satu baris tertentu dari Google Sheet.
     */
    public function getRow(
        string $spreadsheetId,
        string $sheetName,
        int $rowNumber
    ): array {

        $range = sprintf(
            "'%s'!A%d:AO%d",
            $sheetName,
            $rowNumber,
            $rowNumber
        );

        $rows = $this->getValues(
            $spreadsheetId,
            $range
        );

        return $rows[0] ?? [];
    }
}
