package com.account.service;

import java.sql.SQLException;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.apache.commons.logging.Log;
import org.apache.commons.logging.LogFactory;
import org.hibernate.HibernateException;


import com.account.commun.vo.SearchCompteVO;
import com.account.dao.AccountDAO;
import com.account.dao.UserDao;
import com.account.security.model.Compte;
import com.account.security.model.Rights;
import com.account.security.model.Transaction;
import com.account.security.model.User;
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
	
	public List<Compte> getCompteByNum(String num){
		return accountDao.getCompteByNum(num);
	}
	
	public List<Rights> getRightByLib(String lib){
		return accountDao.getRightByLib(lib);
	}
	
	public void saveUser(User user,Rights right) throws HibernateException, SQLException{
		accountDao.saveUser(user,right);
	}
	
	public void saveRight(Rights right){
		accountDao.saveRight(right);
	}
	
	public void updatePass(User user){
		accountDao.updatePass(user);
	}
}
