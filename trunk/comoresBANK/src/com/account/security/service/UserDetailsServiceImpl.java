package com.account.security.service;

import java.util.Set;

import org.acegisecurity.GrantedAuthority;
import org.acegisecurity.GrantedAuthorityImpl;
import org.acegisecurity.userdetails.UserDetails;
import org.acegisecurity.userdetails.UserDetailsService;
import org.acegisecurity.userdetails.UsernameNotFoundException;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.dao.DataAccessException;

import com.account.security.model.Rights;
import com.account.security.model.User;



/**
 * Implements a strategy to perform authentication.
 * @author bmeurant
 */
public class UserDetailsServiceImpl implements UserDetailsService {

	private UserManager userManager;
	private final Log logger = LogFactory.getLog(UserDetailsServiceImpl.class);
	
	/**
     * setter to allows spring to inject userManager implementation
     * @param userManager : object (implementation of UserManager interface) to inject.
     */
	public void setUserManager(UserManager userManager) {
		this.userManager = userManager;
	}
	
	
	/**
	 * Get the user object corresponding to the given login, check the password stored
	 * into the secured session context and grant corresponding rights for the user.
	 * @param login: user login
	 * @return an UserDetails objectrepresenting the authenticated user and his rights 
	 * if the authentication is successfull.
	 */
	public UserDetails loadUserByUsername(String login) {
		logger.info("Trying to Load the User with login: "+login+" and password [PROTECTED] from database and LDAP directory");
		try{
			logger.info("Searching the user with login: "+login+" in database");
			User user = userManager.getUser(login);

			if (null == user) {
				logger.error("User with login: "+login+" not found in database. Authentication failed for user "+login);
				throw new UsernameNotFoundException("user not found in database");
			}
			logger.info("user with login: "+login+" found in database");
			
			Set<Rights> rights = user.getRights();
			GrantedAuthority[] arrayAuths = new GrantedAuthority[rights.size()+1];
			int i=0;
			arrayAuths[i++]= new GrantedAuthorityImpl("ROLE_AUTH");
			
			for (Rights right : rights) {
				arrayAuths[i++]= new GrantedAuthorityImpl("ROLE_"+right.getLabel());
			}
			
			logger.debug("Create User for acegi features for User with login: "+login);
			org.acegisecurity.userdetails.User acegiUser =
				new org.acegisecurity.userdetails.User(login,user.getPasswordUser(),true, true, true, true, arrayAuths);
			logger.info("user with login: "+login+" authenticated");
			
			return acegiUser;
		}
		catch (DataAccessException e){
			logger.error("Cannot retrieve Data from Database server : "+e.getMessage()+". Authentication failed for user "+login);
			throw new UsernameNotFoundException("user not found", e);
		}
	}

}
