<?php
include_once('PapApi.class.php');
$session2 = new Gpf_Api_Session("http://affiliate.yourcloudaround.com/scripts/server.php");
if(!$session2->login(get_option('rc_PanEmail'), get_option('rc_PanPassword'))) {

 if($session2->getMessage()=='Wrong Username(E-mail) and/or Password'){
	delete_option('rc_PanEmail');
	delete_option('rc_PanAccount');
	delete_option('rc_PanAccountId');
	delete_option('rc_PanPassword');
	?>
	<script>
		window.location.reload();
	</script>
	<?php
 }
}else{
	$test = $session2->getUrlWithSessionInfo('http://affiliate.yourcloudaround.com/merchants/index.php');
}

?>
<script>
window.addEventListener('message', receiveMessage, false);


function receiveMessage(evt)
{
 
	var _func = evt.data.split('.')[0];
	if(_func == 'height'){
		jQuery('#rc_manage_adv_iframe').css('height',evt.data.split('.')[1]);
	}

}


</script>

<iframe style="width:100%;overflow-y: hidden;overflow-x: hidden;" scrolling="no" id="rc_manage_adv_iframe" src="<?php echo $test ?>"/>
