@extends('layout.mainweb')

@section('title')
    PIMUS 12
@endsection

@section('style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection

@section('content')
    <!-- Main Banner -->
    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                                <h6><img src="{{ url('assets/images/web/Asset 1.png') }}" alt=""> </h6>
                                <p style="color: #fff; font-weight: bold;">XII-ATHLON: PREPARE FOR YOUR TRIUMPH</p>
                                <p style="color: #fff;text-align:justify !important; text-justify:inter-word" font size="1" >Para <i>conqueror</i> yang telah berhasil memulihkan dunia dan melihat <i>gate</i>
                                    yang mengarahkan mereka ke Earth 2.0. Mereka harus meng-<i>unlock</i> area baru ini menggunakan komponen. Setelah
                                    semua di-<i>unlock</i>, mereka harus berpisah ke setiap <i>district</i> yang membuat mereka dapat menduduki kedudukan
                                    tertinggi di Earth 2.0, yaitu  <b>Throne of Triumph.</b></h6>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <h6><img src="{{ url('assets/images/web/Bumper.png') }}" alt=""> </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Banner -->

    <!-- Fun Fact Pimus -->
    <div id="about" class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="left-image wow fadeIn maskot" data-wow-duration="1s" data-wow-delay="0.2s">
                        <img src="{{ url('assets/images/web/Owl.png') }}" alt="person graphic">
                    </div>
                </div>
                <div class="col-lg-8 align-self-center">
                    <div class="services">
                        <div class="row">
                            <div class="col-lg-6">
                                <div data-tilt class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s">
                                    <div class="icon">
                                        <i class="fas fa-trophy"  style="height: 175px; width: 100px; color: #faba8e;"></i>
                                    </div>
                                    <div class="right-text">
                                        <p>Fakultas dengan perolehan gelar Juara Umum terbanyak adalah Fakultas Teknik</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div data-tilt class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.7s">
                                    <div class="icon">
                                        <i class="fas fa-film" style="height: 175px; width: 100px; color: #faba83;"></i>
                                    </div>
                                    <div class="right-text">
                                        <p>Video Digital Pendidikan merupakan cabang baru yang menggantikan cabang Film
                                            Pendek pada PIMUS sebelumnya</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div data-tilt class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="0.9s">
                                    <div class="icon">
                                        {{-- <i class="fas fa-hand-holding-heart"
                                            style="height: 175px; width: 100px; color: #faba8e;"></i> --}}
                                            <i><img src="{{ url('assets/images/logo/siluet.png') }}" alt="person graphic" style="height: 155px;  color: #faba8e;"></i>
                                    </div>
                                    <div class="right-text">
                                        <p>Maskot PIMUS merupakan burung hantu yang bernama Dr. Pimsy. Burung hantu
                                            merupakan hewan yang melambangkan pengetahuan, kebijaksanaan, dan pembawa
                                            perubahan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div data-tilt class="item wow fadeIn" data-wow-duration="1s" data-wow-delay="1.1s">
                                    <div class="icon">
                                        <i class="fas fa-hands-helping"
                                            style="height: 175px; width: 100px; color: #faba8e;"></i>
                                    </div>
                                    <div class="right-text">
                                        <p>Logo PIMUS berupa tangan-tangan dengan warna yang melambangkan setiap fakultas
                                            dan politeknik saling menggenggam satu sama lain dengan piala di bagian tengah
                                            yang diperebutkan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Fun Fact Pimus -->

    <!-- Throwback Pimus -->
    <div id="services" class="our-services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="left-image drive-responsive">
                        <iframe src="https://drive.google.com/file/d/1_ZlZre5YX7lt7cqatA618Igm9CUYuywM/preview" width="640"
                            height="400" allow="autoplay"></iframe>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="section-heading">
                        <h2 style="color: #ffffff; text-align: left; font-family: joyrideextended, Montserrat, sans-serif; text-transform: none;"
                            data-aos="zoom-in">pekan ilmiah mahasiswa</h2>
                        <p style="color: #fff; text-align:justify !important; " class="text-justify" >Pekan Ilmiah Mahasiswa Universitas Surabaya atau PIMUS merupakan acara tahunan yang diselenggarakan
                             oleh Direktorat Pengembangan Kemahasiswaan Universitas Surabaya dengan tujuan untuk menyaring mahasiswa/i terbaik UBAYA
                             untuk menjadi perwakilan pada kompetisi nasional. Di tahun yang kesebelas ini, PIMUS memiliki 7 cabang lomba yang terdiri
                              dari PKM 4 Bidang (PKM RSH, PKM K, PKM PM, PKM KC), Karya Tulis Ilmiah, Pemilihan Mahasiswa Berprestasi, Video Digital Pendidikan,
                              Kompetisi MIPAS, Debat Bahasa Inggris, dan Debat Bahasa Indonesia. Yuk daftarkan dirimu sekarang, dapatkan pengalaman berharga, kesempatan menjadi
                               perwakilan UBAYA, dan total hadiah puluhan juta rupiah!</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- End Throwback Pimus -->

    <!-- Timeline Pimus -->
    <h1 style="color: #ffffff; margin-top: 1em ; text-align: center; font-family: joyrideextended, Montserrat, sans-serif;"
        data-aos="zoom-in">timeline pimus xii</h1>
    <link rel="stylesheet" href="{{ url('/assets/css/timeline.css') }}">
    <div class="content">
        <div class="timeline col-lg-6 wow fadeInRight">
            <ul>
                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">7-14 November 2022</h3>
                        <h1>Open Registration </h1>
                    </div>
                </li>
                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">17-18 November 2022</h3>
                        <h1>Technical Meeting</h1>
                    </div>
                </li>
                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">23-24 November 2022</h3>
                        <h1>Klinik PKM, PILMAPRES, Video Digital Pendidikan, KTI</h1>
                    </div>
                </li>
                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">24-30 November 2022</h3>
                        <h1>Pengumpulan Proposal untuk di Revisi (PKM, KTI, dan Pilmapres)</h1>
                    </div>
                </li>
                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">2 Desember 2022</h3>
                        <h1>Pengumpulan Final Proposal (PKM, KTI, dan Pilmapres)</h1>
                    </div>
                </li>
                {{--

                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">30 Oktober 2021</h3>
                        <h1>Technical Meeting Debat Indonesia, Debat Inggris, K-MIPA, Poster</h1>
                    </div>
                </li>

                --}}
                <li>
                    <div class="timeline-content">
                        <h3 style="color: #ffffff" class="date">5-9 Desember 2022</h3>
                        <h1>Acara Perlombaan PIMUS XII</h1>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- End Timeline Pimus -->
@endsection

@section('script')
    <script>
        AOS.init();
    </script>
@endsection
