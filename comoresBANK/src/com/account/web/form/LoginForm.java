package com.account.web.form;

import javax.servlet.http.HttpServletRequest;

import org.apache.struts.action.ActionErrors;
import org.apache.struts.action.ActionForm;
import org.apache.struts.action.ActionMapping;
import org.apache.struts.action.ActionMessage;

public class LoginForm extends ActionForm{
	protected String login = null;
    protected String password = null;
    
    public ActionErrors validate(ActionMapping mapping,
            HttpServletRequest request)
    {
    	ActionErrors errors = new ActionErrors();
    	if ((login == null) || (login.length() < 1))
        {
            errors.add("exception",
                       new ActionMessage("esource.message.erreur.login.obligatoire"));
        }
    	
    	if ((password == null) || (password.length() < 1)
                || (password.length() < 7))
        {
            errors.add("exception",
                       new ActionMessage("esource.message.erreur.password.obligatoire"));
        }
    	
    	return errors;
    }
    
    /**
     * Get du champ login
     * @return String - le login utilisateur
     */
    public String getLogin()
    {
        return login;
    }

	/**
	  * Set le champ login
	  * @param String - la nouvelle valeur du login
	  */
    public void setLogin(String login)
    {
        this.login = login;
    }
    
    
    public String getPassword()
    {
        return password;
    }

    
    public void setPassword(String password)
    {
        this.password = password;
    }
    
    public void reset(ActionMapping mapping, HttpServletRequest request)
    {
        super.reset(mapping, request);

        login = null;
        password = null;
        
    }
}
