package com.account.dao;

import org.springframework.dao.DataAccessException;

import com.account.security.model.User;



/**
 * Allows performing complex actions on persistent data 
 * @author bmeurant
 */
public interface UserDao {

    /**
     * Check if the login exists and if the password is correct in datasource. 
     * @param login : user login
     * @param password : user password
     * @return true if the login exists and if the password is correct. 
     * Otherwise, return false. 
     * @throws DataAccessException in case of Data access errors 
     * (database unreachable, etc.)
     */
    public boolean checkLogin (String login, String password);

    /**
     * Return a User object from a given login.
     * @param login : user login
     * @return the corresponding user object.
     * @throws DataAccessException in case of Data access errors 
     * (database unreachable, etc.)
     */
    public User getUser(String login);
    
}
