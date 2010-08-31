package com.account.web.form;

import javax.servlet.http.HttpServletRequest;

import org.apache.struts.action.ActionErrors;
import org.apache.struts.action.ActionForm;
import org.apache.struts.action.ActionMapping;
import org.apache.struts.action.ActionMessage;

public class CreateUserForm extends ActionForm{
	protected String email = null;
    protected String numcompte = null;
    
    
    public String getEmail() {
		return email;
	}


	public void setEmail(String email) {
		this.email = email;
	}


	public String getNumcompte() {
		return numcompte;
	}


	public void setNumcompte(String numcompte) {
		this.numcompte = numcompte;
	}
	
	public ActionErrors validate(ActionMapping mapping,
            HttpServletRequest request)
    {
    	ActionErrors errors = new ActionErrors();
    	
    	
    	if ((numcompte == null))
        {
            errors.add("exception",
                       new ActionMessage("esource.message.erreur.password.obligatoire"));
        }
    	
    	return errors;
    }


	public void reset(ActionMapping mapping, HttpServletRequest request)
    {
        super.reset(mapping, request);

        email = null;
        numcompte = null;
        
    }
}
