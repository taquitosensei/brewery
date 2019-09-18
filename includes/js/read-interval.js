$(document).on('submit', '#interval-create-form', function(e) {
	e.preventDefault();
	var form_data=JSON.stringify($(this).serializeObject());
	createInterval(form_data); 
	recipe_id=$('#recipe_id').val();
	showIntervals(recipe_id); 
	$('#modal').modal('hide'); 
});	

$(document).on('submit', '#interval-edit-form', function(e) {
	e.preventDefault();
	var recipe_id=$('#recipe_id').val();
	console.log("We're updating: "+recipe_id); 
	var form_data=JSON.stringify($(this).serializeObject());
	updateInterval(form_data);
	showIntervals(recipe_id); 
	$('#modal').modal('hide'); 
});

$(document).on('click', '#create-interval', function(){
  recipe_id=$(this).attr('data-id');
	showIntervalsCreate(recipe_id); 
});
$(document).on('click', '.update-interval-button', function(){
	interval_id=$(this).attr('data-id');
	showIntervalsEdit(interval_id);
});
$(document).on('click', '.delete-interval-button', function(){
				interval_id=$(this).attr('data-id');
				deleteInterval(interval_id); 
});

function changePageTitle(page_title) { 
				$('#page-title').text(page_title); 
				document.title=page_title; 
}

function showIntervals(recipe_id) {
				$.getJSON("http://"+ip+"/api/interval/read.php?id="+recipe_id, function(data) {
		     var interval_html=`
				 <table class='table table-bordered table-hover'> 
									<tr>
										<th class='w-40-pct'>Recipe</th>
										<th class='w-10-pct'>Interval #</th>
										<th class='w-10-pct'>Days</th>
										<th class='w-10-pct'>Start Temp</th>
										<th class='w-10-pct'>End Temp</th>
									  <th class='w-20-pct'>Action</th>
									</tr>`;
					$.each(data.records, function(key,val) {
									interval_html+=`
									<tr>
													<td>${val.name}</td>
													<td>${val.recipe_interval}</td>
													<td>${val.days}</td>
													<td>${val.start_temp}</td>
													<td>${val.end_temp}</td>
													<td>
														<button class='btn btn-info m-r-10px update-interval-button' data-id='${val.id}'>
													  <span class='ui-icon ui-icon-pencil'></span> Edit
														</button>
													   <button class='btn btn-danger m-r-10px delete-interval-button' data-id='${val.id}'>
															Delete
														</button>
												</td>
											</tr>`;
					});
					 
					interval_html+=`</table> 
							<div id='create-interval' class='btn btn-primary pull-right m-b-15px create-interval-button' data-id='${recipe_id}'>
								<span class='glyphicon glyphicon-plus'></span> Add Interval
							</div>`;
					$('#page-content').html(interval_html); 
					});
					changePageTitle("Intervals"); 
}

function showIntervalsEdit(id) {

	$.getJSON("http://"+ip+"/api/interval/read_one.php?id="+id, function(data) { 
		var modal_html=`
		<form id='interval-edit-form' action='#' method='post'> 
				<input type='hidden' name='id' id='id' value='${data.id}'>
				<input type='hidden' name='recipe_id' id='recipe_id' value='${data.recipe_id}'>
				<div class='form-group'> 
									<label for='pos'>Interval #</label>
								
									<input type='text' class='form-control' name='recipe_interval' id='recipe_interval' aria-describedby='recipe_intervalhelp' placeholder='Interval Position' value='${data.recipe_interval}'>
									<small id='recipe_intervalhelp' class='form-text text-muted'>Enter the interval #</small> 
			  </div>
				<div class='form-group'> 
									<label for='gpio'># of Days</label>
									<input type='text' class='form-control' name='days' id='days' aria-describedby='dayshelp' placeholder='# of Days' value='${data.days}'>
									<small id='dayshelp' class='form-text text-muted'>Enter # of days for interval</small>
				</div>
				<div class='form-group'> 
									<label for='start_temp'>Start Temperature</label>
									<input type='text' class='form-control' name='start_temp' id='start_temp' aria-describedby='start_temphelp' placeholder='Start Temperature' value='${data.start_temp}'> 
									<small id='start_temphelp' class='form-text text-muted'>Enter Start Temperature</small>
				</div>
				<div class='form-group'>
                  <label for='end_temp'>Start Temperature</label>
                  <input type='text' class='form-control' name='end_temp' id='end_temp' aria-describedby='end_temphelp' placeholder='End Temperature' value='${data.end_temp}'>
                  <small id='end_temphelp' class='form-text text-muted'>Enter End Temperature</small>
        </div>
				<button type='submit' class='btn btn-primary'>Update Interval</button>
		</form>`;
					$('#modal-body').html(modal_html); 
					$('#modal-title').html('Edit Interval'); 
					$('#modal').modal('show');
	});
}


function showIntervalsCreate(recipe_id) {
		var modal_html=`
		<form id='interval-create-form' action='#' method='post'> 
				<input type='hidden' name='recipe_id' id='recipe_id' value='${recipe_id}'>
				<div class='form-group'> 
									<label for='pos'>Interval #</label>
								
									<input type='text' class='form-control' name='recipe_interval' id='recipe_interval' aria-describedby='recipe_intervalhelp' placeholder='Interval #'>
									<small id='recipe_intervalhelp' class='form-text text-muted'>Enter the interval #</small> 
			  </div>
				<div class='form-group'> 
									<label for='days'># of Days</label>
									<input type='text' class='form-control' name='days' id='days' aria-describedby='dayshelp' placeholder='# of Days'>
									<small id='dayshelp' class='form-text text-muted'>Enter # of days for interval</small>
				</div>
				<div class='form-group'> 
									<label for='start_temp'>Start Temperature</label>
									<input type='text' class='form-control' name='start_temp' id='start_temp' aria-describedby='start_temphelp' placeholder='Start Temperature'> 
									<small id='start_temphelp' class='form-text text-muted'>Enter Start Temperature</small>
				</div>
				<div class='form-group'>
                  <label for='end_temp'>Start Temperature</label>
                  <input type='text' class='form-control' name='end_temp' id='end_temp' aria-describedby='end_temphelp' placeholder='End Temperature'>
                  <small id='end_temphelp' class='form-text text-muted'>Enter End Temperature</small>
        </div>
				<button type='submit' id='#create-interval' class='btn btn-primary'>Create Interval</button>
		</form>`
					$('#modal-body').html(modal_html); 
					$('#modal-title').html('Create Interval'); 
					$('#modal').modal('show');
}

function deleteInterval(id) {
 $.getJSON("http://"+ip+"/api/interval/delete.php?id="+id, function() {
 	var recipe_id=$('#create-interval').attr('data-id'); 
  showIntervals(recipe_id); 
 });
}

function updateInterval(form_data) {
	$.ajax({ 
		url: "http://"+ip+"/api/interval/update.php", 
					type: "POST", 
					async: false, 
					contentType: 'application/json', 
					data: form_data, 
					success: function(result) { 
									return true;  
					},
					error: function(xhr, resp, text) { 
									console.log(xhr, resp, text); 
					}
	});
}
function createInterval(form_data) {
				$.ajax({
								url: "http://"+ip+"/api/interval/create.php", 
								type: "POST",
								async: false, 
								contentType: 'application/json', 
								data: form_data, 
								success: function(result) {
												return true;
								},
								error: function(xhr, resp,text) {
												console.log(xhr, resp, text); 
								}
				}); 
}
