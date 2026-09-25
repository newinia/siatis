<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Daftar Peserta Pemanggilan</title>

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


        /* LOGO */

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


        /* TEKS KOP */

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


        /* GARIS KOP */

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
           FILTER
        ========================================================= */

        .filter-info {
            text-align: center;
            font-size: 8px;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .filter-info strong {
            font-weight: bold;
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
            width: 22%;
        }

        .col-jenis {
            width: 13%;
        }

        .col-jurusan {
            width: 15%;
        }

        .col-hp {
            width: 11%;
        }

        .col-hasil {
            width: 8%;
        }


        /* =========================================================
           STATUS
        ========================================================= */

        .status-lulus {
            font-weight: bold;
        }


        /* =========================================================
           EMPTY
        ========================================================= */

        .empty {
            text-align: center;
            padding: 18px;
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
        DAFTAR PESERTA PEMANGGILAN
    </div>


    <div class="title-sub">

        Peserta yang telah dinyatakan lulus pada tahapan Case Conference
        dan dapat mengikuti proses selanjutnya.

    </div>



    {{-- ==========================================================
         FILTER INFO
    =========================================================== --}}

    <div class="filter-info">

        @if (!empty($gelombang) || !empty($tahun))

            @if (!empty($gelombang))

                <strong>
                    Gelombang {{ $gelombang }}
                </strong>

            @endif


            @if (!empty($gelombang) && !empty($tahun))

                &nbsp; | &nbsp;

            @endif


            @if (!empty($tahun))

                <strong>
                    Tahun {{ $tahun }}
                </strong>

            @endif

        @else

            <strong>
                Seluruh Gelombang dan Tahun
            </strong>

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

                <th class="col-jenis">
                    Jenis PPKS
                </th>

                <th class="col-jurusan">
                    Jurusan
                </th>

                <th class="col-hp">
                    No. HP
                </th>

                <th class="col-hasil">
                    Hasil
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse ($pesertas as $index => $ppks)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | DATA PPKS
                    |--------------------------------------------------------------------------
                    */

                    $ppksData = $ppks->data ?? [];

                    if (!is_array($ppksData)) {

                        $ppksData = json_decode(
                            $ppksData,
                            true
                        ) ?? [];

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | IDENTITAS
                    |--------------------------------------------------------------------------
                    */

                    $nama =
                        $ppksData['nama_lengkap']
                        ?? $ppksData['nama']
                        ?? '-';


                    $nik =
                        $ppksData['nik']
                        ?? $ppksData['NIK']
                        ?? '-';


                    /*
                    |--------------------------------------------------------------------------
                    | JENIS PPKS
                    |--------------------------------------------------------------------------
                    */

                    $jenisPpks =
                        $ppksData['jenis_ppks']
                        ?? '-';


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
                    | NOMOR HP
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
                            array_key_exists($key, $ppksData)
                            &&
                            $ppksData[$key] !== null
                            &&
                            trim((string) $ppksData[$key]) !== ''
                        ) {

                            $noHp =
                                is_array($ppksData[$key])
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
                    | JURUSAN
                    |--------------------------------------------------------------------------
                    */

                    $jurusan =
                        $caseConference?->jurusan_diterima
                        ?? $ppksData['jurusan_diterima']
                        ?? '-';

                @endphp


                <tr>

                    {{-- NO --}}

                    <td class="center">
                        {{ $index + 1 }}
                    </td>


                    {{-- NAMA --}}

                    <td class="left">
                        {{ $nama }}
                    </td>


                    {{-- NIK --}}

                    <td class="center">
                        {{ $nik }}
                    </td>


                    {{-- ALAMAT --}}

                    <td class="left">
                        {{ $alamat }}
                    </td>


                    {{-- JENIS PPKS --}}

                    <td class="left">
                        {{ $jenisPpks }}
                    </td>


                    {{-- JURUSAN --}}

                    <td class="left">
                        {{ $jurusan }}
                    </td>


                    {{-- NO HP --}}

                    <td class="center">
                        {{ $noHp }}
                    </td>


                    {{-- HASIL --}}

                    <td class="center status-lulus">
                        Lulus
                    </td>

                </tr>


            @empty

                <tr>

                    <td
                        colspan="8"
                        class="empty"
                    >
                        Tidak terdapat peserta yang memenuhi
                        kriteria pemanggilan.
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

            Daftar Peserta Pemanggilan —
            Sentra Terpadu Inten Soeweno

        </span>


        <span class="footer-right">

            Halaman

            <span class="page-number"></span>

        </span>

    </div>


</body>

</html>
