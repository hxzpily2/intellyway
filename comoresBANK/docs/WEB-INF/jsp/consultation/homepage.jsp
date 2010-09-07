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
					&nbsp;
					<authz:authorize ifAllGranted="ROLE_ADMIN">
						<!-- ADMIN  -->
						<a href="/account/application/Home.do?reqCode=newuser">Cr�er un utilisateur</a>
					</authz:authorize>
				</td>				
			</tr>
		</table>
<jsp:include page="../template/footer.jsp"/>