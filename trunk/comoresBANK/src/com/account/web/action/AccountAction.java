package com.account.web.action;

import java.util.Set;
import java.util.TreeSet;

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
import com.account.commun.vo.SearchCompteVO;
import com.account.security.model.Compte;
import com.account.security.model.Transaction;
import com.account.security.model.User;
import com.account.security.service.AuthenticationManager;
import com.account.security.service.UserManager;
import com.account.service.AccountService;

public class AccountAction extends DispatchActionSupport{
	
	public ActionForward consultation(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		String login = (String)session.getAttribute(AuthenticationManager.ACEGI_SECURITY_LAST_USERNAME_KEY);
		ApplicationContext ctx = getWebApplicationContext();   
		UserManager userManager = (UserManager) ctx.getBean("userManager");
		User user = userManager.getUser(login);
		session.setAttribute(Sessions.USER, user);
		
		if(user.getComptes()!=null && user.getComptes().size()>0){
			session.setAttribute(Sessions.LISTECOMPTES, new TreeSet<Compte>(user.getComptes()));			
		}
		
		return mapping.findForward(Forwards.SHOWHOMEPAGE);
	}
	
	public ActionForward compte(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
		
		/*HttpSession session = request.getSession(false);		
		String login = (String)session.getAttribute(AuthenticationManager.ACEGI_SECURITY_LAST_USERNAME_KEY);
		ApplicationContext ctx = getWebApplicationContext();   
		UserManager userManager = (UserManager) ctx.getBean("userManager");
		User user = userManager.getUser(login);
		session.setAttribute(Sessions.USER, user);
		
		if(user.getComptes()!=null && user.getComptes().size()>0){
			session.setAttribute(Sessions.LISTECOMPTES, new TreeSet<Compte>(user.getComptes()));			
		}
		
		if(user.getCptNum()!=null){
			
			session.setAttribute(Sessions.COMPTE, user.getCptNum());
			Set<Transaction> set = user.getCptNum().getTransactions();
			session.setAttribute(Sessions.LISTETRANSACTIONS, set);
		}*/	
		
		HttpSession session = request.getSession(false);		
		String login = (String)session.getAttribute(AuthenticationManager.ACEGI_SECURITY_LAST_USERNAME_KEY);
		ApplicationContext ctx = getWebApplicationContext();   
		UserManager userManager = (UserManager) ctx.getBean("userManager");
		
		User user = userManager.getUser(login);
		session.setAttribute(Sessions.USER, user);
		
		if(request.getParameter("id")!="" && request.getParameter("id")!=null){
			int id = (new Integer(request.getParameter("id"))).intValue();
			
			if(user!=null){
				TreeSet<Compte> setc = new TreeSet<Compte>(user.getComptes());
				Compte compte = (Compte) setc.toArray()[id];
				
				if(compte!=null){
					
					session.setAttribute(Sessions.COMPTE, compte);
					Set<Transaction> sett = compte.getTransactions();
					if(sett.size()>0)
						session.setAttribute(Sessions.LISTETRANSACTIONS, sett);
					else
						session.setAttribute(Sessions.LISTETRANSACTIONS, null);
						
				}
				/*if(user.getCptNum()!=null){
					
					session.setAttribute(Sessions.COMPTE, user.getCptNum());
					Set<Transaction> set = user.getCptNum().getTransactions();
					session.setAttribute(Sessions.LISTETRANSACTIONS, set);
				}*/
			}
		}	//
		return mapping.findForward(Forwards.LISTETRANSACTIONS);
	}
	
	public ActionForward newuser(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
		ApplicationContext ctx = getWebApplicationContext();   
		AccountService userManager = (AccountService) ctx.getBean("accountManager");
		
		//session.setAttribute(Sessions.LISTECOMPTES,userManager.getComptes());
		
		
		return mapping.findForward(Forwards.SEARCHCOMPTE);
	}
	
	public ActionForward userupdate(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
		ApplicationContext ctx = getWebApplicationContext();   
		AccountService userManager = (AccountService) ctx.getBean("accountManager");
		
		session.setAttribute(Sessions.LISTECOMPTES,userManager.getComptes());
		
		
		return mapping.findForward(Forwards.UPDATEUSER);
	}
	
	public ActionForward usercreate(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
		ApplicationContext ctx = getWebApplicationContext();   
		AccountService userManager = (AccountService) ctx.getBean("accountManager");
		
		session.setAttribute(Sessions.LISTECOMPTES,userManager.getComptes());
		
		
		return mapping.findForward(Forwards.CREATEUSER);
	}
	
	public ActionForward expired(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
				
		session.invalidate();
		
		
		return mapping.findForward(Forwards.SESSIONEXPIRED);
	}
	
	public ActionForward searchcompte(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
				
		ApplicationContext ctx = getWebApplicationContext();   
		AccountService userManager = (AccountService) ctx.getBean("accountManager");
		
		SearchCompteVO scVO = new SearchCompteVO();
		scVO.setLogin(request.getParameter("login"));
		scVO.setNom(request.getParameter("nom"));
		scVO.setPrenom(request.getParameter("prenom"));
		scVO.setNumcompte(request.getParameter("num"));
		
		
		return mapping.findForward(Forwards.LISTECOMPTES);
	}
}
