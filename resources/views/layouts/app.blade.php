<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>@yield('title', 'Dashboard - GoBadminton')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="{{ url('/') }}">GoBadminton</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                {{-- sengaja tidak ada isi --}}
            </div>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            @can('view lapangan')
                                <a class="nav-link" href="{{ route('lapangan.index') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Lapangan
                                </a>
                            @endcan

                            @can('view users')
                                <a class="nav-link" href="{{ route('users.index') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Users
                                </a>
                            @endcan

                            @can('view roles')
                                <a class="nav-link" href="{{ route('roles.index') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Roles
                                </a>
                            @endcan

                            @role('super-admin')
                                <a class="nav-link" href="{{ route('audits.index') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Audits
                                </a>
                            @endrole
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        {{ Auth::user()->nama ?? 'Guest' }}
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div>
                        <x-flash-message />
                    </div>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">@yield('header', 'Dashboard')</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                        </ol>
                        @yield('content')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; GoBadminton {{ date('Y') }}</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aiModal" style="position:fixed;bottom:20px;right:20px;z-index:9999">
            💬 AI Help
        </button>

        <div class="modal fade" id="aiModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>AI Support</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div id="chatBox" style="height:300px;overflow:auto"></div>

                        <input type="text"
                            id="chatInput"
                            class="form-control mt-2"
                            placeholder="Tanya sesuatu...">
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/sb-admin.js') }}"></script>
        @stack('scripts')

        <script>
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.remove();
    });
}, 3000);

$(document).ready(function(){

    $('#chatInput').on('keypress', function(e){

    if(e.which === 13){

        let msg = $(this).val();

        if(msg.trim() === '') return;

        $('#chatBox').append('<div>🧑 '+msg+'</div>');

        $.ajax({
            url: '/ai/chat',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                message: msg
            },
            success: function(res){

                $('#chatBox').append('<div>🤖 '+res.text+'</div>');
                $('#chatBox').scrollTop($('#chatBox')[0].scrollHeight);

            },
            error: function(xhr){

                console.log(xhr.responseText);
                $('#chatBox').append('<div>🤖 Error server</div>');
            }
        });

        $('#chatInput').val('');
    }
});
});
</script>
    </body>
</html>