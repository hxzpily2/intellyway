CREATE TABLE car_accessoire (idacc BIGINT AUTO_INCREMENT, idtypeacc BIGINT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idtypeacc_idx (idtypeacc), PRIMARY KEY(idacc)) ENGINE = INNODB;
CREATE TABLE car_accessoires (id BIGINT AUTO_INCREMENT, idacc BIGINT, idauto BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), INDEX idacc_idx (idacc), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_adress_gar (idadressegar BIGINT AUTO_INCREMENT, idgar BIGINT, idville BIGINT, adresse TEXT NOT NULL, tel1 TEXT NOT NULL, tel2 TEXT NOT NULL, fax TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idville_idx (idville), INDEX idgar_idx (idgar), PRIMARY KEY(idadressegar)) ENGINE = INNODB;
CREATE TABLE car_adress_loc (idadresseloc BIGINT AUTO_INCREMENT, idloc BIGINT, idville BIGINT, adresse TEXT NOT NULL, tel1 TEXT NOT NULL, tel2 TEXT NOT NULL, fax TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idville_idx (idville), INDEX idloc_idx (idloc), PRIMARY KEY(idadresseloc)) ENGINE = INNODB;
CREATE TABLE car_auto (idauto BIGINT AUTO_INCREMENT, idville BIGINT, iduser BIGINT, idmarque BIGINT, idmodele BIGINT, idmoteur BIGINT, idtype BIGINT, idetat BIGINT, idcouleur BIGINT, idcarosserie BIGINT, idboite BIGINT, anneecir BIGINT, moiscir SMALLINT, anneeded BIGINT, moisded SMALLINT, description TEXT, adresse_ip TEXT, visitors BIGINT, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, nbportes SMALLINT, pfiscale SMALLINT, kilometrage BIGINT, cylindres SMALLINT, notedesign SMALLINT, nbnotedesign SMALLINT, noteperf SMALLINT, nbnoteperf SMALLINT, noteconf SMALLINT, nbnoteconf SMALLINT, notecond SMALLINT, nbnotecond SMALLINT, prixstart BIGINT, reprise TINYINT, etranger TINYINT, dedouane TINYINT, garantie TINYINT, urgent TINYINT, nonfumeur TINYINT, garaged TINYINT, hand TINYINT, anneegarantie SMALLINT, title TEXT, source TEXT, telsource1 TEXT, telsource2 TEXT, adresse TEXT, url TEXT, extowner TEXT, active TINYINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idmarque_idx (idmarque), INDEX idmodele_idx (idmodele), INDEX idtype_idx (idtype), INDEX idmoteur_idx (idmoteur), INDEX idetat_idx (idetat), INDEX idcouleur_idx (idcouleur), INDEX idville_idx (idville), PRIMARY KEY(idauto)) ENGINE = INNODB;
CREATE TABLE car_autoprestations (id BIGINT AUTO_INCREMENT, idprestation BIGINT, idauto BIGINT, iduser BIGINT, prix BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), INDEX idprestation_idx (idprestation), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_boite (idboite BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idboite)) ENGINE = INNODB;
CREATE TABLE car_carosserie (idcarosserie BIGINT AUTO_INCREMENT, title TEXT NOT NULL, image VARCHAR(200) NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idcarosserie)) ENGINE = INNODB;
CREATE TABLE car_commentaire (idcommentaire BIGINT, idauto BIGINT, iduser BIGINT, commentaire TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(idcommentaire)) ENGINE = INNODB;
CREATE TABLE car_con (idcon BIGINT, idmarque BIGINT, idville BIGINT, adresse TEXT NOT NULL, tel1 TEXT NOT NULL, tel2 TEXT NOT NULL, fax TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idmarque_idx (idmarque), PRIMARY KEY(idcon, idville)) ENGINE = INNODB;
CREATE TABLE car_couleur (idcouleur BIGINT AUTO_INCREMENT, title TEXT NOT NULL, hexrep VARCHAR(8) NOT NULL, image TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idcouleur)) ENGINE = INNODB;
CREATE TABLE car_creneau (idcrenau BIGINT AUTO_INCREMENT, idauto BIGINT, iduser BIGINT, dated DATETIME NOT NULL, heured SMALLINT, mind SMALLINT, heuref SMALLINT, minf SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(idcrenau)) ENGINE = INNODB;
CREATE TABLE car_creneauprop (idcrenauprop BIGINT, idauto BIGINT, iduser BIGINT, commentaire TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(idcrenauprop)) ENGINE = INNODB;
CREATE TABLE car_encher (idencher BIGINT, idauto BIGINT, iduser BIGINT, prixstart BIGINT, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idencher_idx (idencher), PRIMARY KEY(idauto)) ENGINE = INNODB;
CREATE TABLE car_etat (idetat BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idetat)) ENGINE = INNODB;
CREATE TABLE car_evaluation (id BIGINT AUTO_INCREMENT, idevaluation BIGINT, iduser BIGINT, idauto BIGINT, noteprix BIGINT, notemoteur BIGINT, notekm BIGINT, noteconso BIGINT, noteetat BIGINT, noteoption BIGINT, noteglobal BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idauto_idx (idauto), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_event (idevent BIGINT AUTO_INCREMENT, content TEXT NOT NULL, title TEXT NOT NULL, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, image VARCHAR(200) NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idevent)) ENGINE = INNODB;
CREATE TABLE car_expert (idexpert BIGINT AUTO_INCREMENT, nom TEXT NOT NULL, prenom TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idexpert)) ENGINE = INNODB;
CREATE TABLE car_gar (idgar BIGINT AUTO_INCREMENT, title TEXT NOT NULL, information TEXT NOT NULL, description TEXT NOT NULL, logo TEXT NOT NULL, baniere TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idgar)) ENGINE = INNODB;
CREATE TABLE car_image (idimage BIGINT AUTO_INCREMENT, image VARCHAR(200) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idimage)) ENGINE = INNODB;
CREATE TABLE car_images (idimage BIGINT, idauto BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idimage, idauto)) ENGINE = INNODB;
CREATE TABLE car_loc (idloc BIGINT AUTO_INCREMENT, title TEXT NOT NULL, information TEXT NOT NULL, description TEXT NOT NULL, logo TEXT NOT NULL, baniere TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idloc)) ENGINE = INNODB;
CREATE TABLE car_marque (idmarque BIGINT AUTO_INCREMENT, title TEXT NOT NULL, image TEXT NOT NULL, imagelittle TEXT NOT NULL, information TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, notesav SMALLINT, nbnotesav SMALLINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idmarque)) ENGINE = INNODB;
CREATE TABLE car_message (id BIGINT AUTO_INCREMENT, idmessage BIGINT, iduserfrom BIGINT, iduserto BIGINT, commentaire TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_modele (idmodele BIGINT AUTO_INCREMENT, idmarque BIGINT, title TEXT NOT NULL, description TEXT NOT NULL, notevisiteur SMALLINT, nbnotevisiteur SMALLINT, noteadmin SMALLINT, nbnoteadmin SMALLINT, sanspermis TINYINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idmarque_idx (idmarque), PRIMARY KEY(idmodele)) ENGINE = INNODB;
CREATE TABLE car_moteur (idmoteur BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idmoteur)) ENGINE = INNODB;
CREATE TABLE car_pays (idpays BIGINT AUTO_INCREMENT, title TEXT NOT NULL, devise TEXT NOT NULL, code VARCHAR(2) NOT NULL, bigcode VARCHAR(3) NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idpays)) ENGINE = INNODB;
CREATE TABLE car_prestation (idprestation BIGINT, type TEXT, prix BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idprestation)) ENGINE = INNODB;
CREATE TABLE car_prestations (id BIGINT AUTO_INCREMENT, idprestation BIGINT, iduser BIGINT, prix BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idprestation_idx (idprestation), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_promotion (id BIGINT AUTO_INCREMENT, idpromotion BIGINT, idcon BIGINT, idauto BIGINT, prix BIGINT, datedebut DATETIME NOT NULL, datefin DATETIME NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idcon_idx (idcon), INDEX idauto_idx (idauto), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE car_proposition (idproposition BIGINT, idencher BIGINT, iduser BIGINT, prix BIGINT, accepted TINYINT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idencher_idx (idencher), PRIMARY KEY(idproposition)) ENGINE = INNODB;
CREATE TABLE car_type (idtype BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idtype)) ENGINE = INNODB;
CREATE TABLE car_type_accessoire (idtypeacc BIGINT AUTO_INCREMENT, title TEXT NOT NULL, description TEXT NOT NULL, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(idtypeacc)) ENGINE = INNODB;
CREATE TABLE car_ville (idville BIGINT AUTO_INCREMENT, title TEXT NOT NULL, idpays BIGINT, active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX idpays_idx (idpays), PRIMARY KEY(idville)) ENGINE = INNODB;
CREATE TABLE car_country (iso VARCHAR(2), name VARCHAR(80), printable_name VARCHAR(80), iso3 VARCHAR(3), numcode BIGINT, PRIMARY KEY(iso)) ENGINE = INNODB;
CREATE TABLE car_ipcountry (ip_from BIGINT, ip_to BIGINT, country_code2 VARCHAR(2), country_code3 VARCHAR(2), country_name VARCHAR(50), PRIMARY KEY(ip_from)) ENGINE = INNODB;
CREATE TABLE tag (id BIGINT AUTO_INCREMENT, name VARCHAR(100), is_triple TINYINT(1), triple_namespace VARCHAR(100), triple_key VARCHAR(100), triple_value VARCHAR(100), INDEX name_idx (name), INDEX triple1_idx (triple_namespace), INDEX triple2_idx (triple_key), INDEX triple3_idx (triple_value), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tagging (id BIGINT AUTO_INCREMENT, tag_id BIGINT NOT NULL, taggable_model VARCHAR(30), taggable_id BIGINT, INDEX tag_idx (tag_id), INDEX taggable_idx (taggable_model, taggable_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_access (id BIGINT AUTO_INCREMENT, page_id BIGINT, privilege VARCHAR(100), user_id BIGINT, INDEX pageindex_idx (page_id), INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_area (id BIGINT AUTO_INCREMENT, page_id BIGINT, name VARCHAR(100), culture VARCHAR(7), latest_version BIGINT, INDEX page_index_idx (page_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_area_version (id BIGINT AUTO_INCREMENT, area_id BIGINT, version BIGINT, author_id BIGINT, diff VARCHAR(200), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX area_index_idx (area_id), INDEX author_id_idx (author_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_area_version_slot (id BIGINT AUTO_INCREMENT, slot_id BIGINT, area_version_id BIGINT, permid BIGINT DEFAULT 1, rank BIGINT DEFAULT 1, INDEX area_version_index_idx (area_version_id), INDEX slot_id_idx (slot_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_slot (id BIGINT AUTO_INCREMENT, type VARCHAR(100), variant VARCHAR(100), value LONGTEXT, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_blog_editor (blog_item_id BIGINT, user_id BIGINT, PRIMARY KEY(blog_item_id, user_id)) ENGINE = INNODB;
CREATE TABLE a_blog_item (id BIGINT AUTO_INCREMENT, author_id BIGINT, page_id BIGINT, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, slug_saved TINYINT(1) DEFAULT '0', excerpt TEXT, status VARCHAR(255) DEFAULT 'draft' NOT NULL, allow_comments TINYINT(1) DEFAULT '0' NOT NULL, template VARCHAR(255) DEFAULT 'singleColumnTemplate', published_at DATETIME, type VARCHAR(255), start_date DATE, start_time TIME, end_date DATE, end_time TIME, location TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX a_blog_item_type_idx (type), INDEX author_id_idx (author_id), INDEX page_id_idx (page_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_blog_item_to_category (blog_item_id BIGINT, category_id BIGINT, PRIMARY KEY(blog_item_id, category_id)) ENGINE = INNODB;
CREATE TABLE a_blog_item (id BIGINT AUTO_INCREMENT, author_id BIGINT, page_id BIGINT, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, slug_saved TINYINT(1) DEFAULT '0', excerpt TEXT, status VARCHAR(255) DEFAULT 'draft' NOT NULL, allow_comments TINYINT(1) DEFAULT '0' NOT NULL, template VARCHAR(255) DEFAULT 'singleColumnTemplate', published_at DATETIME, type VARCHAR(255), start_date DATE, start_time TIME, end_date DATE, end_time TIME, location TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX author_id_idx (author_id), INDEX page_id_idx (page_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_category (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_category_group (category_id BIGINT, group_id BIGINT, PRIMARY KEY(category_id, group_id)) ENGINE = INNODB;
CREATE TABLE a_category_user (category_id BIGINT, user_id BIGINT, PRIMARY KEY(category_id, user_id)) ENGINE = INNODB;
CREATE TABLE a_embed_media_account (id BIGINT AUTO_INCREMENT, service VARCHAR(100) NOT NULL, username VARCHAR(100) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_group_access (id BIGINT AUTO_INCREMENT, page_id BIGINT, privilege VARCHAR(100), group_id BIGINT, INDEX pageindex_idx (page_id), INDEX group_id_idx (group_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_lucene_update (id BIGINT AUTO_INCREMENT, page_id BIGINT, culture VARCHAR(7), INDEX page_and_culture_index_idx (page_id, culture), INDEX page_id_idx (page_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_media_item (id BIGINT AUTO_INCREMENT, lucene_dirty TINYINT(1) DEFAULT '0', type VARCHAR(255) NOT NULL, service_url VARCHAR(200), format VARCHAR(10), width BIGINT, height BIGINT, embed TEXT, title VARCHAR(200) NOT NULL, description TEXT, credit VARCHAR(200), owner_id BIGINT, view_is_secure TINYINT(1) DEFAULT '0' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX sluggable_idx (slug), INDEX owner_id_idx (owner_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_media_item_to_category (media_item_id BIGINT, category_id BIGINT, PRIMARY KEY(media_item_id, category_id)) ENGINE = INNODB;
CREATE TABLE a_page (id BIGINT AUTO_INCREMENT, slug TEXT, template VARCHAR(100), view_is_secure TINYINT(1) DEFAULT '0', view_guest TINYINT(1) DEFAULT '1', edit_admin_lock TINYINT(1) DEFAULT '0', view_admin_lock TINYINT(1) DEFAULT '0', published_at DATETIME, archived TINYINT(1), admin TINYINT(1) DEFAULT '0', author_id BIGINT, deleter_id BIGINT, engine VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, lft INT, rgt INT, level SMALLINT, INDEX slugindex_idx (slug(1000)), INDEX engineindex_idx (engine), INDEX author_id_idx (author_id), INDEX deleter_id_idx (deleter_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_page_to_category (page_id BIGINT, category_id BIGINT, PRIMARY KEY(page_id, category_id)) ENGINE = INNODB;
CREATE TABLE a_redirect (id BIGINT AUTO_INCREMENT, page_id BIGINT, slug VARCHAR(255) UNIQUE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX slugindex_idx (slug), INDEX page_id_idx (page_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_slot (id BIGINT AUTO_INCREMENT, type VARCHAR(100), variant VARCHAR(100), value LONGTEXT, INDEX a_slot_type_idx (type), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE a_slot_media_item (media_item_id BIGINT, slot_id BIGINT, PRIMARY KEY(media_item_id, slot_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_forgot_password (id BIGINT AUTO_INCREMENT, user_id BIGINT NOT NULL, unique_key VARCHAR(255), expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id BIGINT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id BIGINT AUTO_INCREMENT, user_id BIGINT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255), last_name VARCHAR(255), email_address VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id BIGINT, group_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id BIGINT, permission_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE car_accessoire ADD CONSTRAINT car_accessoire_idtypeacc_car_type_accessoire_idtypeacc FOREIGN KEY (idtypeacc) REFERENCES car_type_accessoire(idtypeacc);
ALTER TABLE car_accessoires ADD CONSTRAINT car_accessoires_idauto_car_auto_idauto FOREIGN KEY (idauto) REFERENCES car_auto(idauto) ON DELETE CASCADE;
ALTER TABLE car_accessoires ADD CONSTRAINT car_accessoires_idacc_car_accessoire_idacc FOREIGN KEY (idacc) REFERENCES car_accessoire(idacc) ON DELETE CASCADE;
ALTER TABLE car_adress_gar ADD CONSTRAINT car_adress_gar_idville_car_ville_idville FOREIGN KEY (idville) REFERENCES car_ville(idville);
ALTER TABLE car_adress_gar ADD CONSTRAINT car_adress_gar_idgar_car_gar_idgar FOREIGN KEY (idgar) REFERENCES car_gar(idgar) ON DELETE CASCADE;
ALTER TABLE car_adress_loc ADD CONSTRAINT car_adress_loc_idville_car_ville_idville FOREIGN KEY (idville) REFERENCES car_ville(idville);
ALTER TABLE car_adress_loc ADD CONSTRAINT car_adress_loc_idloc_car_loc_idloc FOREIGN KEY (idloc) REFERENCES car_loc(idloc) ON DELETE CASCADE;
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idville_car_ville_idville FOREIGN KEY (idville) REFERENCES car_ville(idville);
ALTER TABLE car_auto ADD CONSTRAINT car_auto_idtype_car_type_idtype FOREIGN KEY (idtype) REFERENCES car_type(idtype);
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
ALTER TABLE a_access ADD CONSTRAINT a_access_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE a_access ADD CONSTRAINT a_access_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_area ADD CONSTRAINT a_area_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_area_version ADD CONSTRAINT a_area_version_author_id_sf_guard_user_id FOREIGN KEY (author_id) REFERENCES sf_guard_user(id) ON DELETE SET NULL;
ALTER TABLE a_area_version ADD CONSTRAINT a_area_version_area_id_a_area_id FOREIGN KEY (area_id) REFERENCES a_area(id) ON DELETE CASCADE;
ALTER TABLE a_area_version_slot ADD CONSTRAINT a_area_version_slot_slot_id_a_slot_id FOREIGN KEY (slot_id) REFERENCES a_slot(id) ON DELETE CASCADE;
ALTER TABLE a_area_version_slot ADD CONSTRAINT a_area_version_slot_area_version_id_a_area_version_id FOREIGN KEY (area_version_id) REFERENCES a_area_version(id) ON DELETE CASCADE;
ALTER TABLE a_blog_editor ADD CONSTRAINT a_blog_editor_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE a_blog_editor ADD CONSTRAINT a_blog_editor_blog_item_id_a_blog_item_id FOREIGN KEY (blog_item_id) REFERENCES a_blog_item(id) ON DELETE CASCADE;
ALTER TABLE a_blog_item ADD CONSTRAINT a_blog_item_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_blog_item ADD CONSTRAINT a_blog_item_author_id_sf_guard_user_id FOREIGN KEY (author_id) REFERENCES sf_guard_user(id) ON DELETE SET NULL;
ALTER TABLE a_blog_item_to_category ADD CONSTRAINT a_blog_item_to_category_category_id_a_category_id FOREIGN KEY (category_id) REFERENCES a_category(id) ON DELETE CASCADE;
ALTER TABLE a_blog_item_to_category ADD CONSTRAINT a_blog_item_to_category_blog_item_id_a_blog_item_id FOREIGN KEY (blog_item_id) REFERENCES a_blog_item(id) ON DELETE CASCADE;
ALTER TABLE a_category_group ADD CONSTRAINT a_category_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE a_category_group ADD CONSTRAINT a_category_group_category_id_a_category_id FOREIGN KEY (category_id) REFERENCES a_category(id) ON DELETE CASCADE;
ALTER TABLE a_category_user ADD CONSTRAINT a_category_user_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE a_category_user ADD CONSTRAINT a_category_user_category_id_a_category_id FOREIGN KEY (category_id) REFERENCES a_category(id) ON DELETE CASCADE;
ALTER TABLE a_group_access ADD CONSTRAINT a_group_access_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_group_access ADD CONSTRAINT a_group_access_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE a_lucene_update ADD CONSTRAINT a_lucene_update_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_media_item ADD CONSTRAINT a_media_item_owner_id_sf_guard_user_id FOREIGN KEY (owner_id) REFERENCES sf_guard_user(id) ON DELETE SET NULL;
ALTER TABLE a_media_item_to_category ADD CONSTRAINT a_media_item_to_category_media_item_id_a_media_item_id FOREIGN KEY (media_item_id) REFERENCES a_media_item(id) ON DELETE CASCADE;
ALTER TABLE a_media_item_to_category ADD CONSTRAINT a_media_item_to_category_category_id_a_category_id FOREIGN KEY (category_id) REFERENCES a_category(id) ON DELETE CASCADE;
ALTER TABLE a_page ADD CONSTRAINT a_page_deleter_id_sf_guard_user_id FOREIGN KEY (deleter_id) REFERENCES sf_guard_user(id) ON DELETE SET NULL;
ALTER TABLE a_page ADD CONSTRAINT a_page_author_id_sf_guard_user_id FOREIGN KEY (author_id) REFERENCES sf_guard_user(id) ON DELETE SET NULL;
ALTER TABLE a_page_to_category ADD CONSTRAINT a_page_to_category_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_page_to_category ADD CONSTRAINT a_page_to_category_category_id_a_category_id FOREIGN KEY (category_id) REFERENCES a_category(id) ON DELETE CASCADE;
ALTER TABLE a_redirect ADD CONSTRAINT a_redirect_page_id_a_page_id FOREIGN KEY (page_id) REFERENCES a_page(id) ON DELETE CASCADE;
ALTER TABLE a_slot_media_item ADD CONSTRAINT a_slot_media_item_slot_id_a_slot_id FOREIGN KEY (slot_id) REFERENCES a_slot(id) ON DELETE CASCADE;
ALTER TABLE a_slot_media_item ADD CONSTRAINT a_slot_media_item_media_item_id_a_media_item_id FOREIGN KEY (media_item_id) REFERENCES a_media_item(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_forgot_password ADD CONSTRAINT sf_guard_forgot_password_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
