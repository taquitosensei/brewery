$(document).on('click', '.read-fermenters-button', function() {
				showFermenters(); 
});

function changePageTitle(page_title) { 
				$('#page-title').text(page_title); 
				document.title=page_title; 
}

function showFermenters() {

	$.getJSON("http://"+ip+"/api/fermenter/read.php", function(data) {
		var read_fermenters_html=`
				 <table class='table table-bordered table-hover'> 
									<tr>
										<th class='w-10-pct'>Pos</th>
										<th class='w-10-pct'>GPIO</th>
										<th class='w-35-pct'>Temp Serial #</th>
										<th class='w-15-pct'>Temp</th>
										<th class='w-30-pct text-align-center'>Action</th>
									</tr>`;

					$.each(data.records, function(key,val) { 
									read_fermenters_html+=`
									<tr>
													<td>` + val.pos + `</td>
													<td>` + val.gpio + `</td>
													<td>` + val.temp_serial + `</td>
													<td>` + val.temp +`</td>
													<td>
														<button class='btn btn-info m-r-10px update-fermenter-button' data-id='`+ val.id +`'>
													  <span class='ui-icon ui-icon-pencil'></span> Edit
														</button> 
												</td>
											</tr>`;
					});
					read_fermenters_html+=`</table>`; 
					read_fermenters_html+=`<div id='create-fermenter' class='btn btn-primary pull-right m-b-15px create-fermenter-button'>
															<span class='glyphicon glyphicon-plus'></span> Start Fermenter
															</div>`;

					$("#page-content").html(read_fermenters_html);
					$(document).on('click', '.update-fermenter-button', function(event){
						showFermentersEdit($(this).attr('data-id')); 
					});
					changePageTitle("Fermenters"); 
									  
	}); 
}

function showFermentersEdit(id) {

	$.getJSON("http://"+ip+"/api/fermenter/read_one.php?id="+id, function(data) { 
		var modal_html=`
		<form id='fermenter-edit-form' action='#' method='post'> 
				<input type='hidden' name='id' id='id' value='`+data.id+`'>
				<div class='form-group'> 
									<label for='pos'>Fermenter Position</label>
								
									<input type='text' class='form-control' name='pos' id='pos' aria-describedby='poshelp' placeholder='Fermenter Position' value='`+data.pos+`'>
									<small id='poshelp' class='form-text text-muted'>Enter the fermenter position</small> 
			  </div>
				<div class='form-group'> 
									<label for='gpio'>GPIO Pin</label>
									<input type='text' class='form-control' name='gpio' id='gpio' aria-describedby='gpiohelp' placeholder='RPi GPIO Pin' value='`+data.gpio+`'>
									<small id='gpiohelp' class='form-text text-muted'>Enter the Raspberry PI GPIO Pin</small>
				</div>
				<div class='form-group'> 
									<label for='temp_serial'>Temp Probe Serial #</label>
									<input type='text' class='form-control' name='temp_serial' id='temp_serial' aria-describedby='temp_serialhelp' placeholder='Temp Probe Serial #' value='`+data.temp_serial+`'> 
									<small id='temp_serialhelp' class='form-text text-muted'>Enter the temp probe serial #</small>
				</div>
				<button type='submit' class='btn btn-primary'>Update Fermenter</button>
		</form>`
					$('#modal-body').html(modal_html); 
					$('#modal-title').html('Edit Fermenter'); 
					$('#modal').modal('toggle');
					$(document).on('submit', '#fermenter-edit-form', function(e) {
									e.preventDefault();
									var form_data=JSON.stringify($(this).serializeObject());
									updateFermenter(form_data); 
									showFermenters(); 
									$('#modal').modal('hide'); 
					});

	});
}

function updateFermenter(form_data) {
	$.ajax({ 
		url: "http://"+ip+"/api/fermenter/update.php", 
					type: "POST", 
					contentType: 'application/json', 
					data: form_data, 
					success: function(result) { 
									showFermenters(); 
					},
					error: function(xhr, resp, text) { 
									console.log(xhr, resp, text); 
					}
	});
}
