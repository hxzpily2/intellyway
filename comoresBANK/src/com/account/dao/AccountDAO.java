package com.account.dao;

import java.sql.SQLException;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.hibernate.Criteria;
import org.hibernate.HibernateException;
import org.hibernate.Session;
import org.hibernate.criterion.Expression;
import org.springframework.dao.DataAccessException;
import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.account.commun.vo.SearchCompteVO;
import com.account.security.model.Compte;
import com.account.security.model.Rights;
import com.account.security.model.User;

public class AccountDAO extends HibernateDaoSupport {
	public List<Compte> getComptes() {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory()
					.getCurrentSession();
			// create a new criteria
			Criteria crit = session.createCriteria(User.class);

			return session.createQuery("from Compte").list();
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			return null;
		}
	}

	public List<Compte> searchComptes(SearchCompteVO scVO) {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory()
					.getCurrentSession();
			// create a new criteria
			Criteria crit = session.createCriteria(User.class);

			String sql = "from Compte as compte where 1=1 ";
			if (scVO.getNom() != "")
				sql += " and compte.nom like '%" + scVO.getNom() + "%' ";
			if (scVO.getPrenom() != "")
				sql += " and compte.prenom like '%" + scVO.getPrenom() + "%' ";			
			
			if (scVO.getNumcompte() != ""){
				sql += " and compte.idCompte like '%" + scVO.getNumcompte()  + "%' ";
			}
			return session.createQuery(sql).list();
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			return null;
		}
	}

	public List<Compte> getCompteByNum(String num) {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory()
					.getCurrentSession();
			// create a new criteria
			Criteria crit = session.createCriteria(Compte.class);

			String sql = "from Compte as compte where compte.idCompte = " + num;

			return session.createQuery(sql).list();
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			return null;
		}
	}

	public List<Rights> getRightByLib(String lib) {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory()
					.getCurrentSession();
			// create a new criteria
			Criteria crit = session.createCriteria(Rights.class);

			String sql = "from Rights as right where right.label like '%" + lib
					+ "%'";

			return session.createQuery(sql).list();
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			return null;
		}
	}

	public void saveUser(User user,Rights right) throws HibernateException, SQLException {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory().openSession();
					
			session.beginTransaction();

			
			session.save(user);
			
			
			
			
			session.getTransaction().commit();
			session.refresh(user);
			
			session.close();

			
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			
		}
	}
	
	public void saveRight(Rights right) {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory()
					.getCurrentSession();
			session.save(right);
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			
		}
	}
	
	public void updatePass(User user) {

		try {
			logger.info("get User with login: ");
			Session session = getHibernateTemplate().getSessionFactory().openSession();
			
			session.beginTransaction();
			
			User temp = (User) session.get(User.class,user.getIdUser());
			temp.setPasswordUser(user.getPasswordUser());
			session.update(temp);
			
			session.getTransaction().commit();
			session.close();
		} catch (DataAccessException e) {
			// Critical errors : database unreachable, etc.
			logger.error("Exception - DataAccessException occurs : "
					+ e.getMessage() + " on complete getUser().");
			
		}
	}

}
