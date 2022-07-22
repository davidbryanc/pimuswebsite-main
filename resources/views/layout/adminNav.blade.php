<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/"><img src="{{url('assets/images/logo/logo-pimus-text.png')}}" alt="{{ config('app.name') }}" style="width: 150px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link{{ request()->is('admin') ? ' active' : '' }}" aria-current="page" href="{{ route('admin.index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link{{ request()->is('admin/accounts') ? ' active' : '' }}" aria-current="page" href="{{ route('admin.accounts') }}">Accounts</a>
                </li>
                <li class="nav-item">   
                    <a class="nav-link{{ request()->is('admin/groups') ? ' active' : '' }}" aria-current="page" href="{{ route('admin.groups') }}">Groups</a>
                </li>
                <li class="nav-item">   
                    <a class="nav-link{{ request()->is('admin/submissions') ? ' active' : '' }}" aria-current="page" href="{{ route('admin.submissions') }}">Submissions</a>
                </li>
                <li class="nav-item nav-center ml-5">
                    <a class="nav-link btnLogin btn btn-danger text-white" href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>