$(document).on('click', '.read-fermentings-button', function() {
				showFermentings(); 
}); 
$(document).on('click', '#create-fermenting', function() {
				showFermentingsCreate();
});
$(document).on('click', '.read-gravity-button', function() {
				fermenting_id=$(this).attr('data-id'); 
				showGravity(fermenting_id); 
});
function changePageTitle(page_title) { 
				$('#page-title').text(page_title); 
				document.title=page_title; 
}

$(document).on('submit','#fermentings-create-form', function(e) {
				e.preventDefault(); 
				var form_data=JSON.stringify($(this).serializeObject()); 
				createFermenting(form_data); 
				showFermentings(); 
				$('#modal').modal('hide'); 
});

function showFermentings() {
	$.getJSON("http://192.168.1.111/api/fermenting/read.php", function(data) {
		var read_fermentings_html=`
				 <table class='table table-bordered table-hover'> 
									<tr>
									  <th class='w-10-pct'>Pos</th> 
										<th class='w-20-pct'>Name</th>
									  <th class='w-10-pct'>Temp
										<th class='w-20-pct'>Start Date</th>
									  <th class='w-10-pct'>Grav</th>
										<th class='w-25-pct text-align-center'>Action</th>
									</tr>`;

					$.each(data.records, function(key,val) { 
									read_fermentings_html+=`
									<tr>
													<td>${val.pos}</td>
													<td>${val.recipe_name}</td>
													<td>${val.temp}</td>
													<td>${val.start_date}</td>
													<td>
														<button class='btn-primary m-r-10px read-gravity-button' data-id='${val.id}'> 
														<span>Gravity</span>
													</button>
													</td>
													<td>
														<button class='btn-primary m-r-10px read-one-fermenting-button' data-id=${val.id}'> 
														<span style='color:black;' class='glyphicon glyphicon-eye-open'></span> View
														</button> 
														<button class='btn btn-danger m-r-10px delete-fermenting-button' data-id='${val.id}'>
														<span class='glyphicon glyphicon-remove'></span> Del
														</button>
												</td>
											</tr>`;
					});
					read_fermentings_html+=`</table>`; 
					read_fermentings_html+=`<div id='create-fermenting' class='btn btn-primary pull-right m-b-15px create-fermenting-button'>
															<span class='glyphicon glyphicon-plus'></span> Start Fermenting
															</div>`;

					$("#page-content").html(read_fermentings_html);
					changePageTitle("Fermentings"); 
									  
	}); 
}

function showFermentingsCreate() {
				var modal_html=`
				<form id='fermentings-create-form' action='#' method='pos'> 
								<div class='form-group'>
									<label for='pos'>Fermenter Position</label>
								  <select 
										id="pos_id"
										class="form-control"
										name="pos_id"
										data-source="http://192.168.1.111/api/fermenter/read.php"
										data-valueKey="id"
										data-displayKey="pos"
									aria-describeby='fermenting_poshelp'>
									</select>
									<small id='fermenting_poshelp' class='form-text text-muted'>Select Fermenter Pos (Left to Right Al)</small>
								</div>
								<div class='form-group'>
									<label for='recipe_id'>Recipe</label>
									<select 
										id="recipe_id"
										name="recipe_id"
										class="form-control"
										data-source="http://192.168.1.111/api/recipe/read.php"
										data-valueKey="id"
										data-displayKey="name"
										aria-describedby='fermenting_recipe_idhelp'>
									</select>
									<small id='fermenting_recipe_idhelp' class='form-text text-muted'>Select Recipe</small> 
								</div> 
								<div class='form-group'> 
									<label for='start_gal'>Starting Gallons</label>
									<input type='number' class='form-control' name='start_gal' id='start_gal' aria-describedby='fermenting_start_galhelp' placeholder='Starting Gallons'>
									<small id='fermenting_start_galhelp' class='form-text text-muted'>Enter the # of Gallons to the fermenter</small>
								</div> 
								<div class='form-group'> 
									<label for='gravity'>Original Gravity</label> 
									<input type='number' step="0.001" class='form-control' name='gravity' id='gravity' aria-describedby='fermenting_gravityhelp' placeholder='Original Gravity'>
									<small id='fermenting_gravityhelp' class='form-text text-muted'>Enter the original Gravity</small>
								</div>
								<button type='submit' class='btn btn-primary'>FERMENT!!!</button> 
							</form>
			 `;

			$('#modal-body').html(modal_html); 
			loadSelect(); 
			$('#modal-title').html('Start Fermenting'); 
		 $('#modal').modal('show'); 

}

function createFermenting(form_data) { 
	$.ajax({
					url: "http://"+ip+"/api/fermenting/create.php",
					type: "POST", 
					async: false, 
					contentType: "application/json", 
					data: form_data, 
					success: function(result) { 
									return true;
					},
					error: function(xhr, resp, text) { 
						console.log(xhr, resp,text); 
					}
	});
}
