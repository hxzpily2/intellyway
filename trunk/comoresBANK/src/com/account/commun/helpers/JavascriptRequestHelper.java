package com.account.commun.helpers;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.displaytag.util.DefaultRequestHelper;
import org.displaytag.util.Href;

public class JavascriptRequestHelper extends DefaultRequestHelper {

	private HttpServletRequest request;
	private HttpServletResponse response;

	public JavascriptRequestHelper(HttpServletRequest servletRequest,
			HttpServletResponse servletResponse) {
		super(servletRequest, servletResponse);
		request = servletRequest;
		response = servletResponse;
	}
	
	public Href getHref()
	 {
		 
		 String requestURI = request.getRequestURI();
		 /**
		  * Search sort request parameter (if exclude="*" )
		  */
		 String searchId = request.getParameter("searchid");
		 String	sortCriterion = null;
		 String	sortDirection = null;
		 if (searchId != null) {
			 // Sort criterion
			 sortCriterion = (String)request.getParameter(searchId + "_sort");
			// Sort direction
			sortDirection = (String)request.getParameter(searchId + "_dir");			
		 }
		 
       Href href = new JavascriptDefaultHref(requestURI, searchId, sortCriterion, sortDirection);
       href.setParameterMap(getParameterMap());
       return href;
	 }

}
