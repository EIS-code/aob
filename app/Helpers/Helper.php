<?php

function sp_encryption($string){
	$ciphering='AES-128-CTR';
	$option=0;
	$enc_iv='1234567891011121';
	$enc_key='SkyPearl iNfotech';
	return openssl_encrypt($string, $ciphering,$enc_key,$option,$enc_iv);
}

function sp_decryption($string){
	$ciphering='AES-128-CTR';
	$option=0;
	$enc_iv='1234567891011121';
	$enc_key='SkyPearl iNfotech';
	return openssl_decrypt($string, $ciphering,$enc_key,$option,$enc_iv);
}

function send_skypearl_email($config,$to_email,$msg,$subject,$member,$logid){
	$message = '';
	$headers = "From: ".strip_tags($config['from_name'])." <".strip_tags($config['replay_email']).">\r\n";
	// $headers = "From: " . strip_tags($config['from_name']) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($config['replay_email']) . "\r\n";
	$headers .= "X-Mailer: SkyPearl \r\n";
	// $headers .= "CC: susan@example.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	//Add Header
		$message .= '<style type="text/css">
		  .top-image{
		    width: 50px !important;
		  }
		  @media only screen and (max-width: 600px) {
		    .main {
		      width: 320px !important;
		    }

		    .top-image {
		      width: 50px !important;
		    }
		    .inside-footer {
		      width: 320px !important;
		    }
		    table[class="contenttable"] { 
		            width: 320px !important;
		            text-align: left !important;
		        }
		        td[class="force-col"] {
		          display: block !important;
		      }
		       td[class="rm-col"] {
		          display: none !important;
		      }
		    .mt {
		      margin-top: 15px !important;
		    }
		    *[class].width300 {width: 255px !important;}
		    *[class].block {display:block !important;}
		    *[class].blockcol {display:none !important;}
		    .emailButton{
		            width: 100% !important;
		        }

		        .emailButton a {
		            display:block !important;
		            font-size:18px !important;
		        }

		  }
		</style>

		<body link="#ed3237" vlink="#ed3237" alink="#ed3237">

		<table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		    <tr>
		      <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
		        <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
			        <tr style="display:none;">
				        <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #ed3237">
				          	<img class="top-image" src="https://www.skypearlinfotech.com/marketing/openemail?log='.$logid.'" style="line-height: 1;" alt="SkyPearl iNfotech"> 
				        </td>
				    </tr>';
				// if($member==0){
				    $message.='
				    <tr>
				        <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #ed3237">
				          <a href="https://skypearlinfotech.com/"><img class="top-image" src="https://skypearlinfotech.com/images/logo.png" style="line-height: 1;width:50px;" alt="SkyPearl iNfotech"></a> 
				        </td>
				    </tr>';
				// }
			    $message.='
			      <tr>
			        <td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">';

				$message .= $msg;

				//Add Footer
				$message .= '</td>
				          </tr>';
				// if($member==0){

				$message .= '<tr bgcolor="#fff" style="border-top: 4px solid #ed3237;">
					            <td valign="top" class="footer" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background: #fff;text-align: center;">
					              <table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					                <tr>
					                  <td class="inside-footer" align="center" valign="middle" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 12px;line-height: 16px;vertical-align: middle;text-align: center;width: 580px;">
					                    <div id="address" class="mktEditable">
					                      <b>SkyPearl iNfotech</b><br>7021 Columbia Gateway Drive<br>  Suite 500 <br> Columbia, MD 21046<br>
					                      <a style="color: #ed3237;" href="https://skypearlinfotech.com/">Contact Us</a>
					                    </div>
					                  </td>
					                </tr>
					              </table>
					            </td>
					          </tr>';
				// }
				$message .= '</table>
					      </td>
					    </tr>
					  </table>
					  </body>'; 
				

mail($to_email, $subject, $message, $headers);
return true;
}
?>
