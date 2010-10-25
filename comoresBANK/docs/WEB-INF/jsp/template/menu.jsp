<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-bean.tld" prefix="bean"%>
<%@ taglib uri="/WEB-INF/conf/tld/struts-logic.tld" prefix="logic"%>
<%@ taglib uri="http://displaytag.sf.net" prefix="display" %>
<%@ taglib uri="http://acegisecurity.org/authz" prefix="authz" %>
<div dojoType="dijit.MenuBar" id="navMenu">
	    <div dojoType="dijit.PopupMenuBarItem">
	        <span>
	            Utilisateurs
	        </span>
	        <div dojoType="dijit.Menu" id="fileMenu">
	            <div dojoType="dijit.MenuItem" onClick="document.location.href='/account/application/Home.do?reqCode=newuser'">
	                Créer un utilisateur
	            </div>
	            <div dojoType="dijit.MenuItem" onClick="document.location.href='/account/application/Home.do?reqCode=newuser'">
	                Modifier un utilisateur
	            </div>
	        </div>
	    </div>	    
	    <authz:authorize ifAllGranted="ROLE_ADMIN">
		    <div dojoType="dijit.PopupMenuBarItem">
		        <span>
		            Session
		        </span>
		        <div dojoType="dijit.Menu" id="sessionMenu">
		            <div dojoType="dijit.MenuItem" onClick="document.location.href='/account/authentication/Login.do?reqCode=logout'">
		                Terminer
		            </div>		            
		        </div>
		    </div>
	    </authz:authorize>
</div>