package com.account.commun.decorateurs;

import java.text.NumberFormat;

import org.displaytag.decorator.TableDecorator;

import com.account.security.model.Transaction;

public class CurrencyDecorateur extends TableDecorator {
	
	public String getMntCredit() {
        Transaction row = (Transaction) getCurrentRowObject();
        NumberFormat nf = NumberFormat.getCurrencyInstance();
        return (nf.format(new Integer(row.getMntCredit())).toString());
    }

}
