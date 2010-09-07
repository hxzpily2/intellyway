package com.account.dao;

import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.hibernate.Criteria;
import org.hibernate.Session;
import org.hibernate.criterion.Expression;
import org.springframework.dao.DataAccessException;
import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.account.security.model.Compte;
import com.account.security.model.User;

public class AccountDAO  extends HibernateDaoSupport{
	public List<Compte> getComptes() {
        
        try {
            logger.info("get User with login: ");
            Session session = getHibernateTemplate().getSessionFactory().getCurrentSession();
            // create a new criteria
            Criteria crit = session.createCriteria(User.class);
            
            
            return session.createQuery("from Compte").list();            
        }
        catch(DataAccessException e) {
            // Critical errors : database unreachable, etc.
            logger.error("Exception - DataAccessException occurs : "+e.getMessage()
                    +" on complete getUser().");
            return null;
        }
    }
}
