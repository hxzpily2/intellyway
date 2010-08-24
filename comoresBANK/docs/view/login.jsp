<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>Login</title>
	</head>
	<body>
		<form id="loginForm" action="home.jsp" method="post">
			<table>
				<tr>
					<td><label>Login: </label></td>
					<td><input type="text" id="username" size="15" maxlength="10"/></td>
					<td rowspan="2" style="vertical-align:middle;"><input type="submit" value="Go"/></td>
				</tr>
				<tr>
					<td><label>Password: </label></td>
					<td><input type="password" id="password" size="15" maxlength="8"/></td>
				</tr>
			</table>
		</form>
	</body>
</html>