<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>


<!-- DOJO INCLUDE -->
<script type='text/javascript' src='/account/js/dojo/dojo.js' djConfig='parseOnLoad: false'></script>
<script type='text/javascript'>
	
	dojo.require('dojo.parser');
	
	dojo.registerModulePath('account', '../account');
	dojo.require('account.integration.Commun');
	var commun = new account.integration.Commun();
</script>
<!-- END DOJO INCLUDE -->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<style type="text/css">
html, body { height: 100%; width: 100%; padding: 0; border: 0; }
</style>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
</head>
<body>
<html:form styleId="loginForm" action="/authentication/j_acegi_security_check.do"
	method="post">
	<input type="hidden" name="reqCode" value="login" />
	
<table width="100%" height="79">
	<tr>
		<td width="50%">&nbsp;</td>
		<td width="1000">
		<img src="/account/image/header.jpg"/>
		</td>
		<td width="50%">&nbsp;</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td width="50%"></td>
		<td width="860">
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
					<authz:authorize ifAllGranted="ROLE_ADMIN">
						ADMIN
					</authz:authorize>
				</td>				
			</tr>
		</table>

		</td>
		<td width="50%"></td>
	</tr>
</table>
</html:form>
</body>
</html>