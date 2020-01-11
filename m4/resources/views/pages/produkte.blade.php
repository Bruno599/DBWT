<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkte.php</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
    <?php
    //include ('snippets/mysqlconnect.php')
    ?>
</head>
<body>
@include('nav.navbaroben')

<div class="container ">
    <div class="row m-4">
        <div class="col-2 ml-3">
        </div>
        <div class="col text-left ">
            <h2>Verfügbare Speisen ({{$array2}})</h2>
        </div>
    </div>
    <div class="row m-2">
        <div class="col-2 border m-2 border-dark" id="speise_filtern">
           <form method="post" action="Produkte.php?limit=4">
               @csrf
               <fieldset>
                   <legend class="text-nowrap text-hide">Speisenliste filter</legend>
                   <p class="on_line text-center">Speisenliste filter</p>
                   <select class="w-100 mb-5 mt-5" name="kategorien">
                   <option value="-1">Alle zeigen</option>';
@foreach ($kat as $element) {
    @if(($element->hatKategorie) == NULL)
        <optgroup label="{{$element->Bezeichnung}}">
        @foreach ($kat as $element2) {
            @if ($element->ID == $element2->hatKategorie)
                @if($variables['kategorien'] == $element2->ID)
                    <option selected value="{{$element2->ID}}">{{$element2->Bezeichnung}}</option>
                @else
                    <option  value="{{$element2->ID}}">{{$element2->Bezeichnung}}</option>
                @endif

            @endif
        @endforeach
        </optgroup>
    @endif
@endforeach



</select>
@if($variables['avail'] == true)
    <input type="checkbox" class="m-2" name="avail" checked value="1"> nur verfügbar
@else
    <input type="checkbox" class="m-2" name="avail" value="1" > nur verfügbar
@endif

@if($variables['vegetarisch'] == true)
    <input type="checkbox" class="m-2" name="vegetarisch" value="1" checked > nur vegetarisch
@else
    <input type="checkbox" class="m-2" name="vegetarisch" value="1"> nur vegetarisch
@endif

@if($variables['vegan'] == true)
    <input type="checkbox" class="m-2" name="vegan" checked value="1"> nur vegan
@else
    <input type="checkbox" class="m-2" name="vegan" value="1"> nur vegan
@endif




                   <button type="submit" class="mt-5">Speisen filtern</button>
               </fieldset>
           </form>

        </div>

        <div class="col" id="body_produkte">


<div class="row text-center">
@if(empty($array))
    <a>nichts gefunden</a>
    @else
        @foreach ($array as $arra)


            @if($arra->Verfügbar)

                <div class="col-3 mb-2 mt-2 p-0">
                                            <div class="col "><img class="img mw-100 preview" alt="platzhalter" src="data:image/jpeg;base64,{{base64_encode($arra->Binärdaten)}}"></div>
                                             <div class="col "><a>{{$arra->Name}}</a></div>
                                             <div class="col "><a class="fh_color" href="Detail.php?id={{$arra->ID}}"> Details</a></div>
                                            </div>

            @else

                <div class="col-3 mb-2 mt-2 p-0 passdout">
                                             <div class="col"><img class="img mw-100 preview" alt="platzhalter" src="data:image/jpeg;base64,{{base64_encode($arra->Binärdaten)}}"></div>
                                             <div class="col"><a>{{$arra->Name}}</a></div>
                                             <div class="col "><a class="fh_color" > Vergriffen</a></div>
                                             </div>
            @endif

            @endforeach
    @endif

</div>

</div>
    </div>
</div>

@include('nav.navbarunten')

</body>
</html>
