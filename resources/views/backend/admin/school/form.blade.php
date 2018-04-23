<div class="row">
        <div class="form-group">
            <strong>School Name:</strong>
          {!! Form::text('name', null, array('placeholder' => '','class' => 'form-control','required'=>'true')) !!}
        </div>

        <div class="form-group">
           <strong>City:</strong>
           <?php
            $cities = ['Abu Dhabi','Ajman','Dubai','Fujairah','Ras Al Khaimah','Sharjah','Umm Al Quwain'];
            $cities_new = [];
            foreach ($cities as $city)  {
              $cities_new[$city] = $city;
            }
           ?>
           {!! Form::select('city', $cities_new, null, array('placeholder' => 'Select City','class' => 'form-control','required'=>'true')) !!}
        </div>

        <div class="form-group">
           <strong>Country:</strong>
           {!! Form::select('country', ['United Arab Emirates'=>'United Arab Emirates'], null, array('class' => 'form-control','required'=>'true')) !!}
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
</div>
