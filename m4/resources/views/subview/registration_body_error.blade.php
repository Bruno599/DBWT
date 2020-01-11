@if(!empty($Error))
<div class="container ">
            <div style="color: white; background-color: indianred" class="row ">
                <div class="col">
    <div class="row text-center ">
        <div class="col"> !Es gab Fehler beim Bearbeiten Ihrer Anfrage! </div>
    </div>
    @foreach($Error as $arr)
        <div class="row text-center">
            <div class="col"> !{{$arr}}! </div>
        </div>
        @endforeach
                </div>
    </div>
</div>
        @endif

