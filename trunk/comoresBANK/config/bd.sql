
CREATE TABLE ACCOUNT_USER
(
  ID_USER    NUMBER,
  LOGIN_USER   VARCHAR2(50 BYTE),
  PASSWORD_USER  VARCHAR2(100 BYTE)  
);


CREATE UNIQUE INDEX PK_USER ON ACCOUNT_USER (ID_USER);

DROP SEQUENCE VAD.SEQ_USER;

CREATE SEQUENCE VAD.SEQ_USER
  START WITH 1
  MAXVALUE 9999999999
  MINVALUE 0
  NOCYCLE
  NOCACHE
  NOORDER;

CREATE OR REPLACE TRIGGER TRG_USER
BEFORE INSERT
ON ACCOUNT_USER
REFERENCING NEW AS NEW OLD AS OLD
FOR EACH ROW
DECLARE
tmpVar NUMBER;

BEGIN
   tmpVar := 0;

   SELECT SEQ_USER.NEXTVAL INTO tmpVar FROM dual;
   :NEW.ID_USER := tmpVar;

END TRG_USER;
/




ALTER TABLE ACCOUNT_USER ADD ( CONSTRAINT PK_USER PRIMARY KEY (ID_USER) USING INDEX );


NSERT INTO user VALUES (NULL,'test', 'test');

CREATE TABLE ACCOUNT_RIGHTS
(
  ID    NUMBER,
  LABEL   VARCHAR2(50 BYTE),
  ID_USER  NUMBER  
);	

CREATE UNIQUE INDEX PK_RIGHTS ON ACCOUNT_RIGHTS (ID);


DROP SEQUENCE VAD.SEQ_RIGHTS;

CREATE SEQUENCE VAD.SEQ_RIGHTS
  START WITH 1
  MAXVALUE 9999999999
  MINVALUE 0
  NOCYCLE
  NOCACHE
  NOORDER;

CREATE OR REPLACE TRIGGER TRG_RIGHTS
BEFORE INSERT
ON ACCOUNT_RIGHTS
REFERENCING NEW AS NEW OLD AS OLD
FOR EACH ROW
DECLARE
tmpVar NUMBER;

BEGIN
   tmpVar := 0;

   SELECT SEQ_RIGHTS.NEXTVAL INTO tmpVar FROM dual;
   :NEW.ID := tmpVar;

END TRG_RIGHTS;
/  

ALTER TABLE ACCOUNT_RIGHTS ADD ( CONSTRAINT PK_RIGHTS PRIMARY KEY (ID) USING INDEX );
ALTER TABLE ACCOUNT_RIGHTS ADD ( CONSTRAINT PK_RIGHTS_FK FOREIGN KEY (ID_USER) REFERENCES ACCOUNT_USER (ID_USER) );

INSERT INTO ACCOUNT_RIGHTS (label, id_user) VALUES ('USER', 1);
INSERT INTO ACCOUNT_RIGHTS (label, id_user) VALUES ('ADMIN', 1);
