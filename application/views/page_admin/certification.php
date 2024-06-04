 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Certification /</span> Rang 1</h4>

        <button type="button" class="btn btn-primary"  onClick="addPdf()" id="export">Exporter PDF </button>

            <div class="row">
                
                <div class="col-xl-6" id="table">
                 <hr>
                  <div class="card mb-4">
                    <h5 class="card-header">Certification</h5>

                    <div class="card-body">
                        <h1>HAHA</h1>    
                        <?php
                         $i = 1;
                        foreach ($allEquipe as $equipe): ?> 
                            <?php echo $equipe['nom_equipe']; ?> 
                            <?php echo $equipe['points_total']; ?>
                            <?php echo $equipe['rang']; ?>

                        <?php 
                        $i++;
                        endforeach;
                            ?>             
                    </div>  <!-- / card body -->

                </div><!-- / col-->

            </div><!-- / row-->
    </div><!-- / container-->
</div>
<!-- / Content -->


<script src="<?= base_url("assets/js/html2pdf.bundle.min.js") ?>"></script>
    <script type="text/javascript">
function addPdf(){
  var element = document.getElementById('table');
  element.style.width = '100%';  
  element.style.padding = '20px';
  element.style.fontSize = 'x-small';

  var opt = {
    filename:     'Certification.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
  };

  html2pdf().from(element).set(opt).save();
}

    </script>