<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@ taglib prefix="html" uri="http://struts.apache.org/tags-html-el" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
</head>
<body>
<html:form action="/j_acegi_security_check"  method="post"  >
<fieldset id="loginFieldSet">
<legend>authentication</legend>
you can enter admin/admin in user/password fields to authenticate
<div>
    <label for="login">Login</label>
    <input id="j_username" type="text" maxlength="20" size="30" name="j_username" tabindex="1" />
</div>
<div>
	<label for="password">Password</label>
    <input id="j_password" type="password" value="" size="30" name="j_password"  tabindex="2" />
</div>
  <div class="spacer">
  &nbsp;
  </div>   
  	<input type="submit" value="submit" tabindex="4"/>
	<input type="reset" value="reset" tabindex="5"/>
</fieldset>
</html:form>
</body>
</html>