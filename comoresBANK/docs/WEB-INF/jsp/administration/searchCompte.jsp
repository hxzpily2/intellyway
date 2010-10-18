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
					<span style="font-weight: bold;font-family: tahoma;font-size: 12pt;">Bienvenue sur Comores BANK</span>
				</td>		
			</tr>
		</table>
		<table width="800">
			<tr>
				<td width="800">
					<authz:authorize ifAllGranted="ROLE_USER">
						<a href="/account/authentication/Login.do?reqCode=logout">Logout</a>
					</authz:authorize>					
				</td>				
			</tr>
		</table>
		<br/>
		<display:table decorator="com.account.commun.decorateurs.SearchCompteDecorateur" name="sessionScope.listeComptes" sort="external" defaultsort="1" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=newuser">			
			<display:column sortable="true" style="width : 50px;font-size:10pt;font-family:tahoma;" property="idCompte" sortName="idCompte" title="N°" />
			<display:column sortable="true" style="width : 200px;font-size:10pt;font-family:tahoma;" property="descriptif" sortName="descriptif" title="Descriptif"  />
			<display:column sortable="true" style="width : 100px;font-size:10pt;font-family:tahoma;" property="nom" sortName="nom" title="Nom"  />
			<display:column sortable="true" style="width : 220px;font-size:10pt;font-family:tahoma;" property="prenom" sortName="prenom" title="Prénom"  />												
			<display:column style="width : 70px;" property="lienNewUser" title="Utilisateur"  />
		</display:table>
		<html:form action='/authentication/j_acegi_security_check.do'> 
			 
		</html:form>
<jsp:include page="../template/footer.jsp"/>		