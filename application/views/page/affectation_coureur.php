 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Insertion /</span> Coureur</h4>

            <div class="row">
                
                <div class="col-xl-6">
                 
                  <div class="card mb-4">
                    <h5 class="card-header">Affectation de coureur</h5>

                    <div class="card-body">
                        <form method="post">

                        <!-- Debut Select -->
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Produit</label>
                                <div class="col-md-10">
                                    <select id="defaultSelect" class="form-select" name="id_produit">
                                        <?php foreach ($listeproduit as $produit): ?>
                                            <option value="<?php echo $produit['id_produit']; ?>"><?php echo $produit['nom_produit']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <!-- /Fin select -->

                        
                        <!-- Debut input -->
                            <div class="mb-3 row">
                                <label for="html5-date-input" class="col-md-2 col-form-label">Date vente</label>
                                <div class="col-md-10">
                                <input class="form-control" type="date" name="date_vente" />
                                </div>
                            </div>
                        <!-- /Fin input -->


                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                            
                        </form>

                    
                    </div>  <!-- / card body -->
                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->
</div>
<!-- / Content -->