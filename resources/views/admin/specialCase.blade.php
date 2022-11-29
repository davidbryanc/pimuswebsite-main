@extends('layout.admin')

@section('content')
    <h3>Tambah Kelompok</h3>

    <br>

    <form action="{{ route('admin.addGroup') }}" method="POST">
        @csrf

        <div class="mb3 mt-3">
            <label class="form-label">Cabang Lomba</label>
            <select name="contest" id="cabangLomba" class="form-select" onchange="contestType()" required>
                <option selected disabled>Lomba</option>
                @foreach ($contest as $lomba)
                    <option value="{{ $lomba->id }}">{{ $lomba->name }}</option>
                @endforeach
            </select>
        </div>

        <div id="form">

        </div>

        <button type="submit" id="btnSubmit" class="btn btn-primary mt-3">Submit</button>
    </form>
@endsection

@section('script')
<script>
    function contestType() {
        var select = document.getElementById('cabangLomba');
        var type = Number(select.options[select.selectedIndex].value);

        const form = document.getElementById('form');
        
        if (type in [1, 5]) {
            form.innerHTML = "";
            form.innerHTML = `
                <div class="mb3 mt-3">
                    <label class="form-label">Peserta</label>
                    <select class="form-select" name="nrpKetua" required>
                        <option selected disabled>NRP - Nama</option>
                        @foreach ($contestants as $contestant)
                            <option value="{{ $contestant->nrp }}">{{ $contestant->nrp }} - {{ $contestant->name }}</option>
                        @endforeach
                    </select>
                </div>
            `;

            document.getElementById('btnSubmit').disabled = false;
        }
        else if (type in [2, 3, 4, 6, 7, 8, 9, 10, 11, 12]) {
            form.innerHTML = "";
            form.innerHTML = `
                <div class="mb3 mt-3">
                    <label>Jumlah Anggota Kelompok</label><br>
                    <input type="radio" id="jumlahAnggota2" name="jumlahAnggota" value="2" onclick="updateAnggota(this.value);" checked required>
                    <label for="jumlahAnggota2">2</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="jumlahAnggota3" name="jumlahAnggota" value="3" onclick="updateAnggota(this.value);" required>
                    <label for="jumlahAnggota3">3</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="jumlahAnggota4" name="jumlahAnggota" value="4" onclick="updateAnggota(this.value);" required>
                    <label for="jumlahAnggota4">4</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="jumlahAnggota5" name="jumlahAnggota" value="5" onclick="updateAnggota(this.value);" required>
                    <label for="jumlahAnggota5">5</label><br>
                    <label class="label-keterangan">*) termasuk ketua kelompok</label><br>
                </div>
        
                <div class="mb3 mt-3">
                    <label class="form-label">Ketua</label>
                    <select class="form-select" name="nrpKetua" required>
                        <option selected disabled>NRP - Nama</option>
                        @foreach ($contestants as $contestant)
                            <option value="{{ $contestant->nrp }}">{{ $contestant->nrp }} - {{ $contestant->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb3 mt-3">
                    <label class="form-label">Anggota 1</label>
                    <select class="form-select" name="nrpAnggota[]" required>
                        <option selected disabled>NRP - Nama</option>
                        @foreach ($contestants as $contestant)
                            <option value="{{ $contestant->nrp }}">{{ $contestant->nrp }} - {{ $contestant->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="additionalMember">
                </div>
            `;

            document.getElementById('btnSubmit').disabled = false;
        }
        else
            document.getElementById('btnSubmit').disabled = false;
    }

    function updateAnggota (amount) {
        const additionalMember = document.getElementById('additionalMember');

        if (amount > 2) {
            additionalMember.innerHTML = "";

            for (let i = 0; i < amount - 2; i++) {
                additionalMember.innerHTML += `
                    <div class="mb3 mt-3">
                        <label class="form-label">Anggota ${i+2}</label>
                        <select class="form-select" name="nrpAnggota[]" required>
                            <option selected disabled>NRP - Nama</option>
                            @foreach ($contestants as $contestant)
                                <option value="{{ $contestant->nrp }}">{{ $contestant->nrp }} - {{ $contestant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                `;
            }
        }
        else {
            additionalMember.innerHTML = "";
        }
    }

    window.onload = contestType();
</script>
@endsection