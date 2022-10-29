@extends('layout.mainweb')

@section('title')
    PIMUS 11 - Register
@endsection

@section('content')
    <section id="form" style="margin-top: 150px; margin-bottom: 50px;">
        <div class="container">
            <div >
            <form action="/registration/cabang/upload" method="POST" enctype="multipart/form-data" class="form-register">
                @csrf
                <div id="awal" style="visibility: visible; display: block;">
                    <div style="text-align: center;">
                        <h1 class="text-lowercase">form registrasi {{$category->name}}</h1>  
                    </div>
                    <input type="text" id="cabang" value="{{$category->id}}" name="idLomba" readonly hidden>
                    @if ($team!=null)
                        @if ($teamLeader != null)
                            <label>Edit Kelompok</label><br>
                            @foreach ($team as $item1)
                                @foreach ($teamLeader as $ketua)
                                    @if ($ketua->idkelompok == $item1->idkelompok)
                                            <input type="radio" id="{{$item1->idkelompok}}" name="idKelompok" value="{{$item1->idkelompok}}" required>
                                            <label for="{{$item1->idkelompok}}">Kelompok {{$item1->idkelompok}} (Ketua : {{$ketua->nama}})</label><br>
                                    @endif
                                @endforeach
                            @endforeach
                            <label><small>*) Pilihan di atas ini ada karena anda telah terdaftar pada 1 atau lebih kelompok pada cabang lomba ini</small></label><br><br>
                        @else
                            {{-- Error because no leader --}}
                            <input type="hidden" name="idKelompok" value="{{$item1->idkelompok}}" readonly>
                        @endif
                    @else
                        <input type="text" name="idKelompok" value='' readonly hidden>
                    @endif
                    
                    <div>
                        <h3 class="text-danger"><b>PERHATIAN!!!</b></h3>                    
                        <p class="text-danger">
                            Untuk pendaftaran lomba <b>HANYA</b> perwakilan (1 orang) yang mengisi pendaftaran di website, <b>BUKAN</b> seluruh anggota mengisi.
                        </p>
                    </div>
                    <br>

                    <?php
                    $id = $category->id;
                    if($id!=1 && $id!=5)
                    {
                        echo '
                        <input type="text" id="nrpKetua" pattern="[0-9]{9}" onchange="nrp();" title="NRP UBAYA" placeholder="NRP Ketua Kelompok" maxlength="9" required><br>

                        <input type="text" name="line" placeholder="ID Line Ketua Kelompok" required><br>
                        <input type="text" name="wa" placeholder="Nomor WhatsApp Ketua Kelompok" required><br>

                        <label>Surat Pernyataan Kesediaan Mewakili Ubaya (.pdf)</label><br>
                        <input type="file" name="suratPernyataan" class="inputLomba" accept=".pdf" required><br>
                        <label class="label-keterangan">*) wajib diprint, diberi materai Rp 10.000,00, diberi tandatangan basah mengenai materai Rp10.000,00<br>
                        format nama file: Surat Pernyataan_Nama_NRP</label><br>

                        <label>Jumlah Anggota Kelompok</label><br>
                        <input type="radio" id="jumlahAnggota2" name="jumlahAnggota" value="2" onclick="displayForm(this.value);" checked required>
                        <label for="jumlahAnggota2">2</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="jumlahAnggota3" name="jumlahAnggota" value="3" onclick="displayForm(this.value);" required>
                        <label for="jumlahAnggota3">3</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="jumlahAnggota4" name="jumlahAnggota" value="4" onclick="displayForm(this.value);" required>
                        <label for="jumlahAnggota4">4</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" id="jumlahAnggota5" name="jumlahAnggota" value="5" onclick="displayForm(this.value);" required>
                        <label for="jumlahAnggota5">5</label><br>
                        <label class="label-keterangan">*) termasuk ketua kelompok</label><br>
                        ';
                    }
                    else
                    {
                        echo '
                        <input type="number" name="jumlahAnggota" value=1 hidden readonly>

                        <input type="text" pattern="[0-9]{9}" name="nrpAnggota[]" title="NRP UBAYA" placeholder="NRP" maxlength="9" required><br>

                        <input type="text" name="line" placeholder="ID Line" required><br>

                        <input type="text" name="wa" placeholder="Nomor WhatsApp" required><br>
                        ';   
                    }
                    $formPendaftaran = '
                    <label>Form Pendaftaran (.pdf)</label><br>
                    <input type="file" name="formDaftar" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) format nama file: Nama_NRP</label><br>
                    ';
                    $pilmapres = '
                    <label>Surat Pernyataan Kesediaan Mewakili Ubaya (.pdf)</label><br>
                    <input type="file" name="suratPernyataan" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) wajib diprint, diberi materai Rp 10.000,00, diberi tandatangan basah mengenai materai Rp10.000,00<br>
                        format nama file: KesediaanMP_Nama Depan_NRP</label><br>

                    <label>Rekap IPK (.pdf)</label><br>
                    <input type="file" name="rekapIPK" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) Dalam bentuk Transkrip. Format nama: Transkrip_Nama Depan_NRP </label><br>

                    <label>Daftar 10 Prestasi + Bukti (.pdf)</label><br>
                    <input type="file" name="daftarPrestasi" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) format nama file: PrestasiMP_Nama Depan_NRP</label><br>

                    <label>Scan KTM / Screenshot Kartu Studi MyUbaya dan KTP / KITAS (.pdf)</label><br>
                    <input type="file" name="ktm1" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) Screenshot MyUbaya pada bagian Kartu Studi Mahasiswa (dalam fitur KS/KHS) wajib terdapat Nama dan NRP
                        <br>format nama file: KTMKTP-MP_Nama Depan_NRP / KTMKITAS-MP_Nama Depan_NRP </label><br>

                    <label>Pas Foto 4x6 (.png / .jpg)</label><br>
                    <input type="file" name="pasFoto1" class="inputLomba" accept=".png, .jpg" required><br>
                    <label class="label-keterangan">*) format nama file: PasFotoMP_Nama Depan_NRP</label><br>

                    <label>Jadwal Kuliah (.pdf)</label><br>
                    <input type="file" name="jadwalKuliah1" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) format nama file: JadwalPerkuliahanMP_Nama Depan_NRP</label><br>
                    ';
                    $tambahan = '
                    <label>Pas Foto 4x6 (.png / .jpg)</label><br>
                    <input type="file" name="pasFoto1" class="inputLomba" accept=".png, .jpg" required><br>
                    <label class="label-keterangan">*) format nama file: Foto_Nama_NRP</label><br>

                    <label>Jadwal Kuliah (.pdf)</label><br>
                    <input type="file" name="jadwalKuliah1" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) format nama file: Jadwal_Nama_NRP</label><br>
                    ';
                    $pilihanMIPA = '
                    <label>Surat Pernyataan Kesediaan Mewakili Ubaya (.pdf)</label><br>
                    <input type="file" name="suratPernyataan" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) wajib diprint, diberi materai Rp 10.000,00, diberi tandatangan basah mengenai materai Rp10.000,00<br>
                    format nama file: Surat Pernyataan_Nama_NRP</label><br>
                    
                    <label>Scan KTM / Screenshot Kartu Studi MyUbaya (.pdf)</label><br>
                    <input type="file" name="ktm1" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) Screenshot MyUbaya pada bagian Kartu Studi Mahasiswa (dalam fitur KS/KHS) wajib terdapat Nama dan NRP
                        <br>format nama file: KTM_Nama_NRP / MyUbaya_Nama_NRP</label><br>

                    <label>Pas Foto 4x6 (.png / .jpg)</label><br>
                    <input type="file" name="pasFoto1" class="inputLomba" accept=".png, .jpg" required><br>
                    <label class="label-keterangan">*) format nama file: Foto_Nama_NRP</label><br>
                    
                    <label>Jadwal Kuliah (.pdf)</label><br>
                    <input type="file" name="jadwalKuliah1" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) format nama file: Jadwal_Nama_NRP</label><br>
                    ';
                    echo $formPendaftaran;
                    
                    switch ($id) {
                        case 1:
                            echo $pilmapres;
                            break;
                        
                        case 5:
                            echo $pilihanMIPA;
                            break;
                    }
                    ?>
                </div>
                <div id="lanjutan" onload="displayForm(1);">
                </div>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
        </div>
    </section>
