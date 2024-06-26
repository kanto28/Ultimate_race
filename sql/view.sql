CREATE OR REPLACE FUNCTION get_categorie_by_genre(genre varchar)
RETURNS int AS $$
DECLARE
    id_categorie int;
    nom_categ varchar;
BEGIN

    IF genre = 'M' THEN
        nom_categ := 'Homme';
    ELSIF genre = 'F' THEN
        nom_categ := 'Femme';
    ELSE
        RAISE EXCEPTION 'Genre invalide : %', genre;
    END IF;

    SELECT c.id_categorie
    INTO id_categorie
    FROM categorie c
    WHERE c.nom_categorie = nom_categ;

    RETURN id_categorie;
END;
$$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION get_categorie_by_name(nom_categ varchar)
RETURNS int AS $$
DECLARE
    id_categorie int;
BEGIN
    SELECT c.id_categorie
    INTO id_categorie
    FROM categorie c
    WHERE c.nom_categorie = nom_categ;

    RETURN id_categorie;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION is_junior(dtn date)
RETURNS int AS $$
DECLARE
    age int;
BEGIN
    age := DATE_PART('year', AGE(CURRENT_DATE, dtn));
    IF age < 18 THEN
        RETURN 1;
    ELSE
        RETURN 0;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION is_junior_id(id_c int)
RETURNS int AS $$
DECLARE
    dtn date;
    result int;
BEGIN
    SELECT c.dtn INTO dtn FROM coureur c WHERE c.id_coureur = id_c;

    IF dtn IS NULL THEN
        RAISE EXCEPTION 'Aucune date de naissance trouvée pour l''identifiant %', id_c;
    END IF;

    result := is_junior(dtn);
    RETURN result;
END;
$$ LANGUAGE plpgsql;



create or replace view v_participation_equipe as
select 
	participation.*,
	coureur.nom as nom_coureur, coureur.numero_dossard, coureur.genre, coureur.dtn,
	equipe.id_equipe, equipe.nom as nom_equipe
from 
	participation
	join coureur on coureur.id_coureur = participation.id_coureur
	join equipe on equipe.id_equipe = coureur.id_equipe;

create or replace view v_coureur_en_course as 
select
 	v.*
from 
	v_participation_equipe as v
	where v.heure_arrivee is NULL;

--Calculer le temps total corrigé pour chaque coureur pour chaque étape
CREATE or replace  VIEW coureur_temps_corrige AS
SELECT
    p.id_coureur,
    p.id_etape,
    EXTRACT(EPOCH FROM (p.heure_arrivee - p.heure_depart)) + p.penalite_secondes AS temps_total_corrige,
	TO_CHAR(
        INTERVAL '1 second' * (EXTRACT(EPOCH FROM (p.heure_arrivee - p.heure_depart)) + p.penalite_secondes),
        'HH24:MI:SS'
    ) AS temps_total_format
FROM
    participation p;

CREATE or replace  VIEW coureur_temps_corrige_lib AS
SELECT
    c_t_c.*,
	c.id_equipe ,c.nom, c.numero_dossard, c.genre, c.dtn, equipe.nom as nom_equipe
FROM
    coureur_temps_corrige c_t_c
	join coureur c on c.id_coureur = c_t_c.id_coureur
	join equipe on c.id_equipe = equipe.id_equipe;


--Attribuer des points selon le rang des temps corrigés pour chaque coureur
CREATE or replace  VIEW classement_etape AS
SELECT
    c.id_etape,
    c.id_coureur,
    r.rang,
    COALESCE(tp.points, 0) AS points
FROM
    coureur_temps_corrige c
JOIN (
    SELECT
        id_etape,
        id_coureur,
        DENSE_RANK() OVER (PARTITION BY id_etape ORDER BY temps_total_corrige ASC) AS rang
    FROM
        coureur_temps_corrige
) r ON c.id_etape = r.id_etape AND c.id_coureur = r.id_coureur
LEFT JOIN
    table_point tp ON r.rang = tp.rang;


--Calculer les points totaux pour chaque coureur
CREATE or replace  VIEW points_totaux_coureur AS
SELECT
    ce.id_coureur,
    SUM(ce.points) AS points_total
FROM
    classement_etape ce
GROUP BY
    ce.id_coureur;

--Voir le classement général des coureurs
CREATE OR REPLACE VIEW classement_general_coureur AS
SELECT
    c.id_coureur,
    c.nom,
    e.nom AS nom_equipe,
    pt.points_total,
    RANK() OVER (ORDER BY pt.points_total DESC) AS rang
FROM
    points_totaux_coureur pt
JOIN
    coureur c ON pt.id_coureur = c.id_coureur
JOIN
    equipe e ON c.id_equipe = e.id_equipe
ORDER BY
    rang;

-- Voir les points pour chaque coureur pour chaque étape
SELECT * FROM classement_etape;

-- Voir le classement général des coureurs
SELECT * FROM classement_general_coureur;



--Attribuer des points selon le rang des temps corrigés pour chaque coureur
CREATE OR REPLACE VIEW v_classement_etape_complet AS
SELECT
    ce.id_etape,
    e.nom AS nom_etape,
    c.nom AS nom_coureur,
    c.numero_dossard,
    ce.rang,
    ce.points,
    c.id_equipe
FROM
    classement_etape ce
JOIN
    coureur c ON ce.id_coureur = c.id_coureur
JOIN
    etape e ON ce.id_etape = e.id_etape
JOIN
    equipe eq ON c.id_equipe = eq.id_equipe
ORDER BY
    ce.points DESC, ce.id_etape, ce.rang;



