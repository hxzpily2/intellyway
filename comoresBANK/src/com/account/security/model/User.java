package com.account.security.model;

// Generated 7 août 2007 14:54:35 by Hibernate Tools 3.2.0.b9

import java.util.HashSet;
import java.util.Set;

import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Id;
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
	private Set<Rights> rights = new HashSet<Rights>(0);

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
	@OneToMany(cascade = CascadeType.ALL, fetch = FetchType.LAZY, mappedBy = "user")
	public Set<Rights> getRights() {
		return this.rights;
	}

	public void setRights(Set<Rights> rights) {
		this.rights = rights;
	}

	@Override
	public String toString() {
		return "User: [id: "+idUser+",login: "+loginUser+", rights: "+rights+"]";
	}
	
	

}
