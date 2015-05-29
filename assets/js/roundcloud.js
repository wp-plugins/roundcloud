
jQuery(document).ready(function(){
	rc_resize_iframe();
	get_option('rc_PanAccountId',function(output){
	rc_PanAccountId =output;
	});
	jQuery('#rc_login_container').hide();
	getCountryList();
	
});

window.onload = function(){
	


}

function rc_register_new_user(){
	jQuery('#rc_login_container').hide();
	jQuery('#rc_register_container').show();
}
function rc_login_user(){
	jQuery('#rc_login_container').show();
	jQuery('#rc_register_container').hide();
}


function rc_resize_iframe(){

	jQuery('#rc_manage_adv_iframe').height(jQuery('#wpwrap').height());
	
}

var rc_PanAccountId;

//validate registration data
function validate() {
	var data = Object();
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  
	if(reg.test(jQuery('#Savereg_email').val()) == true) {
		data['email']=true;
	}else{
		data['email']=false;
	}
	if(jQuery('#Savereg_login').val() !== '') {
		data['login']=true;
	}else{
		data['login']=false;
	}
	
	if(jQuery('#Savereg_country').val() !== '') {
		data['country']=true;
	}else{
		data['coutry']=false;
	}
	
	if(jQuery('#Savereg_password').val() !== '') {
		data['password']=true;
	}else{
		data['password']=false;
	}
	if(jQuery('#Repeat_Savereg_password').val() !== '') {
		data['repeat_password']=true;
	}else{
		data['repeat_password']=false;
	}
	
	var result=jQuery('#Savereg_chbox').prop('checked');
		data['checkbox']=result;
	if(!data['password'] || !data['repeat_password'] || !data['email'] || !data['login'] || !data['country']){
		return "Fill all fields";
	}
	if(jQuery('#Repeat_Savereg_password').val() !== jQuery('#Savereg_password').val()){
		
		return "Wrong password";
	}
	if(!data['checkbox']){
		return "You need to confirm agreement.";
	}else{
		return "ok";
	}
}


function showProgressBar(){
	jQuery('.admin_progressbar').show();
}
function hideProgressBar(){
	jQuery('.admin_progressbar').hide();
}

//function show message
function showToast(message,reload){
	
	if(reload){
		jQuery('.Toast').text(message).fadeIn(400).delay(3000).fadeOut(400,function(){location.reload();}); 
	}else{
		jQuery('.Toast').text(message).fadeIn(400).delay(3000).fadeOut(400); 
	}
	
}

function rc_logout(){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'rc_logout'
			
        },
        type: 'GET',
		success:function(response){
			location.reload();
		}
    });
	
}

//set_option function wordpress
function set_option(name,val){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'set_option',
			option_name:name,
			option_value:val
        },
        type: 'GET',
		success:function(response){
			
		}
    });
}

//get_option function wordpress
function get_option(name,callback){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'get_option',
			option_name:name
        },
        type: 'GET',
		success:function(response){
			callback(response);
		}
    });
}

//update_option function wordpress
function update_option(name,val,reload){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'update_option',
			option_name:name,
			option_value:val
        },
        type: 'GET',
		success:function(response){
			if(reload){
				location.reload();
			}
		}
    });
}

//returns list of forms from contact form 7
function rc_get_contact_form_seven_forms(selected){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'get_Contact_Form_Forms'
		
        },
        type: 'GET',
		success:function(response){

	var data = JSON.parse(response);

			jQuery(data).each(function(){
				jQuery('#rc_contact_form_collection').append("<option val='"+this+"'>"+this+"</option>");
		
			});
		
			
			jQuery("select#rc_contact_form_collection option").each(function() { this.selected = (this.text == selected); });
		}
    });
}

//return list of campaigns for contact form 7
function rc_get_contact_form_seven_campaigns(selected){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'get_RoundCloud_campaigns'
        },
        type: 'GET',
		success:function(response){
		
			var data = JSON.parse(response.slice(0,-1));
	
			jQuery(data.data).each(function(){
		
				jQuery('#rc_contact_form_commission_to_spec_campaign').append("<option val='"+this.company_name+"' company_id='"+this.company_id+"'>"+this.company_name+"</option>");
				
			});
	
			jQuery("select#rc_contact_form_commission_to_spec_campaign option").each(function() { this.selected = (this.text == selected); });
		}
    });
}

