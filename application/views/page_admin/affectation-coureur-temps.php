 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Affectation /</span> Coureur temps</h4>

            <div class="row">
                
                <div class="col-xl-6">
                 
                  <div class="card mb-4">
                    <h5 class="card-header">Affectation temps coureur</h5>

                    <div class="card-body">
                        <form method="post" action = "<?= site_url("admin_controlleur/coureur_affectation_temps") ?>">
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
                                <label for="html5-text-input" class="col-md-2 col-form-label">Coureur</label>
                                <div class="col-md-10">
                                    <select id="coureur" class="form-select" name="id_coureur" required>
                                    </select>
                                </div>
                        </div>
                        <!-- /Fin select -->

						<div class="mb-3 row">
							<label for="html5-time-input" class="col-md-2 col-form-label">Temps</label>
							<div class="col-md-10">
							<input class="form-control" type="time" value="12:30:30" id="html5-time-input" name = "temps" required />
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
                                    <button type="submit" class="btn btn-primary">Affecter</button>
                                </div>
                            </div>
                            
                        </form>

                    
                    </div>  <!-- / card body -->
                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->
</div>
<!-- / Content -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('etape').addEventListener('change', function() {
        var id_etape = this.value;
        var coureurSelect = document.getElementById('coureur');
		// console.log(coureurSelect);

		while (coureurSelect.firstChild) {
            coureurSelect.removeChild(coureurSelect.firstChild);
        }

        if (id_etape) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', "<?php echo site_url('admin_controlleur/coureur_etape/'); ?>" + id_etape, true);
            xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
					// console.log(data);
                    data.forEach(function(coureur) {
						// console.log(coureur);
                        var option = document.createElement('option');
                        option.value = coureur.id_coureur;
                        option.textContent = coureur.nom_coureur;
                        coureurSelect.appendChild(option);
                    });
                } else if (xhr.readyState === 4) {
                    alert('Erreur lors de la récupération des coureurs.');
                }
            };

            xhr.send();
        } else {
            coureurSelect.innerHTML = '<option value="">Sélectionnez un coureur</option>';
        }
    });
});
</script>
