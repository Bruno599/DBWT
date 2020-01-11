
<fieldset>
<div class="container ">
    <div class="row mt-4 mb-2">
        <h3>Ihr Aufgabe</h3>
    </div>
    <div class="row mt-2">
        <div class="col-2">
            <a>Fachbereich?:</a>
        </div>
        <div class="col-4">
            <select class="w-100 " name="fachbereich">
            @foreach ($data_fb as $element) {
                <option  value="{{$element['ID']}}">{{$element['Name']}}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-2">
            <a>Buero</a>
        </div>
        <div class="col" >
            <input type="text" name="buero">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-2">
            <a>Telefonnummer</a>
        </div>
        <div class="col" >
            <input type="number" name="telnummer">
        </div>
    </div>
</div>
</div>
</fieldset>
