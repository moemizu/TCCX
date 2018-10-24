<h5><i class="fas fa-pencil-alt"></i> General</h5>
<input type="hidden" name="id" value="{{old('id',$quest->id ?? '')}}">
<!-- Name/order group -->
<div class="form-row">
    <div class="form-group col-md-8 col-sm-8">
        <label class="col-form-label" for="input-name">Name</label>
        <input required type="text" class="form-control" id="input-name" name="name"
               placeholder="Name" autocomplete="off" value="{{old('name',$quest->name ?? '')}}">
    </div>
    <div class="form-group col-md-4 col-sm-4">
        <label class="col-form-label" for="input-order">Order</label>
        <input required type="number" min="0" max="999" class="form-control"
               id="input-order" name="order"
               placeholder="Order" value="{{old('order',$quest->order ?? '')}}">
    </div>
</div>
<!-- Type/zone/difficulty group -->
<div class="form-row">
    <div class="form-group col-md-4 col-sm-4">
        <label class="col-form-label" for="input-type">Type</label>
        <select id="input-type" name="type" class="custom-select">
            {{-- Default to side quest --}}
            @if(isset($types))
                @foreach($types as $type)
                    <option @if($type->id == old('type',$quest->quest_type_id ?? 2)) selected
                            @endif value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="form-group col-md-4 col-sm-4">
        <label class="col-form-label" for="input-zone">Zone</label>
        <select id="input-zone" name="zone" class="custom-select">
            @if(isset($zones))
                @foreach($zones as $zone)
                    <option @if($zone->id == old('zone',$quest->quest_zone_id ?? 1)) selected
                            @endif value="{{$zone->id}}">{{$zone->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="form-group col-md-2 col-sm-2">
        <label class="col-form-label" for="input-zone">Difficulty</label>
        <select id="input-difficulty" name="difficulty" class="custom-select">
            @if(isset($difficulties))
                @foreach($difficulties as $difficulty => $reward)
                    <option @if($difficulty == old('difficulty',$quest->difficulty ?? 'Normal')) selected
                            @endif value="{{$difficulty}}">{{$difficulty}}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    <div class="form-group col-md-2 col-sm-2">
        <label class="col-form-label" for="input-reward">Reward</label>
        <input required type="number" min="0" class="form-control"
               id="input-reward" name="reward"
               placeholder="Reward" value="{{old('reward',$quest->reward ?? '')}}">
    </div>
</div>
<!-- Location -->
<h5><i class="fas fa-location-arrow"></i> Location</h5>
@if(!isset($quest))
    <h6 class="mb-0">Select existing</h6>
@endif
<div class="form-row">
    <div class="form-group col-md-8 col-sm-8">
        <label class="col-form-label" for="input-location-id">Location</label>
        <select id="input-location-id" name="location-id" class="custom-select">
            <option value="">None</option>
            <?php $locId = old('location-id', $quest->quest_location_id ?? 0);?>
            @if(isset($locations))
                @foreach($locations as $loc)
                    <option @if($locId == $loc->id) selected @endif value="{{$loc->id}}">{{$loc->name}} ({{$loc->type}}
                        )
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
@if(!isset($quest))
    <h6 class="mb-0">Or create the new one</h6>
    <div class="form-row">
        <div class="form-group col-md-8 col-sm-9">
            <label class="col-form-label" for="input-location-name">Location Name</label>
            <input type="text" class="form-control" id="input-location-name"
                   name="location-name"
                   placeholder="Location Name" autocomplete="off">
        </div>
        <div class="form-group col-md-4 col-sm-3">
            <label class="col-form-label" for="input-location-type">Type</label>
            <input type="text" class="form-control" id="input-location-type"
                   name="location-type"
                   placeholder="Location Type">
        </div>
    </div>
    <!-- Lat/Lng -->
    <div class="form-row">
        <div class="form-group col-md-4 col-sm-6">
            <label class="col-form-label" for="input-location-lat">Latitude</label>
            <input type="text" pattern="(\-?\d+(\.\d+)?)" class="form-control"
                   id="input-location-lat" name="location-lat"
                   value="{{old('location-lat',$quest->quest_location->lat ?? '0.000000')}}"
                   placeholder="Latitude">
        </div>
        <div class="form-group col-md-4 col-sm-6">
            <label class="col-form-label" for="input-location-lng">Longitude</label>
            <input type="text" pattern="(\-?\d+(\.\d+)?)" class="form-control"
                   id="input-location-lng" name="location-lng"
                   value="{{old('location-lng',$quest->quest_location->lng ?? '0.000000')}}"
                   placeholder="Longitude">
        </div>
    </div>
@endif
<!-- Details -->
<h5><i class="fas fa-info-circle"></i> Details</h5>
<div class="form-group">
    <label for="input-story">Story</label>
    <textarea class="form-control" id="input-story" name="story"
              rows="5">{{old('story',$quest->story ?? '')}}</textarea>
</div>
<div class="form-group">
    <label for="input-how-to">How to</label>
    <textarea class="form-control" id="input-how-to" name="how-to"
              rows="3">{{old('how-to',$quest->how_to ?? '')}}</textarea>
</div>
<div class="form-group">
    <label for="input-criteria">Criteria <span
                class="text-warning">(Only staff can see this)</span></label>
    <textarea class="form-control" id="input-criteria" name="criteria"
              rows="5">{{old('criteria',$quest->criteria ?? '')}}</textarea>
</div>
<div class="form-group">
    <label for="input-editorial">Editorial <span
                class="text-warning">(Only staff can see this)</span></label>
    <textarea class="form-control" id="input-editorial" name="editorial"
              rows="5">{{old('editorial',$quest->meta ?? '')}}</textarea>
</div>