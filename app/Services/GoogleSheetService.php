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
                    $range,
                    [
                        /*
                        |--------------------------------------------------------------------------
                        | PENTING
                        |--------------------------------------------------------------------------
                        |
                        | Jangan ambil nilai yang sudah diformat oleh
                        | Google Sheets.
                        |
                        | Kalau menggunakan FORMATTED_VALUE,
                        | angka panjang seperti NIK bisa dikembalikan
                        | dalam bentuk scientific notation.
                        |
                        */

                        'valueRenderOption' =>
                            'UNFORMATTED_VALUE',

                        /*
                        |--------------------------------------------------------------------------
                        | FORMATTING DATE
                        |--------------------------------------------------------------------------
                        |
                        | Tetap gunakan serial number untuk tanggal.
                        | Mapping tanggal yang sudah ada di controller
                        | tetap bisa menangani data sesuai kebutuhan.
                        |
                        */

                        'dateTimeRenderOption' =>
                            'FORMATTED_STRING',
                    ]
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


        $rows =
            $this->getValues(
                $spreadsheetId,
                $range
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI DATA ROW
        |--------------------------------------------------------------------------
        |
        | Kolom C = NIK
        |
        | Index array:
        |
        | A = 0
        | B = 1
        | C = 2  <-- NIK
        |
        */

        foreach ($rows as $index => $row) {

            if (
                array_key_exists(
                    2,
                    $row
                )
            ) {

                $rows[$index][2] =
                    $this->normalizeNikValue(
                        $row[2]
                    );
            }
        }


        return $rows;
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


        $row =
            $rows[0] ?? [];


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI NIK
        |--------------------------------------------------------------------------
        */

        if (
            array_key_exists(
                2,
                $row
            )
        ) {

            $row[2] =
                $this->normalizeNikValue(
                    $row[2]
                );
        }


        return $row;
    }


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE NIK VALUE
    |--------------------------------------------------------------------------
    |
    | Tujuan utama:
    |
    | 1. Memastikan NIK diperlakukan sebagai STRING.
    | 2. Menangani scientific notation.
    | 3. Menghilangkan .0 jika muncul.
    | 4. Tidak membiarkan format seperti:
    |
    |    3.27987E+15
    |
    |    berubah menjadi:
    |
    |    327987
    |
    |--------------------------------------------------------------------------
    */

    private function normalizeNikValue(
        mixed $value
    ): string {

        if ($value === null) {
            return '';
        }


        /*
        |--------------------------------------------------------------------------
        | STRING
        |--------------------------------------------------------------------------
        */

        $value =
            trim(
                (string) $value
            );


        if ($value === '') {
            return '';
        }


        /*
        |--------------------------------------------------------------------------
        | SCIENTIFIC NOTATION
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 3.27987E+15
        |
        | Jangan gunakan:
        |
        | preg_replace('/\D/', '', $value)
        |
        | karena hasilnya hanya:
        |
        | 32798715
        |
        | yang SALAH.
        |
        */

        if (
            preg_match(
                '/^[+-]?\d+(?:\.\d+)?[eE][+-]?\d+$/',
                $value
            )
        ) {

            /*
            |--------------------------------------------------------------------------
            | Gunakan BCMath jika tersedia
            |--------------------------------------------------------------------------
            |
            | BCMath lebih aman untuk angka panjang.
            |
            */

            if (
                function_exists('bcadd')
                &&
                function_exists('bcpow')
                &&
                function_exists('bcmul')
            ) {

                try {

                    $parts =
                        preg_split(
                            '/[eE]/',
                            $value
                        );


                    $mantissa =
                        $parts[0];

                    $exponent =
                        (int) $parts[1];


                    /*
                    |--------------------------------------------------------------------------
                    | Pisahkan angka sebelum dan sesudah titik
                    |--------------------------------------------------------------------------
                    */

                    $negative = false;

                    if (
                        str_starts_with(
                            $mantissa,
                            '-'
                        )
                    ) {

                        $negative = true;

                        $mantissa =
                            substr(
                                $mantissa,
                                1
                            );

                    } elseif (
                        str_starts_with(
                            $mantissa,
                            '+'
                        )
                    ) {

                        $mantissa =
                            substr(
                                $mantissa,
                                1
                            );
                    }


                    $decimalPosition =
                        strpos(
                            $mantissa,
                            '.'
                        );


                    if (
                        $decimalPosition !== false
                    ) {

                        $decimalLength =
                            strlen(
                                $mantissa
                            )
                            -
                            $decimalPosition
                            -
                            1;


                        $digits =
                            str_replace(
                                '.',
                                '',
                                $mantissa
                            );

                    } else {

                        $decimalLength =
                            0;

                        $digits =
                            $mantissa;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Posisi desimal baru
                    |--------------------------------------------------------------------------
                    */

                    $newPosition =
                        strlen($digits)
                        -
                        $decimalLength
                        +
                        $exponent;


                    if (
                        $newPosition <= 0
                    ) {

                        $result =
                            '0.'
                            .
                            str_repeat(
                                '0',
                                abs($newPosition)
                            )
                            .
                            $digits;

                    } elseif (
                        $newPosition >=
                        strlen($digits)
                    ) {

                        $result =
                            $digits
                            .
                            str_repeat(
                                '0',
                                $newPosition
                                -
                                strlen($digits)
                            );

                    } else {

                        $result =
                            substr(
                                $digits,
                                0,
                                $newPosition
                            )
                            .
                            '.'
                            .
                            substr(
                                $digits,
                                $newPosition
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NIK harus bilangan bulat
                    |--------------------------------------------------------------------------
                    */

                    if (
                        str_contains(
                            $result,
                            '.'
                        )
                    ) {

                        $result =
                            rtrim(
                                rtrim(
                                    $result,
                                    '0'
                                ),
                                '.'
                            );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan minus jika memang ada
                    |--------------------------------------------------------------------------
                    */

                    if ($negative) {

                        $result =
                            '-' . $result;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | NIK hanya digit
                    |--------------------------------------------------------------------------
                    */

                    return preg_replace(
                        '/\D/',
                        '',
                        $result
                    );

                } catch (\Throwable $e) {

                    /*
                    |--------------------------------------------------------------------------
                    | FALLBACK
                    |--------------------------------------------------------------------------
                    */

                }
            }


            /*
            |--------------------------------------------------------------------------
            | FALLBACK SCIENTIFIC NOTATION
            |--------------------------------------------------------------------------
            |
            | Dipakai jika BCMath tidak tersedia.
            |
            */

            $expanded =
                sprintf(
                    '%.0f',
                    (float) $value
                );


            return preg_replace(
                '/\D/',
                '',
                $expanded
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ANGKA DENGAN .0
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 3279876543210987.0
        |
        */

        if (
            preg_match(
                '/^\d+\.0+$/',
                $value
            )
        ) {

            $value =
                strstr(
                    $value,
                    '.',
                    true
                );
        }


        /*
        |--------------------------------------------------------------------------
        | NIK NORMAL
        |--------------------------------------------------------------------------
        |
        | Contoh:
        |
        | 3279876543210987
        |
        */

        return preg_replace(
            '/\D/',
            '',
            $value
        );
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