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
		<jsp:include page="../template/menu.jsp"/>
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
		<span style="font-size: 12pt;font-family: tahoma;font-weight: bold;">Rechercher un compte</span>
		<hr width="100%"/>
		<table>
			<tr>
				<td>Nom</td>
				<td width="10"></td>
				<td><input type="text" id="search_nom" style="border: 1px solid rgb(181, 181, 181);"/></td>
			</tr>
			<tr>
				<td>Prenom</td>
				<td></td>
				<td><input type="text" id="search_prenom" style="border: 1px solid rgb(181, 181, 181);"/></td>
			</tr>
			<tr>
				<td>Num�ro de compte</td>
				<td></td>
				<td><input type="text" id="search_numcpt" style="border: 1px solid rgb(181, 181, 181);"/></td>
			</tr>
			<tr>
				<td>Login user</td>
				<td></td>
				<td><input type="text" id="search_login" style="border: 1px solid rgb(181, 181, 181);"/></td>
			</tr>
		</table>
		<table width="248" height="28" align="left">
			<tr>
				<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><span
						style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;" onclick="javascript:commun.searchCompte()">RECHERCHER</span></td>
				<td width="10"></td>
				<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><a href="/account/application/Home.do?reqCode=consultation"
						style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;text-decoration: none;color: white;">ANNULER</a></td>
			</tr>
		</table>
		<br/><br/>
		
		<table id="preloader" height="200" width="100%" style="display: none;">
			<tr>
				<td align="center" height="200" valign="middle">
					<img src="/account/image/chargement.gif"/><br/>
					<span style="font-family: tahoma;font-size: 10pt;">Chargement</span>
				</td>
			</tr>									
		</table>						
		
		<div id="content">				
				<br/>
				<!--  -->
				<logic:present name="listeComptes">
					<display:table excludedParams="reqCode" uid="listeComptes" name="sessionScope.listeTransactions" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=compte">			
						<display:column style="width : 50px;font-size:10pt;font-family:tahoma;" property="idTrx" title="Id" />
						<display:column style="width : 300px;font-size:10pt;font-family:tahoma;" property="description" title="Descriptif"  />
						<display:column style="width : 150px;font-size:10pt;font-family:tahoma;" property="dateValeur" title="Date"  />
						<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntDebit" title="Montant d�bit" format="{0,number,###,###,##0.00}" />
						<display:column style="width : 130px;text-align:right;font-size:10pt;font-family:tahoma;" property="mntCredit" title="Montant cr�dit"  format="{0,number,###,###,##0.00}" />
					</display:table>
					<span style="font-family: tahoma;font-size: 7pt;color: #b0b0b0;"><sup>*</sup> rafra�chissement de deux mois</span>						
				</logic:present>
				<logic:notPresent name="listeComptes">
					Aucun enregistrement trouv�	
				</logic:notPresent>								
										
		</div>
<jsp:include page="../template/footer.jsp"/>		