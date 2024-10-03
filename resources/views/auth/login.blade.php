@extends("layouts.auth")

@section("title")
Panel'e Giriş
@endsection

@section("css")
@endsection

@section("content")
<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">
    </div>
    <div class="app-auth-container">
        <div class="logo">
            <a href="index.html">Giriş</a>
        </div>
        <p class="auth-description">Panele erişebilmek için hesabınız ile oturum açın.<br>Hesabınız yok mu ? 
            <a href="{{route('register')}}">Kayıt Ol</a>
        </p>
    
        <div class="auth-credentials m-b-xxl">
            <label for="signInEmail" class="form-label">Email</label>
            <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail"
                placeholder="example@neptune.com">
    
            <label for="signInPassword" class="form-label">Parola</label>
            <input type="password" class="form-control" id="signInPassword" aria-describedby="signInPassword"
                placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
        </div>
    
        <div class="auth-submit">
            <a href="#" class="btn btn-primary">Giriş</a>
            <a href="#" class="auth-forgot-password float-end">Parolamı unuttum</a>
        </div>
        <div class="divider"></div>
        <div class="auth-alts">
            <a href="#" class="auth-alts-google"></a>
            <a href="#" class="auth-alts-facebook"></a>
            <a href="#" class="auth-alts-twitter"></a>
        </div>
    </div>
</div>


@endsection

@section("js")

@endsection