<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;
use Google\Service\Exception as GoogleServiceException;

class GoogleSheetService
{
    protected Sheets $sheets;

    protected Drive $drive;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct()
    {
        $client = new Client();


        /*
        |--------------------------------------------------------------------------
        | GOOGLE CREDENTIALS
        |--------------------------------------------------------------------------
        */

        $client->setAuthConfig(
            config('services.google.credentials')
        );


        /*
        |--------------------------------------------------------------------------
        | GOOGLE SHEETS
        |--------------------------------------------------------------------------
        */

        $client->addScope(
            Sheets::SPREADSHEETS_READONLY
        );


        /*
        |--------------------------------------------------------------------------
        | GOOGLE DRIVE
        |--------------------------------------------------------------------------
        */

        $client->addScope(
            Drive::DRIVE_READONLY
        );


        $this->sheets =
            new Sheets($client);

        $this->drive =
            new Drive($client);
    }


    /*
    |--------------------------------------------------------------------------
    | GET SPREADSHEET
    |--------------------------------------------------------------------------
    */

    public function getSpreadsheet(
        string $spreadsheetId
    ) {
        return $this->sheets
            ->spreadsheets
            ->get($spreadsheetId);
    }


    /*
    |--------------------------------------------------------------------------
    | GET VALUES
    |--------------------------------------------------------------------------
    */

    public function getValues(
        string $spreadsheetId,
        string $range
    ): array {

        $response =
            $this->sheets
                ->spreadsheets_values
                ->get(
                    $spreadsheetId,
                    $range
                );

        return
            $response->getValues()
            ?? [];
    }


    /*
    |--------------------------------------------------------------------------
    | GET ROWS
    |--------------------------------------------------------------------------
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


    /*
    |--------------------------------------------------------------------------
    | GET SINGLE ROW
    |--------------------------------------------------------------------------
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

        $rows =
            $this->getValues(
                $spreadsheetId,
                $range
            );

        return $rows[0] ?? [];
    }


    /*
    |--------------------------------------------------------------------------
    | GET GOOGLE DRIVE FILE
    |--------------------------------------------------------------------------
    */

    public function getDriveFile(
        string $fileId
    ) {

        return $this->drive
            ->files
            ->get(
                $fileId,
                [
                    'fields' =>
                        'id,name,mimeType,size',
                ]
            );
    }


    /*
    |--------------------------------------------------------------------------
    | GET GOOGLE DRIVE FILE STREAM
    |--------------------------------------------------------------------------
    |
    | File tidak dibaca menggunakan getContents().
    | Body dikembalikan sebagai stream supaya controller
    | dapat mengirim file sedikit demi sedikit ke browser.
    |
    */

    public function getDriveFileStream(
        string $fileId
    ) {

        return $this->drive
            ->files
            ->get(
                $fileId,
                [
                    'alt' => 'media',
                ]
            );
    }


    /*
    |--------------------------------------------------------------------------
    | GET GOOGLE DRIVE FILE CONTENT
    |--------------------------------------------------------------------------
    |
    | Method lama tetap dipertahankan agar tidak merusak
    | bagian lain aplikasi yang mungkin masih menggunakannya.
    |
    */

    public function getDriveFileContent(
        string $fileId
    ): string {

        $response =
            $this->getDriveFileStream(
                $fileId
            );

        $body =
            $response->getBody();

        return $body->getContents();
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK ACCESS
    |--------------------------------------------------------------------------
    */

    public function canAccessDriveFile(
        string $fileId
    ): bool {

        try {

            $this->getDriveFile(
                $fileId
            );

            return true;

        } catch (
            GoogleServiceException $e
        ) {

            return false;

        } catch (
            \Throwable $e
        ) {

            return false;
        }
    }
}
