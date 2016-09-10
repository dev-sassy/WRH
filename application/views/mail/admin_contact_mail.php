<?php echo '
<table width="700" cellspacing="0" cellpadding="0" border="1">
						<tr>
							<td colspan="2" style="text-align:center;"><img width="150" height="119" src="'.ASSETS_URL.'/images/wrh_logo.png"></td>
						</tr>
						<tr>
							<td colspan="2">
								<table cellspacing="1" cellpadding="4">
									<tr>
										<td colspan="2">Dear '.$inquiry_details['inquiryName'].',</td>
									</tr>
									<tr>
										<td colspan="2">We have received your message and would like to thank you for writing to us.We will get back to you within a few hours.Your provided details are as below,</td>
									</tr>
									<tr><td colspan="2"></td></tr>
									<tr>
										<td width="100"><strong>Name:</strong></td>
										<td>'.$inquiry_details['inquiryName'].'</td>
									</tr>
									<tr><td colspan="2"></td></tr>									      
									<tr>
										 <td><strong>Email:</strong></td>
										 <td>'.$inquiry_details["inquiryEmail"].'</td>
									</tr>
									<tr>
										 <td><strong>Subject:</strong></td>
										 <td>'.$inquiry_details["inquirySubject"].'</td>
									</tr>
									<tr>
										 <td valign="top"><strong>Message:</strong></td>
										 <td>'.$inquiry_details["inquiryMessage"].'</td>
									</tr>
									<tr><td colspan="2"></td></tr>
									
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table cellspacing="1" cellpadding="4">
									<tr><td colspan="2">&copy;'. date('Y').' '.COPYRIGHT_TEXT.'</td></tr>
								</table>
							</td>
						</tr>
					</table>';?>