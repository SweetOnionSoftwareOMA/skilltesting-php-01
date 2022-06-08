<?php
	$app_name = ucwords(str_replace('_', ' ', $this->config->item('app_name')));?>
<!DOCTYPE html>
<html>
<body style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';margin:0;padding:0;text-align:left;">
    <div style="background:#fff">
        <div style="max-width:100%;margin:0px auto;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%;background-color:#fff;">
                <tbody>
                    <tr>
                        <td>
                            <div style="max-width:100%;box-sizing:border-box;background:#161616">
                                <div style="width:100%;max-width:575px;min-width:300px;margin:auto;text-align:center;padding:15px">
                                    <img src="<?php echo base_url();?>assets/img/mtm-logo-dark.png" style="height:60px;">
                                </div>
                                <div style="width:100%;max-width:575px;min-width:300px;background:#fff;margin:auto;box-sizing:border-box;border-radius:4px;border-bottom-left-radius:0;border-bottom-right-radius:0;padding:50px 30px 10px;">
                                    <h1 style="box-sizing:border-box;color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;">Hi,</h1>
                                    <p style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;">Below is the detail of the entry for <strong style="color:rgb(0, 66, 170);font-size:24px;"><?php echo $form_data['office_name'];?></strong>.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="width:100%;max-width:575px;min-width:300px;margin-left:auto;margin-right:auto;box-sizing:border-box;border-radius:4px;border-top-left-radius:0;border-top-right-radius:0;padding:10px 30px 50px;box-shadow:5px 5px 5px #dadada;">
	            				<table align="center" border="1" cellpadding="5" cellspacing="0" style="width:100%;max-width:515px;min-width:300px;background-color:#fff;border-collapse:collapse;margin:0px 0px 20px;">
	            					<tr>
	            						<td colspan="2" style="background-color:#CCCCCC;"><h2 style="font-size:16px;font-weight:bold;margin:0px;padding:0px 0px;text-align:center;">Reporter Information</h2></td>
	            					</tr>
<?php
	            						$reporting_week = '';
										if (isset($form_data['reporting_week'])){
											$date = new DateTime($form_data['reporting_week']);
											$reporting_week = $date->format("Y-W");
											$reporting_week_date = $date->format("M d, Y");
										}?>
	            					<tr>
	            						<td width="75%"><h3 style="font-size:16px;font-weight:bold;margin:0;text-align:right;">Reporting Week</h3></td>
	            						<td width="25%" align="left"><?php echo $reporting_week_date.'<br>'.$reporting_week;?></td>
	            					</tr>
	            				</table>
	            				<table align="center" border="1" cellpadding="5" cellspacing="0" style="width:100%;max-width:515px;min-width:300px;background-color:#fff;border-collapse:collapse;margin:0px 0px 20px;">
	            					<tr>
	            						<td colspan="2" style="background-color:#CCCCCC;"><h2 style="font-size:16px;font-weight:bold;margin:0px;padding:0px 0px;text-align:center;">Sales Data</h2></td>
	            					</tr>
	            					<tr>
	            						<td width="75%"><h3 style="font-size:16px;font-weight:bold;margin:0;text-align:right;">Total Weekly Sales (this location)</h3></td>
	            						<td width="25%" align="left"><?php echo $form_data['location_gross_sales'];?></td>
	            					</tr>
	            					<tr>
	            						<td style="background-color:#ECECEC;"><h3 style="font-size:16px;font-weight:bold;margin:0;text-align:right;">Second Pair Offerings</h3></td>
	            						<td style="background-color:#ECECEC;" align="left"><?php echo $form_data['secondpair_eligible'];?></td>
	            					</tr>
	            					<tr>
	            						<td><h3 style="font-size:16px;font-weight:bold;margin:0;text-align:right;">Second Pairs Sold</h3></td>
	            						<td align="left"><?php echo $form_data['secondpair_accepted'];?></td>
	            					</tr>
	            					<tr>
	            						<td style="background-color:#ECECEC;"><h3 style="font-size:16px;font-weight:bold;margin:0;text-align:right;">Second Pair Conversion</h3></td>
	            						<td style="background-color:#ECECEC;" align="right"><?php echo number_format($form_data['secondpair_conversion_rate'], 2);?>%</td>
	            					</tr>
	            				</table>
                                <p style="box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;">Thanks,<br><br><?php echo $app_name;?> Team</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="max-width:100%;margin:0px auto;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                    <tr>
                        <td>
                            <div style="width:100%;max-width:575px;min-width:300px;margin:auto;box-sizing:border-box;padding-top:20px;padding-bottom:20px;padding-left:15px;padding-right:15px;">
                                <p style="margin-bottom:0px;text-align:center;font-family:verdana;"><a href="<?php echo base_url();?>" style="text-align:center;font-size:13px;line-height:1.5;color:#999999;text-decoration:none;color:cornflowerblue;align-items:center;justify-content:center;"><img src="<?php echo base_url();?>assets/img/mtm-logo.png" style="height:50px"></a></p>
                                <p style="margin-top:0px;text-align:center;font-family:verdana;font-size:12px;color:#CCC;">Copyright &copy; <?php echo date('Y').'<br>'.$app_name;?></p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