@endsection

<script>
    //[JABESH]
    function gantiJumlah()
    {
        try {
            const id = document.getElementById('cabang').value;

            console.debug(id);
                
            if (id > 1 && id < 5 || id > 5) {
                console.debug("masuk if");
                displayForm(2);
            }
            else
                console.debug("masuk else");
        }
        catch (error) {
            setTimeout(function() { gantiJumlah(); }, 500);
        }
    }

    window.onload = gantiJumlah();

    function nrp() 
    {
        const nama = document.getElementById('nrpKetua').value;
        document.getElementById('nrpAnggota1').value = nama;
    }

    function displayForm(val)
    {
        const form = document.getElementById('lanjutan');
        const cabang = document.getElementById('cabang').value;
        form.innerHTML='';
        if(cabang!=1 || cabang!=5)
        {
            for(let i=1; i<=val; i++)
            {
                if(i==1)
                {
                    form.innerHTML += `<label>Ketua</label><br>`;
                }
                else
                {
                    form.innerHTML += `<label>Anggota ${i-1}</label><br>`;
                }
                form.innerHTML += `
                <input type="text" pattern="[0-9]{9}" id="nrpAnggota${i}" name="nrpAnggota[]" title="NRP UBAYA" placeholder="NRP" required><br>
                <label>Pas Foto 4x6 (.png / .jpg)</label><br>
                <input type="file" name="pasFoto${i}" class="inputLomba" accept=".png, .jpg" required><br>
                <label class="label-keterangan">*) format nama file: Foto_Nama_NRP</label><br>
                <label>Scan KTM / Screenshot Kartu Studi MyUbaya(.pdf)</label><br>
                <input type="file" name="ktm${i}" class="inputLomba" accept=".pdf" required><br>
                <label class="label-keterangan">*) Screenshot MyUbaya pada bagian Kartu Studi Mahasiswa (dalam fitur KS/KHS) wajib terdapat Nama dan NRP
                    <br>format nama file: KTM_Nama_NRP / MyUbaya_Nama_NRP</label><br>
                `;
                if(cabang>=2 && cabang<=4 || cabang>=6 && cabang<=7)
                {
                    form.innerHTML += `
                    <label>Jadwal Kuliah (.pdf)</label><br>
                    <input type="file" name="jadwalKuliah${i}" class="inputLomba" accept=".pdf" required><br>
                    <label class="label-keterangan">*) format nama file: Jadwal_Nama_NRP</label><br>
                    `;
                }
            }
            nrp();
            document.getElementById('nrpAnggota1').readOnly = true;
        }
    }
</script>