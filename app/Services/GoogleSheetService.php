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

        $client->addScope(Sheets::SPREADSHEETS_READONLY);

        $this->sheets = new Sheets($client);
    }

    public function getSpreadsheet(string $spreadsheetId)
    {
        return $this->sheets->spreadsheets->get($spreadsheetId);
    }

    public function getValues(
        string $spreadsheetId,
        string $range
    ): array {
        $response = $this->sheets->spreadsheets_values->get(
            $spreadsheetId,
            $range
        );

        return $response->getValues() ?? [];
    }

    public function getRows(
        string $spreadsheetId,
        string $sheetName,
        int $startRow,
        int $limit
    ): array {
        $endRow = $startRow + $limit - 1;

        $range = sprintf(
            "'%s'!A%d:AO%d",
            $sheetName,
            $startRow,
            $endRow
        );

        return $this->getValues(
            $spreadsheetId,
            $range
        );
    }
}
