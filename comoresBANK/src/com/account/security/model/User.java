package com.account.security.model;

// Generated 7 août 2007 14:54:35 by Hibernate Tools 3.2.0.b9

import java.util.Date;
import java.util.HashSet;
import java.util.Map;
import java.util.Set;

import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.JoinTable;
import javax.persistence.ManyToMany;
import javax.persistence.ManyToOne;
import javax.persistence.OneToMany;
import javax.persistence.Table;

import org.directwebremoting.annotations.DataTransferObject;
import org.directwebremoting.annotations.RemoteProperty;

@DataTransferObject
@Entity
@Table(name = "ACCOUNT_USER", catalog = "VAD")
public class User implements java.io.Serializable {

	private static final long serialVersionUID = 1073256708139002061L;
	
	private int idUser;
	private String loginUser;
	private String passwordUser;
	private String email;
	private Compte cptNum;
	private Date dateCreation;
	private Date lastLogin;
	
	private String nom;
	private String prenom;
	
	
	private Set<Rights> rights = new HashSet<Rights>(0);
	private Set<Compte> comptes = new HashSet<Compte>(0);

	

	public User() {
	}

	public User(int idUser, String loginUser, String passwordUser) {
		this.idUser = idUser;
		this.loginUser = loginUser;
		this.passwordUser = passwordUser;
	}

	public User(int idUser, String loginUser, String passwordUser,
			Set<Rights> rights) {
		this.idUser = idUser;
		this.loginUser = loginUser;
		this.passwordUser = passwordUser;
		this.rights = rights;
	}

	@RemoteProperty
	@Id
	@Column(name = "id_user", unique = true, nullable = false)
	public int getIdUser() {
		return this.idUser;
	}

	public void setIdUser(int idUser) {
		this.idUser = idUser;
	}

	@RemoteProperty
	@Column(name = "login_user", nullable = false, length = 25)
	public String getLoginUser() {
		return this.loginUser;
	}

	public void setLoginUser(String loginUser) {
		this.loginUser = loginUser;
	}

	@RemoteProperty
	@Column(name = "password_user", nullable = false, length = 25)
	public String getPasswordUser() {
		return this.passwordUser;
	}

	public void setPasswordUser(String passwordUser) {
		this.passwordUser = passwordUser;
	}
	
	@RemoteProperty
	@Column(name = "email_user", nullable = true, length = 50)
	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}
	
	@RemoteProperty
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(name = "cpt_num", nullable = false)
	public Compte getCptNum() {
		return cptNum;
	}

	public void setCptNum(Compte cptNum) {
		this.cptNum = cptNum;
	}
	
	@RemoteProperty
	@Column(name = "date_creation", nullable = true)
	public Date getDateCreation() {
		return dateCreation;
	}

	public void setDateCreation(Date dateCreation) {
		this.dateCreation = dateCreation;
	}
	
	@RemoteProperty
	@Column(name = "last_login", nullable = true)
	public Date getLastLogin() {
		return lastLogin;
	}

	public void setLastLogin(Date lastLogin) {
		this.lastLogin = lastLogin;
	}

	@RemoteProperty
	@OneToMany(cascade = CascadeType.ALL, fetch = FetchType.LAZY, mappedBy = "user")
	public Set<Rights> getRights() {
		return this.rights;
	}

	public void setRights(Set<Rights> rights) {
		this.rights = rights;
	}
	
	///////////////////////////////
	@RemoteProperty
	@ManyToMany(cascade = CascadeType.ALL, fetch = FetchType.LAZY)
	@JoinTable(name = "COMPTES_USER",joinColumns = { @JoinColumn(name = "ID_USER") }, inverseJoinColumns = { @JoinColumn(name = "CPT_NUM") })
	public Set<Compte> getComptes() {
		return comptes;
	}

	public void setComptes(Set<Compte> comptes) {
		this.comptes = comptes;
	}
    //////////////////////
	
	
	
	@Override
	public String toString() {
		return "User: [id: "+idUser+",login: "+loginUser+", rights: "+rights+"]";
	}

	public String getNom() {
		return nom;
	}

	public void setNom(String nom) {
		this.nom = nom;
	}

	public String getPrenom() {
		return prenom;
	}

	public void setPrenom(String prenom) {
		this.prenom = prenom;
	}
	

}
