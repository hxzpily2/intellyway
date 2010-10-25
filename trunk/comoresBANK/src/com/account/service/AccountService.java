package com.account.service;

import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;


import com.account.commun.vo.SearchCompteVO;
import com.account.dao.AccountDAO;
import com.account.dao.UserDao;
import com.account.security.model.Compte;
import com.account.security.model.Transaction;
import com.account.security.service.UserManagerImpl;

public class AccountService {
	private final Log logger = LogFactory.getLog(AccountService.class);
    
    private AccountDAO accountDao = null;
    
	public AccountDAO getAccountDao() {
		return accountDao;
	}

	public void setAccountDao(AccountDAO accountDao) {
		this.accountDao = accountDao;
	}

	public Set<Transaction> getTrasactions(){
		return new HashSet<Transaction>();
	}
	
	public List<Compte> getComptes(){
		return accountDao.getComptes();
	}
	
	public List<Compte> searchComptes(SearchCompteVO scVO){
		return accountDao.searchComptes(scVO);
	}
}
