CREATE TABLE car_accessoire (idacc BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idacc)) ENGINE = INNODB;
CREATE TABLE car_accessoires (id BIGINT AUTO_INCREMENT, idacc BIGINT, idauto BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), INDEX idacc_idx (idacc), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_adress_gar (idadressegar BIGINT AUTO_INCREMENT, idgar BIGINT, idville BIGINT, adresse TEXT NOT NULL, tel1 TEXT NOT NULL, tel2 TEXT NOT NULL, fax TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idville_idx (idville), INDEX idgar_idx (idgar), PRIMARY KEY(idadressegar)) ENGINE = INNODB;
CREATE TABLE car_auto (idauto BIGINT AUTO_INCREMENT, idpays BIGINT, idmarque BIGINT, idmodele BIGINT, idmoteur BIGINT, idtype BIGINT, idetat BIGINT, idcouleur BIGINT, idcarosserie BIGINT, idboite BIGINT, anneecir BIGINT, moiscir SMALLINT, anneeded BIGINT, moisded SMALLINT, description TEXT NOT NULL, adresse_ip TEXT NOT NULL, visitors BIGINT, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, nbportes SMALLINT, pfiscale SMALLINT, kilometrage SMALLINT, cylindres SMALLINT, notedesign SMALLINT, nbnotedesign SMALLINT, noteperf SMALLINT, nbnoteperf SMALLINT, noteconf SMALLINT, nbnoteconf SMALLINT, notecond SMALLINT, nbnotecond SMALLINT, prixstart BIGINT, reprise TINYINT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idmarque_idx (idmarque), INDEX idmodele_idx (idmodele), INDEX idtype_idx (idtype), INDEX idmoteur_idx (idmoteur), INDEX idetat_idx (idetat), INDEX idcouleur_idx (idcouleur), INDEX idpays_idx (idpays), PRIMARY KEY(idauto)) ENGINE = INNODB;
CREATE TABLE car_autoprestations (id BIGINT AUTO_INCREMENT, idprestation BIGINT, idauto BIGINT, iduser BIGINT, prix BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), INDEX idprestation_idx (idprestation), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_boite (idboite BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idboite)) ENGINE = INNODB;
CREATE TABLE car_carosserie (idcarosserie BIGINT AUTO_INCREMENT, title TEXT NOT NULL, image VARCHAR(200) NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idcarosserie)) ENGINE = INNODB;
CREATE TABLE car_commentaire (idcommentaire BIGINT, idauto BIGINT, iduser BIGINT, commentaire TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(idcommentaire)) ENGINE = INNODB;
CREATE TABLE car_con (idcon BIGINT, idmarque BIGINT, idville BIGINT, adresse TEXT NOT NULL, tel1 TEXT NOT NULL, tel2 TEXT NOT NULL, fax TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idmarque_idx (idmarque), PRIMARY KEY(idcon, idville)) ENGINE = INNODB;
CREATE TABLE car_couleur (idcouleur BIGINT AUTO_INCREMENT, title TEXT NOT NULL, hexrep VARCHAR(8) NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idcouleur)) ENGINE = INNODB;
CREATE TABLE car_creneau (idcrenau BIGINT AUTO_INCREMENT, idauto BIGINT, iduser BIGINT, dated DATETIME NOT NULL, heured SMALLINT, mind SMALLINT, heuref SMALLINT, minf SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(idcrenau)) ENGINE = INNODB;
CREATE TABLE car_creneauprop (idcrenauprop BIGINT, idauto BIGINT, iduser BIGINT, commentaire TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(idcrenauprop)) ENGINE = INNODB;
CREATE TABLE car_encher (idencher BIGINT, idauto BIGINT, iduser BIGINT, prixstart BIGINT, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idencher_idx (idencher), PRIMARY KEY(idauto)) ENGINE = INNODB;
CREATE TABLE car_etat (idetat BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idetat)) ENGINE = INNODB;
CREATE TABLE car_evaluation (id BIGINT AUTO_INCREMENT, idevaluation BIGINT, iduser BIGINT, idauto BIGINT, noteprix BIGINT, notemoteur BIGINT, notekm BIGINT, noteconso BIGINT, noteetat BIGINT, noteoption BIGINT, noteglobal BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_event (idevent BIGINT AUTO_INCREMENT, content TEXT NOT NULL, title TEXT NOT NULL, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, image VARCHAR(200) NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idevent)) ENGINE = INNODB;
CREATE TABLE car_expert (idexpert BIGINT AUTO_INCREMENT, nom TEXT NOT NULL, prenom TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idexpert)) ENGINE = INNODB;
CREATE TABLE car_gar (idgar BIGINT AUTO_INCREMENT, title TEXT NOT NULL, information TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idgar)) ENGINE = INNODB;
CREATE TABLE car_image (idimage BIGINT AUTO_INCREMENT, image VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idimage)) ENGINE = INNODB;
CREATE TABLE car_images (idimage BIGINT, idauto BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idimage, idauto)) ENGINE = INNODB;
CREATE TABLE car_marque (idmarque BIGINT AUTO_INCREMENT, title TEXT NOT NULL, image TEXT NOT NULL, imagelittle TEXT NOT NULL, information TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, notesav SMALLINT, nbnotesav SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idmarque)) ENGINE = INNODB;
CREATE TABLE car_message (id BIGINT AUTO_INCREMENT, idmessage BIGINT, iduserfrom BIGINT, iduserto BIGINT, commentaire TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_modele (idmodele BIGINT AUTO_INCREMENT, idmarque BIGINT, title TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idmarque_idx (idmarque), PRIMARY KEY(idmodele)) ENGINE = INNODB;
CREATE TABLE car_moteur (idmoteur BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idmoteur)) ENGINE = INNODB;
CREATE TABLE car_pays (idpays BIGINT AUTO_INCREMENT, title TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idpays)) ENGINE = INNODB;
CREATE TABLE car_prestation (idprestation BIGINT, type TEXT, prix BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idprestation)) ENGINE = INNODB;
CREATE TABLE car_prestations (id BIGINT AUTO_INCREMENT, idprestation BIGINT, iduser BIGINT, prix BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idprestation_idx (idprestation), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_promotion (id BIGINT AUTO_INCREMENT, idpromotion BIGINT, idcon BIGINT, idauto BIGINT, prix BIGINT, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idcon_idx (idcon), INDEX idauto_idx (idauto), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_proposition (idproposition BIGINT, idencher BIGINT, iduser BIGINT, prix BIGINT, accepted TINYINT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idencher_idx (idencher), PRIMARY KEY(idproposition)) ENGINE = INNODB;
CREATE TABLE car_type (idtype BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idtype)) ENGINE = INNODB;
CREATE TABLE car_ville (idville BIGINT AUTO_INCREMENT, title TEXT NOT NULL, idpays BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idpays_idx (idpays), PRIMARY KEY(idville)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id, ip_address)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, username VARCHAR(128) NOT NULL UNIQUE, soldeannonce SMALLINT, soldeproposition SMALLINT, soldeencher SMALLINT, soldeexpert SMALLINT, nom TEXT, prenom TEXT, mail TEXT, tel TEXT, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', newsletter TINYINT(1) DEFAULT '1', offre TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE car_accessoires ADD CONSTRAINT car_accessoires_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_accessoires ADD CONSTRAINT car_accessoires_idacc_car_accessoire_idacc FOREIGN KEY (idacc) REFERENCES car_accessoire(idacc) ON DELETE CASCADE;
ALTER TABLE car_adress_gar ADD CONSTRAINT car_adress_gar_idville_car_ville_idville FOREIGN KEY (idville) REFERENCES car_ville(idville);
ALTER TABLE car_adress_gar ADD CONSTRAINT car_adress_gar_idgar_car_gar_idgar FOREIGN KEY (idgar) REFERENCES car_gar(idgar) ON DELETE CASCADE;
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idtype_car_type_idtype FOREIGN KEY (idtype) REFERENCES car_type(idtype);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idpays_car_pays_idpays FOREIGN KEY (idpays) REFERENCES car_pays(idpays);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idmoteur_car_moteur_idmoteur FOREIGN KEY (idmoteur) REFERENCES car_moteur(idmoteur);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idmodele_car_modele_idmodele FOREIGN KEY (idmodele) REFERENCES car_modele(idmodele);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idmarque_car_marque_idmarque FOREIGN KEY (idmarque) REFERENCES car_marque(idmarque);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idetat_car_etat_idetat FOREIGN KEY (idetat) REFERENCES car_etat(idetat);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idcouleur_car_couleur_idcouleur FOREIGN KEY (idcouleur) REFERENCES car_couleur(idcouleur);
ALTER TABLE car_autoprestations ADD CONSTRAINT car_autoprestations_idprestation_car_prestation_idprestation FOREIGN KEY (idprestation) REFERENCES car_prestation(idprestation) ON DELETE CASCADE;
ALTER TABLE car_autoprestations ADD CONSTRAINT car_autoprestations_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_commentaire ADD CONSTRAINT car_commentaire_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_con ADD CONSTRAINT car_con_idville_car_ville_idville FOREIGN KEY (idville) REFERENCES car_ville(idville);
ALTER TABLE car_con ADD CONSTRAINT car_con_idmarque_car_marque_idmarque FOREIGN KEY (idmarque) REFERENCES car_marque(idmarque) ON DELETE CASCADE;
ALTER TABLE car_con ADD CONSTRAINT car_con_idcon_car_promotion_idcon FOREIGN KEY (idcon) REFERENCES car_promotion(idcon);
ALTER TABLE car_creneau ADD CONSTRAINT car_creneau_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_creneauprop ADD CONSTRAINT car_creneauprop_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_evaluation ADD CONSTRAINT car_evaluation_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_images ADD CONSTRAINT car_images_idimage_car_image_idimage FOREIGN KEY (idimage) REFERENCES car_image(idimage) ON DELETE CASCADE;
ALTER TABLE car_images ADD CONSTRAINT car_images_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_modele ADD CONSTRAINT car_modele_idmarque_car_marque_idmarque FOREIGN KEY (idmarque) REFERENCES car_marque(idmarque) ON DELETE CASCADE;
ALTER TABLE car_prestations ADD CONSTRAINT car_prestations_idprestation_car_prestation_idprestation FOREIGN KEY (idprestation) REFERENCES car_prestation(idprestation) ON DELETE CASCADE;
ALTER TABLE car_promotion ADD CONSTRAINT car_promotion_idcon_car_con_idcon FOREIGN KEY (idcon) REFERENCES car_con(idcon) ON DELETE CASCADE;
ALTER TABLE car_promotion ADD CONSTRAINT car_promotion_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_proposition ADD CONSTRAINT car_proposition_idencher_car_encher_idencher FOREIGN KEY (idencher) REFERENCES car_encher(idencher) ON DELETE CASCADE;
ALTER TABLE car_ville ADD CONSTRAINT car_ville_idpays_car_pays_idpays FOREIGN KEY (idpays) REFERENCES car_pays(idpays) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
