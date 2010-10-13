package com.account.commun.helpers;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.jsp.PageContext;

import org.displaytag.util.RequestHelper;
import org.displaytag.util.RequestHelperFactory;

public class JavascriptRequestHelperFactory implements RequestHelperFactory{

	public JavascriptRequestHelperFactory()
    {
    	
    }

    public RequestHelper getRequestHelperInstance(PageContext pageContext)
    {
        return new JavascriptRequestHelper((HttpServletRequest)pageContext.getRequest(), (HttpServletResponse)pageContext.getResponse());
    }


}