var DMap = {0: 0, 1: 1, 2: 2, 3: 3, 4: 4, 5: 5, 6: 6, 7: 7, 8: 8, 9: 9, 10: 10, 11: 11, 12: 12, 13: 13, 14: 14, 15: 15, 16: 16, 17: 17, 18: 18, 19: 19, 20: 20, 21: 21, 22: 22, 23: 23, 24: 24, 25: 25, 26: 26, 27: 27, 28: 28, 29: 29, 30: 30, 31: 31, 32: 32, 33: 33, 34: 34, 35: 35, 36: 36, 37: 37, 38: 38, 39: 39, 40: 40, 41: 41, 42: 42, 43: 43, 44: 44, 45: 45, 46: 46, 47: 47, 48: 48, 49: 49, 50: 50, 51: 51, 52: 52, 53: 53, 54: 54, 55: 55, 56: 56, 57: 57, 58: 58, 59: 59, 60: 60, 61: 61, 62: 62, 63: 63, 64: 64, 65: 65, 66: 66, 67: 67, 68: 68, 69: 69, 70: 70, 71: 71, 72: 72, 73: 73, 74: 74, 75: 75, 76: 76, 77: 77, 78: 78, 79: 79, 80: 80, 81: 81, 82: 82, 83: 83, 84: 84, 85: 85, 86: 86, 87: 87, 88: 88, 89: 89, 90: 90, 91: 91, 92: 92, 93: 93, 94: 94, 95: 95, 96: 96, 97: 97, 98: 98, 99: 99, 100: 100, 101: 101, 102: 102, 103: 103, 104: 104, 105: 105, 106: 106, 107: 107, 108: 108, 109: 109, 110: 110, 111: 111, 112: 112, 113: 113, 114: 114, 115: 115, 116: 116, 117: 117, 118: 118, 119: 119, 120: 120, 121: 121, 122: 122, 123: 123, 124: 124, 125: 125, 126: 126, 127: 127, 1027: 129, 8225: 135, 1046: 198, 8222: 132, 1047: 199, 1168: 165, 1048: 200, 1113: 154, 1049: 201, 1045: 197, 1050: 202, 1028: 170, 160: 160, 1040: 192, 1051: 203, 164: 164, 166: 166, 167: 167, 169: 169, 171: 171, 172: 172, 173: 173, 174: 174, 1053: 205, 176: 176, 177: 177, 1114: 156, 181: 181, 182: 182, 183: 183, 8221: 148, 187: 187, 1029: 189, 1056: 208, 1057: 209, 1058: 210, 8364: 136, 1112: 188, 1115: 158, 1059: 211, 1060: 212, 1030: 178, 1061: 213, 1062: 214, 1063: 215, 1116: 157, 1064: 216, 1065: 217, 1031: 175, 1066: 218, 1067: 219, 1068: 220, 1069: 221, 1070: 222, 1032: 163, 8226: 149, 1071: 223, 1072: 224, 8482: 153, 1073: 225, 8240: 137, 1118: 162, 1074: 226, 1110: 179, 8230: 133, 1075: 227, 1033: 138, 1076: 228, 1077: 229, 8211: 150, 1078: 230, 1119: 159, 1079: 231, 1042: 194, 1080: 232, 1034: 140, 1025: 168, 1081: 233, 1082: 234, 8212: 151, 1083: 235, 1169: 180, 1084: 236, 1052: 204, 1085: 237, 1035: 142, 1086: 238, 1087: 239, 1088: 240, 1089: 241, 1090: 242, 1036: 141, 1041: 193, 1091: 243, 1092: 244, 8224: 134, 1093: 245, 8470: 185, 1094: 246, 1054: 206, 1095: 247, 1096: 248, 8249: 139, 1097: 249, 1098: 250, 1044: 196, 1099: 251, 1111: 191, 1055: 207, 1100: 252, 1038: 161, 8220: 147, 1101: 253, 8250: 155, 1102: 254, 8216: 145, 1103: 255, 1043: 195, 1105: 184, 1039: 143, 1026: 128, 1106: 144, 8218: 130, 1107: 131, 8217: 146, 1108: 186, 1109: 190}

function UnicodeToWin1251(s) {
    var L = []
    for (var i=0; i<s.length; i++) {
        var ord = s.charCodeAt(i)
        if (!(ord in DMap))
            throw "Character "+s.charAt(i)+" isn't supported by win1251!"
        L.push(String.fromCharCode(DMap[ord]))
    }
    return L.join('')
}

function rc_get_autoreg_affiliates(){
	
	 jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'get_RoundCloud_Top_Affiliates'
		
        },
        type: 'GET',
		success:function(response){
		
		if(response!=='0'){
			var data = JSON.parse(response.slice(0,-1));
			jQuery(data.data).each(function(){
		
				jQuery('#rc_singup_settings').append("<option val='"+this.affiliate_name+"' company_id='"+this.userid+"'>"+this.affiliate_name+"</option>");
				
			});
		}
		}
    });
}



