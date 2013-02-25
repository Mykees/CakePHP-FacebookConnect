<?php
class FacebookHelper extends AppHelper{

	public $helpers = array('Html');

	public function connect(){
		$this->fbRoot();
		$link = Router::url(array('plugin'=>'Facebook','controller'=>'facebooks','action'=>'facebook'));
		return '<a href="'.$link.'" id="facebookConnect">Facebook Connect</a>';
	}

	public function fbRoot(){

		$this->Html->scriptStart(array('inline'=>false));
		?>
		jQuery(function($){

			$("body").prepend('<div id="fb-root"></div>');

			window.fbAsyncInit = function() {
	          FB.init({
	            appId      : '<?php echo Configure::read('Plugin.Facebook.facebook.appID'); ?>', // App ID
	            status     : true, // check login status
	            cookie     : true, // enable cookies to allow the server to access the session
	            xfbml      : true,  // parse XFBML
	            oauth	   : true
	          });
	        };
	        // Load the SDK Asynchronously
	        (function(d){
	           var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	           if (d.getElementById(id)) {return;}
	           js = d.createElement('script'); js.id = id; js.async = true;
	           js.src = "//connect.facebook.net/fr_FR/all.js";
	           ref.parentNode.insertBefore(js, ref);
	         }(document));

	         $("#facebookConnect").click(function(){
	         	var url = $(this).attr("href");
	         	FB.login(function( response) {
	         		if(response.authResponse){
	         			window.location = url;
	         		}
	         	},{ scope : "email"});
	         	return false;
	     	 });

		});
		<?php
		$this->Html->scriptEnd();
	}
}