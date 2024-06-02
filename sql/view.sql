create or replace view v_participation_equipe as
select 
	participation.*,
	coureur.nom as nom_coureur, coureur.numero_dossard, coureur.genre, coureur.dtn,
	equipe.id_equipe, equipe.nom as nom_equipe
from 
	participation
	join coureur on coureur.id_coureur = participation.id_coureur
	join equipe on equipe.id_equipe = coureur.id_equipe;

--Calculer le temps total corrigé pour chaque coureur pour chaque étape
CREATE VIEW coureur_temps_corrige AS
SELECT
    p.id_coureur,
    p.id_etape,
    EXTRACT(EPOCH FROM (p.heure_arrivee - p.heure_depart)) + p.penalite_secondes AS temps_total_corrige
FROM
    participation p;

--Attribuer des points selon le rang des temps corrigés pour chaque coureur
CREATE VIEW classement_etape AS
SELECT
    c.id_etape,
    c.id_coureur,
    RANK() OVER (PARTITION BY c.id_etape ORDER BY c.temps_total_corrige ASC) AS rang,
    CASE
        WHEN RANK() OVER (PARTITION BY c.id_etape ORDER BY c.temps_total_corrige ASC) = 1 THEN 10
        WHEN RANK() OVER (PARTITION BY c.id_etape ORDER BY c.temps_total_corrige ASC) = 2 THEN 6
        WHEN RANK() OVER (PARTITION BY c.id_etape ORDER BY c.temps_total_corrige ASC) = 3 THEN 4
        WHEN RANK() OVER (PARTITION BY c.id_etape ORDER BY c.temps_total_corrige ASC) = 4 THEN 2
        WHEN RANK() OVER (PARTITION BY c.id_etape ORDER BY c.temps_total_corrige ASC) = 5 THEN 1
        ELSE 0
    END AS points
FROM
    coureur_temps_corrige c;

--Calculer les points totaux pour chaque coureur
CREATE VIEW points_totaux_coureur AS
SELECT
    ce.id_coureur,
    SUM(ce.points) AS points_total
FROM
    classement_etape ce
GROUP BY
    ce.id_coureur;

--Voir le classement général des coureurs
CREATE VIEW classement_general_coureur AS
SELECT
    c.id_coureur,
    c.nom,
    c.id_equipe,
    pt.points_total
FROM
    points_totaux_coureur pt
JOIN
    coureur c ON pt.id_coureur = c.id_coureur
ORDER BY
    pt.points_total DESC;

-- Voir les points pour chaque coureur pour chaque étape
SELECT * FROM classement_etape;

-- Voir le classement général des coureurs
SELECT * FROM classement_general_coureur;

-- Voir les points pour chaque coureur pour chaque étape avec nom du coureur et etape
CREATE VIEW v_classement_etape_complet AS
SELECT
	ce.id_etape,
    e.nom AS nom_etape,
    c.nom AS nom_coureur,
    c.numero_dossard,
    ce.rang,
    ce.points
FROM
    classement_etape ce
JOIN
    coureur c ON ce.id_coureur = c.id_coureur
JOIN
    etape e ON ce.id_etape = e.id_etape
ORDER BY
    ce.id_etape, ce.rang;

