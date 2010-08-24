package com.account.security.model;


import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.Table;

import org.directwebremoting.annotations.DataTransferObject;
import org.directwebremoting.annotations.RemoteProperty;

@DataTransferObject
@Entity
@Table(name = "rights", catalog = "experiments")
public class Rights implements java.io.Serializable {

	private static final long serialVersionUID = -8905167784828935704L;
	
	private int id;
	private User user;
	private String label;

	public Rights() {
	}

	public Rights(int id, User user, String label) {
		this.id = id;
		this.user = user;
		this.label = label;
	}

	@RemoteProperty
	@Id
	@Column(name = "id", unique = true, nullable = false)
	public int getId() {
		return this.id;
	}

	public void setId(int id) {
		this.id = id;
	}

	@RemoteProperty
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(name = "id_user", nullable = false)
	public User getUser() {
		return this.user;
	}

	public void setUser(User user) {
		this.user = user;
	}

	@RemoteProperty
	@Column(name = "label", nullable = false, length = 45)
	public String getLabel() {
		return this.label;
	}

	public void setLabel(String label) {
		this.label = label;
	}
	
	@Override
	public String toString() {
		return "Rights: [ id: "+id+", label: "+label+"]";
	}

}
