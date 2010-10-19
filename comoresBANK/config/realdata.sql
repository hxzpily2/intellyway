INSERT INTO ACCOUNT_USER (ID_USER, LOGIN_USER, EMAIL_USER, PASSWORD_USER, NOM, PRENOM) Values (1, 'admin', 'test@test.com', '8cb2237d0679ca88db6464eac60da96345513964', 'TOUCH', 'Alfred');
INSERT INTO ACCOUNT_USER (ID_USER, LOGIN_USER, EMAIL_USER, PASSWORD_USER, NOM, PRENOM) Values (2, 'SAA20000368770', 'test@test.com', '8cb2237d0679ca88db6464eac60da96345513964', 'Mr SAID ALI ABDEREMANE', '');

INSERT INTO ACCOUNT_RIGHTS (ID, LABEL, ID_USER) Values (2, 'ADMIN', 1);
INSERT INTO ACCOUNT_RIGHTS (ID, LABEL, ID_USER) Values (1, 'USER', 2);

INSERT INTO T_CPT (CPT_NUM, CPT_SOLDE, CPT_DATE_SOLDE, CPT_HOLDER_PRENOM) Values ('20000368770', 304559, TO_DATE('10/14/2010 00:00:00', 'MM/DD/YYYY HH24:MI:SS'), 'Mr SAID ALI ABDEREMANE');
INSERT INTO T_CPT (CPT_NUM, CPT_SOLDE, CPT_DATE_SOLDE, CPT_HOLDER_PRENOM) Values ('20000368746', 238809, TO_DATE('10/14/2010 00:00:00', 'MM/DD/YYYY HH24:MI:SS'), 'Mr IBRAHIM  BOINALI');


INSERT INTO COMPTES_USER (CPT_NUM, ID_USER) VALUES ( '20000368770', 2);


INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('121', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '13/10/2010', 'DD/MM/YYYY'), 0 , 150008); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '30/09/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'ESPECES 00000000',  TO_Date( '21/09/2010', 'DD/MM/YYYY'), -500000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('235', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '06/09/2010', 'DD/MM/YYYY'), 0 , 140308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/08/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('914', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '13/08/2010', 'DD/MM/YYYY'), 0 , 137308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/07/2010', 'DD/MM/YYYY'), -189,0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('33', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '09/07/2010', 'DD/MM/YYYY'), 0 , 137308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '30/06/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'ESPECES 00000000',  TO_Date( '14/06/2010', 'DD/MM/YYYY'), -25000,  0); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('33', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '10/06/2010', 'DD/MM/YYYY'), 0 , 137308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/05/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'ESPECES 00000000',  TO_Date( '17/05/2010', 'DD/MM/YYYY'), -600000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('151', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '07/05/2010', 'DD/MM/YYYY'), 0 , 136262); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '30/04/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('32', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '09/04/2010', 'DD/MM/YYYY'), 0 , 136249); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/03/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('43', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '05/03/2010', 'DD/MM/YYYY'), 0 , 140308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '28/02/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('877', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '05/02/2010', 'DD/MM/YYYY'), 0 , 140308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/01/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'ESPECES 00000000',  TO_Date( '22/01/2010', 'DD/MM/YYYY'), -20000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'ESPECES 00000000',  TO_Date( '15/01/2010', 'DD/MM/YYYY'), -30000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/12/2009', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'CHEQUE AU PORTEUR 00000058',  TO_Date( '31/12/2009', 'DD/MM/YYYY'), -20000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('32', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '24/12/2009', 'DD/MM/YYYY'), 0 , 140308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368746', 'ESPECES 00000000',  TO_Date( '17/12/2009', 'DD/MM/YYYY'), -250000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('410', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '01/12/2009', 'DD/MM/YYYY'), 0 , 140308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '30/11/2009', 'DD/MM/YYYY'), -189,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('24', '20000368746', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '07/11/2009', 'DD/MM/YYYY'), 0 , 140308); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('130', '20000368746', 'Frais de tenue de compte',  TO_Date( '31/10/2009', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('92', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '13/10/2010', 'DD/MM/YYYY'), 0 , 301316); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '30/09/2010', 'DD/MM/YYYY'), -189,  0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�119 DU 13/09/10',  TO_Date( '13/09/2010', 'DD/MM/YYYY'), -50000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�118 DU 7/09/10',  TO_Date( '07/09/2010', 'DD/MM/YYYY'), -275000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('206', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '06/09/2010', 'DD/MM/YYYY'),0  , 300176); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6575', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '31/08/2010', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6576', '20000368770', 'Agio de d�couvert',  TO_Date( '31/08/2010', 'DD/MM/YYYY'), -153, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '31/08/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N� 117 DU 18/08/10',  TO_Date( '21/08/2010', 'DD/MM/YYYY'), -750000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'VRMT DU 18/08/10 DE MY HY AN',  TO_Date( '18/08/2010', 'DD/MM/YYYY'),  0, 750000); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�116 DU 14/08/10',  TO_Date( '14/08/2010', 'DD/MM/YYYY'), -300000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('885', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '13/08/2010', 'DD/MM/YYYY'), 0 , 360346); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6389', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '31/07/2010', 'DD/MM/YYYY'), -1000,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6390', '20000368770', 'Agio de d�couvert',  TO_Date( '31/07/2010', 'DD/MM/YYYY'), -236, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '31/07/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�115 DU 16/07/10',  TO_Date( '17/07/2010', 'DD/MM/YYYY'), -50000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�114 DU 14/07/10',  TO_Date( '14/07/2010', 'DD/MM/YYYY'), -25000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�113 DU 12/07/10',  TO_Date( '12/07/2010', 'DD/MM/YYYY'), -305000,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('4', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '09/07/2010', 'DD/MM/YYYY'), 0 , 380017); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DU CHEQUE N�112 DU 02/07/10',  TO_Date( '02/07/2010', 'DD/MM/YYYY'), -45000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '30/06/2010', 'DD/MM/YYYY'), -189,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�111 DU 15/06/10',  TO_Date( '16/06/2010', 'DD/MM/YYYY'), -11000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�110 DU 11/06/10',  TO_Date( '14/06/2010', 'DD/MM/YYYY'), -310000,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('4', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '10/06/2010', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6663', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '31/05/2010', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6664', '20000368770', 'Agio de d�couvert',  TO_Date( '31/05/2010', 'DD/MM/YYYY'), -113, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '31/05/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�109 DU 22/05/10',  TO_Date( '22/05/2010', 'DD/MM/YYYY'), -280000,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('122', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '07/05/2010', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6614', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '30/04/2010', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6615', '20000368770', 'Agio de d�couvert',  TO_Date( '30/04/2010', 'DD/MM/YYYY'), -120,  0); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '30/04/2010', 'DD/MM/YYYY'), -189,  0); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000108',  TO_Date( '27/04/2010', 'DD/MM/YYYY'), -50000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000107',  TO_Date( '20/04/2010', 'DD/MM/YYYY'), -300000,0  ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('4', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '09/04/2010', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6587', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '31/03/2010', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '31/03/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6588', '20000368770', 'Agio de d�couvert',  TO_Date( '31/03/2010', 'DD/MM/YYYY'), -15, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000106',  TO_Date( '29/03/2010', 'DD/MM/YYYY'), -50000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000101',  TO_Date( '09/03/2010', 'DD/MM/YYYY'), -20000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�105 DU 06/03/10',  TO_Date( '08/03/2010', 'DD/MM/YYYY'), -285000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000104',  TO_Date( '06/03/2010', 'DD/MM/YYYY'), -10000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000103',  TO_Date( '06/03/2010', 'DD/MM/YYYY'), -15000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('15', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '05/03/2010', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '28/02/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000102',  TO_Date( '23/02/2010', 'DD/MM/YYYY'), -7500, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'ESPECES 00000000',  TO_Date( '13/02/2010', 'DD/MM/YYYY'), -300000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('849', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '05/02/2010', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '31/01/2010', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000100',  TO_Date( '11/01/2010', 'DD/MM/YYYY'), -25000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N�99 DU 05/01/10',  TO_Date( '06/01/2010', 'DD/MM/YYYY'), -5000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT CHQ N�98 DU 31/12/09',  TO_Date( '31/12/2009', 'DD/MM/YYYY'), -335000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '31/12/2009', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6609', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '31/12/2009', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6610', '20000368770', 'Agio de d�couvert',  TO_Date( '31/12/2009', 'DD/MM/YYYY'), -33, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('4', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '24/12/2009', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000097',  TO_Date( '17/12/2009', 'DD/MM/YYYY'), -200000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000096',  TO_Date( '11/12/2009', 'DD/MM/YYYY'), -3000000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'D�p�t ESPECES ',  TO_Date( '10/12/2009', 'DD/MM/YYYY'), 0 , 3000000); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('389', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '01/12/2009', 'DD/MM/YYYY'), 0 , 330196); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6474', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '30/11/2009', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6475', '20000368770', 'Agio de d�couvert',  TO_Date( '30/11/2009', 'DD/MM/YYYY'), -682, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('146', '20000368770', 'Frais de tenue de compte',  TO_Date( '30/11/2009', 'DD/MM/YYYY'), -189, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'ESPECES 00000000',  TO_Date( '21/11/2009', 'DD/MM/YYYY'), -100000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'CHEQUE AU PORTEUR 00000095',  TO_Date( '13/11/2009', 'DD/MM/YYYY'), -120000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('1', '20000368770', 'DEBIT DE CHQ N 94 DU 09/11/09',  TO_Date( '10/11/2009', 'DD/MM/YYYY'), -50000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('3', '20000368770', 'Versement de salaire - b�n�ficiaire -',  TO_Date( '07/11/2009', 'DD/MM/YYYY'), 0 , 330193); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6671', '20000368770', 'Taxe mensuelle de d�couvert',  TO_Date( '31/10/2009', 'DD/MM/YYYY'), -1000, 0 ); 
INSERT INTO T_TRX ( TRX_NUM, TRX_CPT_NUM, TRX_DESC, TRX_DATE_VALEUR, TRX_MNT_DEBIT,TRX_MNT_CREDIT ) VALUES ('6672', '20000368770', 'Agio de d�couvert',  TO_Date( '31/10/2009', 'DD/MM/YYYY'), -1691, 0 ); 
