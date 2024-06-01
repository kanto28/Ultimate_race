create or replace view v_participation_equipe as
select 
	participation.*,
	coureur.nom as nom_coureur, coureur.numero_dossard, coureur.genre, coureur.dtn,
	equipe.id_equipe, equipe.nom as nom_equipe
from 
	participation
	join coureur on coureur.id_coureur = participation.id_coureur
	join equipe on equipe.id_equipe = coureur.id_equipe;
