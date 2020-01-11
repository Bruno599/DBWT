        @if($display2 == 0) {{--normale benutzerausgabe ohne login--}}
        <form  action="" target="_self" class="h-100" method="post" {{--action="{{$_SERVER['PHP_SELF']}}?{{$_SERVER['QUERY_STRING']}}"--}}>
            @csrf
            <fieldset class=" border border-dark h-100 w-100">
                <legend class="h5 ml-3 w-auto p-2">Login</legend>
                <div class="text-center m-2">
                    <input class="m-2" type="text" placeholder="Benutzer" name="benutzer"><br>
                    <input class="m-2" type="password" placeholder="Passwort" name="passwort">
                    <button class="btn-link btn" type="submit"> Anmelden </button>
                </div>
            </fieldset>
        </form>
        @elseif($display2 == -1) {{--benutzerlogin mit fehler--}}
            <form  target="_self" class="h-100" method="post" {{--action="{{$_SERVER['PHP_SELF']}}?{{$_SERVER['QUERY_STRING']}}"--}}>
                @csrf
                <fieldset class=" border border-dark h-100 w-100">
                    <legend class="h5 ml-3 w-auto p-2">Login</legend>
                    <div class="text-center m-2">
                        <a class="is-invalid" style="color: red">Das hat nicht geklappt! Bitte versuchen Sie es erneut.</a>
                        <input class=" is-invalid form-control" type="text" placeholder="{{$_POST['benutzer']}}" name="benutzer" value="{{$_POST['benutzer']}}"><br>
                        <input class=" is-invalid form-control" type="password" placeholder="Passwort" name="passwort">
                        <button class="btn-link btn" type="submit"> Anmelden </button>
                    </div>
                </fieldset>
            </form>
        @elseif($display2 == 1) {{--abmelden--}}
            <form  target="_self" class="h-100" method="post" {{--action="{{$_SERVER['PHP_SELF']}}?{{$_SERVER['QUERY_STRING']}}"--}}>
                @csrf
                <fieldset class=" border border-dark h-100 w-100">
                    <legend class="h5 ml-3 w-auto p-2">Login</legend>
                    <div class="text-center m-2">
                        <input type="hidden" value="true" name="logout">
                        <p>Willkommen {{$_SESSION['nutzername']}}, du bist angemeldet als {{$_SESSION['role']}}</p>
                        <button class="btn-link btn" type="submit"> Abmelden </button>
                    </div>
                </fieldset>
            </form>
        @endif
