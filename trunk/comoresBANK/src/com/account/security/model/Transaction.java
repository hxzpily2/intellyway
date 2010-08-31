package com.account.security.model;

import java.util.Date;

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
@Table(name = "T_TRX", catalog = "VAD")
public class Transaction {
	private static final long serialVersionUID = -8915698784828935704L;
	
	private int idTrx;	
	private String description;
	private Date dateValeur;	
	private int minDebit;
	private int maxDebit;
	private Compte compte;
	
	
	@RemoteProperty
	@Id
	@Column(name = "trx_num", unique = true, nullable = false, length = 24)
	public int getIdTrx() {
		return idTrx;
	}
	public void setIdTrx(int idTrx) {
		this.idTrx = idTrx;
	}
	
	@RemoteProperty	
	@Column(name = "trx_desc", nullable = true, length = 255)
	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}
	
	@RemoteProperty	
	@Column(name = "trx_date_valeur", nullable = true)
	public Date getDateValeur() {
		return dateValeur;
	}
	public void setDateValeur(Date dateValeur) {
		this.dateValeur = dateValeur;
	}
	
	@RemoteProperty	
	@Column(name = "trx_min_debit", nullable = true)
	public int getMinDebit() {
		return minDebit;
	}
	public void setMinDebit(int minDebit) {
		this.minDebit = minDebit;
	}
	
	@RemoteProperty	
	@Column(name = "trx_max_debit", nullable = true)
	public int getMaxDebit() {
		return maxDebit;
	}
	public void setMaxDebit(int maxDebit) {
		this.maxDebit = maxDebit;
	}
	
	@RemoteProperty
	@ManyToOne(fetch = FetchType.LAZY)
	@JoinColumn(name = "cpt_num", nullable = false)
	public Compte getCompte() {
		return compte;
	}
	public void setCompte(Compte compte) {
		this.compte = compte;
	}
	
	
}
