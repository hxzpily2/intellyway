<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>


<!-- DOJO INCLUDE -->
<script type='text/javascript' src='/account/js/dojo/dojo.js' djConfig='parseOnLoad: false'></script>
<script type='text/javascript'>
	
	dojo.require('dojo.parser');
	
	dojo.registerModulePath('account', '../account');
	dojo.require('account.integration.Commun');
	var commun = new account.integration.Commun();
</script>
<!-- END DOJO INCLUDE -->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<style type="text/css">
html, body { height: 100%; width: 100%; padding: 0; border: 0; }
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>La Poste Comores : Consultation des Comptes</title>
</head>
<body>
<html:form styleId="loginForm" action="/authentication/j_acegi_security_check.do"
	method="post">
	<input type="hidden" name="reqCode" value="login" />
	
<table width="100%" height="79">
	<tr>
		<td width="50%">&nbsp;</td>
		<td width="1000">
		<img src="/account/image/header.jpg"/>
		</td>
		<td width="50%">&nbsp;</td>
	</tr>
</table>

<table width="100%">
	<tr>
		<td width="50%"></td>
		<td width="860">
		<table width="100%" height="79">
			<tr>
				<td style="color: #7dc327;" width="860" align="center">
					<span style="font-weight: bold;font-family: tahoma;font-size: 12pt;">Bienvenue sur la poste comores</span>
				</td>		
			</tr>
		</table>
		<table width="800">
			<tr>
				<td width="300">
				<!-- SAISIR LOGIN -->
				<table width="380" cellspacing="0" cellpadding="0">
					<tr height="61">
						<td width="21" height="61" background="/account/image/ltop.jpg">

						</td>
						<td valign="top" width="43" height="61"
							background="/account/image/top_vide.jpg"><img
							src="/account/image/01.gif"></td>
						<td width="34" height="61" background="/account/image/top.jpg">
						<table width="300">
							<tr>
								<td width="300" background="/account/image/more.gif">&nbsp;</td>
							</tr>
							<tr>
								<td width="300" valign="top"><span
									style="color: #b0b0b0; font-family: tahoma; font-size: 10pt;">Saisissez
								votre Identifiant</span></td>
							</tr>
						</table>
						</td>
						<td width="20" height="61" background="/account/image/rtop.jpg">

						</td>
					</tr>
					<tr>
						<td width="21" height="61" background="/account/image/left.jpg">
							
						</td>
						<td colspan="2" width="250" height="61" style="background-image:url(/account/image/centre.jpg);background-repeat:repeat-x;background-position: top;padding-left: 45px;">
							<input style="border-style: solid;border-color: #b5b5b5;border-width: 1px;" id="j_username" type="text" maxlength="20" size="30" name="j_username" tabindex="1" />
							<br/>
							<SPAN style="color: red;font-family: tahoma;font-size: 10pt;"><html:errors/></SPAN>
							
						</td>
						<td width="20" height="61" background="/account/image/right.jpg">

						</td>
					</tr>
					<tr>
						<td width="21" height="20" background="/account/image/lbotom.jpg">

						</td>
						<td width="34" height="20" background="/account/image/botom.jpg">

						</td>
						<td width="34" height="20" background="/account/image/botom.jpg">

						</td>
						<td width="20" height="20" background="/account/image/rbotom.jpg">

						</td>
					</tr>
				</table>
				<!-- FIN SAISIR LOGIN --> <!-- SAISIR PASS -->
				<table width="380" cellspacing="0" cellpadding="0">
					<tr height="61">
						<td width="21" height="61" background="/account/image/ltop.jpg">

						</td>
						<td valign="top" width="43" height="61"
							background="/account/image/top_vide.jpg"><img
							src="/account/image/02.gif"></td>
						<td width="34" height="61" background="/account/image/top.jpg">
						<table width="300">
							<tr>
								<td width="300" background="/account/image/more.gif">&nbsp;</td>
							</tr>
							<tr>
								<td width="300" valign="top"><span
									style="color: #b0b0b0; font-family: tahoma; font-size: 10pt;">composer
								les six chiffres de votre Code secret</span></td>
							</tr>
						</table>
						</td>
						<td width="20" height="61" background="/account/image/rtop.jpg">

						</td>
					</tr>
					<tr>
						<td width="21" height="61" background="/account/image/left.jpg">

						</td>
						<td colspan="2" width="300" height="61" style="background-image:url(/account/image/centre.jpg);background-repeat:repeat-x;background-position: top;">
						<table width="250">
							<tr>
								<td width="129"><logic:present name="grilleImage">
									<img width="129" height="129" BORDER="0"
										src="/account/cache/<bean:write name="grilleImage" property="url"/>.PNG"
										usemap="#securitygrille" />
									<map name="securitygrille">
										<area shape="rect" coords="0,0,26,26" href="javascript:commun.writePWD(1)" />
										<area shape="rect" coords="26,0,52,26" href="javascript:commun.writePWD(2)" />										
										<area shape="rect" coords="52,0,78,26" href="javascript:commun.writePWD(3)" />
										<area shape="rect" coords="78,0,104,26" href="javascript:commun.writePWD(4)" />
										<area shape="rect" coords="104,0,130,26" href="javascript:commun.writePWD(5)" />
										
										<area shape="rect" coords="0,26,26,52" href="javascript:commun.writePWD(6)" />
										<area shape="rect" coords="26,26,52,52" href="javascript:commun.writePWD(7)" />										
										<area shape="rect" coords="52,26,78,52" href="javascript:commun.writePWD(8)" />
										<area shape="rect" coords="78,26,104,52" href="javascript:commun.writePWD(9)" />
										<area shape="rect" coords="104,26,130,52" href="javascript:commun.writePWD(10)" />
										
										<area shape="rect" coords="0,52,26,78" href="javascript:commun.writePWD(11)" />
										<area shape="rect" coords="26,52,52,78" href="javascript:commun.writePWD(12)" />										
										<area shape="rect" coords="52,52,78,78" href="javascript:commun.writePWD(13)" />
										<area shape="rect" coords="78,52,104,78" href="javascript:commun.writePWD(14)" />
										<area shape="rect" coords="104,52,130,78" href="javascript:commun.writePWD(15)" />
										
										<area shape="rect" coords="0,78,26,104" href="javascript:commun.writePWD(16)" />
										<area shape="rect" coords="26,78,52,104" href="javascript:commun.writePWD(17)" />										
										<area shape="rect" coords="52,78,78,104" href="javascript:commun.writePWD(18)" />
										<area shape="rect" coords="78,78,104,104" href="javascript:commun.writePWD(19)" />
										<area shape="rect" coords="104,78,130,104" href="javascript:commun.writePWD(20)" />
										
										<area shape="rect" coords="0,104,26,130" href="javascript:commun.writePWD(21)" />
										<area shape="rect" coords="26,104,52,130" href="javascript:commun.writePWD(22)" />										
										<area shape="rect" coords="52,104,78,130" href="javascript:commun.writePWD(23)" />
										<area shape="rect" coords="78,104,104,130" href="javascript:commun.writePWD(24)" />
										<area shape="rect" coords="104,104,130,130" href="javascript:commun.writePWD(25)" />
									</map>
								</logic:present></td>
								<td width="20"></td>
								<td width="100" valign="top" align="left">
								<table align="left" width="100%">
									<tr>
										<td></td>
										<td style="color: #8c8c8c;"><span
											style="font-family: tahoma; font-size: 10pt; font-weight: bold;">Code
										secret</span></td>
									</tr>
									<tr>
										<td></td>
										<td>
										<input style="border-style: solid;border-color: #b5b5b5;border-width: 1px;" size="5" id="password" type="password" disabled="disabled" maxlength="5" value="" name="password"/>
										<input style="border-style: solid;border-color: #b5b5b5;border-width: 1px;" size="5" id="j_password" type="hidden" maxlength="5" value="" name="j_password"/>
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
									</tr>
									<tr height="24">
										<td colspan="2" width="81">
										<table width="81" height="24">
											<tr height="28"><td width="81" background="/account/image/button_corr.jpg" align="center" valign="middle" style="color: #747474;"><span
											style="font-family: tahoma; font-size: 8pt; font-weight: bold;cursor: pointer;" onclick="javascript:commun.corPWD()">Corriger</span></td></tr>
										</table>
										</td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						</td>
						<td width="20" height="61" background="/account/image/right.jpg">

						</td>
					</tr>
					<tr>
						<td width="21" height="20" background="/account/image/lbotom.jpg">

						</td>
						<td width="34" height="20" background="/account/image/botom.jpg">

						</td>
						<td width="34" height="20" background="/account/image/botom.jpg">

						</td>
						<td width="20" height="20" background="/account/image/rbotom.jpg">

						</td>
					</tr>
				</table>
				<table width="380" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center" valign="middle">
							<table width="252" height="28">
								<tr>
									<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><span
											style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;" onclick="javascript:document.getElementById('loginForm').submit()">VALIDER</span></td>
									<td width="10"></td>
									<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><span
											style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;">ANNULER</span></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<!-- FIN SAISIR PASS --></td>
				<td width="30">&nbsp;</td>
				<td width="500" valign="top" style="padding-top: 6px;">
					<table cellpadding="0" cellspacing="0" width="500">
						<tr>
							<td width="20" height="20" background="/account/image/notice_ltop.jpg">&nbsp;</td>
							<td width="460" background="/account/image/notice_top.jpg">&nbsp;</td>
							<td width="20" height="20" background="/account/image/notice_rtop.jpg">&nbsp;</td>
						</tr>
						<tr>
							<td width="20" height="20" background="/account/image/notice_left.jpg">&nbsp;</td>
							<td width="460">							
								<table cellpadding="0" cellspacing="0">
									<tr>
										<td width="59">
											<img src="/account/image/notice.gif"/>				
										</td>
										<td width="10">&nbsp;</td>
										<td valign="middle" align="left" style="color: #73bc25;"><span
											style="font-family: tahoma; font-size: 10pt; font-weight: bold;">Espace Sécurisé</span></td>
									</tr>
									<tr height="10">
										<td colspan="3"></td>										
									</tr>
									<tr height="10">
										<td colspan="3">
											<table width="460" height="10" cellpadding="0" cellspacing="0">
												<tr height="10">
													<td width="9"><img src="/account/image/point.jpg"/></td>
													<td width="10">&nbsp;</td>
													<td align="left" valign="middle" style="color: #6d6d6d;"><span
									style="font-family: tahoma; font-size: 10pt;">Démo</span></td>
												</tr>
											</table>
															
										</td>										
									</tr>
									<tr height="10">
										<td colspan="3">
											<table width="460" cellpadding="0" cellspacing="0">
												<tr>
													<td width="9"><img src="/account/image/point.jpg"/></td>
													<td width="10">&nbsp;</td>
													<td align="left" valign="middle" style="color: #6d6d6d;"><span
									style="font-family: tahoma; font-size: 10pt;">Aide à la connexion</span></td>
												</tr>
											</table>
															
										</td>										
									</tr>
									<tr height="10">
										<td colspan="3">
											<table width="460" cellpadding="0" cellspacing="0">
												<tr>
													<td width="9"><img src="/account/image/point.jpg"/></td>
													<td width="10">&nbsp;</td>
													<td align="left" valign="middle" style="color: #6d6d6d;"><span
									style="font-family: tahoma; font-size: 10pt;">Sécurité sur internet</span></td>
												</tr>
											</table>
															
										</td>										
									</tr>									
								</table>
							</td>
							<td width="20" height="20" background="/account/image/notice_right.jpg">&nbsp;</td>
						</tr>
						<tr>
							<td width="20" height="20" background="/account/image/notice_lbotom.jpg">&nbsp;</td>
							<td width="460" background="/account/image/notice_botom.jpg">&nbsp;</td>
							<td width="20" height="20" background="/account/image/notice_rbotom.jpg">&nbsp;</td>
						</tr>
					</table>
					<!-- ADDED -->
					<div style="padding-left: 10px;width: 460px;">
						<center><img height="200" src="/account/image/batimentSNPSF.jpg"/></center>
					</div>			
					<!-- FIN ADDED -->
				</td>
			</tr>
		</table>

		</td>
		<td width="50%"></td>
	</tr>
</table>
</html:form>
</body>
</html>