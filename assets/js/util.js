document.addEventListener('DOMContentLoaded', function() {
    var btnAjouter = document.getElementById('btnAjouter');
    var sectionAjout = document.getElementById('ajout');
    sectionAjout.style.display = 'none';

    btnAjouter.addEventListener('click', function() {
        if (sectionAjout.style.display === 'none') {
            sectionAjout.style.display = 'block';
        } else {
            sectionAjout.style.display = 'none';
        }
    });

    var erreur = sectionAjout.getAttribute('data-erreur');
    if (erreur !== 'aucun') {
        sectionAjout.style.display = 'block';
    }
});