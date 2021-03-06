@extends ('layouts.master')

@section('content')
	
	<!-- form for submitting medical entry page -->

    @include ('entries.create_illness')

    @include ('entries.create_symptom')

	<div class="card">
		<div class="card-header">
			<h4>Medisch Dagboek</h4> <p>Velden met een sterretje (*) zijn verplicht</p>
		</div>

		<div class="card-body">
			<form method="POST" action="/entries/create_entry">
				{{ csrf_field() }} 
				<!-- places all illnesses from db -->
				<div>
					<h5>Aandoening: *</h5>
					<select name="illness_id" class="medform-control{{ $errors->has('illness_id') ? ' is-invalid' : '' }}" required>
							<option selected></option>
						@foreach($illnesses as $illness)
							<option value="{{ $illness->id }}">{{ $illness->illness }}</option>
						@endforeach()
					</select>
<!-- 					@if ($errors->has('illness_id'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('illness_id') }}</strong>
                        </span>
                 	@endif -->
<!-- 					@include('layouts.error')	 -->
				</div>
				<hr>
				<div>
					<p>Symptomen:</p>
					<!-- places all symptomes from db -->
					@foreach($symptomes as $symptom)
						<input type="checkbox" name="symptom[]" value="{{ $symptom->id }}" enctype="multipart/form-data">
						<label for="subscribeNews">{{ $symptom->symptom }}</label>
					@endforeach()	
				</div>
				<hr>
				<div>
					<p>Wanneer gebeurde het:</p>
					<input type="date" id='timespan_date' name="timespan_date">
					<input type="time" name="timespan_time" value="now">
				</div>
				<hr>
				<div>
					<p>Waar gebeurde het:</p>
					<input type="text" name="location" placeholder="locatie">
				</div>
				<hr>
				<div>
					<p>Intensiteit</p>
					<input type="range" min="1" max="10" value="5" class="slider" id="intensityRange">
					<span id="intensityValue"></span>
				</div>
				<hr>
				<div>
					<p>Klachtsduur</p>
					<input type="time" name="complaint_time"> (Tijd)
				</div>
				<hr>
				<div>
					<p>Hersteltijd</p>
					<input type="time" name="recoverytime_time"> (Tijd)
				</div>
				<hr>
				<div>
					<p>Medicatie</p>
					<input type="checkbox" name="medA" value="medA" enctype="multipart/form-data">
					<label for="subscribeNews">MEDICATIE A</label>
					<input type="checkbox" name="medA" value="medA" enctype="multipart/form-data">
					<label for="subscribeNews">MEDICATIE B</label>
					<input type="checkbox" name="medA" value="medA" enctype="multipart/form-data">
					<label for="subscribeNews">MEDICATIE C</label>
				</div>
				<hr>
				<div>
					<p>Weer</p>
					<textarea name="weather" placeholder="Omschrijving eventuele weersomstandigheden"></textarea>
				</div>
				<hr>
				<div>
					<p>Getuigen verslagen</p>
					<textarea name="witness_report" placeholder="Getuigenverklaringen"></textarea>
				</div>
				<hr>
				<div>
					<p>Overig</p>
					<textarea name="comments" placeholder="Overige aantekeningen"></textarea>
				</div>
				<div>
					<p>Sla mijn dagboek op</p>
					<input type="submit" value="save">
				</div>				
			</form>
		</div>
	</div>
	
<script>

	// Function to determine current date
	Date.prototype.toDateInputValue = (function() {
	    var local = new Date(this);
	    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
	    return local.toJSON().slice(0,10);
	})

	// Places current date into input 'date' fields
	document.getElementById('timespan_date').value = new Date().toDateInputValue();

	// Function to keep pagescroll unchanged on buttonclick
    $('a.btnSub').click(function(e)
        {
            e.preventDefault();
        });

    // Function to determine current time
    $(function(){  
		$('input[type="time"][value="now"]').each(function(){    
		    var d = new Date(),        
		        h = d.getHours(),
		        m = d.getMinutes();
		    if(h < 10) h = '0' + h; 
		    if(m < 10) m = '0' + m; 
		    $(this).attr({
		      'value': h + ':' + m
    		});
  		});
	});

	var sliderBar = document.getElementById('intensityRange');
	var sliderVal = document.getElementById('intensityValue');
	sliderVal.innerHTML = sliderBar.value;

	sliderBar.oninput = function() {
  	sliderVal.innerHTML = this.value;
  		if (this.value == 1) 
  		{
  			sliderVal.innerHTML = '<i class="far fa-frown"></i>';
  		}
}

</script>
@endsection
