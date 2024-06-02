INSERT INTO admin (nom, password) VALUES ('admin', 'admin');

INSERT INTO equipe (nom, password)
VALUES
    ('Equipe A', 'passwordA'),
    ('Equipe B', 'passwordB'),
    ('Equipe C', 'passwordC'),
    ('Equipe D', 'passwordD'),
    ('Equipe E', 'passwordE');

INSERT INTO categorie (nom_categorie) VALUES 
('Homme'),
('Femme'),
('Junior'),
('Senior');


INSERT INTO coureur (nom, numero_dossard, genre, dtn, id_equipe, id_categorie) VALUES 
('Lova', 1, 'Femme', '2000-05-15', 1, 2),
('Sabrina', 2, 'Femme', '1998-09-25', 1, 2),
('Justin', 3, 'Homme', '1995-12-12', 2, 1),
('Vero', 4, 'Femme', '1997-04-08', 2, 2),
('John', 5, 'Homme', '2001-11-30', 3, 1),
('Jill', 6, 'Femme', '2002-02-14', 3, 2),
('Victor', 7, 'Homme', '1996-07-18', 1, 1);

INSERT INTO etape (nom, distance_km, nb_coureur_equipe, rang_etape, date_debut, date_fin) VALUES 
('Betsizaraina', 5.0, 2, 1, '2024-06-01 07:00:00', '2024-06-01 09:00:00'),
('Ampasimbe', 10.0, 1, 3, '2024-06-02 07:00:00', '2024-06-02 10:00:00');


INSERT INTO participation ( id_coureur, id_etape, heure_depart, heure_arrivee, penalite_secondes) VALUES 
( 1, 1, '2024-06-01 07:00:00', '2024-06-01 07:30:00', 0 ),
( 2, 1, '2024-06-01 07:00:00', '2024-06-01 07:40:00', 0 ),
( 3, 1, '2024-06-01 07:00:00', '2024-06-01 07:50:00', 0 ),
( 4, 1, '2024-06-01 07:00:00', '2024-06-01 07:55:00', 0 ),
( 5, 1, '2024-06-01 07:00:00', '2024-06-01 08:00:00', 0 ),
( 6, 1, '2024-06-01 07:00:00', '2024-06-01 08:05:00', 0 ),

( 7, 2, '2024-06-02 07:00:00', '2024-06-02 07:50:00', 0 ),
( 3, 2, '2024-06-02 07:00:00', '2024-06-02 08:05:00', 0 ),
( 6, 2, '2024-06-02 07:00:00', '2024-06-02 08:15:00', 0 );

INSERT INTO table_point (rang, points)
VALUES
    (1, 10),
    (2, 6),
    (3, 4),
    (4, 2),
    (5, 1);