<fieldset>
<div class="container ">
    <div class="row mt-4 mb-2">
        <h3>Ihr Aufgabe</h3>
    </div>
    <div class="row mt-2">
        <div class="col-2">
            <a>Grund Ihres Aufenthaltes?:</a>
        </div>
        <div class="col">
            <input type="text" name="gast-grund" value="@if(isset($_POST['gast-grund'])){{$_POST['gast-grund']}}@endif">
        </div>
    </div>
</div>
</fieldset>
