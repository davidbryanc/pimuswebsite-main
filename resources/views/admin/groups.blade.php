@extends('layout.admin')

@section('content')
@if (isset($_GET['messageType'], $_GET['message']))
    <div class="alert{{ $_GET['messageType'] == "success" ? " alert-success" : " alert-danger" }}" role="alert">
        {{ $_GET['message'] }}
    </div>    
@endif

<div class="position-relative">
    <h3>Group</h3>
    
    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Sekre' || Auth::user()->role == 'Acara')
        <a href="{{ route('admin.specialCase') }}" class="btn btn-success position-absolute top-0 end-0" style="font-weight: bolder">+</a>
    @endif
</div>

<div class="table-responsive">
    <table class="table align-middle text-center table-hover">
        <thead>
            <tr style="vertical-align: middle">
                <th scope="col">ID Kelompok</th>
                <th scope="col">Nama Ketua</th>
                <th scope="col">Cabang</th>
                <th scope="col">Formulir Pendaftaran</th>
                <th scope="col">Surat Pernyataan</th>
                <th scope="col">Jenis Kelompok</th>
                <th scope="col">Status</th>
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Sekre' || Auth::user()->role == 'Acara')
                    <th scope="col">Aksi</th>
                    <th scope="col">Hasil Karya</th>
                @endif
            </tr>
        </thead>
        <tbody>
            {{ $cabang = null }}
            @foreach ($arrGroups as $group)
                {{-- Make cabang section --}}
                @if ($cabang == null || $group->nama_cabang != $cabang)
                    <tr>
                        <th colspan="100%" class="text-uppercase py-4">{{ $group->nama_cabang }}</th>
                    </tr>
                    
                    <?php
                        $cabang = $group->nama_cabang
                    ?>
                @endif
                
                {{-- fill table --}}
                <tr>
                    <th scope="row">{{ $group->id }}</th>
    
                    <?php
                        $leaderName = null;
    
                        foreach ($arrDetailUsers as $detailUser) {
                            if ($detailUser->teams_id == $group->id) {
                                if ($detailUser->role == "Ketua") {
                                    $leaderName = $detailUser->nama_user;
                                    break;
                                }
                            }
                        }
                    ?>
    
                    {!! $leaderName != null ? "<td>$leaderName</td>" : "<td style='color: white; background-color: red;'>Tidak ada Ketua</td>" !!}
    
                    <td>{{ $group->nama_cabang }}</td>
                    <td>
                        @if ($group->registration_form != "empty")
                            <a href="/{{ $group->registration_form }}" target="_blank">Formulir Pendaftaran Kelompok {{ $group->id }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if ($group->statement_letter != "empty")
                            <a href="/{{ $group->statement_letter }}" target="_blank">Surat Pernyataan Kelompok {{ $group->id }}</a></td>
                        @else
                            -
                        @endif
                    <td>                       
                        {{ $group->competition_type != null ? $group->competition_type : "Individu" }}
                    </td>
                    <td>{{ $group->status }}</td>
    
                    @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Sekre' || Auth::user()->role == 'Acara')
                        {{-- Admin and Sekre only can edit --}}
                        <td>                    
                            <!-- Button Group Detail trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Detail{{ $group->id }}">
                                Detail
                            </button>
                        </td>
                        <td>                    
                            <!-- Button Show Submission trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#Show{{ $group->id }}">
                                Show
                            </button>
                        </td>
                    @endif
                </tr>
    
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Sekre' || Auth::user()->role == 'Acara')
                    {{-- Modals for Detail and Show submissions --}}
                    <!-- Modal Group Detail -->
                    <div class="modal fade" id="Detail{{ $group->id }}" tabindex="-1" aria-labelledby="Detail{{ $group->id }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <form action="{{ route('admin.editGroup') }}" method="POST">
                                    @csrf
    
                                    <div class="modal-header">
                                        <input type="hidden" name="idkelompok" value="{{ $group->id }}">
    
                                        <h5 class="modal-title" id="Detail{{ $group->id }}Label">Kelompok {{ $group->id }} ({{$group->nama_cabang}})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach ($arrDetailUsers as $detailUser)
                                            @if ($detailUser->teams_id == $group->id)
                                                <div>
                                                    <h5><b>{{ $detailUser->nama_user }}</b></h5>
                                                    <span>Role : {{ $detailUser->role }}</span><br>
                                                    <span>Gooaya : {{ $detailUser->email }}</span><br>
                                                    <span>
                                                        KTM : 
                                                        @if ($detailUser->id_card != "empty")
                                                            <a href="/{{ $detailUser->id_card }}" target="_blank">KTM {{ $detailUser->nama_user }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </span><br>
                                                    <span>
                                                        Pas Foto : 
                                                        @if ($detailUser->self_photo != "empty")
                                                            <a href="/{{ $detailUser->self_photo }}" target="_blank">Pas Foto {{ $detailUser->nama_user }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </span><br>
    
                                                    @if ($detailUser->role == "Ketua")
                                                        <span>
                                                            Line : 
                                                            @if ($detailUser->line != "empty")
                                                                <a href="https://line.me/ti/p/~{{ $detailUser->line }}" target="_blank">{{ $detailUser->line }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </span><br>
                                                        <span>
                                                            @if ($detailUser->phone_number != "empty")
                                                                <div>Nomor WA: {{ $detailUser->phone_number }}</div>
                                                            @else
                                                                <div>Nomor WA: - </div>
                                                            @endif
                                                        </span><br>
                                                    @endif
    
                                                    {{-- <span>
                                                        Jadwal Kuliah :
                                                        @if ($detailUser->schedule != "empty")
                                                             <a href="/{{ $detailUser->schedule }}" target="_blank">Jadwal Kuliah {{ $detailUser->nama_user }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </span><br> --}}
                                                    
                                                    {{-- Khusus Pilmapres --}}
                                                    @if ($group->nama_cabang == "Pilmapres")
                                                        <span>
                                                            Borang : 
                                                            @if ($detailUser->borang != "empty")
                                                                <a href="/{{ $detailUser->borang }}" target="_blank">Borang {{ $detailUser->nama_user }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </span><br>
                                                        <span>
                                                            Rekap IPK : 
                                                            @if ($detailUser->gpa_recap != "empty")
                                                                <a href="/{{ $detailUser->gpa_recap }}" target="_blank">Rekap IPK {{ $detailUser->nama_user }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </span><br>
                                                        <span>
                                                            Daftar Prestasi : 
                                                            @if ($detailUser->achievement_list != "empty")
                                                                <a href="/{{ $detailUser->achievement_list }}" target="_blank">Daftar Prestasi {{ $detailUser->nama_user }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </span><br>
                                                    @endif
    
                                                    {{-- Khusus Kompetisi MIPA --}}
                                                    @if ($group->nama_cabang == "Kompetisi MIPAS")
                                                        <span>
                                                            Jenis Kompetisi : 
                                                            @if ($detailUser->competition_type != "empty")
                                                                {{ $detailUser->competition_type }}
                                                            @else
                                                                -
                                                            @endif
                                                        </span><br>
                                                    @endif
                                                </div>
                                                
                                                <div class="dropdown-divider mt-4 mb-4"></div>
                                            @endif
                                        @endforeach
            
                                        <div>
                                            <label class="form-label">Status :</label>
                                            <select name="updateStatus" id="updateStatus" class="form-control">
                                                <option value="Pending"{{ $group->status == "Pending" ? ' selected=True' : ''}}>Pending</option>
                                                <option value="Terima"{{ $group->status == "Terima" ? ' selected=True' : ''}}>Terima</option>
                                                <option value="Tolak"{{ $group->status == "Tolak" ? ' selected=True' : ''}}>Tolak</option>
                                            </select>
                                        </div>
    
                                        <br>
    
                                        <div class="">
                                            <label class="form-label">Message :</label>
                                            <textarea class="form-control" name="detailMessage" placeholder="Leave a message here" id="floatingTextarea2" style="height: 100px">{{ $group->pesan ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
    
                    <!-- Modal Show Submission  -->
                    <div class="modal fade" id="Show{{ $group->id }}" tabindex="-1" aria-labelledby="Show{{ $group->id }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="Show{{ $group->id }}Label">Kelompok {{ $group->id }} ({{ $group->nama_cabang }})</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($arrSubmissions as $submission)
                                        @if ($submission->id == $group->id)
                                            <h5><b>Description</b></h5>
                                            <p>{{ $submission->description }}</p>
                                            <p>Link Exhibition : <a href="{{ $submission->link_exhibition }}" target="_blank">{{ $submission->link_exhibition }}</a></p>
                                            <p>Link Proposal : <a href="{{ $submission->link_proposal }}" target="_blank">{{ $submission->link_proposal }}</a></p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection