@extends('layout.admin')

@section('style')
    
@endsection

@section('content')
    @if (isset($_GET['messageType'], $_GET['message']))
        @if ($_GET['messageType'] == "success")
            <div class="alert alert-success" role="alert">
                {{ $_GET['message'] }}
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                {{ $_GET['message'] }}
            </div>
        @endif
    @endif

    <div style="position: relative">
        <h3>Submissions</h3>
    
        @if (in_array(Auth::user()->role, ["Admin", "Sekre", "Acara"]))            
            <button type="button" class="btn btn-success position-absolute top-0 end-0" style="font-weight: bolder" data-bs-toggle="modal" data-bs-target="#AddSubmission">
                +
            </button>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table align-middle text-center table-hover">
            <thead>
                <tr style="vertical-align: middle">
                    <th scope="col">Nama Ketua</th>
                    <th scope="col">
                        Like
                        <br>
                        @foreach ($countLike as $like)
                            <small>Total : {{ $like->count_like }}</small>
                        @endforeach
                    </th>
                    <th scope="col">Link Poster/Video</th>
                    <th scope="col">Link Proposal</th>
                    @if (in_array(Auth::user()->role, ["Admin", "Sekre", "Acara"]))
                        <th scope="col">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $idContest = null;
                @endphp
                @foreach ($submissions as $submission)
                    {{-- Make cabang lomba divider --}}
                    @if ($idContest == null || $submission->competition_categories_id != $idContest)
                        @php
                            $idContest = $submission->competition_categories_id;    
                        @endphp

                        @foreach ($contests as $contest)
                            @if ($contest->id == $idContest)
                                <tr>
                                    <th class="text-uppercase py-4" colspan="100%">{{ $contest->name }}</th>
                                </tr>
                            @endif
                        @endforeach
                    @endif

                    <tr>
                        <th scope="row">
                            @php
                                $name = null;
                            @endphp
                            @if ($submission->teams_id != null)
                                {{-- Get group leader name if no name --}}
                                @php
                                    foreach ($leaders as $leader) {
                                        if ($leader->teams_id == $submission->teams_id)
                                            $name = $leader->name;
                                    }
                                @endphp
                                
                                @if ($name == null)
                                    <i>Error No Name</i>
                                @else
                                    {{ $name }}
                                @endif
                            @else
                                {{ $submission->name }}
                            @endif
                        </th>
                        <td>{{ $submission->like_count }}</td>
                        <td><a href="{{ $submission->link_exhibition }}" target="_blank">Show Poster/Video</a></td>
                        <td><a href="{{ $submission->link_proposal }}" target="_blank">Show Proposal</a></td>
                        <td>
                            <!-- Button Update submission trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Show{{ $submission->id }}">
                                Update
                            </button>   
                            <!-- Button Delete submission trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Delete{{ $submission->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>

                    @if (in_array(Auth::user()->role, ["Admin", "Sekre", "Acara"]))
                        <!-- Modal Update Submissions  -->
                        <div class="modal fade" id="Show{{ $submission->id }}" tabindex="-1" aria-labelledby="Show{{ $submission->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form action="{{ route('admin.editSubmissions') }}" method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <input type="hidden" name="id" value="{{ $submission->id }}">

                                            <h5 class="modal-title" id="Show{{ $submission->id }}Label">UPDATE : {{ isset($name) ? $name : $submission->nama }} ( ID Submission {{ $submission->id }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="updateContest" class="form-label">Cabang Lomba :</label>
                                                <select name="updateContest" id="updateContest" class="form-select">
                                                    @foreach ($contests as $contest)
                                                        <option value="{{ $contest->id }}"{{ $contest->id == $submission->competition_categories_id ? " selected" : "" }}>{{ $contest->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="updateName" class="form-label">Nama Ketua :</label>
                                                <input type="text" class="form-control" name="updateName" id="updateName" value="{{ $name == null ? ($submission->name == null ? "-" : $submission->name) : $name }}">
                                            </input>

                                            <div class="mb-3">
                                                <label for="updateDescription" class="form-label">Deskripsi :</label>
                                                <textarea name="updateDescription" id="updateDescription" cols="30" rows="5" class="form-control">{{ $submission->description }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="updateLinkExhibition" class="form-label">Link Poster/Video : <a target="_blank" href="{{ $submission->link_exhibition }}">Show Link</a></label>
                                                <textarea name="updateLinkExhibition" id="updateLinkExhibition" cols="30" rows="2" class="form-control">{{ $submission->link_exhibition }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="updateLinkProposal" class="form-label">Link Proposal : <a target="_blank" href="{{ $submission->link_proposal }}">Show Link</a></label>
                                                <textarea name="updateLinkProposal" id="updateLinkProposal" cols="30" rows="2" class="form-control">{{ $submission->link_proposal }}</textarea>
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

                        <!-- Modal Delete User  -->
                        <div class="modal fade" id="Delete{{ $submission->id }}" tabindex="-1" aria-labelledby="Delete{{ $submission->id }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <form action="{{ route('admin.deleteSubmissions') }}" method="POST">
                                        @csrf

                                        <div class="modal-header">
                                            <input type="hidden" name="id" value="{{ $submission->id }}">

                                            <h5 class="modal-title" id="Show{{ $submission->id }}Label">Delete : {{ isset($name) ? $name : $submission->name }} ( ID Submission {{ $submission->id }})</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label>
                                                This action will <b>DELETE</b> {{ $name == null ? ($submission->name == null ? "-" : $submission->name) : $name }} submission from data.
                                            </label>
                                            <label>
                                                Are you sure ?
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="AddSubmission" tabindex="-1" aria-labelledby="AddSubmissionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ShowLabel">Add New Submission :</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">                    
                    <form action="{{ route('admin.addSubmission') }}" method="POST" id="formAddSubmission">
                        @csrf

                        <div class="mb-3">
                            <label for="addContest" class="form-label">Cabang Lomba :</label>
                            <select name="addContest" id="addContest" class="form-select" required>
                                <option selected disabled>Select One</option>

                                @foreach ($contests as $contest)
                                    <option value="{{ $contest->id }}">{{ $contest->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="addTeam" class="form-label">Team ID :</label>
                            <input type="text" class="form-control" name="addTeam" id="addTeam" required>
                        </div>

                        <div class="mb-3">
                            <label for="addDescription" class="form-label">Deskripsi :</label>
                            <textarea name="addDescription" id="addDescription" cols="30" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="addLinkExhib" class="form-label">Link Poster/YouTube :</label>
                            <textarea name="addLinkExhib" id="addLinkExhib" cols="30" rows="2" class="form-control"></textarea>
                        </div>

                        <div>
                            <label for="addLinkProposal" class="form-label">Link Proposal :</label>
                            <textarea name="addLinkProposal" id="addLinkProposal" cols="30" rows="2" class="form-control" required></textarea>
                            <div class="form-text">
                                Semua link harus dalam bentuk : https://drive.google.com/file/d/.... <br>(Gunakan fitur share pada Google Drive lalu tekan tombol setting dan hilangkan centang untuk mendownload file)
                            {{-- </div>
                            <div class="form-text">
                                Untuk YouTube harus dalam bentuk : https://youtu.be/.... <br>(Gunakan fitur share pada YouTube, jangan copy link di address bar)
                            </div> --}}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="formAddSubmission">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection