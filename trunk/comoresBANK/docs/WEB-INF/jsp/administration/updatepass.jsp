<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>
<logic:present name="errorUpdatePass">
	<span style="color: red;"><bean:write name="errorUpdatePass"/></span>
</logic:present>
<logic:present name="okUpdatePass">
	<span style="color: #7dc327;">Votre mot de passe a été correctement modifié</span>
</logic:present>