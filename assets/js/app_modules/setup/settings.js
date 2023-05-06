var Settings = function() {

	var save = function( sal_calc ) {

		$.ajax({
			url : base_url + 'index.php/setting/save',
			type : 'POST',
			data : { 'sal_calc' : sal_calc },
			dataType : 'JSON',
			success : function(data) {

				if (data.error === 'false') {
					alert('An internal error occured while saving department. Please try again.');
				} else {
					alert('Setting saved successfully.');
					general.reloadWindow();
				}
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	return {

		init: function(){
			this.bindUI();
		},

		bindUI: function() {

			$('.btnSave').on('click', function(e) {
				e.preventDefault();
				save($('#sal_dropdown').val());
			});
		}
	}
}

var settings = new Settings();
settings.init();