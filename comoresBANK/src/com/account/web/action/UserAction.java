package com.account.web.action;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.struts.action.ActionForm;
import org.apache.struts.action.ActionForward;
import org.apache.struts.action.ActionMapping;
import org.apache.struts.actions.DispatchAction;

import com.account.commun.Forwards;
import com.account.security.service.UserManager;





public class UserAction   extends DispatchAction{
	
	private UserManager userManager;
	public void setUserManager(UserManager userManager) {
		this.userManager = userManager;
	}
	
	public ActionForward login(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);
		

		return mapping.findForward(Forwards.LOGIN);
	}
}
