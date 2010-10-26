package com.account.security.model;

import java.util.Date;
import java.util.HashSet;
import java.util.Set;

import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.FetchType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.JoinTable;
import javax.persistence.ManyToMany;
import javax.persistence.OneToMany;
import javax.persistence.Table;

import org.directwebremoting.annotations.DataTransferObject;
import org.directwebremoting.annotations.RemoteProperty;

@DataTransferObject
@Entity
@Table(name = "T_CPT"/*, catalog = "SYSTEM"*/)
public class Compte implements Comparable<Compte>{
	private static final long serialVersionUID = 1915698369828935704L;
	
	private long idCompte;
	private String descriptif;
	private float solde;
	private Date dateSolde;
	private String nom;
	private String prenom;
	
	private Set<Transaction> transactions = new HashSet<Transaction>(0);
	private Set<User> usersc = new HashSet<User>(0);
	
	@RemoteProperty
	@Id
	@Column(name = "cpt_num", unique = true, nullable = false, length = 24)
	public long getIdCompte() {
		return idCompte;
	}
	public void setIdCompte(long idCompte) {
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
	
	public int compareTo(Compte arg0) {
		// TODO Auto-generated method stub
		return (new Long(this.idCompte).compareTo(new Long(arg0.idCompte)));
	}
	
	@RemoteProperty
	@ManyToMany( fetch = FetchType.LAZY)
	@JoinTable(name = "COMPTES_USER",joinColumns = { @JoinColumn(name = "CPT_NUM") }, inverseJoinColumns = { @JoinColumn(name = "ID_USER") })
	public Set<User> getUsersc() {
		return usersc;
	}
	public void setUsersc(Set<User> usersc) {
		this.usersc = usersc;
	}
	
	
}
