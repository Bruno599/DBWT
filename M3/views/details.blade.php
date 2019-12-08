<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Details.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">

    @if($refresh)<meta http-equiv="refresh" content="0; URL=Produkte.php">@endif


</head>
<body>
@include('navbaroben')
<div class="container mt-4 mb-4">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-7 text-left">
                <h2>Details für "{{$mahlzeit['Name']}}"</h2>
            </div>
            <div class="col-2 text-right">
                <br><a class="">@if(isset($_SESSION['aktive'])){{$_SESSION['role']}}-Preis</a> @else Gast-Preis</a> @endif
            </div>
        </div>
        <div class="row">
            <div class="col-3 mb-2 ">
{{--include ('auth.php');--}}

                @include('login')


</div>
            <div class="col-7 p-2 pt-3" >
@if ($mahlzeit['Binärdaten'])
    <img class="img details_picture mw-100" alt="platzhalter" src="data:image/jpeg;base64, {{$mahlzeit['Binärdaten']}}">
@else
    <img class="img details_picture mw-100" src="pictures/platzhalter.jpg" alt="platzhalter">
@endif
            </div>
            <div class="col-2 p-2">
                <div class="row h-50 text-right">
                    <div class="col">
                    <h2>{{$mahlzeit['Preis']}}€</h2>
                    </div>
                </div>
                <div class="row h-50 align-items-end">
                    <div class="col">
                        <button class="w-100 align-middle align-content-end p-0  text-center">
                            <img class="img symbol float-md-left ml-2" src="button/svgs/solid/utensils.svg" alt="platzhalter">
                            <i class="fas fa-utensils"></i>
                            Vorbestellen
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3 mt-4 ">
                <a class="text-center">Melden Sie sich jetzt an, um die wirklich viel günstigeren Preis für Mitarbeiter oder Studenten zu sehen</a>
            </div>
            <div class="mt-3 col-7 pl-1 pr-1">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item ml-4">
                        <a class="nav-link active fh_color" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Beschreibung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fh_color" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Zutaten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fh_color" id="messages-tab" data-toggle="tab" href="#messages" role="tab" aria-controls="messages" aria-selected="false">Bewertung</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active border-right border-left border-bottom tab_content_size p-2" id="home" role="tabpanel" aria-labelledby="home-tab">
                        {{$mahlzeit['Beschreibung']}}
                    </div>
                    <div class="tab-pane border-right border-left border-bottom tab_content_size p-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <ol>
                            <li>noch statisch</li>
                        </ol>
                    </div>
                    <div class="tab-pane border-right border-left border-bottom tab_content_size p-2 h-auto" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                        <form action="http://bc5.m2c-lab.fh-aachen.de/form.php" method="post">
                            <fieldset class="border border-dark pl-4">
                                <legend class="ml-4 w-auto">
                                    Mahlzeit bewerten
                                </legend>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-3 text-right m-2"><a>Mahlzeit:</a></div>
                                        <div class="col">
                                            <select class="m-2" name="mahlzeit">
                                            <option>Curry Wok</option>
                                            <option>Schitzel</option>
                                            <option>Bratrolle</option>
                                            <option>Krautsalat</option>
                                        </select></div>
                                    </div>
                                    <div class="row">
                                        <div
                                            class="col-3 text-right m-2">Benutzername:
                                        </div>
                                        <div class="col">
                                            <input class="m-2" type="text" name="benutzer">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 text-right m-2">Bewertung: </div>
                                        <div class="col">
                                            <select class="m-2" name="bewertung">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 text-right m-2">Bemerkung: </div>
                                        <div class="col">
                                            <textarea class="m-2" id="bemerkung" name="bemerkung" cols="25" rows="5">Geben Sie eine Bemerkung ein, wenn Sie möchten...</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">

                                        </div>
                                        <div class="col">
                                            <button class="m-2 btn btn-link" type="submit">Bewertung absenden</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="matrikel" value="3188412">
                                    <input type="hidden" name="kontrolle" value="Sch">
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>

                <script>
                    $(function () {
                        $('#myTab li:last-child a').tab('show')
                    })
                </script>
            </div>
        </div>


</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@include ('navbarunten')
</body>
</html>
