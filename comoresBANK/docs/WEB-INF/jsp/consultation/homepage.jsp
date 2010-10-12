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
					<span style="font-weight: bold;font-family: tahoma;font-size: 12pt;">Bienvenue sur la poste comores</span>
				</td>		
			</tr>
		</table>
		<table width="800">
			<tr>
				<td width="800">
					<authz:authorize ifAllGranted="ROLE_USER">
						<table width="100%">
							<tr>
								<td width="100%" valign="top"><span style="font-family: tahoma;font-size: 12pt;">Bienvenue <b><bean:write name="compteConnected" property="nom"/> <bean:write name="compteConnected" property="prenom"/></b></span></td>
								<td align="right" valign="top"><a href="/account/authentication/Login.do?reqCode=logout">Déconnexion</a></td>
							</tr>
							<tr>
								<td width="100%" colspan="2"></td>								
							</tr>
							<tr>
								<td width="100%" style="font-family: tahoma;font-size: 12pt;">Votre compte numéro <b><bean:write name="compteConnected" property="idCompte"/></b> est créditeur d'un solde de <span style="font-weight: bold;font-family: tahoma;font-size: 12pt;color: #4AB1FF;"><bean:write name="compteConnected" property="solde"/> FC</span></td>
								<td align="right"></td>
							</tr>
						</table>
						
						<br/><br/>
						<display:table name="sessionScope.listeTransactions" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=newuser">			
							<display:column style="width : 50px;" property="idTrx" title="Id" />
							<display:column sortable="true" style="width : 200px;" property="description" title="Descriptif"  />
							<display:column sortable="true" style="width : 150px;" property="dateValeur" title="Date"  />
							<display:column sortable="true" style="width : 130px;text-align:right;" property="mntDebit" title="Montant débit" format="{0,number,###,###,##0.00}" />
							<display:column sortable="true" style="width : 130px;text-align:right;" property="mntCredit" title="Montant crédit"  format="{0,number,###,###,##0.00}" />
						</display:table>
					</authz:authorize>
					&nbsp;
					<authz:authorize ifAllGranted="ROLE_ADMIN">
						<!-- ADMIN  -->
						<a href="/account/application/Home.do?reqCode=newuser">Créer un utilisateur</a>
					</authz:authorize>
				</td>				
			</tr>
		</table>
<jsp:include page="../template/footer.jsp"/>