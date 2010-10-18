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
				<td style="color: #7dc327;" width="860" align="left">
					<table width="860">						
							<tr>
								<td width="100%" valign="top"><a href="/account/application/Home.do?reqCode=newuser">Créer un utilisateur</a></td>
								<td align="right" valign="top"><a href="/account/authentication/Login.do?reqCode=logout">Déconnexion</a></td>
							</tr>
							<tr>
								<td width="100%" colspan="2"></td>								
							</tr>						
					</table>
					<html:form action="/application/Home.do">
							<table width="252" height="28" align="left">
								<tr>
									<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><span
											style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;" onclick="javascript:document.getElementById('loginForm').submit()">VALIDER</span></td>
									<td width="10"></td>
									<td style="color: #FFFFFF;cursor: pointer;" align="center" valign="middle" width="119" background="/account/image/blue_buton.jpg"><a href=""
											style="font-family: tahoma; font-size: 10pt; font-weight: bold;cursor: pointer;text-decoration: none;color: white;">ANNULER</a></td>
								</tr>
							</table>					
					</html:form>
				</td>		
			</tr>
		</table>		
<jsp:include page="../template/footer.jsp"/>