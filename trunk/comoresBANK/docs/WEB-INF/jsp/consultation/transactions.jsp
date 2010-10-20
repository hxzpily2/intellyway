<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
</head>
<body>
<logic:present name="compteConnected">
	<table>										
		<tr>
			<td width="100%" style="font-family: tahoma;font-size: 12pt;">Votre compte numéro <b><bean:write name="compteConnected" property="idCompte"/></b> est <logic:greaterEqual value="0" name="compteConnected" property="solde">créditeur</logic:greaterEqual><logic:lessThan value="-1" name="compteConnected" property="solde">débiteur</logic:lessThan> d'une somme de <span style="font-weight: bold;font-family: tahoma;font-size: 12pt;color: #4AB1FF;"><bean:write name="compteConnected" property="solde" format="###.##"/> FC</span></td>
			<td align="right"></td>
		</tr>							
	</table>
	<br/>
	<!--  -->
	    <logic:present name="listeTransactions">
			<display:table excludedParams="reqCode" uid="listeTransactions" name="sessionScope.listeTransactions" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=compte">			
				<display:column style="width : 50px;font-size:10pt;font-family:tahoma;" property="idTrx" title="Id" />
				<display:column style="width : 300px;font-size:10pt;font-family:tahoma;" property="description" title="Descriptif"  />
				<display:column style="width : 150px;font-size:10pt;font-family:tahoma;" property="dateValeur" title="Date"  />
				<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntDebit" title="Montant débit" format="{0,number,###,###,##0.00}" />
				<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntCredit" title="Montant crédit"  format="{0,number,###,###,##0.00}" />
			</display:table>			
			<span style="font-family: tahoma;font-size: 7pt;color: #b0b0b0;"><sup>*</sup> rafraîchissement de deux mois</span>						
		</logic:present>
		<logic:notPresent name="listeTransactions">
			Aucun enregistrement trouvé	
		</logic:notPresent>										
</logic:present>
</body>
</html>