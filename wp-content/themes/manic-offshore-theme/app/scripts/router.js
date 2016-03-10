// define(['jquery','underscore','backbone','shared','views/form'], function($, _, Backbone, Shared, FormView){
// 	var AppRouter = Backbone.Router.extend({ 
// 		routes : {
// 			'' : 'customerForm',
// 			'*other' : 'default'
// 		},
// 		customerForm : function(){
// 			console.log('hi');
// 			// var formView = new FormView({ router : AppRouter });
// 			// formView.render();
// 		},		
// 		default : function(other) {
// 			alert('no idea what you searching for: '+other)
// 		}
// 	}); 

// 	var initialize = function(){
// 		var app_router = new AppRouter;

// 		Shared.router = app_router;
		
// 		Backbone.history.start(); 
// 	}; 

// 	return { initialize: initialize };
// });