package com.account.web.action;

import java.io.UnsupportedEncodingException;
import java.security.NoSuchAlgorithmException;
import java.util.HashSet;
import java.util.List;
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



import com.account.commun.Constantes;
import com.account.commun.Forwards;
import com.account.commun.SecuriteGrilleGenerator;
import com.account.commun.Sessions;
import com.account.commun.vo.SearchCompteVO;
import com.account.security.model.Compte;
import com.account.security.model.Rights;
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
		if(request.getParameter("id")!=""){
			java.util.List<Compte> list = userManager.getCompteByNum(request.getParameter("id")); 
			if(list.size()>0){
				Compte compte = list.get(0); 
				session.setAttribute(Sessions.COMPTEUSER,compte);
				session.setAttribute(Sessions.PASSWORD,SecuriteGrilleGenerator.generatePassword().toString());
			}else
				session.setAttribute(Sessions.COMPTEUSER,null);	
		}
		
		
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
		
		session.setAttribute(Sessions.LISTECOMPTES, userManager.searchComptes(scVO));
		return mapping.findForward(Forwards.LISTECOMPTES);
	}
	
	public ActionForward usercreateform(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) throws NoSuchAlgorithmException, UnsupportedEncodingException {
 
		HttpSession session = request.getSession(false);		
		
		ApplicationContext ctx = getWebApplicationContext();   
		AccountService userManager = (AccountService) ctx.getBean("accountManager");
		
		if(request.getParameter("login")!=""){
			User user = new User();
			user.setLoginUser(request.getParameter("login"));
			user.setPasswordUser(SecuriteGrilleGenerator.SHA1(request.getParameter("password")));
			user.setNom(request.getParameter("nom"));
			user.setPrenom(request.getParameter("prenom"));
			
			Compte compte = (Compte) session.getAttribute(Sessions.COMPTE);
			Set<Compte> list = new HashSet<Compte>();
			list.add(compte);
			user.setComptes(list);
			
			
			userManager.saveUser(user);
			
			Rights right = new Rights();
			right.setUser(user);
			right.setLabel(Constantes.USER);
			right.setI18nkey("");
			userManager.saveRight(right);

		}
		
		return mapping.findForward(Forwards.USERCREATESUCCESS);
	}
}
