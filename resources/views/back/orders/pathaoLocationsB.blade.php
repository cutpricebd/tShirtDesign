<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label><b>City*</b></label>
            <select name="city" class="form-control city_select" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{$city['city_id']}}">{{$city['city_name']}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label><b>Zones*</b></label>
            <select name="zone" class="form-control zone_select" required>
                <option value="">Select Zones</option>
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label><b>Area</b></label>
            <select name="area" class="form-control area_select">
                <option value="">Select Area</option>
            </select>
        </div>
    </div>
</div>
