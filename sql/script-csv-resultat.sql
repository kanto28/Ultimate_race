INSERT into equipe (nom, password)
select 
equipe as nom, equipe as password
from 
resultat_temp 
GROUP BY equipe order by equipe;

INSERT into coureur (nom, numero_dossard, genre, dtn, id_equipe)
select 
res.nom, res.numero_dossard, res.genre, res.dtn, e.id_equipe
from 
resultat_temp res
join equipe e on e.nom = res.equipe
GROUP by res.nom, res.numero_dossard, res.genre, res.dtn, e.id_equipe;


INSERT into participation (id_coureur, id_etape, heure_depart, heure_arrivee)
select 
c.id_coureur, et.id_etape, et.date_debut, res.arrivee
from 
resultat_temp res
join etape et on et.rang_etape = res.etape_rang
join coureur c on c.nom = res.nom;

delete from resultat_temp;
