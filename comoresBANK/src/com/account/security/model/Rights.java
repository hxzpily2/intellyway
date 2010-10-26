package com.account.security.model;


import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.SequenceGenerator;
import javax.persistence.Table;

import org.directwebremoting.annotations.DataTransferObject;
import org.directwebremoting.annotations.RemoteProperty;

@DataTransferObject
@Entity
@SequenceGenerator(name="right_seq", sequenceName="SEQ_RIGHTS",allocationSize = 1)
@Table(name = "ACCOUNT_RIGHTS"/*, catalog = "SYSTEM"*/)
public class Rights implements java.io.Serializable {

	private static final long serialVersionUID = -8905167784828935704L;
	
	private Integer id;
	private User user;
	private String label;
	private String I18nkey;

	

	public Rights() {
	}

	public Rights(Integer id, User user, String label) {
		this.id = id;
		this.user = user;
		this.label = label;
	}

	@RemoteProperty
	@Id	
	@GeneratedValue(strategy = GenerationType.SEQUENCE ,generator="right_seq")
	@Column(name = "id", unique = true, nullable = false)
	public Integer getId() {
		return this.id;
	}

	public void setId(Integer id) {
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
	
	@RemoteProperty
	@Column(name = "i18nkey", nullable = false, length = 100)
	public String getI18nkey() {
		return I18nkey;
	}

	public void setI18nkey(String i18nkey) {
		I18nkey = i18nkey;
	}
	
	@Override
	public String toString() {
		return "Rights: [ id: "+id+", label: "+label+"]";
	}

}
