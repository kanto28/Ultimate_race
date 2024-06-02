<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Classement /</span> Coureur</h4>


        <button type="button" class="btn btn-primary"  onClick="addPdf()" id="export">Exporter PDF </button>
        <hr>
        
        <!-- Atao ato anatin'ito ze ho exportena pdf-->
        <div class="card" id="table">

            <!-- Eto manomboka le tableau -->
            <h5 class="card-header">Classemet des Coureur</h5>
            
            <div class="table-responsive text-nowrap">
                <table class="table">
                <thead class="table-dark">
                    <tr>
                    <th>ID</th>
                    <th>Nom coureur</th>
                    <th>ID equipe</th>
                    <th>Point total</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php
                        foreach ($listeCoureur as $coureur): ?>
                        <tr>
                            <td><?php echo $coureur['id_coureur']; ?></td>
                            <td><?php echo $coureur['nom']; ?> km</td>
                            <td><?php echo $coureur['id_equipe']; ?></td>
                            <td><?php echo $coureur['points_total']; ?></td>
                        </tr>
                        <?php
                    endforeach; ?>
                </tbody>
                </table>
            </div>
            <!-- Eto mifarana le tableau -->


        </div>
        <!-- Fin ny table exportena pdf-->
             
    </div>
</div>

<script src="<?= base_url("assets/js/html2pdf.bundle.min.js") ?>"></script>
    <script type="text/javascript">
function addPdf(){
  var element = document.getElementById('table');
  element.style.width = '100%';  
  element.style.padding = '20px';
  element.style.fontSize = 'x-small';

  var opt = {
    filename:     'document.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
  };

  html2pdf().from(element).set(opt).save();
}

    </script>