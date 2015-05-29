<?php?><div>
	<div class="rc_settings_container">
		<h style='font-weight:bold;font-size: 16px;'>Integration settings</h>
		<p>Signup settings options - enables automatic registration of new visitors to your site as affiliates in the RoundCloud network.</br>Click-tracking options - enables tracking visits to any page of your site</br>Contact Form 7 tracking options – enables tracking of registrations (or other) people using the popular plugin "CONTACT FORM 7"</br>WooCommerce (Sell-tracking) options – enables sales tracking on a user site, where the popular ecommerce plugin «WooCommerce» installed.</p>
	</div>
	<div class="rc_settings_container">
		<input type="checkbox" id="rc_integration_autoregister_as_affiliate_checkbox" value=""/>
		<h style='font-weight:bold;font-size: 16px;'>Singup settings options</h>
		<p>These options will apply when a new affiliate is automatically created with RoundCloud</p>
		<p>Default Parent Affiliate (should be "resolved by cookie" by default)<p>		
	</div>
	<div class="rc_settings_container">
		<input type="checkbox" id="rc_integration_clicktracking_checkbox" value=""/>
		<h style='font-weight:bold;font-size: 16px;'>Click tracking options</h>
		<p>Use click tracking integration (if checked, RoundCloud tracking code will be inserted to every Wordpress page)</p>
	</div>
	<div class="rc_settings_container">
		<input type="checkbox" id="rc_integration_contact_form_checkbox" value=""/>
		<h style='font-weight:bold;font-size: 16px;'>Contact Form 7 tracking options</h>
		<p>Here you can set up commission which will be registered in RoundCloud after someone fill contact form and send it</p>
		<table>
			<tbody>
				<tr>
					<td style="text-align: right;">
						<p>Choose one of Contact form 7 forms collection:</p>
					</td>
					<td>
						<select style="margin-left: 10px;" id="rc_contact_form_collection" name="rc_contact_form_collection" value=""></select>
					</td>
				</tr>
				<tr>
					<td style="text-align: right;">
						<p>Amount of commissions. $:</p>
					</td>
					<td>
						<input style="margin-left: 10px;" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="rc_contact_form_commission"/>
					</td>
				</tr>
				<tr>
					<td style="text-align: right;">
						<p>Register commission to specified campaign:</p>
					</td>
					<td>
						<select style="margin-left: 10px;" id="rc_contact_form_commission_to_spec_campaign" name="rc_contact_form_commission_to_spec_campaign" value="">
						
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="rc_settings_container">
		<input type="checkbox" value=""/>
		<h style='font-weight:bold;font-size: 16px;'>WooCommerce options</h>
		<p>This integration is for WordPress module called WooCommerce - integrates orders done in the shopping cart.</p>
	</div>
	<div style="width:100%;text-align:center;padding-top: 20px;">
		<a href="javascript:rc_save_integration_options()"  class="ecwid_admin_btn">Save options</a>
	</div>
</div>
<script>
	rc_get_contact_form_seven_forms('<?php echo get_option('rc_contact_seven_form_name');?>');
	rc_get_contact_form_seven_campaigns('<?php echo get_option('rc_contact_seven_company');?>');
	document.getElementById("rc_integration_clicktracking_checkbox").checked = <?php echo get_option('rc_clicktracking');?>;
	document.getElementById("rc_integration_autoregister_as_affiliate_checkbox").checked = <?php echo get_option('rc_autoregister');?>;
	document.getElementById("rc_integration_contact_form_checkbox").checked = <?php echo get_option('rc_form_seven');?>;
	jQuery('#rc_contact_form_commission').val('<?php echo get_option('rc_contact_seven_commissions');?>');
</script>