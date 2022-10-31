@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Exhibition
@endsection

@section('content')
    <section id="exhibition" style="margin-top: 150px;">

        <div class="container">
            <div class="row">
                <div class="col-12 exhibition-title">
                    <h1>exhibitions</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="wrapper">
                        <div class="card-exhibition">
                            <img src="{{ url('assets/images/exhibition/lynx.jpg') }}" alt="Gambar Lynx">
                            <div class="info">
                                <h1>Heading 1</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, molestias. Magni veniam
                                    officiis eligendi esse.</p>
                                <button class="btn-vote" data-bs-toggle="modal"
                                data-bs-target="#exhibitionCard">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="wrapper">
                        <div class="card-exhibition">
                            <img src="{{ url('assets/images/exhibition/eagle.jpg') }}" alt="Gambar Lynx">
                            <div class="info">
                                <h1>Heading 2</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, molestias. Magni veniam
                                    officiis eligendi esse.</p>
                                <button class="btn-vote" data-bs-toggle="modal"
                                data-bs-target="#exhibitionCard">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="wrapper">
                        <div class="card-exhibition">
                            <img src="{{ url('assets/images/exhibition/wolf.jpg') }}" alt="Gambar Lynx">
                            <div class="info">
                                <h1>Heading 3</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, molestias. Magni veniam
                                    officiis eligendi esse.</p>
                                <button class="btn-vote" data-bs-toggle="modal"
                                data-bs-target="#exhibitionCard">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="wrapper">
                        <div class="card-exhibition">
                            <img src="{{ url('assets/images/exhibition/bird.jpg') }}" alt="Gambar Lynx">
                            <div class="info">
                                <h1>Heading 4</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fuga, molestias. Magni veniam
                                    officiis eligendi esse.</p>
                                <button class="btn-vote" data-bs-toggle="modal"
                                data-bs-target="#exhibitionVideoCard">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="exhibitionVideoCard" tabindex="-1" aria-labelledby="exhibitionVideoCardLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ebb010;">
                    <h5 class="modal-title text-white" id="formGDriveSubmissionLabel">Poster</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form>
                            <div class="row justify-content-center mb-3 exhibition-content">
                                <div class="col-12 ex-video">
                                    <iframe src="https://drive.google.com/file/d/1hnVmk4jcJvmA1_pkUhsf-IGA-mkg4eZt/preview" style="width: 100%; height: 100%;" allow="autoplay"></iframe>
                                </div>
                                <div class="col-12">
                                    <h1 class="ex-title">Judul</h1>
                                    <h5>Jumlah votes: 5</h5>
                                    <p class="ex-by">
                                        abc - 1608xxxx <br>
                                        bca - 1608xxxx
                                    </p>
                                    <p class="ex-desc">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae, quisquam. Harum dolorum, voluptas illo inventore id consequatur nemo ea soluta, magni blanditiis eos tenetur similique iste, quas ullam hic quidem cumque unde reiciendis rerum eaque. Autem mollitia voluptatum ullam molestias ipsa vitae eligendi tempora esse, unde odio nostrum accusamus aliquam itaque porro adipisci, rem aut repudiandae blanditiis, hic quisquam laborum. Exercitationem enim nisi, numquam vero quasi, et corrupti tempora odio aut magnam expedita cupiditate eum commodi qui ex nemo excepturi voluptatum quibusdam cumque laboriosam deleniti maiores repudiandae reiciendis. Reprehenderit quidem, dolores inventore veniam nobis odio doloremque consequatur porro natus consectetur?
                                    </p>
                                    <div class="div-vote">
                                        <p class="text-danger">vote left: 5</p>
                                        <button type="submit" class="btnVote">Vote</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
