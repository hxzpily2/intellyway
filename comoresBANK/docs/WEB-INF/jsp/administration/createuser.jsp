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
		<span style="font-size: 12pt;font-family: tahoma;font-weight: bold;">Créer un utilisateur pour le compte <logic:present name="compteUser"><bean:write name="compteUser" property="idCompte"/></logic:present></span>
		<hr width="100%"/>
		<html:form action="/application/Home.do?reqCode=usercreateform" styleId="userForm">
			<input type="hidden" name="reqCode" value="usercreateform"/>
			<table>
				<tr>
					<td>Login</td>
					<td width="10"></td>
					<td><input value="<logic:present name="compteUser"><bean:write name="compteUser" property="idCompte"/></logic:present>" type="text" id="login" name="login" style="border: 1px solid rgb(181, 181, 181);width: 250px;"/></td>
				</tr>
				<tr>
					<td>Nom</td>
					<td width="10"></td>
					<td>
						<input disabled="disabled" value="<logic:present name="compteUser"><bean:write name="compteUser" property="nom"/></logic:present>" type="text" id="nomC" name="nomC" style="border: 1px solid rgb(181, 181, 181);width: 250px;"/>
						<input value="<logic:present name="compteUser"><bean:write name="compteUser" property="nom"/></logic:present>" type="hidden" id="nom" name="nom" style="border: 1px solid rgb(181, 181, 181);"/>
					</td>
				</tr>
				<tr>
					<td>Prenom</td>
					<td width="10"></td>
					<td>
						<input disabled="disabled" value="<logic:present name="compteUser"><bean:write name="compteUser" property="prenom"/></logic:present>" type="text" id="prenomC" name="prenomC" style="border: 1px solid rgb(181, 181, 181);width: 250px;"/>
						<input value="<logic:present name="compteUser"><bean:write name="compteUser" property="prenom"/></logic:present>" type="hidden" id="prenom" name="prenom" style="border: 1px solid rgb(181, 181, 181);"/>
					</td>
				</tr>
				<tr>
					<td>Mot de passe</td>
					<td></td>
					<td>
						<input disabled="disabled" value="<bean:write name="password"/>" type="text" id="passwordC" name="passwordC" style="border: 1px solid rgb(181, 181, 181);"/>
						<input type="hidden" value="<bean:write name="password"/>" id="password" name="password" style="border: 1px solid rgb(181, 181, 181);"/>
					</td>
				</tr>			
			</table>
			<table width="248" height="28" align="left">
				<tr>
					<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><span
							style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;" onclick="javascript:dojo.byId('userForm').submit()">VALIDER</span></td>
					<td width="10"></td>
					<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><a href="/account/application/Home.do?reqCode=consultation"
							style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;text-decoration: none;color: white;">ANNULER</a></td>
				</tr>
			</table>
		</html:form>
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
													
		</div>
<jsp:include page="../template/footer.jsp"/>		