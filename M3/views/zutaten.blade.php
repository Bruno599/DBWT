<!DOCTYPE html><html lang='de'>
<head>
    <meta charset='UTF-8'>
    <title>test</title>
    <link href='css/bootstrap.css' rel='stylesheet'>
    <link href='css/design.css' rel='stylesheet'>
</head>
<body>
@include('navbaroben')
<div class="container mt-4">
    <div class="row mt-2">
        <div class="col-12 float-md-none">

            <a><h2>{{$anzahl}} Zutaten</h2></a>

</div>
</div>
<div class="border-dark border mt-4">
    <table class="table table-striped table-hover">

        <thead>
        <tr class="">
            <th scope="col" class="w-auto"><a class="m-1">Zutaten</a></th>
            <th scope="col" class="w-auto"><a class="m-1">Bio?</a></th>
            <th scope="col" class="w-auto"><a class="m-1">Vegan?</a></th>
            <th scope="col" class="w-auto"><a class="m-1">Vegetarisch?</a></th>
            <th scope="col" class="w-auto"><a class="m-1">Glutenfrei?</a></th>
        </tr>
        </thead>
        <tbody>

        @foreach($zutaten as $zutat)

                <tr>
                <td>
                            <form action="http://www.google.de/search" target="_blank" method="get">
                            <input class="btn btn-link" type="submit" name="q"  value="{{$zutat['Name']}}" data-toggle="tooltip" title="Suchen Sie nach '.htmlspecialchars($zutat['Name']).' im Web">
                            </form>
                            </td>
                @if($zutat['Bio'])
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>
                @else
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg" alt="fehler"></td>
                @endif
                @if($zutat['Vegan'])
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>
                        @else
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg" alt="fehler"></td>
                    @endif
                @if($zutat['Vegetarisch'])
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>
                        @else
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/circle.svg" alt="fehler"></td>
                    @endif
                @if($zutat['Glutenfrei'])
                        <td><img class="img symbol float-md-left ml-2" src="button/svgs/regular/check-circle.svg" alt="fehler"></td>
                        @else
                        <td><img class="img symbol float-md-left ml-2 regular" src="button/svgs/regular/circle.svg" alt="fehler"></td>
                    @endif
                </tr>
        @endforeach
            </tbody>

    </table>
</div>
</div>
@include('navbarunten')
</body>
</html>