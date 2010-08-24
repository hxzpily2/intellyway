package tuto.webssh.web.dwr;

import javax.servlet.http.HttpServletRequest;

import org.directwebremoting.annotations.Param;
import org.directwebremoting.annotations.RemoteMethod;
import org.directwebremoting.annotations.RemoteProxy;
import org.directwebremoting.spring.SpringCreator;

import com.account.security.model.User;



/**
 * This interface publishes business features to handle user to web interfaces
 * @author bmeurant
 */
@RemoteProxy(creator = SpringCreator.class, 
             creatorParams = @Param(name = "beanName", value = "userDWR"))
public interface UserDWR {

    /**
     * Return a User object from a given login.
     * @param login : user login
     * @param request : the web client request used to get some specific data from client.
     * @return the corresponding user object.
     */
    @RemoteMethod
    public User getUser(String login, HttpServletRequest request);
    
    /**
     * Get the connected user object from session
     * @param request : the web client request used to get some specific data from client.
     * @return the corresponding user object.
     */
    @RemoteMethod
    public User getUserFromSession(HttpServletRequest request);
    
    /**
     * This method checks the actual login and password and, if this verification
     * is successful, change the password to 'password' for the given login.
     * @param request : the web client request used to get some specific data from client.
     * @param login : user login
     * @param oldPass : user old password
     * @param newPass : user new password
     * @return the new User object
     */
    @RemoteMethod
    public User changePassword(HttpServletRequest request, String login, String oldPass, String newPass);
    
}
