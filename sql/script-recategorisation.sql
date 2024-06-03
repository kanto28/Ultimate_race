delete from coureur_categorie;

-- insertion homme / femme
INSERT INTO coureur_categorie (id_coureur, id_categorie)
select 
id_coureur, get_categorie_by_genre(genre)
from coureur;

-- insertion junior
INSERT INTO coureur_categorie (id_coureur, id_categorie)
select 
id_coureur, get_categorie_by_name('Junior')
from coureur
where is_junior(dtn) = 1;


-- insertion Senior
INSERT INTO coureur_categorie (id_coureur, id_categorie)
select 
id_coureur, get_categorie_by_name('Senior')
from coureur
where is_junior(dtn) = 0;
