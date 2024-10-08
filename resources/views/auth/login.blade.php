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

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show m-b-sm" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif

        <form action="{{ route('login')}}" method="post">
            @csrf
            <div class="auth-credentials m-b-xxl">
                <label for="signInEmail" class="form-label">Email</label>
                <input type="email" class="form-control m-b-md" id="signInEmail" aria-describedby="signInEmail"
                    placeholder="ornek@mailadresi.com" name="email" value="{{ old('email') }}">

                <label for="signInPassword" class="form-label">Parola</label>
                <input type="password" class="form-control" id="signInPassword" aria-describedby="signInPassword"
                    placeholder="Parola" name="password">
            </div>
            <div class="auth-credentials m-b-xxl">
                <div class="form-check">
                    <label for="remember" class="form-check-label">Beni Hatırla</label>
                    <input type="checkbox" class="form-check-input" value="1" name="remember" id="remember" {{old("remember") ? "checked" : ""}}>
                </div>
            </div>
            <div class="auth-submit">
                <button class="btn btn-primary" type="submit">Giriş</button>
                <a href="#" class="auth-forgot-password float-end">Parolamı unuttum</a>
            </div>
        </form>
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