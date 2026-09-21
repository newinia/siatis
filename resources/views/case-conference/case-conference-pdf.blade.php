<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Data Case Conference</title>

    <style>

        /* =========================================================
           PAGE
        ========================================================= */

        @page {
            size: A4 portrait;
            margin: 22px 18px 25px 18px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #111;
            margin: 0;
        }


        /* =========================================================
           HEADER / KOP SURAT
        ========================================================= */

        .kop-surat {
            width: 100%;
            margin-bottom: 12px;
        }

        .kop-wrapper {
            width: 100%;
            display: table;
            table-layout: fixed;
        }

        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        .kop-logo {
            display: table-cell;
            width: 18%;
            vertical-align: middle;
            text-align: center;
        }

        .kop-logo img {
            width: 72px;
            height: auto;
            display: inline-block;
        }

        /*
        |--------------------------------------------------------------------------
        | TEKS KOP
        |--------------------------------------------------------------------------
        */

        .kop-text {
            display: table-cell;
            width: 82%;
            vertical-align: middle;
            text-align: center;
            padding-right: 10%;
        }

        .kop-instansi {
            font-size: 12px;
            font-weight: bold;
            line-height: 1.15;
            text-transform: uppercase;
            margin: 0;
        }

        .kop-direktorat {
            font-size: 11px;
            font-weight: bold;
            line-height: 1.15;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .kop-sentra {
            font-size: 13px;
            font-weight: bold;
            line-height: 1.15;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .kop-alamat {
            font-size: 8px;
            line-height: 1.25;
            margin-top: 4px;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | GARIS KOP
        |--------------------------------------------------------------------------
        */

        .kop-garis {
            border-top: 2px solid #111;
            border-bottom: 1px solid #111;
            height: 3px;
            margin-top: 6px;
        }


        /* =========================================================
           JUDUL
        ========================================================= */

        .title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .title-sub {
            text-align: center;
            font-size: 8px;
            margin-bottom: 12px;
            line-height: 1.5;
        }


        /* =========================================================
           TABLE
        ========================================================= */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 0.7px solid #333;
            padding: 4px 3px;
            word-wrap: break-word;
            vertical-align: middle;
        }

        th {
            background-color: #e5e5e5;
            text-align: center;
            font-size: 7px;
            font-weight: bold;
            line-height: 1.2;
        }

        td {
            font-size: 7px;
            line-height: 1.3;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f8f8;
        }


        /* =========================================================
           ALIGNMENT
        ========================================================= */

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }


        /* =========================================================
           COLUMN WIDTH
        ========================================================= */

        .col-no {
            width: 4%;
        }

        .col-nama {
            width: 15%;
        }

        .col-nik {
            width: 12%;
        }
        .col-alamat {
            width: 15%;
        }

        .col-umur {
            width: 7%;
        }

        .col-jenis {
            width: 13%;
        }

        .col-jurusan {
            width: 14%;
        }

        .col-hasil {
            width: 10%;
        }

        .col-keterangan {
            width: 15%;
        }

        .col-hp {
            width: 10%;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 0.7px solid #777;
            font-size: 7px;
            color: #555;
        }

        .footer-left {
            float: left;
        }

        .footer-right {
            float: right;
        }

        .page-number:after {
            content: counter(page);
        }

    </style>
</head>

<body>


    {{-- ==========================================================
         HEADER / KOP SURAT
    =========================================================== --}}

    <div class="kop-surat">

        <div class="kop-wrapper">

            {{-- LOGO --}}
            <div class="kop-logo">

                <img
                    src="{{ public_path('images/logo.png') }}"
                    alt="Logo Kementerian Sosial"
                >

            </div>


            {{-- TEKS KOP --}}
            <div class="kop-text">

                <div class="kop-instansi">
                    KEMENTERIAN SOSIAL REPUBLIK INDONESIA
                </div>

                <div class="kop-direktorat">
                    DIREKTORAT JENDERAL REHABILITASI SOSIAL
                </div>

                <div class="kop-sentra">
                    SENTRA TERPADU INTEN SOEWENO
                </div>

                <div class="kop-alamat">
                    Jl. SKB No.5 Karadenan Cibinong Bogor
                    Telp. (0251) 8654702/05
                    Fax (0251) 8654701
                </div>

            </div>

        </div>


        {{-- GARIS KOP --}}
        <div class="kop-garis"></div>

    </div>



    {{-- ==========================================================
         JUDUL
    =========================================================== --}}

    <div class="title">
        DATA CASE CONFERENCE
    </div>


    <div class="title-sub">

        Daftar Hasil Case Conference Peserta

        @if(!empty($gelombang) || !empty($tahun))

            <br>

            @if(!empty($gelombang))

                Gelombang {{ $gelombang }}

            @endif


            @if(!empty($tahun))

                @if(!empty($gelombang))
                    &nbsp; | &nbsp;
                @endif

                Tahun {{ $tahun }}

            @endif

        @endif

    </div>



    {{-- ==========================================================
         TABEL DATA
    =========================================================== --}}

    <table>

        <thead>

            <tr>

                <th class="col-no">
                    No
                </th>

                <th class="col-nama">
                    Nama
                </th>

                <th class="col-nik">
                    NIK
                </th>
                <th class="col-alamat">
                    Alamat
                </th>

                <th class="col-umur">
                    Umur
                </th>

                <th class="col-jenis">
                    Jenis PPKS
                </th>

                <th class="col-jurusan">
                    Jurusan
                </th>

                <th class="col-hasil">
                    Hasil
                </th>

                <th class="col-keterangan">
                    Keterangan
                </th>

                <th class="col-hp">
                    No. HP
                </th>

            </tr>

        </thead>



        <tbody>

            @forelse ($data as $index => $ppks)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | DATA PPKS
                    |--------------------------------------------------------------------------
                    */

                    $ppksData = $ppks->data ?? [];

                    if (!is_array($ppksData)) {
                        $ppksData = [];
                    }
                /*
                |--------------------------------------------------------------------------
                | ALAMAT
                |--------------------------------------------------------------------------
                */

                $alamat =
                    $ppksData['alamat']
                    ?? $ppksData['Alamat']
                    ?? $ppksData['alamat_lengkap']
                    ?? $ppksData['Alamat Lengkap']
                    ?? $ppksData['alamat_domisili']
                    ?? $ppksData['Alamat Domisili']
                    ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | UMUR
                    |--------------------------------------------------------------------------
                    */

                    $usia = $ppksData['usia'] ?? null;

                    if (
                        $usia === null ||
                        trim((string) $usia) === ''
                    ) {

                        $tanggalLahir =
                            $ppksData['tanggal_lahir']
                            ?? $ppksData['tgl_lahir']
                            ?? null;


                        if ($tanggalLahir) {

                            try {

                                $usia =
                                    \Carbon\Carbon::parse(
                                        $tanggalLahir
                                    )->age;

                            } catch (\Throwable $e) {

                                $usia = '-';

                            }

                        } else {

                            $usia = '-';

                        }

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | CASE CONFERENCE TERBARU
                    |--------------------------------------------------------------------------
                    */

                    $caseConference =
                        $ppks->prosesPesertas
                            ->where(
                                'tahap',
                                'case_conference'
                            )
                            ->sortByDesc(
                                function ($item) {

                                    return
                                        $item->tanggal_proses
                                        ?? $item->created_at;

                                }
                            )
                            ->first();


                    /*
                    |--------------------------------------------------------------------------
                    | JURUSAN DITERIMA
                    |--------------------------------------------------------------------------
                    */

                    $jurusanDiterima =
                        $ppksData['jurusan_diterima']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | HASIL CASE CONFERENCE
                    |--------------------------------------------------------------------------
                    */

                    $hasilCaseConference =
                        match (
                            $caseConference?->status
                        ) {

                            'lulus' =>
                                'Diterima',

                            'tidak_lulus' =>
                                'Tidak Diterima',

                            'pending' =>
                                'Pending',

                            default =>
                                '-',

                        };


                    /*
                    |--------------------------------------------------------------------------
                    | KETERANGAN
                    |--------------------------------------------------------------------------
                    */

                    $keterangan =
                        $caseConference?->catatan
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | NO HP
                    |--------------------------------------------------------------------------
                    */

                    $noHp = '-';


                    foreach ([

                        'no_hp_1',
                        'nomor_hp_1',
                        'no_telepon',
                        'nomor_telepon'

                    ] as $key) {

                        if (

                            array_key_exists(
                                $key,
                                $ppksData
                            )

                            &&

                            $ppksData[$key] !== null

                            &&

                            trim(
                                (string) $ppksData[$key]
                            ) !== ''

                        ) {

                            $noHp =

                                is_array(
                                    $ppksData[$key]
                                )

                                ?

                                implode(
                                    ', ',
                                    $ppksData[$key]
                                )

                                :

                                $ppksData[$key];

                            break;

                        }

                    }

                @endphp



                <tr>


                    {{-- NO --}}

                    <td class="center">

                        {{ $index + 1 }}

                    </td>



                    {{-- NAMA --}}

                    <td class="left">

                        {{
                            $ppksData['nama_lengkap']
                            ?? $ppksData['nama']
                            ?? '-'
                        }}

                    </td>



                    {{-- NIK --}}

                    <td class="center">

                        {{
                            $ppksData['nik']
                            ?? $ppksData['NIK']
                            ?? '-'
                        }}

                    </td>
                    {{-- ALAMAT --}}

                    <td class="left">

                        {{ $alamat }}

                    </td>


                    {{-- UMUR --}}

                    <td class="center">

                        {{
                            $usia !== '-'
                                ? $usia . ' Tahun'
                                : '-'
                        }}

                    </td>



                    {{-- JENIS PPKS --}}

                    <td class="left">

                        {{
                            $ppksData['jenis_ppks']
                            ?? '-'
                        }}

                    </td>



                    {{-- JURUSAN --}}

                    <td class="left">

                        {{ $jurusanDiterima }}

                    </td>



                    {{-- HASIL --}}

                    <td class="center">

                        {{ $hasilCaseConference }}

                    </td>



                    {{-- KETERANGAN --}}

                    <td class="left">

                        {{ $keterangan }}

                    </td>



                    {{-- NO HP --}}

                    <td class="center">

                        {{ $noHp }}

                    </td>


                </tr>


            @empty

                <tr>

                    <td
                        colspan="9"
                        class="center"
                        style="padding: 10px;"
                    >

                        Tidak ada data Case Conference.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>



    {{-- ==========================================================
         FOOTER
    =========================================================== --}}

    <div class="footer">

        <span class="footer-left">

            Data Case Conference —
            Sentra Terpadu Inten Soeweno

        </span>


        <span class="footer-right">

            Halaman

            <span class="page-number"></span>

        </span>

    </div>


</body>
</html>
