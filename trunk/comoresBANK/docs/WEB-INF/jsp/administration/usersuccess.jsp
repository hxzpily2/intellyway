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
		<span style="font-size: 12pt;font-family: tahoma;font-weight: bold;">Utilisateur Créé avec succés</span>
		
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