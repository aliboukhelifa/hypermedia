CREATE EXTENSION pgcrypto;

CREATE TABLE account (
	user_id serial PRIMARY KEY,
	email VARCHAR ( 255 ) UNIQUE NOT NULL,
	password TEXT NOT NULL,
        role varchar(100)
);

INSERT INTO account (email, password, role) VALUES (
  'ali@gmail.com',
  crypt('ali', gen_salt('bf')), 'admin');


CREATE TABLE files (id serial, nom varchar(255), type varchar(100), path varchar(255), size int) 