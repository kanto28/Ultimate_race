 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Import /</span> Etape et Resultat</h4>

            <div class="row">
                
                <div class="col-xl-6">
            
                    <div class="card">
                        <h5 class="card-header">Importation</h5>
                        <div class="card-body">
                        <form action="<?php echo site_url('Admin/import_etape_resultat'); ?>" method="post" enctype="multipart/form-data" >
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Import Etape</label>
                                <input class="form-control" type="file" id="etape_csv" name="etape_csv" />
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Import Resultat</label>
                                <input class="form-control" type="file" id="participation_csv" name="participation_csv" />
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
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Importer</button>
                            </div>
                        </form> 
                        </div>
                    </div>

                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->
</div>
<!-- / Content -->
