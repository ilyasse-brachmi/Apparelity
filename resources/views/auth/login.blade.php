
@section('title')
    Admin Login
@endsection

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1">
                                            <img src="{{asset('public/assets/admin/images/logo/logo_login.png')}}" alt="branding logo">
                                        </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                        <span>Formulaire de Connexion</span>
                                    </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal form-simple" action="{{route('login')}}" method="post" novalidate>
                                            @csrf
                                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                                <input type="text" name="Login" class="form-control form-control-lg input-lg" id="Login" placeholder="Votre Identification" value="{{old('Login')}}">
                                                <div class="form-control-position">
                                                    <i class="ft-user"></i>
                                                </div>
                                                @error('Login')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </fieldset>
                                            <br>
                                            <fieldset class="form-group position-relative has-icon-left ">
                                                <input type="password" name="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Entrer le Mot de Passe">
                                                <div class="form-control-position">
                                                    <i class="la la-key"></i>
                                                </div>
                                                @error('password')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-12 text-center text-md-left">
                                                    <fieldset>
                                                        <input type="checkbox" id="remember-me" class="chk-remember">
                                                        <label for="remember-me"> Se Souvient de moi</label>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 col-12 text-center text-md-right"><a href="" class="card-link"><i class="icon-home"></i> Accueil</a></div>
                                            </div>
                                            <button type="submit" class="btn btn-lg btn-block" style="background-color: #0C1248 ; color: white"> <i class="ft-unlock"></i> Se Connecter</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>





