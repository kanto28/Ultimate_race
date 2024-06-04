 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Gestion Penalite /</span> CD </h4>
		<button id="btnAjouter" type="button" class="btn btn-primary" style="margin-bottom : 15px;">
      		<i class="bi bi-plus"></i>
    	</button>
            <div class="row" id="ajout" data-erreur="<?= $erreur ?>">
                
                <div class="col-xl-6">
                 
                  <div class="card mb-4">
                    <h5 class="card-header">Penalitsation</h5>

                    <div class="card-body">
                        <form method="post" action = "<?= site_url("admin_controlleur/gestion_penalite") ?>">
							<!-- Debut Select -->
							<div class="mb-3 row">
									<label for="html5-text-input" class="col-md-2 col-form-label">Etape</label>
									<div class="col-md-10">
										<select id="etape" class="form-select" name="id_etape">
											<?php foreach ($etapes as $etape): ?>
												<option value="<?php echo $etape['id_etape']; ?>"><?php echo $etape['nom']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
							</div>
							<!-- /Fin select -->

							<!-- Debut Select -->
							<div class="mb-3 row">
									<label for="html5-text-input" class="col-md-2 col-form-label">Equipe</label>
									<div class="col-md-10">
										<select id="equipe" class="form-select" name="id_equipe">
											<?php foreach ($equipes as $equipe): ?>
												<option value="<?php echo $equipe['id_equipe']; ?>"><?php echo $equipe['nom']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
							</div>
							<!-- /Fin select -->

							<div class="mb-3 row">
								<label for="html5-time-input" class="col-md-2 col-form-label">Temps</label>
								<div class="col-md-10">
								<input class="form-control" type="time" value="00:00:30" id="html5-time-input" name = "temps" required />
								</div>
							</div>

							
							<?php
							if ($erreur != 'aucun') {
								?>
								<div class="row mb-3">
								<span class="badge border-danger border-1 text-danger">
									<?= $erreur ?>
								</span>
								</div>
								<?php
							}
							?>
		

							<div class="row justify-content-end">
								<div class="col-sm-10">
									<button type="submit" class="btn btn-primary">Penaliser</button>
								</div>
							</div>
                            
                        </form>

                    
                    </div>  <!-- / card body -->
                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->
	
	<div class="card" id="table">

		<!-- Eto manomboka le tableau -->
		<h5 class="card-header">Liste Penalites</h5>
		
		<div class="table-responsive text-nowrap">
			<table class="table">
			<thead class="table-dark">
				<tr>
					<th>Etape</th>
					<th>Equipe</th>
					<th>Temps penalite</th>
					<th></th>
				</tr>
			</thead>
			<tbody class="table-border-bottom-0">
				<?php
					foreach ($penalites as $penalite): ?>
					<tr>
						<td><?php echo $penalite['nom_etape']; ?></td>
						<td><?php echo $penalite['nom_equipe']; ?> </td>
						<td><?php echo $penalite['penalite']; ?></td>
						<td style="text-align: center;">
							<button type="button" class="btn btn-danger" data-url="<?= site_url('admin_controlleur/supprimer_penalite/'.$penalite['id_penalite'])?>" >
								<i class="bi bi-trash"></i>
							</button>
						</td>
					</tr>
					<?php
				endforeach; ?>
			</tbody>
			</table>
		</div>
		<!-- Eto mifarana le tableau -->


	</div>

</div>
<!-- / Content -->
<script src="<?php echo base_url('assets/js/util.js'); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Trouver tous les boutons avec l'attribut data-url
    const buttons = document.querySelectorAll('button[data-url]');

    // Ajouter un gestionnaire d'événements pour l'événement de clic à chaque bouton
    buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Récupérer l'URL de l'attribut data-url du bouton
            const url = this.getAttribute('data-url');

            // Afficher la boîte de dialogue de confirmation
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette pénalité?')) {
                event.preventDefault(); // Empêcher l'action par défaut si l'utilisateur annule
                return;
            }

            // Effectuer la requête AJAX
            fetch(url, { method: 'DELETE' }) 
              .then(response => {
                    if (response.ok) {
                        console.log('Suppression réussie');
                        // Rediriger vers une autre page ou mettre à jour l'interface utilisateur ici
						window.location.href = '<?= site_url("admin_controlleur/gestion_penalite") ?>';
                    } else {
                        throw new Error('Erreur lors de la suppression');
                    }
                })
              .catch(error => {
                    console.error('Erreur:', error);
                    // Gérer l'erreur ici
					alert(error);
                });
        });
    });
});
</script>


