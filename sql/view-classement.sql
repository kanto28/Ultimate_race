CREATE or replace  VIEW coureur_temps_corrige_categ_lib AS
SELECT
    c_t_c.*,
	c.id_equipe ,c.nom, c.numero_dossard, c.genre, c.dtn, equipe.nom as nom_equipe,
	ca.id_categorie, ca.nom_categorie 
FROM
    coureur_temps_corrige c_t_c
	join coureur c on c.id_coureur = c_t_c.id_coureur
	join equipe on c.id_equipe = equipe.id_equipe
	join coureur_categorie c_c on c_c.id_coureur = c.id_coureur
	join categorie ca on ca.id_categorie = c_c.id_categorie;


CREATE or replace  VIEW classement_etape_categ AS
SELECT
    c.id_etape,
    c.id_coureur,
    c.id_equipe,
    c.nom_equipe,
    c.id_categorie,
    c.nom_categorie,
    r.rang,
    COALESCE(tp.points, 0) AS points
FROM
    coureur_temps_corrige_categ_lib c
JOIN (
    SELECT
        id_etape,
        id_coureur,
        id_categorie,
        DENSE_RANK() OVER (PARTITION BY id_etape, id_categorie ORDER BY temps_total_corrige ASC) AS rang
    FROM
        coureur_temps_corrige_categ_lib
) r ON c.id_etape = r.id_etape AND c.id_coureur = r.id_coureur AND c.id_categorie = r.id_categorie
LEFT JOIN
    table_point tp ON r.rang = tp.rang
ORDER BY
    c.id_etape, c.id_equipe, c.id_categorie, r.rang;


CREATE OR REPLACE VIEW v_classement_general_equipe_categ_point AS
select
	t.id_equipe, t.nom_equipe, t.id_categorie, t.nom_categorie ,sum( points) as points_total
from
	classement_etape_categ t
	GROUP by t.id_equipe, t.nom_equipe, t.id_categorie, t.nom_categorie
union all 
select
	e.id_equipe, e.nom, ca.id_categorie, ca.nom_categorie , 0
from equipe e, categorie ca;

CREATE OR REPLACE VIEW v_classement_general_equipe_point_total AS
select
	t.id_equipe, t.nom_equipe, t.id_categorie, t.nom_categorie, sum( points_total) as points_total
from
	v_classement_general_equipe_categ_point t
	GROUP by t.id_equipe, t.nom_equipe, t.id_categorie, t.nom_categorie;


select
	t.id_equipe, t.nom_equipe, points_total,
	RANK() OVER (ORDER BY points_total DESC) AS rang
from
	v_classement_general_equipe_point_total t
	where nom_categorie = 'Homme'
ORDER by rang;

