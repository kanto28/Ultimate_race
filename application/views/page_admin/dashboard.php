 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Generer /</span> Categorie</h4>

            <div class="row">
                
                <div class="col-xl-6">
                 
                  <div class="card mb-4">
                    <h5 class="card-header">Generer les categories</h5>

                    <div class="card-body">
                        <form method="post" action="<?php echo site_url('Admin/insert_categories'); ?>">
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Exécuter</button>
                                </div>
                            </div>  
                        </form>                    
                    </div>  <!-- / card body -->
                </div><!-- / col-->
            </div><!-- / row-->
    </div><!-- / container-->
</div>
<!-- / Content -->