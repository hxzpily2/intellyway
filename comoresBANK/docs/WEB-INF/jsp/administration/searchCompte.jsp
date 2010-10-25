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
				<td>Numéro de compte</td>
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
		<div id="preloader" height="200" width="100%" style="display: none;position: relative;
					 top: 25%;
					 left: 25%;
					 width: 50%;
					 height: 50%;					 
					 padding: 5px;" >
			<table height="200" width="100%">
				<tr>					
					<td align="center" height="200" valign="middle">
						<img src="/account/image/chargement.gif"/><br/>
						<span style="font-family: tahoma;font-size: 10pt;">Chargement</span>
					</td>					
				</tr>									
			</table>						
		</div>
		<div id="content">				
				<br/>
				<!--  -->
				<logic:present name="listeComptes">
					<display:table excludedParams="reqCode" uid="listeComptes" name="sessionScope.listeComptes" sort="external" defaultsort="3" defaultorder="descending" export="true" pagesize="10" requestURI="/application/Home.do?reqCode=searchcompte">			
						<display:column style="width : 50px;font-size:10pt;font-family:tahoma;" property="idCompte" title="Id" />
						<display:column style="width : 200px;font-size:10pt;font-family:tahoma;" property="nom" title="Nom"  />
						<display:column style="width : 200px;font-size:10pt;font-family:tahoma;" property="prenom" title="Prenom"  />						
					</display:table>							
				</logic:present>
				<logic:notPresent name="listeComptes">
					Aucun enregistrement trouvé	
				</logic:notPresent>										
		</div>
<jsp:include page="../template/footer.jsp"/>		