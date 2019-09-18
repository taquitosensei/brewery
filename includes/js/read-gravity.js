$(document).on('submit', '#gravity-create-form', function(e) {
				e.preventDefault();
				var fermenting_id=$('#fermenting_id').val();
				var form_data = JSON.stringify($(this).serializeObject()); 
				createGravity(form_data); 
				showGravity(fermenting_id); 
				$('#modal').modal('hide'); 
});
$(document).on('submit', '#gravity-update-form', function(e) {
				e.preventDefault();
				console.log('blah');
			  var fermenting_id = $('#fermenting_id').val();	
				var form_data = JSON.stringify($(this).serializeObject()); 
				updateGravity(form_data); 
				showGravity(fermenting_id); 
				$('#modal').modal('hide'); 
});
$(document).on('click', '#create-gravity', function() {
				fermenting_id=$(this).attr('data-id'); 
				showGravityCreate(fermenting_id); 
}); 

$(document).on('click', '.update-gravity-button', function() {
				var gravity_id=$(this).attr('data-id'); 
				showGravityUpdate(gravity_id); 
}); 

function showGravity(fermenting_id) {
				$.getJSON("http://192.168.1.111/api/gravity/read.php?fermenting_id="+fermenting_id, function(data) { 
								var gravity_html=`
									<table class='table table-bordered table-hover'> 
												<tr>
													<th class=''>Recipe</th>
												  <th class=''>Pos</th> 
												  <th class=''>Gravity</th>
												  <th class=''>Yeast removed</th>
												  <th class=''>Date</th>
												</tr>`;
								$.each(data.records, function(key,val) { 
												gravity_html+=`
												<tr>
													<td>${val.name}</td>
													<td>${val.pos}</td>
													<td>${val.gravity}</td>
													<td>${val.yeast_gal}</td>
													<td>${val.date}</td>
													<td>
																<button class='btn btn-primary m-r-10px update-gravity-button' data-id='${val.id}'>
																<span>Edit</span>
													</td>`;
								}); 
								gravity_html+=`</table>`; 
								gravity_html+=`<div id='create-gravity' class='btn btn-primary pull-right m-b-15px create-gravity-button' data-id='${fermenting_id}'>
																Add Gravity
															</div>`; 
								$('#page-content').html(gravity_html); 
								changePageTitle("Gravity"); 

				});
}

function showGravityCreate(fermenting_id) {
				var modal_html=`
				<form id='gravity-create-form' action='#' method='post'> 
								<input type='hidden' name='fermenting_id' id='fermenting_id' value='${fermenting_id}'> 
								<div class='form-group'> 
									<label for='gravity'>Gravity</label>
									<input type='number' step='0.001' class='form-control' name='gravity' id='gravity' aria-describedby='gravityhelp' placeholder='Gravity Reading'>
									<small id='gravityhelp' class='form-text text-muted'>Enter the gravity reading</small>
								</div>
								<div class='form-group'>
									<label for='yeast_gal'>Yeat Gal</label>
									<input type='number' class='form-control' name='yeast_gal' id='yeast_gal' aria-describedby='yeast_galhelp' placeholder='Gallons of Yeast removed'>
									<small id='yeast_galhelp' class='form-text text-muted'>Enter # of Gallons of yeast removed</small>
								</div>
								<button type='submit' class='btn btn-primary'>Record Gravity</button>
				</form>`;
				$('#modal-body').html(modal_html); 
				$('#modal-title').html('Record Gravity'); 
				$('#modal').modal('show'); 
}

function showGravityUpdate(gravity_id) { 
				$.getJSON("http://"+ip+"/api/gravity/read.php?id="+gravity_id, function(data) {
								var data = data.records[0]; 
				var modal_html =`
				<form id='gravity-update-form' action='#' method='post'> 
								<input type='hidden' name='gravity_id' id='gravity_id' value='${gravity_id}'> 
								<input type='hidden' name='fermenting_id' id='fermenting_id' value='${data.fermenting_id}'>
								<div class='form-group'> 
									<label for='gravity'>Gravity</label>
									<input type='number' step='0.001' class='form-control' name='gravity' id='gravity' aria-describedby='gravityhelp' placehord='Gravity Reading' value='${data.gravity}'> 
									<small id='gravityhelp' class='form-text text-muted'>Enter Gravity Reading</small>
								</div> 
								<div class='form-group'> 
												<label for='yeast_gal'>Yeast in Gal</label>
												<input type='number' class='form-control' name='yeast_gal' id='yeast_gal' aria-describedby='yeast_galhelp' placeholder='Gallons of Yeast removed' value='${data.yeast_gal}'> 
												<small id='yeast_galhelp' class='form-text text-muted'>Enter Gallons of Yeast removed</small>
								</div>
								<button type='submit' class='btn btn-primary'>Update Gravity</button> 
				</form>`;
								$('#modal-body').html(modal_html); 
								$('#modal-title').html('Update Gravity'); 
								$('#modal').modal('show'); 

				}); 
}

function updateGravity(form_data) { 
				$.ajax({
								url: "http://"+ip+"/api/gravity/update.php", 
								type: "POST", 
								async: false, 
								contentType: "application/json", 
								data: form_data, 
								success: function(result) { 
												return true; 
								},
								error: function(xhr, resp, text) { 
												console.log(xhr, resp, text); 
								}

				}); 
}
function createGravity(form_data) { 
	$.ajax({
					url: "http://"+ip+"/api/gravity/create.php",
					type: "POST", 
					async: false, 
					contentType: "application/json", 
					data: form_data, 
					success: function(result) { 
									return true;
					},
					error: function(xhr, resp, text) { 
									console.log(xhr, resp, text); 
					}
	}); 
}
