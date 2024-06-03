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
                        <form method="post" action="<?php echo site_url('Admin/reinitialiserDonnees'); ?>">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Import Etape</label>
                                <input class="form-control" type="file" id="formFile" />
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Import Resultat</label>
                                <input class="form-control" type="file" id="formFile" />
                            </div>
                            <div class="col-sm-10">
                                <button type="submit" name="reinitialiser" value="1" class="btn btn-primary">Importer</button>
                            </div>
                        </form> 
                        </div>
                    </div>

                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->
</div>
<!-- / Content -->