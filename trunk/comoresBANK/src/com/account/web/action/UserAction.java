package com.account.web.action;

import java.io.IOException;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import org.acegisecurity.context.SecurityContextHolder;
import org.apache.struts.action.ActionErrors;
import org.apache.struts.action.ActionForm;
import org.apache.struts.action.ActionForward;
import org.apache.struts.action.ActionMapping;
import org.apache.struts.action.ActionMessage;
import org.apache.struts.actions.DispatchAction;

import com.account.commun.Constantes;
import com.account.commun.Forwards;
import com.account.commun.ImageGrille;
import com.account.commun.SecuriteGrilleGenerator;
import com.account.commun.Sessions;
import com.account.security.service.UserManager;





public class UserAction   extends DispatchAction{
	
	private UserManager userManager;
	public void setUserManager(UserManager userManager) {
		this.userManager = userManager;
	}
	
	public ActionForward authentication(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) throws IOException {
		
		HttpSession session = request.getSession(false);
		int[] grille = SecuriteGrilleGenerator.getGrilleToLogin();
		session.setAttribute(Sessions.GRILLE_LOGIN,grille);
		long timestamp = System.currentTimeMillis();
		SecuriteGrilleGenerator.updateImageWithGrilleToLogin(grille,getServlet().getServletContext().getRealPath("/")+Constantes.GRILLE_URL,getServlet().getServletContext().getRealPath("/cache/")+"/",timestamp);
				
		ImageGrille imG = new ImageGrille();
		imG.setUrl(new Long(timestamp).toString());
		
		session.setAttribute(Sessions.GRILLE_IMAGE, imG);
		return mapping.findForward(Forwards.SHOWLOGINPAGE);
	}
	
	public ActionForward login(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) {
 
		HttpSession session = request.getSession(false);		
		
		
		
		
		return new ActionForward("/Login.do");
	}
	
	public ActionForward error(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) throws IOException {
		ActionErrors erreurs = new ActionErrors();
		HttpSession session = request.getSession(false);
		
		int[] grille = SecuriteGrilleGenerator.getGrilleToLogin();
		session.setAttribute(Sessions.GRILLE_LOGIN,grille);
		long timestamp = System.currentTimeMillis();
		SecuriteGrilleGenerator.updateImageWithGrilleToLogin(grille,getServlet().getServletContext().getRealPath("/")+Constantes.GRILLE_URL,getServlet().getServletContext().getRealPath("/cache/")+"/",timestamp);
				
		ImageGrille imG = new ImageGrille();
		imG.setUrl(new Long(timestamp).toString());
		
		session.setAttribute(Sessions.GRILLE_IMAGE, imG);
		
		erreurs.add("Exception", new ActionMessage("authentication.login.error"));
		saveErrors(request, erreurs);
		
		return mapping.findForward(Forwards.SHOWLOGINPAGE);
	}
	
	public ActionForward logout(ActionMapping mapping,
			ActionForm form, HttpServletRequest request,
			HttpServletResponse response) throws IOException {
		
		HttpSession session = request.getSession(false);
		
		session.invalidate();
		
		return mapping.findForward(Forwards.LOGOUT);
	}
}
