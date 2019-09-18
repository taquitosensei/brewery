$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
function loadSelect() {
	$('select[data-source]').each(function() {
		var $select = $(this);						  
		$select.append('<option></option>');						  
	  $.ajax({
	    url: $select.attr('data-source'),
	  }).then(function(options) {
			console.log(options); 
		  options.records.map(function(option) {
			  var $option = $('<option>');										      
	      $option
	        .val(option[$select.attr('data-valueKey')])
	        .text(option[$select.attr('data-displayKey')]);																$select.append($option);
			});
		});
	});
}
