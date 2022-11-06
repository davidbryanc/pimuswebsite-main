@if(isset($pesan))
{
    <script type='text/javascript'>alert('{{ $pesan }}')</script>
}
@endif
@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Registration
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
@endsection

@section('content')
    {{-- Registration card --}}
    <div id="portfolio" class="our-portfolio section" style="margin-bottom: 80px;">
        <div class="container">
            <div class='row'><p></p>
                <div class='col-lg-6 offset-lg-3 mt-5'>
                    <div class='section-heading  wow bounceIn' data-wow-duration='1s' data-wow-delay='0.2s'>
                        <h2>cabang lomba</h2>
                        <button class='btn-mekanisme' data-bs-toggle='modal' data-bs-target='#mekanisme'>Mekanisme Pendaftaran</button>
                    </div>
                </div>
            </div>
            <div class='row mb-3'>
                <div class='col-lg-3 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=1'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.3s'>
                            <div class='hidden-content'>
                                <h4>PILMAPRES</h4>
                                <p>Kompetisi mahasiswa/i UBAYA yang memiliki keunggulan bidang akademik maupun non akademik.
                                </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Pilmapres.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-lg-3 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=2'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.4s'>
                            <div class='hidden-content'>
                                <h4>Debat Inggris</h4>
                                <p>Kompetisi yang mengasah kemampuan berpikir kritis dan berargumentasi dengan menggunakan Bahasa Inggris. </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Debat Inggris.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-lg-3 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=3'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.5s'>
                            <div class='hidden-content'>
                                <h4>Debat Indonesia</h4>
                                <p>Kompetisi yang mengasah kemampuan berpikir kritis dan berargumentasi dengan menggunakan Bahasa Indonesia.
                                </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Debat Indonesia.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-lg-3 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=4'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.4s'>
                            <div class='hidden-content'>
                                <h4>KTI</h4>
                                <p>Kompetisi untuk menuliskan ide kreatif berupa respons intelektual atas persoalan aktual. </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Karya Tulis Ilmiah.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
       
                <div class='col-lg-4 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=5'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.5s'>
                            <div class='hidden-content'>
                                <h4>Kompetisi MIPAS</h4>
                                <p>Kompetisi di bidang Matematika, Ilmu Pengetahuan Alam dan Statisik. </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Kompetisi MIPAS.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
                <div class='col-lg-4 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=7'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.5s'>
                            <div class='hidden-content'>
                                <h4>Video Digital Pendidikan</h4>
                                <p>Kompetisi membuat suatu karya video pendidikan sesuai dengan tema yang ditentukan. </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Video Digital Pendidikan.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
                {{-- <div class='col-lg-3 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=6'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.4s'>
                            <div class='hidden-content'>
                                <h4>Poster Digital</h4>
                                <p>Kompetisi untuk menyampaikan informasi dalam bentuk visual sesuai dengan tema yang ditentukan. </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/Poster Digital.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div> --}}
                <div class='col-lg-4 col-sm-6 mb-5'>
                    <a href='/registration/cabang?cabang=8'>
                        <div class='item wow bounceInUp' data-wow-duration='1s' data-wow-delay='0.5s'>
                            <div class='hidden-content'>
                                <h4>PKM</h4>
                                <p>Kompetisi untuk mengkaji, mengembangkan, dan menerapkan ilmu serta teknologi kepada masyarakat luas.
                                </p>
                            </div>
                            <div class='showed-content'>
                                <img src='/assets/images/icon cabang/PKM-Riset Sosial Humaniora.png' alt=''>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            </div>
    </div>


    <!-- Modal -->
        <div class="modal fade" id="mekanisme" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header" style="background-color: #211e51;">
                <h5 class="modal-title text-white fw-bold" id="exampleModalLabel">Mekanisme Pendaftaran PIMUS XI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    1. Peserta melengkapi berkas yang dibutuhkan untuk pendaftaran sesuai dengan pedoman cabang/PKM yang diikuti. Pedoman dapat dilihat <a href='https://drive.google.com/drive/folders/11A7k7Ng94aJzfCg4UygO67BsS-D3IEQI' target='_blank'>disini</a>.<br>
                    2. Pendaftaran dapat dilakukan pada website <a href='https://pimusubaya.com' target='_blank'>pimusubaya.com</a><br>
                    3.  Peserta harus register/sign up terlebih dahulu pada website.<br>
                        <small class='text-danger'>Note &#58; Jika mendaftar berkelompok, maka seluruh anggota harus register/sign up terlebih dahulu pada website sebelum melakukan pendaftaran.</small><br>
                    4. Peserta mengupload formulir pendaftaran dan seluruh berkas yang dibutuhkan sesuai dengan cabang/PKM yang diikuti.<br>
                        <small class='text-danger'>Note &#58; File formulir pendaftaran terdapat di folder berkas wajib.</small><br>
                    5. Perhatikan ketentuan pada saat mendaftar dan pastikan telah sesuai.<br>
                    6. Berkas yang telah disubmit saat pendaftaran akan dilakukan pengecekan oleh panitia.<br>
                    7. Jika berkas yang dikumpulkan tidak sesuai dengan ketentuan, panitia akan menghubungi ketua kelompok untuk mensubmit ulang berkas pendaftaran.<br>
                    8. Jika hingga batas akhir pendaftaran, berkas yang dikumpulkan tidak sesuai maka peserta dianggap <b>TIDAK TERDAFTAR SEBAGAI PESERTA PIMUS XII.</b><br>
                </p>
            </div>
            </div>
        </div>
        </div>
    {{-- end registration card --}}
@endsection

@section('script')
    <script src="assets/js/image-slider.js"></script>
@endsection
