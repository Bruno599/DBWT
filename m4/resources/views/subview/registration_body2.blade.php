
<form method="post" action="Registration.php">
    <fieldset>
        <input type="hidden" value="{{$_POST['role']}}" name="role">
        <input type="hidden" value="{{$_POST['nickname']}}" name="nickname">
        <input type="hidden" value="{{$_POST['passwort']}}" name="passwort">
        <div class="container">
            <div class="row mt-2">
                <div class="col">
                    <h3>Ihre Benutzerdaten</h3>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <a>Vorname:</a>
                </div>
                <div class="col-3">
                    <input type="text" name="vorname" value="@if(isset($_POST['vorname'])){{$_POST['vorname']}}@endif">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <a>Nachname:</a>
                </div>
                <div class="col-3">
                    <input type="text" name="nachname" value="@if(isset($_POST['nachname'])){{$_POST['nachname']}}@endif">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <a>E-MAIL Adresse:</a>
                </div>
                <div class="col-3">
                    <input type="email" name="e_mail" value="@if(isset($_POST['e_mail'])){{$_POST['e_mail']}}@endif">
                </div>
                <div class="col-2">

                </div>
                <div>

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-2">
                    <a> Geburtsdatum:</a>
                </div>
                <div class="col-3">
                    <input type="date" name="geburtsdatum" value="@if(isset($_POST['geburtsdatum'])){{$_POST['geburtsdatum']}}@endif">
                </div>
            </div>
        </div>
    </fieldset>
        @if($_POST['role'] == 'Gast')
            @include ('subview\registration_body2_Gast')
        @elseif($_POST['role'] == 'Student')
            @include ('subview\registration_body2_Student')
        @elseif($_POST['role'] == 'Mitarbeiter')
            @include ('subview\registration_body2_Mitarbeiter')
        @endif
    <fieldset>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <button type="submit">Registrierung abschließen</button>
                </div>
            </div>
        </div>
    </fieldset>
</form>


