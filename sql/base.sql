-- CREATE DATABASE race;
-- \c race;

CREATE TABLE admin (
    id_admin SERIAL PRIMARY KEY,
    nom VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE equipe (
    id_equipe SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE categorie (
    id_categorie SERIAL PRIMARY KEY,
    nom_categorie VARCHAR(50) NOT NULL
);

CREATE TABLE coureur (
    id_coureur SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    numero_dossard INT UNIQUE NOT NULL,
    genre VARCHAR(10) NOT NULL,
    dtn DATE NOT NULL,
    id_equipe INT NOT NULL,
    FOREIGN KEY (id_equipe) REFERENCES equipe(id_equipe)
);

create table coureur_categorie(
    id_coureur_categorie SERIAL PRIMARY KEY,
	id_coureur int,
	id_categorie int,
	FOREIGN KEY (id_coureur) REFERENCES coureur (id_coureur),
	FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie)
);


CREATE TABLE etape (
    id_etape SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    distance_km FLOAT NOT NULL,
    nb_coureur_equipe INT NOT NULL,
    rang_etape INT NOT NULL,
    date_debut TIMESTAMP NOT NULL
);

CREATE TABLE penalite (
	id_penalite SERIAL PRIMARY KEY,
    id_etape int not null,
    id_equipe int NOT NULL,
    penalite time,
	FOREIGN key (id_etape) REFERENCES etape(id_etape),
	FOREIGN key (id_equipe) REFERENCES equipe(id_equipe)
);
alter table penalite add UNIQUE (id_etape, id_equipe);

CREATE TABLE participation (
    id_participation SERIAL PRIMARY KEY,
    id_coureur INT NOT NULL,
    id_etape INT NOT NULL,
    heure_depart TIMESTAMP,
    heure_arrivee TIMESTAMP,
    penalite_secondes INT DEFAULT 0,
    FOREIGN KEY (id_coureur) REFERENCES coureur(id_coureur),
    FOREIGN KEY (id_etape) REFERENCES etape(id_etape),
    UNIQUE (id_coureur, id_etape)
);


CREATE TABLE table_point (
    id_table_point SERIAL PRIMARY KEY,
    rang INT,
    points INT
);

create table resultat_temp (
	etape_rang int,
	numero_dossard int,
	nom varchar,
	genre varchar,
	dtn date,
	equipe varchar,
	arrivee TIMESTAMP
);
