<x-app-layout>

    <div class="case-conference-page">

        {{-- =====================================================
        HEADER
        ====================================================== --}}
        <div class="case-conference-header">

            <div>
                <h1>Case Conference</h1>

                <p>
                    Case Conference untuk menentukan kelulusan PPKS
                </p>
            </div>


            {{-- DATE FILTER --}}
            <button type="button" class="date-filter">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="18" rx="2" />

                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h18" />
                </svg>


                <span>
                    Oct 12, 2023 - Oct 19, 2023
                </span>


                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>

        </div>



        {{-- =====================================================
        FILTER
        ====================================================== --}}
        <div class="case-filter-wrapper">


            {{-- SEARCH --}}
            <div class="case-search">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="7" />

                    <path d="m20 20-3.5-3.5" />
                </svg>


                <input type="text" placeholder="Cari Nama atau NIK">

            </div>



            {{-- FILTER JENIS PPKS --}}
            <button type="button" class="case-filter-button">

                <span>
                    Semua Jenis PPKS
                </span>


                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>



            {{-- FILTER HASIL --}}
            <button type="button" class="case-filter-button">

                <span>
                    Semua Hasil
                </span>


                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6" />
                </svg>

            </button>

        </div>




        <div class="table-wrapper">

            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Umur</th>
                        <th>Jenis PPKS</th>
                        <th>Jurusan</th>
                        <th>Hasil</th>
                        <th>Keterangan</th>

                    </tr>

                </thead>


                <tbody>

                    @php


                        $students = [

                            [
                                'nama' => 'Siti Rahmawati',
                                'nik' => '012345678',
                                'umur' => '18',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Contact Center',
                                'hasil' => 'Asesmen Kesehatan Awal',
                                'status' => 'health',
                                'keterangan' => 'Lolos',
                            ],

                            [
                                'nama' => 'Andi Saputra',
                                'nik' => '012345679',
                                'umur' => '20',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Komputer',
                                'hasil' => 'Asesmen Kesehatan Awal',
                                'status' => 'health',
                                'keterangan' => 'Lolos',
                            ],

                            [
                                'nama' => 'Budi Santoso',
                                'nik' => '012345680',
                                'umur' => '19',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Desain Grafis',
                                'hasil' => 'Asesmen Kesehatan Awal',
                                'status' => 'health',
                                'keterangan' => 'Lolos',
                            ],

                            [
                                'nama' => 'Citra Lestari',
                                'nik' => '012345681',
                                'umur' => '23',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Menjahit',
                                'hasil' => 'Asesmen Kesehatan Awal',
                                'status' => 'health',
                                'keterangan' => 'Lolos',
                            ],

                            [
                                'nama' => 'Dewi Anggraini',
                                'nik' => '012345682',
                                'umur' => '27',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Teknik Elektro',
                                'hasil' => 'Asesmen Kesehatan Awal',
                                'status' => 'health',
                                'keterangan' => 'Lolos',
                            ],

                            [
                                'nama' => 'Rizky Maulana',
                                'nik' => '012345683',
                                'umur' => '30',
                                'ppks' => 'Disabilitas Fisik',
                                'jurusan' => 'Teknik Mesin',
                                'hasil' => 'Asesmen Kesehatan Awal',
                                'status' => 'health',
                                'keterangan' => 'Lolos',
                            ],

                        ];

                    @endphp


                    @foreach ($students as $index => $student)

                        <tr>

                            {{-- NO --}}
                            <td>
                                {{ $index + 1 }}
                            </td>


                            {{-- NAMA --}}
                            <td>
                                {{ $student['nama'] }}
                            </td>


                            {{-- NIK --}}
                            <td>
                                {{ $student['nik'] }}
                            </td>


                            {{-- UMUR --}}
                            <td>
                                {{ $student['umur'] }}
                            </td>


                            {{-- PPKS --}}
                            <td>
                                {{ $student['ppks'] }}
                            </td>


                            {{-- JURUSAN --}}
                            <td>
                                {{ $student['jurusan'] }}
                            </td>


                            {{-- HASIL --}}
                            <td>

                                {{-- ==========================
                                DITERIMA
                                =========================== --}}
                                @if ($student['status'] === 'accepted')

                                    <a href="#" class="result-badge result-accepted">

                                        <span class="material-symbols-outlined result-icon">
                                            task_alt
                                        </span>

                                        <span>
                                            Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- ==========================
                                    TIDAK DITERIMA
                                    =========================== --}}
                                @elseif ($student['status'] === 'rejected')

                                    <a href="#" class="result-badge result-rejected">

                                        <span class="material-symbols-outlined result-icon">
                                            cancel
                                        </span>

                                        <span>
                                            Tidak Diterima
                                        </span>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- ==========================
                                    ASESMEN kesehatan
                                    =========================== --}}
                                @elseif ($student['status'] === 'instructor')

                                    <a href="#" class="result-badge result-instructor">

                                        <span class="material-symbols-outlined result-icon">
                                            assignment
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title result-instructor">
                                                Asesmen kesehatan
                                            </span>

                                            <span class="result-status pending">

                                                <span class="status-dot pending"></span>

                                                Pending

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>


                                    {{-- ==========================
                                    ASESMEN KESEHATAN
                                    =========================== --}}
                                @elseif ($student['status'] === 'health')

                                    <a href="#" class="result-badge result-health">

                                        <span class="material-symbols-outlined result-icon">
                                            medical_services
                                        </span>

                                        <div class="result-content">

                                            <span class="result-title result-health">
                                                Asesmen Kesehatan
                                            </span>

                                            <span class="result-status lolos">

                                                <span class="status-dot lolos"></span>

                                                Lolos

                                            </span>

                                        </div>

                                        <span class="result-arrow">
                                            ›
                                        </span>

                                    </a>

                                @endif

                            </td>


                            {{-- KETERANGAN --}}
                            <td>
                                {{ $student['keterangan'] }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

</x-app-layout>