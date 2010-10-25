<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>
<logic:present name="listeComptes">
	<display:table excludedParams="reqCode" uid="listeComptes" name="sessionScope.listeTransactions" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=compte">			
		<display:column style="width : 50px;font-size:10pt;font-family:tahoma;" property="idTrx" title="Id" />
		<display:column style="width : 300px;font-size:10pt;font-family:tahoma;" property="description" title="Descriptif"  />
		<display:column style="width : 150px;font-size:10pt;font-family:tahoma;" property="dateValeur" title="Date"  />
		<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntDebit" title="Montant débit" format="{0,number,###,###,##0.00}" />
		<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntCredit" title="Montant crédit"  format="{0,number,###,###,##0.00}" />
	</display:table>							
</logic:present>
<logic:notPresent name="listeComptes">
	Aucun enregistrement trouvé	
</logic:notPresent>