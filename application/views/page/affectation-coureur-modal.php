<style>
	.ajout_coureur {
		margin-top: 20px;
    	margin-left: 20px;
	}
 </style>
 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Insertion /</span> Coureur</h4>

            <div class="row">
                
                <div class="col-xl-6">
                 
                  <div class="card mb-4">
                    <h5 class="card-header">Affectation de coureur <?= $etape["nom"] ?> </h5>

                    <div class="card-body">
                        <form method="post" action = "<?= site_url("coureur/coureur_affectation_modal/".$etape["id_etape"]) ?>">

                        <!-- Debut Select -->
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Coureur</label>
                                <div class="col-md-10">
                                    <select id="defaultSelect" class="form-select" name="id_coureur">
                                        <?php foreach ($coureurs as $coureur): ?>
                                            <option value="<?php echo $coureur['id_coureur']; ?>"><?php echo $coureur['nom']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <!-- /Fin select -->

                        
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
                                    <button type="submit" class="btn btn-primary">Affecter</button>
                                </div>
                            </div>
                            
                        </form>
						<div style="margin-top: 20px">
							<a href = "<?= site_url("coureur/coureur_affectation") ?>">
								<button type="submit" class="btn btn-secondary"> Retour </button>  
							</a>
						</div>
						

                    
                    </div>  <!-- / card body -->
                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->

</div>
<!-- / Content -->
