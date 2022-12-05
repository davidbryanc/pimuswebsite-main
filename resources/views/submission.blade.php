@extends('layout.mainweb')

@section('title')
    PIMUS 12 - Submission
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('/assets/css/style.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection

@section('content')
    <div class="table-container" style="margin-top: 150px; margin-bottom: 50px;">
        <h1 class="heading">submission</h1>
        {{-- <div class="alert alert-info" id="timer">
            
        </div> --}}
        <table class="table-submit">
            <thead>
                <tr>
                    {{-- Submission with webstie --}}
                    <th>Competition Name</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th></th>

                    {{-- Submission with Google Form --}}
                    {{-- <th>Competition Name</th>
                    <th>Starting Date</th>
                    <th>Deadline</th>
                    <th></th> --}}
                </tr>
            </thead>
            <tbody>
                {{-- Submission with website --}}
                @foreach ($group as $grp)
                    <tr>
                        <td data-label="Competition Name">{{ $grp->name }}</td>

                        @if($grp->competition_categories_id == 1)
                            <td data-label="Deadline">5 Desember 2022 23:59 WIB</td>
                            @php
                                $datetime1 = new DateTime('2022-12-05 23:59:59');
                                $datetime1 = $datetime1->format('Y-m-d H:i:s');
                            @endphp
                        @elseif($grp->competition_categories_id == 4)
                            <td data-label="Deadline">30 November 2022 23:59 WIB</td>
                            @php
                                $datetime1 = new DateTime('2022-11-30 23:59:59');
                                $datetime1 = $datetime1->format('Y-m-d H:i:s');
                            @endphp
                        @else
                            <td data-label="Deadline">2 Desember 2022 23:59 WIB</td>
                            @php
                                $datetime1 = new DateTime('2022-12-02 23:59:59');
                                $datetime1 = $datetime1->format('Y-m-d H:i:s');
                            @endphp
                        @endif

                        @php
                            $currentDateTime = date('Y-m-d H:i:s');
                            $diff = strtotime($datetime1) - strtotime($currentDateTime);
                            
                        @endphp

                        @if ($grp->link_proposal != null)
                            <td data-label="Status"><span class="text_open text-success">Submitted</span></td>
                            <td data-label="Submit" class="tdButton"><button class="btnSubmit" id="submitLink"
                                    onclick="SetID({{ $grp->id }}, {{ $grp->teams_id }})" data-bs-toggle="modal"
                                    data-bs-target="#formGDriveSubmission" disabled>Submit</button>
                            </td>
                        @elseif($diff < 0)
                            <td data-label="Status"><span class="text_open text-danger">NOT Submitted</span></td>
                            <td data-label="Submit" class="tdButton"><button class="btnSubmit" id="submitLink"
                                    onclick="SetID({{ $grp->id }}, {{ $grp->teams_id }})" data-bs-toggle="modal"
                                    data-bs-target="#formGDriveSubmission" disabled>Submit</button>
                            </td>

                        @else
                            <td data-label="Status"><span class="text_open text-danger">NOT Submitted</span></td>
                            <td data-label="Submit" class="tdButton"><button class="btnSubmit" id="submitLink"
                                    onclick="SetID({{ $grp->id }}, {{ $grp->teams_id }}, {{ $grp->competition_categories_id }})"  data-bs-toggle="modal"
                                    data-bs-target="#formGDriveSubmission">Submit</button></td>
                        @endif

                    </tr>
                @endforeach

                {{-- Submission with Google Form --}}
                
                {{-- @foreach ($listSubmission as $list)
                    <tr>
                        <td data-label="Competition Name">
                            @if ($list->id >= 8)
                                PKM
                            @else
                                {{ $list->name }}
                            @endif
                        </td>
                        <td data-label="Starting Date">
                            {{ date('l d F Y H:i', strtotime($list->start_date)) }}
                        </td>
                        <td data-label="Deadline">
                            {{ date('l d F Y H:i', strtotime($list->end_date)) }}
                        </td>
                        <td data-label="Submit" class="tdButton">
                            @if (time() >= strtotime($list->start_date) && time() <= strtotime($list->end_date))
                                <a class="btnSubmit" id="submitLink" target="_blank" href="{{ $list->link_form }}">Submit</a>
                            @else
                                <button class="btnSubmit" id="submitLink" disabled>Submit</button>
                            @endif
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="formGDriveSubmission" tabindex="-1" aria-labelledby="formGDriveSubmissionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #ebb010;">
                    <h5 class="modal-title text-white" id="formGDriveSubmissionLabel">Submission</h5>
                    <div class="invisible" id="idtes">Tes</div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center mb-2" id="isi">
                            
                        </div>
                        <div class="row mb-3">
                            <div class="col"></div>
                            <div class="col">
                                <button id="btnSubmit" class="btnSubmit" name="btnSubmit"
                                    value="submit">Submit</button>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var idlomba = null;
        var idkelompok = null;

        function SetID (pidlomba, pidkelompok, pidkategori) {
            idlomba = pidlomba;
            idkelompok = pidkelompok;
            
            $('#idtes').val(pidkategori)

            const isi = document.getElementById('isi')
            isi.innerHTML = ''

            if(pidkategori == 7){
                isi.innerHTML += `<div class="col">
                                    <div class="mb-3">
                                        <label for="LinkGoogleDrive" class="form-label">Link Youtube Video</label>
                                        <input type="text" class="form-control" id="linkDrive" name="linkDrive"
                                            placeholder="Input Youtube Link" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="LinkProposal" class="form-label">Link Drive Proposal</label>
                                        <input type="text" class="form-control" id="LinkProposal" name="LinkProposal"
                                            placeholder="Input Google Drive Link" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea type="text" class="form-control" id="description" name="description"
                                            placeholder="Deskripsi" rows="3" maxlength="200" required></textarea>
                                    </div>
                                </div>`
            }
            else if (pidkategori == 1){
                isi.innerHTML += `<div class="mb-3">
                                    <label for="LinkProposal" class="form-label">Link Drive</label>
                                    <input type="text" class="form-control" id="LinkProposal" name="LinkProposal"
                                        placeholder="Input Google Drive Link" required>
                                </div>`
            }
            else if (pidkategori == 4){
                isi.innerHTML += `<div class="col">
                                    <div class="mb-3">
                                        <label for="LinkGoogleDrive" class="form-label">Link Drive Poster</label>
                                        <input type="text" class="form-control" id="linkDrive" name="linkDrive"
                                            placeholder="Input Google Drive Link" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="LinkProposal" class="form-label">Link Drive Proposal</label>
                                        <input type="text" class="form-control" id="LinkProposal" name="LinkProposal"
                                            placeholder="Input Google Drive Link" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea type="text" class="form-control" id="description" name="description"
                                            placeholder="Deskripsi" rows="3" maxlength="200" required></textarea>
                                    </div>
                                </div>`
            }else{
                isi.innerHTML += `<div class="mb-3">
                                    <label for="LinkProposal" class="form-label">Link Drive Proposal</label>
                                    <input type="text" class="form-control" id="LinkProposal" name="LinkProposal"
                                        placeholder="Input Google Drive Link" required>
                                </div>`
            }
        }

        var linkEx = null;
        var linkProp = null;
        var description = null;

        
        $('#btnSubmit').on('click', function() {
            if (!confirm("Are you sure?")) return

            if(idlomba == 4 || idlomba == 7){
                var linkEx = $("#linkDrive").val()
                var linkProp = $("#LinkProposal").val()
                var description = $("#description").val()
            }
            else{
                var linkProp = $("#LinkProposal").val()
            }

            $.ajax({
                url: "{{ route('submitlink') }}",
                type: "POST",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'idlomba': idlomba,
                    'idkelompok': idkelompok,
                    'linkEx': linkEx,
                    'linkProp': linkProp,
                    'description': description,
                },
                success: function(data) {
                    alert(data.message);
                    location.reload();
                },
            });
        });

        // Set the date we're counting down to
        if(idlomba == 1){
            var countDownDate = new Date("Dec 05, 2022 23:59:59").getTime();
        }
        else if(idlomba == 4){
            var countDownDate = new Date("Nov 20, 2022 23:59:59").getTime();
        }else{
            var countDownDate = new Date("Dec 02, 2022 23:59:59").getTime();
        }

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var date = new Date();

            var now = date.getTime();

            //Find the local time zone offset (60000 from 60 seconds * 1000 millisecond)
            var localOffset = date.getTimezoneOffset() * 60000;

            var utc = now + localOffset;

            var offset = 7;

            //360000 from 3600 seconds * 1000 milliseconds
            var wibTime = utc + (3600000 * offset);

            var newNowTime = new Date(wibTime);

            // Find the distance between now and the count down date
            var distance = countDownDate - newNowTime;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            $("#timer").text("Submission will end in " + days + "d " + hours + "h " +
                minutes + "m " + seconds + "s" + ". Don't forget to submit!");

            // If the count down is finished, write some text
            if (distance > 0) {
                clearInterval(x);
                $("#timer").text("Submission ends now.");
                $(".btnSubmit").attr('disabled','true');
            }
        }, 1000);
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection
