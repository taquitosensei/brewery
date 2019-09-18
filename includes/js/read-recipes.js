$(document).ready(function(){
				showRecipes(); 
});
$(document).on('click', '.read-recipes-button', function() {
				showRecipes(); 
}); 
$(document).on('click', '.read-one-recipe-button', function() {
				showIntervals($(this).attr('data-id')); 
});
function changePageTitle(page_title) { 
				$('#page-title').text(page_title); 
				document.title=page_title; 
}

function showRecipes() {
	$.getJSON("http://"+ip+"/api/recipe/read.php", function(data) {
		var read_recipes_html=`
				 <table class='table table-bordered table-hover'> 
									<tr>
										<th class='w-75-pct'>Name</th>
										<th class='w-25-pct text-align-center'>Action</th>
									</tr>`;

					$.each(data.records, function(key,val) { 
									read_recipes_html+=`
									<tr>
													<td>` + val.name + `</td>
													<td>
														<button class='btn-primary m-r-10px read-one-recipe-button' data-id='`+ val.id + `'> 
														<span style='color:black;' class='ui-icon ui-icon-action'></span>
														</button> 
														<button class='btn btn-info m-r-10px update-recipe-button' data-id='`+ val.id +`'>
													  <span class='glyphicon glyphicon-edit'></span> Edit
														</button> 
														<button class='btn btn-danger m-r-10px delete-recipe-button' data-id='`+ val.id +`'>
														<span class='glyphicon glyphicon-remove'></span> Del
														</button>
												</td>
											</tr>`;
					});
					read_recipes_html+=`</table>`; 
					read_recipes_html+=`<div id'create-recipe' class='btn btn-primary pull-right m-b-15px create-recipe-button'>
															<span class='glyphicon glyphicon-plus'></span> Add Recipe
															</div>`;

					$("#page-content").html(read_recipes_html);
					changePageTitle("Recipes");
									  
	}); 
}
