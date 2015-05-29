<?php
	$pan_email = get_option('rc_PanEmail');
	$panAccountId = get_option('rc_PanAccountId');

?>
<div style="padding-top: 10px;"><h style="font-weight:bold;">Advertiser email (username):</h></div>
<input type="text" style="width: 300px;" value="<?php echo $pan_email ?>" id="Savereg_email" disabled></input>
<div style="padding-top: 10px;"><h style="font-weight:bold;">User Id</h></div>
<input type="text" style="width: 300px;" value="<?php echo $panAccountId ?>" id="Savereg_login" disabled></input>

<div class="ecwid_admin_text_container">
		<h id="suc_reg_text">Click on the tab "Integration" for tracking scripts and "Affiliate signup" functions settings.</br> 
Click on the tab "Manage Adv"  to manage all the functions of an advertiser on the system RoundCloud Affiliate Network. </h>
</div>
<div style="  padding-top: 10px;">
					<a href="javascript:rc_logout()"  class="ecwid_admin_btn">Logout</a>
				</div>
