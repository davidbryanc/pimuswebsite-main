@extends('layout.mainweb')

@section('title')
    PIMUS 12 - About Us
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection

@section('content')
    <h2 class="aboutus-title">about us</h2>
    <!-- image slider -->
    <section id="slider">
        <div class="image-slider">
            <div class="slide active">
                <img src="{{ url('/assets/images/slider/1.jpg') }}" alt="1">

            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/2.jpg') }}" alt="2">

            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/3.jpg') }}" alt="3">
            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/4.jpg') }}" alt="4">
            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/5.jpg') }}" alt="5">
            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/6.jpg') }}" alt="6">
            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/7.jpg') }}" alt="7">
            </div>
            <div class="slide">
                <img src="{{ url('/assets/images/slider/8.jpg') }}" alt="8">
            </div>

            <div class="navigation">
                <div class="selector active"></div>
                <div class="selector"></div>
                <div class="selector"></div>
                <div class="selector"></div>
                <div class="selector"></div>
                <div class="selector"></div>
                <div class="selector"></div>
                <div class="selector"></div>
            </div>
        </div>
    </section>
    <!-- end image slider -->

    <!-- FAQ -->
    <section id="faq">
        <div class="container-faq" data-aos="zoom-in">
            <h2>frequently asked questions (faq)</h2>
            <div class="accordion-faq">
                <div class="icon"></div>
                <h5>Apakah tiap fakultas wajib memberikan 1 perwakilan?</h5>
            </div>
            <div class="panel">
                <p>Iya, namun disesuaikan kembali pada pedoman masing-masing cabang perlombaan.</p>
            </div>

            <div class="accordion-faq">
                <div class="icon"></div>
                <h5>Apakah pemenang PIMUS tahun sebelumnya boleh mengikuti PIMUS tahun ini?</h5>
            </div>
            <div class="panel">
                <p>Boleh, kecuali cabang lomba Pilmapres</p>
            </div>

            <div class="accordion-faq">
                <div class="icon"></div>
                <h5>Apakah dalam satu tim diperbolehkan terdiri dari fakultas yang berbeda?</h5>
            </div>
            <div class="panel">
                <p>Boleh.</p>
            </div>

            <div class="accordion-faq">
                <div class="icon"></div>
                <h5>Apakah boleh mengikuti lebih dari 1 cabang PIMUS?</h5>
            </div>
            <div class="panel">
                <p>boleh, namun peserta tidak dapat menjadi ketua di 2 cabang lomba yang berbeda.</p>
            </div>

            <div class="accordion-faq">
                <div class="icon"></div>
                <h5>Apa benefit yang didapatkan ketika mengikuti PIMUS?</h5>
            </div>
            <div class="panel">
                <p>Kalian bisa mendapat pengalaman, berkesempatan menjadi perwakilan Universitas Surabaya di ajang
                    perlombaan nasional maupun internasional. Selain itu, kalian juga bisa mendapatkan hadiah dengan total
                    puluhan juta rupiah.
                </p>
            </div>
        </div>
    </section>
    <!-- End FAQ -->

    <!-- Contact -->
    <div id="contact" class="contact-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                    <div class="section-heading">
                        <div class="google-maps">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.305509732659!2d112.76638771534648!3d-7.319538324008685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fae3f29c4665%3A0x7536c23b4453a79!2sUniversity%20of%20Surabaya!5e0!3m2!1sen!2sid!4v1630590815843!5m2!1sen!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay="1s">
                    <form id="contact" action="" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <fieldset>
                                    <input type="name" name="name" id="name" placeholder="Name" autocomplete="on" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <fieldset>
                                    <input type="surname" name="surname" id="surname" placeholder="Surname"
                                        autocomplete="on" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                        placeholder="Your Email" required="">
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="message" type="text" class="form-control" id="message"
                                        placeholder="Message" required=""></textarea>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-button ">Send Message</button>
                                </fieldset>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="phone-info col-lg-6 wow fadeInLeft">
                    <h4 style="color: #ffffff">Contact Us</h4>
                    <h2 style="color: #ffffff"><a style="color: #ffffff" href="https://www.instagram.com/pimus12/"
                            TARGET="_blank"><i class="bi bi-instagram"></i> Pimus12 </a></span></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact -->
@endsection


@section('script')
    <script src="assets/js/image-slider.js"></script>

    <script>
        AOS.init();
    </script>
@endsection
