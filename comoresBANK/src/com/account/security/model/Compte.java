package com.account.security.model;

import java.util.Date;
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
@Table(name = "T_CPT", catalog = "VAD")
public class Compte implements Comparable<Compte>{
	private static final long serialVersionUID = 1915698369828935704L;
	
	private int idCompte;
	private String descriptif;
	private float solde;
	private Date dateSolde;
	private String nom;
	private String prenom;
	private Set<User> users = new HashSet<User>(0);
	
	private Set<Transaction> transactions = new HashSet<Transaction>(0);
	
	
	@RemoteProperty
	@Id
	@Column(name = "cpt_num", unique = true, nullable = false, length = 24)
	public int getIdCompte() {
		return idCompte;
	}
	public void setIdCompte(int idCompte) {
		this.idCompte = idCompte;
	}
	
	@RemoteProperty	
	@Column(name = "cpt_desc", nullable = true, length = 24)
	public String getDescriptif() {
		return descriptif;
	}
	public void setDescriptif(String descriptif) {
		this.descriptif = descriptif;
	}
	
	@RemoteProperty	
	@Column(name = "cpt_solde", nullable = true)
	public float getSolde() {
		return solde;
	}
	public void setSolde(float solde) {
		this.solde = solde;
	}
	
	@RemoteProperty	
	@Column(name = "cpt_date_solde", nullable = true)
	public Date getDateSolde() {
		return dateSolde;
	}
	public void setDateSolde(Date dateSolde) {
		this.dateSolde = dateSolde;
	}
	
	@RemoteProperty	
	@Column(name = "cpt_holder_nom", nullable = true, length = 24)
	public String getNom() {
		return nom;
	}
	public void setNom(String nom) {
		this.nom = nom;
	}
	
	@RemoteProperty	
	@Column(name = "cpt_holder_prenom", nullable = true, length = 24)
	public String getPrenom() {
		return prenom;
	}
	public void setPrenom(String prenom) {
		this.prenom = prenom;
	}
	
	@RemoteProperty
	@OneToMany(cascade = CascadeType.ALL, fetch = FetchType.LAZY, mappedBy = "compte")
	public Set<Transaction> getTransactions() {
		return transactions;
	}
	public void setTransactions(Set<Transaction> transactions) {
		this.transactions = transactions;
	}
	
	@RemoteProperty
	@OneToMany(cascade = CascadeType.ALL, fetch = FetchType.LAZY, mappedBy = "cptNum")
	public Set<User> getUsers() {
		return users;
	}
	public void setUsers(Set<User> users) {
		this.users = users;
	}
	public int compareTo(Compte arg0) {
		// TODO Auto-generated method stub
		return (new Integer(this.idCompte).compareTo(new Integer(arg0.idCompte)));
	}
	
	
}