CREATE OR REPLACE VIEW v_classement_general_equipe AS
	SELECT
		e.id_equipe,
		e.nom AS nom_equipe,
		SUM(ec.points) AS points_total,
		RANK() OVER (ORDER BY SUM(ec.points) DESC) AS rang
	FROM
		v_classement_etape_complet ec
	JOIN
		equipe e ON ec.id_equipe = e.id_equipe
	GROUP BY
		e.id_equipe, e.nom
	ORDER BY
		rang;

create or replace view v_coureur_categ as
select 
	c.*,
	ct.*
from 
	coureur c
	LEFT join coureur_categorie c_c on c.id_coureur = c_c.id_coureur
	join categorie ct on ct.id_categorie = c_c.id_categorie; 


-- --- classement general
--categorie Homme
CREATE or replace  VIEW classement_etape_homme AS
SELECT
    c.id_etape,
    c.id_coureur,
	c.nom_equipe,
    r.rang,
    COALESCE(tp.points, 0) AS points, 
	c.id_equipe
FROM
    coureur_temps_corrige_lib c
JOIN (
    SELECT
        id_etape,
        id_coureur,
        DENSE_RANK() OVER (PARTITION BY id_etape ORDER BY temps_total_corrige ASC) AS rang
    FROM
        coureur_temps_corrige_lib where genre = 'M'
) r ON c.id_etape = r.id_etape AND c.id_coureur = r.id_coureur
LEFT JOIN
    table_point tp ON r.rang = tp.rang;

CREATE OR REPLACE VIEW v_classement_general_equipe_homme_point AS
select
	t.id_equipe, t.nom_equipe, sum( points) as points_total
from
	classement_etape_homme t
	GROUP by t.id_equipe, t.nom_equipe
union all 
select
	e.id_equipe, e.nom, 0
from equipe e;

CREATE OR REPLACE VIEW v_classement_general_equipe_homme_point_total AS
select
	t.id_equipe, t.nom_equipe, sum( points_total) as points_total
from
	v_classement_general_equipe_homme_point t
	GROUP by t.id_equipe, t.nom_equipe;


CREATE OR REPLACE VIEW v_classement_general_equipe_homme AS
select
	t.id_equipe, t.nom_equipe, points_total,
	RANK() OVER (ORDER BY points_total DESC) AS rang
from
	v_classement_general_equipe_homme_point_total t
ORDER by rang;


--categorie femme
CREATE or replace  VIEW classement_etape_femme AS
SELECT
    c.id_etape,
    c.id_coureur,
	c.nom_equipe,
    r.rang,
    COALESCE(tp.points, 0) AS points, 
	c.id_equipe
FROM
    coureur_temps_corrige_lib c
JOIN (
    SELECT
        id_etape,
        id_coureur,
        DENSE_RANK() OVER (PARTITION BY id_etape ORDER BY temps_total_corrige ASC) AS rang
    FROM
        coureur_temps_corrige_lib where genre = 'F'
) r ON c.id_etape = r.id_etape AND c.id_coureur = r.id_coureur
LEFT JOIN
    table_point tp ON r.rang = tp.rang;

CREATE OR REPLACE VIEW v_classement_general_equipe_femme_point AS
select
	t.id_equipe, t.nom_equipe, sum( points) as points_total
from
	classement_etape_femme t
	GROUP by t.id_equipe, t.nom_equipe
union all 
select
	e.id_equipe, e.nom, 0
from equipe e;

CREATE OR REPLACE VIEW v_classement_general_equipe_femme_point_total AS
select
	t.id_equipe, t.nom_equipe, sum( points_total) as points_total
from
	v_classement_general_equipe_femme_point t
	GROUP by t.id_equipe, t.nom_equipe;


CREATE OR REPLACE VIEW v_classement_general_equipe_femme AS
select
	t.id_equipe, t.nom_equipe, points_total,
	RANK() OVER (ORDER BY points_total DESC) AS rang
from
	v_classement_general_equipe_femme_point_total t
ORDER by rang;


--categorie junior
CREATE or replace  VIEW classement_etape_junior AS
SELECT
    c.id_etape,
    c.id_coureur,
	c.nom_equipe,
    r.rang,
    COALESCE(tp.points, 0) AS points, 
	c.id_equipe
FROM
    coureur_temps_corrige_lib c
JOIN (
    SELECT
        id_etape,
        id_coureur,
        DENSE_RANK() OVER (PARTITION BY id_etape ORDER BY temps_total_corrige ASC) AS rang
    FROM
        coureur_temps_corrige_lib where is_junior(dtn) = 1
) r ON c.id_etape = r.id_etape AND c.id_coureur = r.id_coureur
LEFT JOIN
    table_point tp ON r.rang = tp.rang;

CREATE OR REPLACE VIEW v_classement_general_equipe_junior_point AS
select
	t.id_equipe, t.nom_equipe, sum( points) as points_total
from
	classement_etape_junior t
	GROUP by t.id_equipe, t.nom_equipe
union all 
select
	e.id_equipe, e.nom, 0
from equipe e;

CREATE OR REPLACE VIEW v_classement_general_equipe_junior_point_total AS
select
	t.id_equipe, t.nom_equipe, sum( points_total) as points_total
from
	v_classement_general_equipe_junior_point t
	GROUP by t.id_equipe, t.nom_equipe;


CREATE OR REPLACE VIEW v_classement_general_equipe_junior AS
select
	t.id_equipe, t.nom_equipe, points_total,
	RANK() OVER (ORDER BY points_total DESC) AS rang
from
	v_classement_general_equipe_junior_point_total t
ORDER by rang;

