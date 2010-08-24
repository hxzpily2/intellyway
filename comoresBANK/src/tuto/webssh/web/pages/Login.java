package tuto.webssh.web.pages;

import org.apache.tapestry.Link;
import org.apache.tapestry.annotations.ApplicationState;
import org.apache.tapestry.annotations.Inject;
import org.apache.tapestry.annotations.Persist;
import org.apache.tapestry.beaneditor.Validate;
import org.apache.tapestry.internal.services.LinkImpl;
import org.apache.tapestry.services.Request;
import org.apache.tapestry.services.Response;

public class Login {

	private static final String BAD_CREDENTIALS = "Bad login and/or password. Please retry."; 
	
	@Persist
	private boolean error = false;
		
	@ApplicationState
	private String login;
	
	@Inject
    private Request request;
    
    @Inject
    private Response response;
	
	private String password;
	
	public String getLogin() {
		return login;
	}

	@Validate("required")
	public void setLogin(String login) {
		this.login = login;
	}

	public String getPassword() {
		return password;
	}

	public String getErrorMessage() {
		String ret = null;
		if (error) {
			ret = BAD_CREDENTIALS;
		}
		return ret;
	}
	
	@Validate("required")
	public void setPassword(String password) {
		this.password = password;
	}
	
	void onActivate() {
		error = new Boolean(request.getParameter("error")).booleanValue();
	}

	Link onSuccess() {
		Link link= new LinkImpl(response, request.getContextPath(), "j_acegi_security_check");
        link.addParameter("j_username", login);
        link.addParameter("j_password", password);
        return link;
	}
}