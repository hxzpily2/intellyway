package com.account.commun.helpers;

import org.displaytag.util.DefaultHref;

public class JavascriptDefaultHref extends DefaultHref{
	private String searchId;
	private String sortCriterion;
	private  String sortDirection;
	
	public JavascriptDefaultHref(String baseUrl, String searchId, String sortCriterion, String sortDirection)
	{
		super(baseUrl);
		this.searchId = searchId;
		this.sortCriterion = sortCriterion;
		this.sortDirection = sortDirection;		
	}
	
	public String toString() {
				
		if (searchId != null) {			
			String sortCriterionParam = searchId + "_sort";
			if (getParameterMap().get(sortCriterionParam) == null) {			
				String sortDirectionParam = searchId + "_dir";
				addParameter(sortCriterionParam, sortCriterion);
				addParameter(sortDirectionParam, sortDirection);				
			}			
		}		
		String url = super.toString();		
		
		
		return "javascript:commun.sortOrPaginate('" + url + "');";
	}

}
