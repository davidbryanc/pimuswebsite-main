@extends('layout.mainweb')

@section('title')
PIMUS 11 - Exhibition
@endsection

@section('content')
<section id="exhibition" style="margin-top: 150px;">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('errorMessage') }}
            </div>
        @endif


        <div class="row">
            <div class="col-12 exhibition-title">
                <h1>exhibition {{ $cabang->nama }}</h1>
            </div>
        </div>

        <div class="row">
            @if ($submissions->count() != 0)
                @php
                    // For submission counter
                    $counter = 1;
                @endphp
                @foreach ($submissions as $submission)
                @if ($submission->link_poster_youtube!=null)
                @php
                $matches=array();
                $img='';
                $video='';
                $kti='';
                switch ($submission->idlomba) {
                    case 1:
                        preg_match('/(?<=file\/d\/)(.*)(?=\/)/', $submission->link_poster_youtube, $matches);
                        $img='https://drive.google.com/uc?export=view&id='.$matches[0];
                        break;
                    
                    case 4:
                        preg_match('/(?<=file\/d\/)(.*)(?=\/)/', $submission->link_poster_youtube, $matches);
                        $img='https://drive.google.com/uc?export=view&id='.$matches[0];
                        break;
                        
                    case 6:
                        preg_match('/(?<=file\/d\/)(.*)(?=\/)/', $submission->link_poster_youtube, $matches);
                        $img='https://drive.google.com/uc?export=view&id='.$matches[0];
                        break;
        
                    case 7:
                        preg_match('/(?<=youtu.be\/)(.*)/', $submission->link_poster_youtube, $matches);
                        $img='https://img.youtube.com/vi/'.$matches[0].'/0.jpg';
                        $video='https://www.youtube.com/embed/'.$matches[0];
                        break;
                }
                @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="wrapper">
                            <div class="card-exhibition">
                                <img src="{{ url($img) }}" alt="{{ $cabang->nama." ".$counter }}">
                                <div class="info">
                                    <h1>{{ $cabang->nama." ".$counter }}</h1>
                                    <p>
                                        <i>
                                            @if ($submission->idkelompok != null)
                                                {{-- Get group leader name if no name --}}
                                                @php
                                                    $name = null;
        
                                                    foreach ($leaders as $leader) {
                                                        if ($leader->idkelompok == $submission->idkelompok)
                                                            $name = $leader->nama;
                                                    }
                                                @endphp
                                                
                                                @if ($name == null)
                                                    Error No Name
                                                @else
                                                    {{ $name }}
                                                @endif
                                            @else
                                                {{ $submission->nama }}
                                            @endif    
                                        </i>
                                    </p>
                                    <button class="btn-vote" data-bs-toggle="modal"
                                        data-bs-target="#exhibitionCard{{ $submission->id }}">Read
                                        More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exhibitionCard{{ $submission->id }}" tabindex="-1"
                        aria-labelledby="exhibitionCardLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #ebb010;">
                                    <h5 class="modal-title text-white" id="formExhibition">Exhibition {{ $cabang->nama }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <form action="{{ route('exhibition.vote', [
                                            'id' => $submission->id
                                        ]) }}" method="POST">
                                            @csrf
                                            <div class="row justify-content-center mb-3 exhibition-content">
                                                    @switch($cabang->idlomba)
                                                        @case(1)
                                                            <div class="col-lg-4 col-md-12 mt-3">
                                                                <a href="{{ url($img) }}" target="_blank">
                                                                    <img class="exhibition-img"
                                                                        src="{{ url($img) }}"
                                                                        alt="{{ $cabang->nama." ".$counter }}">
                                                                </a>
                                                            </div>
                                                            @break
                                                        @case(4)
                                                            <div class="col-lg-4 col-md-12 mt-3">
                                                                <a href="{{ url($img) }}" target="_blank">
                                                                    <img class="exhibition-img"
                                                                        src="{{ url($img) }}"
                                                                        alt="{{ $cabang->nama." ".$counter }}">
                                                                </a>
                                                            </div>
                                                            @break
                                                        @case(6)
                                                            <div class="col-lg-4 col-md-12 mt-3">
                                                                <a href="{{ url($img) }}" target="_blank">
                                                                    <img class="exhibition-img"
                                                                        src="{{ url($img) }}"
                                                                        alt="{{ $cabang->nama." ".$counter }}">
                                                                </a>
                                                            </div>
                                                            @break
                                                        @case(7)
                                                            <div class="col-12 ex-video">
                                                                <iframe class="exhibition-content" style="width: 100%; height: 100%;"
                                                                    src="{{ url($video) }}?autoplay=0&rel=0" allow="fullscreen">
                                                                </iframe>
                                                            </div>
                                                        @break
                                                    @endswitch
                                                <div class="col-lg-8 col-md-12 mt-3">
                                                    <h1 class="ex-title">
                                                        {{ $cabang->nama." ".$counter }}</h1>
                                                    <h5>Jumlah votes: {{ $submission->like_count }}</h5>
                                                    <p class="ex-by">
                                                        Ketua :
                                                        @if ($submission->idkelompok != null)
                                                            {{-- Get group leader name if no name --}}
                                                            @php
                                                                $name = null;
        
                                                                foreach ($leaders as $leader) {
                                                                    if ($leader->idkelompok == $submission->idkelompok)
                                                                        $name = $leader->nama;
                                                                }
                                                            @endphp
                                                            
                                                            @if ($name == null)
                                                                <i>Error No Name</i>
                                                            @else
                                                                {{ $name }}
                                                            @endif
                                                        @else
                                                            {{ $submission->nama }}
                                                        @endif
                                                    </p>
                                                    <p class="ex-desc">
                                                        {{ $submission->deskripsi }}
                                                    </p>
                                                    <div class="div-vote">
                                                        @if (!Auth::guest())
                                                            <p class="text-danger">vote left: {{ Auth::user()->tiket_vote }}</p>
                                                        @endif

                                                        @if (time() <= strtotime("2021-11-12 00:00:00"))
                                                            <button type="submit" class="btnVote">Vote</button>
                                                        @else
                                                            <br>
                                                            <h4 style="color: red">*) Masa Vote telah berakhir</h4>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                @else
                    <div class="alert alert-light" role="alert">
                        There's no data
                    </div>
            @endif
        </div>
</section>
@endsection