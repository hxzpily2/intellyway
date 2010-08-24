package tuto.webssh.web.dwr.impl;

import javax.servlet.http.HttpServletRequest;

import tuto.webssh.web.dwr.UserDWR;

import com.account.security.model.User;
import com.account.security.service.UserManager;



/**
 * Implements business features to handle user to web interfaces
 * @author bmeurant
 */
public class UserDWRImpl implements UserDWR {

    private UserManager userManager;

    /**
     * setter to allows spring to inject userManager implementation
     * @param userManager : object (implementation of UserManager interface) to inject.
     */
    public void setUserManager(UserManager userManager) {
        this.userManager = userManager;
    }

    /**
     * {@inheritDoc}
     */
    public User getUser(String login, HttpServletRequest request) {
        return userManager.getUser(login);
    }

    /**
     * {@inheritDoc}
     */
    public User getUserFromSession(HttpServletRequest request) {
        String login = (String)request.getSession().getAttribute("loginUser");
        if (null != login) {
            return this.getUser(login, request);
        }
        else {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public User changePassword(HttpServletRequest request, String login,
            String oldPass, String newPass) {
        if (userManager.checkLogin(login, oldPass)) {
            return this.userManager.changePassword(login, newPass);
        }
        else {
            return null;
        }
    }
}