//save rc integration options
function rc_save_integration_options(){
	
	
	update_option('rc_clicktracking',jQuery('#rc_integration_clicktracking_checkbox').prop('checked'));
	update_option('rc_woocommerce',jQuery("#rc_woocommerce").prop('checked'));
	
	update_option('rc_form_seven',jQuery('#rc_integration_contact_form_checkbox').prop('checked'));
	update_option('rc_contact_seven_form_name',jQuery("#rc_contact_form_collection").val());
	update_option('rc_contact_seven_company',jQuery("#rc_contact_form_commission_to_spec_campaign").val());
	update_option('rc_show_banner',jQuery('#rc_integration_show_banner').prop('checked'));
	
	
	var company_id='';
	jQuery("select#rc_contact_form_commission_to_spec_campaign option").each(function() { 
			if(jQuery(this).html() == jQuery("#rc_contact_form_commission_to_spec_campaign").val()){

				company_id=jQuery(this).attr('company_id');
			}
	});
	update_option('rc_contact_seven_company_id',company_id);
	update_option('rc_contact_seven_commissions',	jQuery.trim(document.getElementById("rc_contact_form_commission").value));
		update_option('rc_autoregister',jQuery('#rc_integration_autoregister_as_affiliate_checkbox').prop('checked'),true);
}


function PaNLogin(){ 
	var data = Object();
	data['QueryType']='PaNlogin';
	data['email'] = jQuery('#rc_login_username').val();
	data['pass'] = jQuery('#rc_login_password').val();
	data['userRole']='merchant';
	showProgressBar();
	jQuery.ajax({
	
          url: '../wp-content/plugins/roundcloud/includes/roundcloudapi.php',
            data: data,
            dataType: 'json',
            type: 'POST',
            success: function (response) {
				hideProgressBar();
				if(response.status=="success"){
			
					set_option('rc_PanAccountId',response.account_id);
					set_option('rc_PanEmail',data['email']);
					set_option('rc_PanAccount',response.username);
					set_option('rc_PanPassword',data['pass']);
					showToast("Logined",true);
				}else{
					showToast(response.text);
				}	
			},
				
            error: function (response) {
				console.log(response);
				showToast(response.text);
            }

        });
}
function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function SaleTrack(account_id,total,order_id){ 

/*
	var data = Object();
	data['QueryType']='createSale';
	data['account_id'] =account_id;
	data['total'] =total;
	data['PAPVisitorId'] =readCookie('PAPVisitorId');
	data['order_id']=order_id;
	showProgressBar();
	jQuery.ajax({
	
          url: 'http://affiliate.yourcloudaround.com/scripts/savereg.php',
            data: data,
            dataType: 'json',
            type: 'POST',
            success: function (response) {
			
			},
				
            error: function (response) {
			
            }

        });*/
}

function getCountryList(){ 
	var data = Object();
	data['QueryType']='GetCountries';
	showProgressBar();
	jQuery.ajax({
	
          url: '../wp-content/plugins/roundcloud/includes/roundcloudapi.php',
            data: data,
            dataType: 'json',
            type: 'POST',
            success: function (response) {
				hideProgressBar();
				if(response.status=="success"){
					jQuery(response.data).each(function(){
						jQuery('#Savereg_country').append('<option value="'+this.code+'">'+this.desc+'</option>');
					});
					
				
				}else{
					showToast(response.text);
				}	
			},
				
            error: function (response) {
				console.log(response);
				showToast(response.text);
            }

        });
}


//registration new merchant
function sendRegistrationRequest(){
	var data = Object();
	data['QueryType']='Registration';
	data['Email'] = jQuery('#Savereg_email').val();
	data['AppName'] = 'RC_ECWID_ADV_V1.0';
	data['AccountName'] = jQuery('#Savereg_login').val();
	data['roleType'] = "merchant";
	data['password'] = jQuery('#Savereg_password').val();
	data['lang']='en-US';
	data['country'] = jQuery('#Savereg_country').val();

	if(validate() =="ok"){
	showProgressBar();
	jQuery.ajax({
          url: '../wp-content/plugins/roundcloud/includes/roundcloudapi.php',
            data: data,
            dataType: 'json',
            type: 'POST',
            success: function (response) {
				hideProgressBar();
				if(response.status=="success"){
				
					set_option('rc_PanAccountId',response.accountId);
					set_option('rc_PanEmail',data['Email']);
					set_option('rc_PanAccount',data['AccountName']);
					set_option('rc_PanPassword',data['password']);
					showToast("The user was created",true);
				}else{
					showToast(response.text);
					console.log(response);
				}	
			},
				
            error: function (response) {
			console.log(response);
				hideProgressBar();
                showToast(response);
            }

        });
	}else{
		showToast(validate());
	}

}



