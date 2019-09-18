<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
		<meta name="brewery control panel" content=""> 
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="includes/jquery-mobile/jquery.mobile.js"></script>
		<link rel="stylesheet" href="includes/jquery-mobile/jquery.mobile.css">
		<link rel="stylesheet" href="includes/css/style.css"> 
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="includes/js/ip.js"></script>
		<script src="includes/js/app.js"></script>
		<script src="includes/js/read-recipes.js"></script>
    <script src="includes/js/read-gravity.js"></script>
		<script src="includes/js/read-fermenting.js"></script>
		<script src="includes/js/read-fermenter.js"></script>
		<script src="includes/js/read-interval.js"></script>
	</head>
	<body>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body">
			</div>
		<!--
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="modal-save" type="button" class="btn btn-primary">Save changes</button>
			</div>
			-->
    </div>
  </div>
	</div>
		<div class="container"> 
			<div class="row"> 
				<div class="col-md-4">
					<div class="panel-group" id="accordion"> 
						<div class="panel panel-default"> 
							<div class="panel-heading"> 
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									<span class="glyphicon glyphicon-folder-close"></span>
									Menu
									</a>
								</h4>
							</div>
							<div id="collapseOne" class="panel-collapse collapse in"> 
								<div class="panel-body"> 
									<table class="table"> 
										<tr>
											<td><a href="#" class='read-fermentings-button'>Currently Fermenting</a></td> 
										</tr> 
										<tr>
											<td><a href="#" class='read-fermenters-button'>Fermenters</a></td>
										</tr>
										<tr>
											<td><a href="#" class='read-recipes-button'>Recipes</a></td>
										</tr>
										<tr>
											<td><a href="#">Reports</a></td>
										</tr>
									</table> 
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class='page-header'> 
						<h1 id='page-title'>Recipes</h1>
						<div id='page-content'></div>
					</div> 
				</div> 
			</div>
		</div>
	</body> 
</html>
		
