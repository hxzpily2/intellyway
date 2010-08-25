package com.account.security.service;

import javax.servlet.FilterConfig;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;

import org.acegisecurity.Authentication;
import org.acegisecurity.AuthenticationException;
import org.acegisecurity.providers.UsernamePasswordAuthenticationToken;


public class AuthenticationManager extends AccountAbstractProcessingFilter{

	//~ Static fields/initializers =====================================================================================
	
	            public static final String ACEGI_SECURITY_FORM_USERNAME_KEY = "j_username";
	            public static final String ACEGI_SECURITY_FORM_PASSWORD_KEY = "j_password";
	            public static final String ACEGI_SECURITY_LAST_USERNAME_KEY = "ACEGI_SECURITY_LAST_USERNAME";
	
	            //~ Methods ========================================================================================================
	
	            public Authentication attemptAuthentication(
	                    HttpServletRequest request) throws AuthenticationException {
	                String username = obtainUsername(request);
	                String password = obtainPassword(request);
	
	                if (username == null) {
	                    username = "";
	                }
	
	                if (password == null) {
	                    password = "";
	                }
	
	                username = username.trim();
	
	                UsernamePasswordAuthenticationToken authRequest = new UsernamePasswordAuthenticationToken(
	                        username, password);
	
	                // Place the last username attempted into HttpSession for views
	                request.getSession().setAttribute(
	                        ACEGI_SECURITY_LAST_USERNAME_KEY, username);
	
	                // Allow subclasses to set the "details" property
	                setDetails(request, authRequest);
	
	                return this .getAuthenticationManager()
	                        .authenticate(authRequest);
	            }
	
	            /**
	             * This filter by default responds to <code>/j_acegi_security_check</code>.
	             *
	             * @return the default
	             */
	            public String getDefaultFilterProcessesUrl() {
	                return "/j_acegi_security_check";
	            }
	
	            public void init(FilterConfig filterConfig) throws ServletException {
	            }
	
	            /**
	             * Enables subclasses to override the composition of the password, such as by including additional values
	             * and a separator.<p>This might be used for example if a postcode/zipcode was required in addition to the
	             * password. A delimiter such as a pipe (|) should be used to separate the password and extended value(s). The
	             * <code>AuthenticationDao</code> will need to generate the expected password in a corresponding manner.</p>
	             *
	             * @param request so that request attributes can be retrieved
	             *
	             * @return the password that will be presented in the <code>Authentication</code> request token to the
	             *         <code>AuthenticationManager</code>
	             */
	            protected String obtainPassword(HttpServletRequest request) {
	                return request.getParameter(ACEGI_SECURITY_FORM_PASSWORD_KEY);
	            }
	
	            /**
	             * Enables subclasses to override the composition of the username, such as by including additional values
	             * and a separator.
	             *
	             * @param request so that request attributes can be retrieved
	             *
	             * @return the username that will be presented in the <code>Authentication</code> request token to the
	             *         <code>AuthenticationManager</code>
	             */
	            protected String obtainUsername(HttpServletRequest request) {
	                return request.getParameter(ACEGI_SECURITY_FORM_USERNAME_KEY);
	            }
	
	            /**
	             * Provided so that subclasses may configure what is put into the authentication request's details
	             * property.
	             *
	             * @param request that an authentication request is being created for
	             * @param authRequest the authentication request object that should have its details set
	             */
	            protected void setDetails(HttpServletRequest request,
	                    UsernamePasswordAuthenticationToken authRequest) {
	                authRequest.setDetails(authenticationDetailsSource
	                        .buildDetails(request));
	            }


}
