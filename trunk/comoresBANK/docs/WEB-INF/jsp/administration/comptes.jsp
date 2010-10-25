<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>
<br/>
<logic:present name="listeComptes">
	<display:table decorator="com.account.commun.decorateurs.SearchCompteDecorateur" excludedParams="reqCode" uid="listeComptes" name="sessionScope.listeComptes" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=searchcompte">			
		<display:column style="width : 50px;font-size:10pt;font-family:tahoma;" property="idCompte" title="Id" />
		<display:column style="width : 200px;font-size:10pt;font-family:tahoma;" property="nom" title="Nom"  />
		<display:column style="width : 200px;font-size:10pt;font-family:tahoma;" property="prenom" title="Prenom"  />
		<display:column style="width : 70px;" property="lienNewUser" title="Utilisateur"  />		
	</display:table>							
</logic:present>
<logic:notPresent name="listeComptes">
	Aucun enregistrement trouvé	
</logic:notPresent>