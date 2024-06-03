 <style>
	.ajout_coureur {
		margin-top: 20px;
    	margin-left: 20px;
	}
 </style>
 <!-- Content wrapper -->
 <div class="content-wrapper">
        
	<div class="card" >
					
			<?php
			foreach($etapes_coureurs as $etapes_coureur) {
			?>
				<div class="" style="margin-bottom: 30px" >
					<!-- Eto manomboka le tableau -->
					<h5 class="card-header"><?= $etapes_coureur['etape']['nom']; ?> - <?php $etapes_coureur['etape']['distance_km']; ?> km</h5>
            
					<div class="table-responsive text-nowrap">
						<table class="table">
						<thead class="table-dark">
							<tr>
								<th>Nom coureur</th>
								<th>Temps Chrono</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0">
							<?php
							foreach($etapes_coureur['coureurs'] as $coureur) {
							?>	
								<tr>
									<td><?= $coureur['nom'] ?></td>
									<td><?= $coureur['temps_total_format'] ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
						</table>
					</div>
					<!-- Eto mifarana le tableau -->
					<div class="ajout_coureur">
						<a href = "<?= site_url("coureur/coureur_affectation_modal/".$etapes_coureur['etape']['id_etape']) ?>">
							<button type="submit" class="btn btn-primary"> Ajouter Coureur </button>  
						</a>
						
					</div>
				</div>
				 
			<?php
			}
			?>
									

    </div>

</div>
<!-- / Content -->
