define(['backbone', 'jquery', 'collections/carts', 'collections/searchusers', 'models/customer', 'views/finishcart', 'views/prints', 'views/searchusers','validate', 'iefix'], function(Backbone, $, cartsCollection, SearchUsersCollection, CustomerModel, FinishCartView, PrintsView, SearchUserView, validate, iefix){

	var formView = Backbone.View.extend({
		el : '#CustomerRegistrationForm',
		template : _.template($('#customerForm').html()),
		// productListing : $('#ProductListing'),
		events : {
			'click #submit' : 'submit'
		},
		render : function() {
			$('body').addClass('main');
			$('.container').css('display', 'none');
			// $('.index').css('display','block');
			// $('footer').animate({width:'toggle'},350);
			$('.index').animate({width:'toggle'},350);

			this.router = new this.options.router;

			console.log(this.router);

			if (CustomerModel.has("name")) {
			  	this.router.navigate("showcarmodels", {trigger: true});
			}else {
				this.$el.show();
				var html = this.template();
				this.$el.html(html);

				$(this.el).validate({
					onkeyup: false,
					focusInvalid: false,
					rules : {
						name : {
							required	: true
						},
						phone : {
							required	: true,
							number		: true
						}
					},
					messages : {
						name : "Missing Name",
						phone: {
							required:"Missing Phone No",
							number:"Invalid Phone No"
						}
					},
					showErrors: function(errorMap, errorList) {
						for(var error in errorMap){
							if(error=="name" || error=="phone"){
								$(':text[name='+error+']').val(errorMap[error]).addClass('error');//append err msg in all text field and hightlight
							}
						}
					}
				});

				$('input,textarea').blur(function(){
					var error_array = [ "Missing Name","Missing Phone No","Invalid Phone No" ];		
					var input_value = $(this).val();
					if(jQuery.inArray(input_value, error_array)==-1) { //-1 = not found in error array
						$(this).removeClass('error');//when focus out and field is not blank remove err highlight
						
					}
				});
				
				$('input:text,textarea').focus(function(){
					var error_array = [ "Missing Name","Missing Phone No","Invalid Phone No" ];		
					var input_value = $(this).val();
					if(jQuery.inArray(input_value, error_array)!=-1){ //if there is error in text field remove
						$(this).val("");
					}
				});

				this.renderUser();
			}
		},
		renderUser: function() {
			var searchUsersCollection = new SearchUsersCollection();

			var searchUserView = new SearchUserView({ collection : searchUsersCollection });
			searchUserView.render();
		},
		submit : function(e){

			e.preventDefault();
			e.stopPropagation();

			console.log('hi');

			//$('#submit').attr('disabled','disabled');

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

			if( $(this.el).valid() ){

				var values = $(this.el).serializeObject();

				if(values.name !== 'Missing Name') {

					CustomerModel.set(values);
					
					CustomerModel.url = function(){
						// return 'http://singaporebentleymotors.com/ipad/dist/api/submit';
						return 'http://localhost:8888/bentley_ipad/ipad/app/api/submit';

					};
					var self = this;
					CustomerModel.save({},{
			            success: function(model, response) {

			                self.$el.hide();
			                
							self.router.navigate("showcarmodels", {trigger: true});

			            },
			            error: function(model, response) {
			                console.log(model);
			                console.log(response);
			            }
			        }, this);

		        }else
		        	values.name = '';

			}
		},
		save: function(customer_id){

			var self = this;

			cartsCollection.each(function(cart){
				cart.set('customer_id' , customer_id);
				console.log(cart);

				var finishCartView = new FinishCartView({ model : cart });
			}, this);

		}
	});	

	return formView;
});