<form method="post" action="Start.php">
    <fieldset>
        <div class="container">
            <div class="row">
                <h1>Ihre Registrierung hat geklappt!</h1>
            </div>
            <div class="row">
                <a>Ihre Nummer ist {{$_POST['nummer'][0]}}.</a>
            </div>
            <div class="row">
                <button>Zur Startseite</button>
            </div>
        </div>
    </fieldset>
</form>
