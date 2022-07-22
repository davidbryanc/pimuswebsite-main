@extends('layout.mainweb')

@section('title')
    PIMUS 11 - Registration
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('/assets/css/register-cabang.css') }}">
@endsection

@section('content')
    {{-- card --}}
    @foreach ($cabang as $item)
    <section id="card">
        <div class="container">
            <div class="card-cabang">
                <?php
                    date_default_timezone_set('Asia/Jakarta');

                    foreach ($tanggal as $calendar) {
                        $timeNow = date('Y-m-d H:i:s');
                        $timeNow = strtotime($timeNow);

                        if ($timeNow > strtotime($calendar->awal) && $timeNow < strtotime($calendar->akhir))
                            $buka = true;
                        else
                            $buka = false;
                    }

                $nama_cabang = $item->nama == 'PKM-Riset' ? 'Program Kreativitas Mahasiswa' : $item->nama;

                echo '
                    <div class="image">
                        <img src="/assets/images/icon cabang/'.$item->nama.'.png" alt="Gambar '.$item->nama.'">
                    </div>
                    <div class="info">
                        <h1 class="title text-lowercase">'.$nama_cabang.'</h1>
                        <p class="desc">'.$item->deskripsi.'</p>';
                if ($userID==null) {
                    if ($buka == true) {
                        if($item->idlomba==8)
                            {
                                echo '
                                <div>
                                    <a href="/login" class="buttons" id="register">Register PKM-Riset</a><br><br>
                                    <a href="/login" class="buttons" id="register">Register PKM-Kewirausahaan</a><br><br>
                                    <a href="/login" class="buttons" id="register">Register PKM-Karsa Cipta</a><br><br>
                                    <a href="/login" class="buttons" id="register">Register PKM-Pengabdian kepada Masyarakat</a><br><br>
                                    <a href="/login" class="buttons" id="register">Register PKM-Penerapan IPTEK</a>
                                </div>
                                ';
            
                            }
                        else 
                            {
                                echo '
                                <div>
                                    <a href="/login" class="buttons" id="register">Register Now!</a>
                                </div>
                                ';
                        }
                    }
                    else {
                        echo '
                            <div class="mt-3" style="font-weight: bold;">
                                <p class="text-danger" style="font-size: 20px;">*) Masa Registrasi sudah selesai</p>
                            </div>
                            ';
                    }
                }
                else 
                {
                    if ($user==null) {
                        if ($buka == true) {
                            if($item->idlomba==8)
                                {
                                    echo '
                                    <div>
                                        <a href="/registration/cabang/register?cabang=8" class="buttons" id="register">Register PKM-Riset</a><br><br>
                                        <a href="/registration/cabang/register?cabang=9" class="buttons" id="register">Register PKM-Kewirausahaan</a><br><br>
                                        <a href="/registration/cabang/register?cabang=10" class="buttons" id="register">Register PKM-Karsa Cipta</a><br><br>
                                        <a href="/registration/cabang/register?cabang=11" class="buttons" id="register">Register PKM-Pengabdian kepada Masyarakat</a><br><br>
                                        <a href="/registration/cabang/register?cabang=12" class="buttons" id="register">Register PKM-Penerapan IPTEK</a>
                                    </div>
                                    ';            
                                }
                            else 
                                {
                                    echo '
                                    <div>
                                        <a href="/registration/cabang/register?cabang='.$item->idlomba.'" class="buttons" id="register">Register Now!</a>
                                    </div>
                                    ';
                                }
                        }
                        else {
                            echo '
                                <div class="mt-3" style="font-weight: bold;">
                                    <p class="text-danger" style="font-size: 20px;">*) Masa Registrasi sudah selesai</p>
                                </div>
                                ';
                        }  
                    }
                    else {                        
                        foreach ($user as $item1) {
                            $status = $item1->status;
                            $pesan = $item1->pesan;
                            if($status=='Tolak')
                            {
                                if($item->idlomba==8)
                                {
                                    echo '
                                    <div>
                                        <a href="/registration/cabang/register?cabang=8" class="buttons" id="register">Register PKM-Riset</a><br><br>
                                        <a href="/registration/cabang/register?cabang=9" class="buttons" id="register">Register PKM-Kewirausahaan</a><br><br>
                                        <a href="/registration/cabang/register?cabang=10" class="buttons" id="register">Register PKM-Karsa Cipta</a><br><br>
                                        <a href="/registration/cabang/register?cabang=11" class="buttons" id="register">Register PKM-Pengabdian kepada Masyarakat</a><br><br>
                                        <a href="/registration/cabang/register?cabang=12" class="buttons" id="register">Register PKM-Penerapan IPTEK</a>
                                    </div>
                                    ';
            
                                }
                                else 
                                {
                                    echo '
                                    <div>
                                        <a href="/registration/cabang/register?cabang='.$item->idlomba.'" class="buttons" id="register">Register Now!</a>
                                    </div>
                                    ';
                                }
                                echo '
                                <div class="mt-3" style="font-weight: bold;">
                                    <p class="text-danger" style="font-size: 20px;">*) Registrasi '.$item1->nama.' Anda ditolak karena '.$pesan.'</p>
                                </div>
                                ';
                            }
                            else
                            {
                                echo '<div class="mt-3" style="font-weight: bold;"> ';
    
                                if ($status == 'Terima') {
                                    echo ' <p class="text-success" style="font-size: 20px;">*) Registrasi '.$item1->nama.' Anda di'.strtolower($status).'</p>';
                                } elseif ($status == 'Pending'){
                                    echo ' <p class="text-warning" style="font-size: 20px;">*) Registrasi '.$item1->nama.' Anda sedang '.strtolower($status).'</p>';
                                }
                                                        
                                echo '</div>';
                            }
                        }
                    }
                }
                echo '</div>';
                ?>
            </div>
        </div>
    </section>
    @endforeach
@endsection
