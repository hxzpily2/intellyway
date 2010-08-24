package com.account.security.service;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;

import com.account.dao.UserDao;
import com.account.security.model.User;



/**
 * Implements business features to handler users
 * @author bmeurant
 */
public class UserManagerImpl implements UserManager {

    private final Log logger = LogFactory.getLog(UserManagerImpl.class);
    
    private UserDao userDao = null;

    /**
     * setter to allows spring to inject userDao implementation
     * @param userDao : object (implementation of UserDao interface) to inject.
     */
    public void setUserDao(UserDao userDao) {
        this.userDao = userDao;
    }
    
    /**
     * {@inheritDoc}
     */
    public boolean checkLogin (String login, String password) {
        return userDao.checkLogin(login, password);
    }

    /**
     * {@inheritDoc}
     */
    public User changePassword(String login, String password) {
        User user = userDao.getUser(login);
        if (user != null) {
            user.setPasswordUser(password);
        }
        return user;
    }
    
    /**
     * {@inheritDoc}
     */
    @SuppressWarnings("finally")
    public User getUser(String login) {
        return userDao.getUser(login);
    }


}
