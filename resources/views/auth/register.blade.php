@extends("layouts.auth")

@section("title")
Panel'e Giriş
@endsection

@section("css")
@endsection

@section("content")
<div class="app-auth-background">

</div>
<div class="app-auth-container">
    <div class="logo">
        <a href="index.html">Kayıt</a>
    </div>
    <p class="auth-description">Panele erişebilmek için kayıt olun.<br>Hesabınız var mı ? <a href="{{route('login')}}">Giriş</a></p>

    <div class="auth-credentials m-b-xxl">
        <label for="signUpUsername" class="form-label">Username</label>
        <input type="email" class="form-control m-b-md" id="signUpUsername" aria-describedby="signUpUsername" placeholder="Enter username">

        <label for="signUpEmail" class="form-label">Email address</label>
        <input type="email" class="form-control m-b-md" id="signUpEmail" aria-describedby="signUpEmail" placeholder="example@neptune.com">

        <label for="signUpPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="signUpPassword" aria-describedby="signUpPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
        <div id="emailHelp" class="form-text">Password must be minimum 8 characters length*</div>
    </div>

    <div class="auth-submit">
        <a href="#" class="btn btn-primary">Sign Up</a>
    </div>
    <div class="divider"></div>
    <div class="auth-alts">
        <a href="#" class="auth-alts-google"></a>
        <a href="#" class="auth-alts-facebook"></a>
        <a href="#" class="auth-alts-twitter"></a>
    </div>
</div>

@endsection

@section("js")

@endsection