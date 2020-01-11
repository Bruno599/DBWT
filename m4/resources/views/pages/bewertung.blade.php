<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bewertung</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">


</head>
<body>
<!--<form action="http://bc5.m2c-lab.fh-aachen.de/form.php" method="post">-->
<form action="/Bewertung" method="post">
                            <fieldset class="border border-dark pl-4">
                                <legend class="ml-4 w-auto">
                                Mahlzeit bewerten
                                </legend>
                                <div class="container">
                                    <!--<div class="row">
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
                                    </div>-->
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
                                    <input type="hidden" name="benutzerID" value="{{$_SESSION['benutzerID']}}">
                                </div>
                            </fieldset>
                        </form>
</body>
</html>
