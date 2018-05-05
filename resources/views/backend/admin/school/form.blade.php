  <div class="form-group">
    <label class="control-label col-sm-2" >School Name:</label>
    <div class="col-sm-10">
      {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control','required'=>'true')) !!}
    </div>
  </div>
  <div class="form-group">
     <label class="control-label col-sm-2" >City:</label>
     <?php
      $cities = ['Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain'];
      $cities_new = [];
      foreach ($cities as $city)  {
        $cities_new[$city] = $city;
      }
     ?>
     <div class="col-sm-10">
       {!! Form::select('city', $cities_new, null, array('placeholder' => 'Select City','class' => 'form-control','required'=>'true')) !!}
     </div>
  </div>

  <div class="form-group">
     <label class="control-label col-sm-2" >Country:</label>
     <div class="col-sm-10">
       {!! Form::select('country', ['United Arab Emirates'=>'United Arab Emirates'], null, array('class' => 'form-control','required'=>'true')) !!}
     </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</div>
