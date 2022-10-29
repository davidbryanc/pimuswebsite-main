@extends('layout.admin')

@section('style')
<style>
    .link-sort a, .link-sort a:hover, .link-sort a:visited {
        text-decoration: none;
        color: black;
    }
</style>    
@endsection

@section('content')
<div>
    <h3>Account</h3>
    <p>Total Akun : {{ $countAccount }}</p>
</div>

<div class="table-responsive">
    <table class="table align-middle text-center table-hover">
        <thead>
            <tr style="vertical-align: middle">
                <th scope="col">NRP</th>
                <th scope="col">Nama</th>
                <th scope="col">Email (Gooaya)</th>
                <th scope="col">Divisi</th>
                <th scope="col">
                    Ticket Vote
                    <br>
                    @foreach ($countTicket as $ticket)
                        <small>Total : {{ $ticket->count_ticket }}</small>
                    @endforeach
                </th>
                <th scope="col">Verified</th>
                @if (Auth::user()->divisi == "Admin")
                    <th scope="col">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($arrAccounts as $account)
                <tr>
                    <th scope="row">{{ $account->nrp }}</th>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->email }}</td>
                    <td>{{ $account->role }}</td>
                    <td>{{ $account->vote_tickets }}</td>
                    <td>{{ $account->email_verified_at != null ? 'Yes' : 'No' }}</td>
                    @if (Auth::user()->role == "Admin")                    
                        <td>
                            <!-- Button Update User trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Show{{ $account->nrp }}">
                                Update
                            </button>
                            <!-- Button Delete User trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#Delete{{ $account->nrp }}">
                                Delete
                            </button>
                        </td>
                    @endif
                </tr>
    
                @if (Auth::user()->divisi == "Admin")
                    <!-- Modal Update User  -->
                    <div class="modal fade" id="Show{{ $account->nrp }}" tabindex="-1" aria-labelledby="Show{{ $account->nrp }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <form action="{{ route('admin.editUser') }}" method="POST">
                                    @csrf
    
                                    <div class="modal-header">
                                        <input type="hidden" name="nrp" value="{{ $account->nrp }}">
    
                                        <h5 class="modal-title" id="Show{{ $account->nrp }}Label">UPDATE : {{ $account->name }} ({{ $account->nrp }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <label class="form-label">Divisi :</label>
                                            <select name="updateDivisi" id="updateDivisi" class="form-select">
                                                <option value="Admin"{{ $account->role == "Admin" ? ' selected=True' : ''}}>Admin</option>
                                                <option value="Sekre"{{ $account->role == "Sekre" ? ' selected=True' : ''}}>Sekre</option>
                                                <option value="Acara"{{ $account->role == "Acara" ? ' selected=True' : ''}}>Acara</option>
                                                <option value="Panitia"{{ $account->role == "Panitia" ? ' selected=True' : ''}}>Panitia</option>
                                                <option value="Umum"{{ $account->role == "Umum" ? ' selected=True' : ''}}>Umum</option>
                                            </select>
                                        </div>
            
                                        <br>
            
                                        <div>
                                            <label class="form-label">Verification :</label>
                                            <select name="updateVerification" id="updateVerification" class="form-select">
                                                <option value="1"{{ $account->email_verified_at != null ? ' selected=True' : ''}}>Yes</option>
                                                <option value="0"{{ $account->email_verified_at == null ? ' selected=True' : ''}}>No</option>
                                            </select>
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
                    <div class="modal fade" id="Delete{{ $account->nrp }}" tabindex="-1" aria-labelledby="Delete{{ $account->nrp }}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <form action="{{ route('admin.deleteUser') }}" method="POST">
                                    @csrf
    
                                    <div class="modal-header">
                                        <input type="hidden" name="nrp" value="{{ $account->nrp }}">
    
                                        <h5 class="modal-title" id="Delete{{ $account->nrp }}Label">DELETE : {{ $account->name }} ({{ $account->nrp }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label>
                                            This action will <b>DELETE</b> {{ $account->name }} ({{ $account->nrp }}) from data.
                                        </label>
                                        <label>
                                            Are You sure ?
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
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
@endsection