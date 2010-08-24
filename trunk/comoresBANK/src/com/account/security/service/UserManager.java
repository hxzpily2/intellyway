package com.account.security.service;

import org.acegisecurity.annotation.Secured;
import org.springframework.transaction.annotation.Propagation;
import org.springframework.transaction.annotation.Transactional;

import com.account.security.model.User;



/**
 * This interface publishes business features to handler users
 * @author bmeurant
 */
@Transactional (readOnly=true, propagation=Propagation.REQUIRED)
public interface UserManager {

    /**
     * Check if the login exists and if the password is correct. 
     * @param login : user login
     * @param password : user password
     * @return true if the login exists and if the password is correct. 
     * Otherwise, return false. 
     */
	public boolean checkLogin (String login, String password);

	/**
     * Return a User object from a given login.
     * @param login : user login
     * @return the corresponding user object.
     */
	public User getUser(String login);
	
	/**
     * Change the password to 'password' for the given login
     * @param login : user login
     * @param password : user new password
     * @return the new User object
     */
	@Secured({"ROLE_AUTH","HIMSELF"})
	@Transactional (readOnly=false)
	public User changePassword (String login, String password);
	
}
