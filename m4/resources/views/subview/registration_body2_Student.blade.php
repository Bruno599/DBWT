<fieldset>
    <div class="container ">
        <div class="row mt-4 mb-2">
            <h3>Ihr Aufgabe</h3>
        </div>
        <div class="row mt-2">
            <div class="col-2">
                <a>Studiengang?:</a>
            </div>
            <div class="col-4">
                <select class="w-100 " name="fachbereich">
                    @foreach ($data_sg as $element) {
                    <option  value="{{$element['ID']}}">{{$element['Name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-2">
                <a>Matrikelnummer</a>
            </div>
            <div class="col" >
                <input type="text" name="Matrikelnummer">
            </div>
        </div>
    </div>
    </div>
</fieldset>
