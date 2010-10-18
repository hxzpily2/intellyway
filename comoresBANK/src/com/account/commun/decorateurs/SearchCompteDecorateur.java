package com.account.commun.decorateurs;

import org.displaytag.decorator.TableDecorator;

import com.account.security.model.Compte;

public class SearchCompteDecorateur extends TableDecorator{
	
		
	public String replaceString(String value) {
		if (value == null)
			return "";
		return value + " ";
	}
	
	public String replaceNull(String value) {
		if (value == null)
			return "";
		return value;
	}
	
	public boolean contains(String[] values, String id) {
		if (values != null && values.length > 0) {
			for (int i = 0; i < values.length; i++) {
				if (values[i].equals(id))
					return true;
			}
		}
		return false;
	}
	
	public void finish() {		
		super.finish();
	}
	
	public String getLienNewUser() {
		Object object = getCurrentRowObject();

		if ( object instanceof Compte){
			if(((Compte) object).getUsersc().size()>0){
				return "<a style=\"font-family: tahoma;font-size: 10pt;\" href=\"/account/application/Home.do?reqCode=userupdate&id="+((Compte) object).getIdCompte()+"\">Modifier</a>";
			}else{
				return "<a style=\"font-family: tahoma;font-size: 10pt;\" href=\"/account/application/Home.do?reqCode=usercreate&id="+((Compte) object).getIdCompte()+"\">Créer</a>";
			}
		}
		return "";
	}
	
	
}
