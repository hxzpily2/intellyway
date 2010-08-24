package com.account.security.service;

import org.acegisecurity.Authentication;
import org.acegisecurity.ConfigAttribute;
import org.acegisecurity.ConfigAttributeDefinition;
import org.acegisecurity.userdetails.UserDetails;
import org.acegisecurity.vote.RoleVoter;
import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.springframework.aop.framework.ReflectiveMethodInvocation;

public class HimselfVoter extends RoleVoter {

	private Log logger = LogFactory.getLog(HimselfVoter.class);
	
	public boolean supports(ConfigAttribute configAttribute) {
		Boolean result = (configAttribute != null
					&& configAttribute.getAttribute() != null
					&& configAttribute.getAttribute().equals(
							this.getRolePrefix()));
		
		logger.info("support : result = "+result.toString());
		return result;
		
	}

	public int vote(Authentication authentication, Object obj,
			ConfigAttributeDefinition configAttributeDefinition) {
		int result = ACCESS_ABSTAIN;
		String login = null;
		ReflectiveMethodInvocation methodInvocation = (ReflectiveMethodInvocation) obj;
		Object[] params = methodInvocation.getArguments();
		String methodName = methodInvocation.getMethod().getName();
		
		if (methodName != null && methodName.equals("changePassword")){
			login = (String)params[0];
		}
		String userName = ((UserDetails)authentication.getPrincipal()).getUsername();
		
		if (userName != null && login != null && userName.equals(login)){
			result = ACCESS_GRANTED;
			logger.info("Himself Vote: ACCESS GRANTED");
		}
		else {
			result = ACCESS_DENIED;
			logger.info("Himself Vote: ACCESS DENIED");
		}

		return result; 
	}
	
}
