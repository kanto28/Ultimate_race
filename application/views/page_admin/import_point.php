 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Import /</span> Point</h4>

            <div class="row">
                
                <div class="col-xl-6">
            
                    <div class="card">
                        <h5 class="card-header">Importation</h5>
                        <div class="card-body">
                            <form action="<?php echo site_url('Csv/import_point'); ?>" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Import Points</label>
                                    <input class="form-control" type="file" id="point_csv" name="point_csv" />
                                </div>
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