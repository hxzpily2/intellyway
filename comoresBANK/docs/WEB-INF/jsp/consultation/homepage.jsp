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
							<logic:present name="userConnected">
								<tr>
									<td width="100%" valign="top"><span style="font-family: tahoma;font-size: 12pt;">Bienvenue <b><bean:write name="userConnected" property="nom"/> <bean:write name="userConnected" property="prenom"/></b></span></td>
									<td align="right" valign="top"><a href="/account/authentication/Login.do?reqCode=logout">D�connexion</a></td>
								</tr>
								<tr>
									<td width="100%" colspan="2"></td>								
								</tr>
							</logic:present>
							<logic:present name="listeComptes">
								<tr>
									<td width="100%" style="font-family: tahoma;font-size: 12pt;">Vous �tes titulaire des comptes : </td>
									<td align="right"></td>
								</tr>
								<tr>
									<td width="100%" colspan="2"></td>								
								</tr>
								<logic:iterate indexId="indexData" name="listeComptes" id="unCompte">
									<tr>
										<td align="left" width="100%" colspan="2"><img src="/account/image/point.jpg">&nbsp;<a href="javascript:commun.sortOrPaginate('/account/application/Home.do?reqCode=compte&id=<bean:write name="indexData"/>')" style="color: #7dc327;text-decoration: none;"><bean:write name="unCompte" property="idCompte"/></a></td>								
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
										<td width="100%" style="font-family: tahoma;font-size: 12pt;">Votre compte num�ro <b><bean:write name="compteConnected" property="idCompte"/></b> est cr�diteur d'un solde de <span style="font-weight: bold;font-family: tahoma;font-size: 12pt;color: #4AB1FF;"><bean:write name="compteConnected" property="solde"/> FC</span></td>
										<td align="right"></td>
									</tr>							
								</table>
								<br/>
								<!--  -->
									<logic:present name="listeTransactions">
										<display:table excludedParams="reqCode" uid="listeTransactions" name="sessionScope.listeTransactions" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=compte">			
											<display:column style="width : 50px;" property="idTrx" title="Id" />
											<display:column sortable="true" style="width : 200px;" property="description" title="Descriptif"  />
											<display:column sortable="true" style="width : 150px;" property="dateValeur" title="Date"  />
											<display:column sortable="true" style="width : 130px;text-align:right;" property="mntDebit" title="Montant d�bit" format="{0,number,###,###,##0.00}" />
											<display:column sortable="true" style="width : 130px;text-align:right;" property="mntCredit" title="Montant cr�dit"  format="{0,number,###,###,##0.00}" />
										</display:table>						
									</logic:present>
									<logic:notPresent name="listeTransactions">
										Aucun enregistrement trouv�	
									</logic:notPresent>																
							</logic:present>							
						</div>
					</authz:authorize>
					&nbsp;
					<authz:authorize ifAllGranted="ROLE_ADMIN">
						<!-- ADMIN  -->
						<a href="/account/application/Home.do?reqCode=newuser">Cr�er un utilisateur</a>
					</authz:authorize>
				</td>				
			</tr>
		</table>
<jsp:include page="../template/footer.jsp"/>