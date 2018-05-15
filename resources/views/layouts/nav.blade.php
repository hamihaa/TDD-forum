<div>
    <nav id="primary-navbar" class="navbar navbar-default navbar-static-top">
        <div class="intro-header">
            <div class="overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="intro-message">
                                <a href="{{ url('/') }}">
                                    <h1 class="hero-title">
                                        predlagam.vladi.si
                                    </h1>
                                </a>
                                </h1>
                                <!--h3>spletno orodje za e-participacijo</h3-->
                            </div>
                        </div>
                    </div>
                </div>


                <div class="container-fluid">
                    <div class="navbar-header navbar-row">
                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse navigacija" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    Razišči<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/threads">Novi predlogi</a></li>
                                    @if(Auth::check())
                                        <li><a href="/threads?by={{ auth()->user()->name }}">Moji predlogi</a></li>
                                    @endif
                                    <li><a href="/threads?votes=1">Predlogi z največ glasovi</a></li>
                                    <li><a href="/threads?popular=1">Predlogi z največ odgovori</a></li>
                                    <li><a href="/threads?unanswered=1">Predlogi brez odgovorov</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Kategorije<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @foreach($categories as $category)
                                        <li><a href="/threads/{{ $category->slug }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @if(Auth::check())
                                <li><a href="/threads/create"><i class="fa fa-plus" style="color:white"></i> Ustvari predlog</a></li>
                            @endif
                        </ul>
                        <!-- Center nav -->
                        <ul class="nav navbar-nav navbar-center">
                            <li>
                                <form class="navbar-form" role="search" method="GET" action="/threads?search=">
                                    <div class="form-inline input-group" id="nav-search">
                                        <div class="form-group">
                                            <input type="text" id="nav-search-field" class="form-control"
                                                   placeholder='Vnesite iskalni niz...' name="search">
                                            <button class="btn btn-default" type="submit"><i
                                                        class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                        <!-- /center nav -->
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            @if(Auth::check() && Auth::user()->isAdmin())
                                <li><a href="/admin">Nadzorna plošča</a></li>
                            @endif
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li><a href="{{ route('login') }}">Prijava</a></li>
                                <li><a href="{{ route('register') }}">Registracija</a></li>
                            @else
                                <user-notifications></user-notifications>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                       aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="/profiles/{{ Auth::user()->name }}">
                                                <i class="fa fa-user"></i>  Moj profil
                                            </a>
                                        </li>
                                        <li><a href="/profiles/{{ Auth::user()->name }}/edit">
                                                <i class="fa fa-gear"></i>  Uredi profil
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out"></i> Odjava
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid" id= "secondary-navbar" >
        <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/threads?status=2">V razpravi</a></li>
                    <li><a href="/threads?status=3">V glasovanju</a></li>
                    <li><a href="/threads?status=4">Posredovani</a></li>
                    <li><a href="/threads?status=5">Sprejeti</a></li>
                    <li><a href="/threads?status=6">Zavrnjeni</a></li>
                    <li><a href="/threads?status=7">Neustrezni</a></li>
                    <li><a id="last-item" href="/threads">Vsi</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
</div>

