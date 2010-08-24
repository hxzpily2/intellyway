package tuto.webssh.web.pages;

import javax.servlet.http.HttpSession;

import org.apache.tapestry.ComponentResources;
import org.apache.tapestry.Link;
import org.apache.tapestry.annotations.ApplicationState;
import org.apache.tapestry.annotations.Inject;
import org.apache.tapestry.annotations.OnEvent;
import org.apache.tapestry.services.RequestGlobals;

public class Home {
	
	@Inject
	private ComponentResources resources;
	
	@Inject
    private RequestGlobals requestGlobals;
   
    @ApplicationState
	private String login;

	public String getLogin() {
		return login;
	}

	public void setLogin(String login) {
		this.login = login;
	}
    
    @OnEvent(component = "logout")
    public Link onLogout()
    {
    	HttpSession session = requestGlobals.getHTTPServletRequest().getSession();
		session.invalidate();
    	return resources.createPageLink("login", false);  
    }

}
