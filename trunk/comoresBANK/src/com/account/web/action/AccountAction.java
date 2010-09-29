package com.account.web.action;

import java.util.Set;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.apache.struts.action.ActionForm;
import org.apache.struts.action.ActionForward;
import org.apache.struts.action.ActionMapping;
import org.apache.struts.actions.DispatchAction;
import org.springframework.context.ApplicationContext;
import org.springframework.web.struts.DispatchActionSupport;

import com.account.commun.Forwards;
import com.account.commun.Sessions;
import com.account.security.model.Transaction;
import com.account.security.model.User;
import com.account.security.service.AuthenticationManager;
import com.account.security.service.UserManager;
import com.account.service.AccountService;

public class AccountAction    extends DispatchActionSupport{
	
	public ActionForward consultation(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		String login = (String)session.getAttribute(AuthenticationManager.ACEGI_SECURITY_LAST_USERNAME_KEY);
		ApplicationContext ctx = getWebApplicationContext();   
		UserManager userManager = (UserManager) ctx.getBean("userManager");
		User user = userManager.getUser(login);
		if(user.getCptNum()!=null){
			session.setAttribute(Sessions.USER, user);
			session.setAttribute(Sessions.COMPTE, user.getCptNum());
			Set<Transaction> set = user.getCptNum().getTransactions();
			session.setAttribute(Sessions.LISTETRANSACTIONS, set);
		}
		return mapping.findForward(Forwards.SHOWHOMEPAGE);
	}
	
	public ActionForward newuser(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
		ApplicationContext ctx = getWebApplicationContext();   
		AccountService userManager = (AccountService) ctx.getBean("accountManager");
		
		session.setAttribute(Sessions.LISTECOMPTES,userManager.getComptes());
		
		
		return mapping.findForward(Forwards.CREATEUSER);
	}
}
