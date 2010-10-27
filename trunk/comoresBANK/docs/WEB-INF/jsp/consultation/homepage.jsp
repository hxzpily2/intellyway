<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>
<jsp:include page="../template/header.jsp"/>
		<table width="100%" height="79">
			<tr>
				<td style="color: #7dc327;" width="860" align="center">
					<span style="font-weight: bold;font-family: tahoma;font-size: 12pt;">Bienvenue sur la Banque Postale des Comores SNPSF</span>
				</td>		
			</tr>
		</table>
		<table width="800">
			<tr>
				<td width="800">
					<authz:authorize ifAllGranted="ROLE_USER">
						<table width="100%">
							<logic:present name="userConnected">
								<tr>
									<td width="700" valign="top"><span style="font-family: tahoma;font-size: 12pt;">Bienvenue <b><bean:write name="userConnected" property="nom"/> <bean:write name="userConnected" property="prenom"/></b></span></td>
									<td width="150" align="left" valign="top"><a href="javascript:commun.showDialogPassUpdate();">Modifier mot de passe</a></td>
									<td align="right" valign="top"><a href="/account/authentication/Login.do?reqCode=logout">Déconnexion</a></td>
								</tr>
								<tr>
									<td width="100%" colspan="2"></td>								
								</tr>
							</logic:present>
							<logic:present name="listeComptes">
								<tr>
									<td width="700" style="font-family: tahoma;font-size: 12pt;">Vous êtes titulaire des comptes : </td>
									<td colspan="2" align="right"></td>
								</tr>
								<tr>
									<td width="100%" colspan="3"></td>								
								</tr>
								<logic:iterate indexId="indexData" name="listeComptes" id="unCompte">
									<tr>
										<td align="left" width="100%" colspan="2"><img src="/account/image/point.jpg">&nbsp;<a href="javascript:commun.sortOrPaginate('/account/application/Home.do?reqCode=compte&id=<bean:write name="indexData"/>')" style="color: #7dc327;text-decoration: none;"><bean:write name="unCompte" property="idCompte"/> de solde <bean:write name="unCompte" property="solde" format="###.##"/> FC <logic:present name="unCompte" property="descriptif">( <bean:write name="unCompte" property="descriptif"/> )</logic:present></a></td>								
									</tr>
								</logic:iterate>
							</logic:present>							
						</table>
						
						<br/><br/>
						<div id="preloader" align="center" style="display: none;">
							<table height="200">
								<tr>
									<td align="center" height="200" valign="middle">
										<img src="/account/image/chargement.gif"/><br/>
										<span style="font-family: tahoma;font-size: 10pt;">Chargement</span>
									</td>
								</tr>									
							</table>						
						</div>
						<div id="content">
							<logic:present name="compteConnected">
								<table>										
									<tr>
										<td width="100%" style="font-family: tahoma;font-size: 12pt;">Votre compte numéro <b><bean:write name="compteConnected" property="idCompte"/></b> est <logic:greaterEqual value="0" name="compteConnected" property="solde">créditeur</logic:greaterEqual><logic:lessThan value="-1" name="compteConnected" property="solde">débiteur</logic:lessThan> d'une somme de <span style="font-weight: bold;font-family: tahoma;font-size: 12pt;color: #4AB1FF;"><bean:write name="compteConnected" property="solde"/> FC</span></td>
										<td align="right"></td>
									</tr>							
								</table>
								<br/>
								<!--  -->
									<logic:present name="listeTransactions">
										<display:table excludedParams="reqCode" uid="listeTransactions" name="sessionScope.listeTransactions" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=compte">			
											<display:column style="width : 50px;font-size:10pt;font-family:tahoma;" property="idTrx" title="Numéro" />
											<display:column style="width : 300px;font-size:10pt;font-family:tahoma;" property="description" title="Opération"  />
											<display:column style="width : 150px;font-size:10pt;font-family:tahoma;" property="dateValeur" title="Date de valeur"  />
											<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntDebit" title="Montant débit" format="{0,number,###,###,##0.00}" />
											<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntCredit" title="Montant crédit"  format="{0,number,###,###,##0.00}" />
										</display:table>
										<span style="font-family: tahoma;font-size: 7pt;color: #b0b0b0;"><sup>*</sup> rafraîchissement de deux mois</span>						
									</logic:present>
									<logic:notPresent name="listeTransactions">
										Aucune opération trouvée	
									</logic:notPresent>																
							</logic:present>							
						</div>
					</authz:authorize>
					&nbsp;
					<authz:authorize ifAllGranted="ROLE_ADMIN">
						<jsp:include page="../template/menu.jsp"/>
						<!-- ADMIN  -->
						<table width="100%">						
								<tr>
									<td width="100%" valign="top">
										
										
									</td>									
								</tr>
								<tr>
									<td width="100%" colspan="2"></td>								
								</tr>						
						</table>						
					</authz:authorize>
				</td>				
			</tr>
		</table>
<authz:authorize ifAllGranted="ROLE_USER">		
<div style="width: 350px;height: 300px;" dojoType="dijit.Dialog" id="formDialog" title="Modifier password" execute="alert('submitted w/args:\n' + dojo.toJson(arguments[0], true));">
    
			<table height="100%" width="100%" id="preloaderDialog" style="display: none;">
				<tr>					
					<td align="center" height="200" valign="middle">
						<img src="/account/image/chargement.gif"/><br/>
						<span style="font-family: tahoma;font-size: 10pt;">Chargement</span>
					</td>					
				</tr>									
			</table>						
		
	<div id="errorContent">
	</div>
    <table id="contentDialog" width="100%" height="100%">
        <tr>            
            <td>
                <input type="radio" dojoType="dijit.form.RadioButton" name="drink" id="radioOne" checked="checked" />
                <label for="name">
                    Ancien password:
                </label>
            </td>
            <td>
                <input disabled="disabled" maxlength="6" dojoType="dijit.form.TextBox" type="password" name="passwordold" id="passwordold">                
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" dojoType="dijit.form.RadioButton" name="drink" id="radioTwo" />
                <label for="loc">
                    Noveau password:
                </label>                
            </td>
            <td>
                <input disabled="disabled" maxlength="6" dojoType="dijit.form.TextBox" type="password" name="passwordnew" id="passwordnew">
            </td>
        </tr>
        <tr>
            <td>
                <input type="radio" dojoType="dijit.form.RadioButton" name="drink" id="radioTree" />
                <label for="date">
                    Confirmez password:
                </label>
            </td>
            <td>
                <input disabled="disabled" maxlength="6" dojoType="dijit.form.TextBox" type="password" name="passwordconf" id="passwordconf">
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <br/>
                <logic:present name="GRILLE_IMAGE_UPDATE_PASSWORD">
									<img width="129" height="129" BORDER="0"
										src="/account/cache/<bean:write name="GRILLE_IMAGE_UPDATE_PASSWORD" property="url"/>.PNG"
										usemap="#securitygrille" />
									<map name="securitygrille">
										<area shape="rect" coords="0,0,26,26" href="javascript:commun.writeUpdatePWD(1)" />
										<area shape="rect" coords="26,0,52,26" href="javascript:commun.writeUpdatePWD(2)" />										
										<area shape="rect" coords="52,0,78,26" href="javascript:commun.writeUpdatePWD(3)" />
										<area shape="rect" coords="78,0,104,26" href="javascript:commun.writeUpdatePWD(4)" />
										<area shape="rect" coords="104,0,130,26" href="javascript:commun.writeUpdatePWD(5)" />
										
										<area shape="rect" coords="0,26,26,52" href="javascript:commun.writeUpdatePWD(6)" />
										<area shape="rect" coords="26,26,52,52" href="javascript:commun.writeUpdatePWD(7)" />										
										<area shape="rect" coords="52,26,78,52" href="javascript:commun.writeUpdatePWD(8)" />
										<area shape="rect" coords="78,26,104,52" href="javascript:commun.writeUpdatePWD(9)" />
										<area shape="rect" coords="104,26,130,52" href="javascript:commun.writeUpdatePWD(10)" />
										
										<area shape="rect" coords="0,52,26,78" href="javascript:commun.writeUpdatePWD(11)" />
										<area shape="rect" coords="26,52,52,78" href="javascript:commun.writeUpdatePWD(12)" />										
										<area shape="rect" coords="52,52,78,78" href="javascript:commun.writeUpdatePWD(13)" />
										<area shape="rect" coords="78,52,104,78" href="javascript:commun.writeUpdatePWD(14)" />
										<area shape="rect" coords="104,52,130,78" href="javascript:commun.writeUpdatePWD(15)" />
										
										<area shape="rect" coords="0,78,26,104" href="javascript:commun.writeUpdatePWD(16)" />
										<area shape="rect" coords="26,78,52,104" href="javascript:commun.writeUpdatePWD(17)" />										
										<area shape="rect" coords="52,78,78,104" href="javascript:commun.writeUpdatePWD(18)" />
										<area shape="rect" coords="78,78,104,104" href="javascript:commun.writeUpdatePWD(19)" />
										<area shape="rect" coords="104,78,130,104" href="javascript:commun.writeUpdatePWD(20)" />
										
										<area shape="rect" coords="0,104,26,130" href="javascript:commun.writeUpdatePWD(21)" />
										<area shape="rect" coords="26,104,52,130" href="javascript:commun.writeUpdatePWD(22)" />										
										<area shape="rect" coords="52,104,78,130" href="javascript:commun.writeUpdatePWD(23)" />
										<area shape="rect" coords="78,104,104,130" href="javascript:commun.writeUpdatePWD(24)" />
										<area shape="rect" coords="104,104,130,130" href="javascript:commun.writeUpdatePWD(25)" />
									</map>
								</logic:present>
								<br/>
            </td>            
        </tr> 
        <tr>
        	<td align="center" colspan="2">
                
            </td>
        </tr>       
        <tr>
            <td align="center" colspan="2">
                <button dojoType="dijit.form.Button" type="button" onClick="commun.updatePassword();">
                    OK
                </button>
                <button dojoType="dijit.form.Button" type="button" onClick="dijit.byId('formDialog').hide();">
                    Cancel
                </button>
                <button dojoType="dijit.form.Button" type="button" onClick="commun.corrigerPass();">
                    CORRIGER
                </button>
            </td>
        </tr>
    </table>
</div>
</authz:authorize>
<jsp:include page="../template/footer.jsp"/>