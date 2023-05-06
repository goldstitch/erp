var PrivillagesGroup = function(){

	var validateSignIn = function() {

		var errorFlag = [];
		var name = $.trim($('#txtUsername').val());
		var pass = $.trim($('#txtPassowrd').val());
		var mobcode = $.trim($('#txtMobCode').val());

		// remove previous errors
		$('.login-error').remove();

		if ( name === '' || name === null ) {
			$('#txtUsername').addClass('inputerror');
			errorFlag.push("Enter Username.");
		}
		if ( pass === '' || pass === null ) {
			$('#txtPassowrd').addClass('inputerror');
			errorFlag.push("Enter Password.");
		}
		if ( mobcode === '' || mobcode === null ) {
			$('#txtMobCode').addClass('inputerror');
			errorFlag.push("Enter Mobile Code.");
		}

		return errorFlag;
	}

	var validateSignInMobCode = function() {

		var errorFlag = [];
		var name = $.trim($('#txtUsername').val());
		var pass = $.trim($('#txtPassowrd').val());
		

		// remove previous errors
		$('.login-error').remove();

		if ( name === '' || name === null ) {
			$('#txtUsername').addClass('inputerror');
			errorFlag.push("Enter Username.");
		}
		if ( pass === '' || pass === null ) {
			$('#txtPassowrd').addClass('inputerror');
			errorFlag.push("Enter Password.");
		}
		

		return errorFlag;
	}

	var fetch = function(uname, pass, mob_code) {
		
		$.ajax({
			url : base_url + 'index.php/welcome/login',
			type : 'POST',
			data : { uname : uname, pass : pass, mob_code: mob_code },
			dataType : 'JSON',
			success : function(data) {
				if (data.error == true) {
					var span = "<span class='login-error'>Invalid username or password entered.</span>";
					$(span).appendTo('.errors_section');
				} else {				

					window.location = base_url + 'index.php/user/dashboard';
				}
			}, error : function(xhr, status, error) {
				window.location = base_url + 'index.php/user/dashboard';
				console.log(xhr.responseText);
			}
		});
	}

	var fetchCode = function(uname, pass) {
		$.ajax({
			url : base_url + 'index.php/welcome/loginCode',
			type : 'POST',
			data : { uname : uname, pass : pass },
			dataType : 'JSON',
			success : function(data) {
				if (data == true) {
					alert('Mobile Code Send Successfuly To Your Cell.....');					
				} else {
					alert('code sending error');					
					var span = "<span class='login-error'>Mobile Code Sending Error. Try Again!...</span>";
					$(span).appendTo('.errors_section');
					window.location = base_url + 'index.php/welcome/login';
				}
			}, error : function(xhr, status, error) {
				alert('send error');
				console.log(xhr.responseText);
			}
		});
	}





	return {

		init: function() {
			
			this.bindUI();
		},

		bindUI: function() {
			var self = this;
			
			$('#login_form input').on('keypress', function(e) {
				if (e.keyCode == 13) {
					$('.btnSignin').trigger('click');
				}
			});

			$('.btnSignin').on('click', function(e) {
				e.preventDefault();
				self.initSignIn();
			});

			$('.btnMobCode').on('click', function(e) {
				 e.preventDefault();
				 self.initSignInCode();
			});
		},

		initSignIn: function() {

			var errors = validateSignIn();

			if (errors.length == 0) {

				var uname = $.trim($('#txtUsername').val());
				var pass = $.trim($('#txtPassowrd').val());
				var mob_code = $.trim($('#txtMobCode').val());
				fetch(uname, pass, mob_code);
			} else {
				alert('enter valid user name or password');
				var spans = "";
				$.each(errors, function(index, elem) {
					spans += "<span class='login-error'>"+ elem +"</span>";
				});
				// show the errors on the screen
				$(spans).appendTo('.errors_section');
			}
		},

		initSignInCode: function() {

			var errors = validateSignInMobCode();

			if (errors.length == 0) {
				var uname = $.trim($('#txtUsername').val());
				var pass = $.trim($('#txtPassowrd').val());
				fetchCode(uname, pass);
			} else {
				var spans = "";
				$.each(errors, function(index, elem) {
					spans += "<span class='login-error'>"+ elem +"</span>";
				});
				// show the errors on the screen
				$(spans).appendTo('.errors_section');
			}
		},


		resetVoucher: function() {

			$('#txtIdHidden').val('');
			$('#txtName').val('');
			$('input[type="checkbox"]').prop('checked', false);
			getMaxId();
		}
	}

};

var privillagesGroup = new PrivillagesGroup();
privillagesGroup.init();