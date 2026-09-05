<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PpksFileController extends Controller
{
    public function show(
        string $fileId,
        GoogleSheetService $googleSheetService
    ): StreamedResponse {

        try {

            /*
            |--------------------------------------------------------------------------
            | AMBIL FILE DARI GOOGLE DRIVE
            |--------------------------------------------------------------------------
            */

            $response = $googleSheetService
                ->getDriveFileStream($fileId);


            /*
            |--------------------------------------------------------------------------
            | AMBIL BODY STREAM
            |--------------------------------------------------------------------------
            */

            $body = $response->getBody();


            /*
            |--------------------------------------------------------------------------
            | HEADER
            |--------------------------------------------------------------------------
            */

            $contentType =
                $response->getHeaderLine('Content-Type')
                ?: 'application/octet-stream';

            $contentLength =
                $response->getHeaderLine('Content-Length');


            /*
            |--------------------------------------------------------------------------
            | STREAM LANGSUNG KE BROWSER
            |--------------------------------------------------------------------------
            |
            | Tidak menggunakan:
            |
            | $body->getContents()
            |
            | karena itu membaca seluruh file ke memory terlebih dahulu.
            |
            */

            return response()->stream(
                function () use ($body) {

                    while (!$body->eof()) {

                        echo $body->read(8192);

                        /*
                         * Paksa data dikirim ke browser
                         */
                        if (ob_get_level() > 0) {
                            ob_flush();
                        }

                        flush();
                    }

                    $body->close();
                },
                200,
                array_filter([
                    'Content-Type' =>
                        $contentType,

                    'Content-Length' =>
                        $contentLength ?: null,

                    'Cache-Control' =>
                        'private, max-age=3600',

                    'X-Content-Type-Options' =>
                        'nosniff',

                    'Content-Disposition' =>
                        'inline',
                ])
            );

        } catch (Throwable $e) {

            abort(
                404,
                'File Google Drive tidak dapat diakses oleh sistem.'
            );
        }
    }
}

