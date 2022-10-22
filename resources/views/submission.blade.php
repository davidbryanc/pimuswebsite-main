@extends('layout.mainweb')

@section('title')
    PIMUS 11 - Submission
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
                        <td data-label="Deadline">21 Oktober 2021 23:59 WIB</td>
                        @if ($grp->link_drive != null)
                            <td data-label="Status"><span class="text_open text-success">Submitted</span></td>
                            <td data-label="Submit" class="tdButton"><button class="btnSubmit" id="submitLink"
                                    onclick="SetID({{ $grp->id }}, {{ $grp->idkelompok_ketua }})" data-bs-toggle="modal"
                                    data-bs-target="#formGDriveSubmission" disabled>Submit</button>
                            </td>
                        @else
                            <td data-label="Status"><span class="text_open text-danger">NOT Submitted</span></td>
                            <td data-label="Submit" class="tdButton"><button class="btnSubmit" id="submitLink"
                                    onclick="SetID({{ $grp->id }}, {{ $grp->idkelompok_ketua }})" data-bs-toggle="modal"
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
                    <h5 class="modal-title text-white" id="formGDriveSubmissionLabel">Poster</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center mb-2">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="LinkGoogleDrive" class="form-label">Google Drive Link</label>
                                    <input type="text" class="form-control" id="linkDrive" name="linkDrive"
                                        placeholder="Input Google Drive Link">
                                </div>
                            </div>
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

        function SetID (pidlomba, pidkelompok) {
            idlomba = pidlomba;
            idkelompok = pidkelompok;
        }

        $('#btnSubmit').on('click', function() {
            $.ajax({
                url: "{{ route('submitlink') }}",
                type: "POST",
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'idlomba': idlomba,
                    'idkelompok': idkelompok,
                    'linkdrive': $("#linkDrive").val(),
                },
                success: function(data) {
                    alert(data.message);
                    location.reload();
                },
            });
        });

        // Set the date we're counting down to
        var countDownDate = new Date("Oct 23, 2023 23:59:59").getTime();

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
            if (distance < 0) {
                clearInterval(x);
                $("#timer").text("Submission ends now.");
                $(".btnSubmit").attr('disabled','true');
            }
        }, 1000);
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@endsection
