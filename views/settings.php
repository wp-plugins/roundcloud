<?php?>
<script>
 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
 var lang = "<?php echo WPLANG ?>";

 </script>
 <?php
 if( get_option('rc_show_banner') =='true'){
 echo '<div id="banner_peel_R" style="position: absolute; width: 100px; height:100px; z-index: 0; right: 0px; top: 0px; padding-bottom:10px; padding-left: 10px;">
                  <embed style="position:relative;left:-600px;" name="banner_peel_R_sub" id="banner_peel_R_sub" flashvars="bannertype=R&amp;bannerwidth=700&amp;bannerheight=500&amp;img=//affiliate.yourcloudaround.com/accounts/default1/banners/250c432f.png&amp;smallimg=//affiliate.yourcloudaround.com/accounts/default1/banners/250c432f_7.png&amp;link=http%3A%2F%2Fyourcloudaround.com%2Fdownload%2F&amp;scrolltxt=&amp;bigtxt=&amp;bgcolor=0xFFFFFF&amp;textcolor=CC0000&amp;smallperc=14" scale="exactfit" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowscriptaccess="always" wmode="transparent" src="http://affiliate.yourcloudaround.com/include/Pap/Features/PagePeelBanner/EdgeBanner/edgeBanner.swf" height="500" width="700">
                  </div>';
 }

echo "<div style='padding-top:10px;' class='rc_list_desc'>";
echo "<h style='font-weight:bold;font-size: 16px;'>About RoundCloud Affiliate Network"; echo "</h>";
echo "<p >Welcome to the RoundCloud Affiliate network! This plugin will allow you to quickly and easily start using the most advanced advertising technology called \"CPA marketing”.</br>Advertising campaigns that you create in our network, now will become available for promotion for thousands of partners of RoundCloud.</br>Features of the plugin:</br>1. Easy new advertiser registration in the RoundCloud affiliate network</br><ul><li>Is made directly from the page settings, without having to visit any sites</li><li>No user pre-moderation  -  any user can become an advertiser in the affiliate network</li></ul>2. “Affiliate signup\" function</br><ul><li>Enables automatic registration of new visitors to your site as affiliates in the RoundCloud network. Thus, you  can create your own program to attract affiliates with network marketing.</li></ul>3. Automatic integration of event tracking script in the source code for your site with the ability to specify the types of tracked events:</br><ul><li>Click-tracking - tracking visits to any page of your site</li><li>Lead-tracking – tracking of registrations (or other) people using the popular plugin “CONTACT FORM 7”</li><li>Sell-tracking – sales tracking on a user site, where the popular ecommerce plugin «WooCommerce» installed.</li></ul>4. The ability to create and adjust commissions referrals directly from the plugin settings page, without having to go to any site.</br>5. Manage all of the advanced promotion functions in RoundCloud network and view full statistics directly from the plugin settings page, without having to go to any site."; echo "</p>";

echo "<h style='font-weight:bold;font-size: 16px;'>General Settings";echo "</h>";
echo "<p>The advertiser's online registration takes only 1 minute. Immediately after registration you can start creating  your advertising campaigns and materials. In order to start publishing your banners and links, you should add money to your account in the RoundCloud network. You can deposit any amount, at your discretion. Your ads will run until the sum of commissions (including the cost of services the RoundCloud network) does not have exhausted your balance.</br>After the registration you will receive an email to your specified address. Carefully read the enclosed instruction. This will make your first steps to get acquainted with our service.</br>Good luck!";echo "</p>";

if(get_option('rc_PanAccountId')!==false){
	include('admin_registered_values.php');
}else{
	include('admin_unregistered_values.php');
	
}
echo "</div>";
?>

<div class="admin_progressbar"></div>
<div class="Toast"  style='display:none'></div>