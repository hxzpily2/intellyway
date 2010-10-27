<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>

<link rel="stylesheet" href="/account/css/displaytag.css" type="text/css" />


<!-- DOJO INCLUDE -->
<style type='text/css'>
	@import '/account/js/dijit/themes/claro/claro.css';
	@import '/account/js/dojo/resources/dojo.css';
</style>
<script type='text/javascript' src='/account/js/dojo/dojo.js' djConfig='parseOnLoad: true'></script>
<script type='text/javascript'>
	dojo.require("dijit.MenuBar");
	dojo.require("dijit.PopupMenuBarItem");
	dojo.require("dijit.Menu");
	dojo.require("dijit.MenuItem");
	dojo.require("dijit.PopupMenuItem");
	dojo.require("dijit.form.Button");
    dojo.require("dijit.Dialog");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.RadioButton");
	
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
<title>La Poste Comores : Consultation des Comptes</title>
</head>
<body class="claro">
<table width="100%" height="79">
	<tr>
		<td width="50%">&nbsp;</td>
		<td width="1000">
		<a href="/account/authentication/Login.do?reqCode=logout" style="border-style: none;text-decoration: none;"><img style="border-style: none;" src="/account/image/header.jpg"/></a>
		</td>
		<td width="50%">&nbsp;</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td width="50%"></td>
		<td width="860">