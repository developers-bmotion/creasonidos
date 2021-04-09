
document.getElementsByTagName('html')[0].style.background = 'unset';
document.getElementsByTagName('html')[0].style.backgroundColor = 'unset';
document.getElementsByTagName('body')[0].style.background = '#ffffff00';
window.onload = function() {

	document.body.innerHTML += '<div class="wpbot_embed_container"><iframe style="border:none;" id="wpbot_embed_iframe" src="'+wpIframeUrl+'" scrolling="no" width="100%" ></iframe></div><style type="text/css">.wpbot_embed_container{position:fixed;bottom:10px;right:10px;width: 455px;z-index:9999;}#wpbot_embed_iframe{height:300px}</style>';

	setTimeout(function(){
		if(document.getElementsByClassName('circleRollButton').length>0){
			document.getElementsByClassName('circleRollButton')[0].style.display = 'none';
		}
		if(document.getElementById('moove_gdpr_save_popup_settings_button')){
			document.getElementById('moove_gdpr_save_popup_settings_button').style.display = 'none';
		}
	},3000);

	document.querySelector("#wpbot_embed_iframe").addEventListener("load", function() {

		var json = {
			msg: 'parent',
			val: 'I am from parent window'
		}
		document.querySelector("#wpbot_embed_iframe").contentWindow.postMessage(json, '*');


		var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
		var eventer = window[eventMethod];
		var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
	
		// Listen to message from child window
		eventer(messageEvent,function(e) {
			console.log(e.data);
			if(e.data.msg=='chatbot_open'){
				setTimeout(function(){
					document.getElementById("wpbot_embed_iframe").style.height = '772px';
					document.getElementsByClassName("wpbot_embed_container")[0].style.width = '401px';
				},10)
			}

			if(e.data.msg=='chatbot_close'){
				setTimeout(function(){
					document.getElementById("wpbot_embed_iframe").style.height = '300px';
					document.getElementsByClassName("wpbot_embed_container")[0].style.width = '455px';
				},10)
			}

		},false);
	  
	});

};