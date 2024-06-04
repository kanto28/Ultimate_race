<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Classement /</span> Equipe</h4>


        <!-- <button type="button" class="btn btn-primary"  onClick="addPdf()" id="export">Exporter PDF </button>
        <hr>
         -->
        <!-- Atao ato anatin'ito ze ho exportena pdf-->
		<a  href="<?= site_url('equipe/classement_equipe?categ=Tous') ?>" ><button type="button" class="btn btn-primary">Tous</button></a>
		<a  href="<?= site_url('equipe/classement_equipe?categ=Homme') ?>" ><button type="button" class="btn btn-primary">Homme</button></a>
		<a  href="<?= site_url('equipe/classement_equipe?categ=Femme') ?>" ><button type="button" class="btn btn-primary">Femme</button></a>
		<a  href="<?= site_url('equipe/classement_equipe?categ=Junior') ?>" ><button type="button" class="btn btn-primary">Junior</button></a>
		<hr>
        <div class="card" id="table">


            <!-- Eto manomboka le tableau -->
            <h5 class="card-header">Classemet des Equipes : <?= $categ ?></h5>
			<div class = row>
				<div class="col-6">
					<div class="table-responsive text-nowrap">
					<table class="table">
						<thead class="table-dark">
							<tr>
							<th>ID</th>
							<th>Nom equipe</th>
							<th>Point total</th>
							<th>Rang</th>
							<th>Certification</th>
							</tr>
						</thead>
						<tbody class="table-border-bottom-0">
							<?php
								foreach ($listeEquipe as $equipe): ?>
								<tr>
									<td><?php echo $equipe['id_equipe']; ?></td>
									<td><?php echo $equipe['nom_equipe']; ?></td>
									<td><?php echo $equipe['points_total']; ?></td>
									<td><?php echo $equipe['rang']; ?></td>
									<td>
										<?php if ($equipe['rang'] == 1): ?>
											<a href="<?php echo site_url('Admin/detailsEquipe?id_equipe='.$equipe['id_equipe']); ?>" class="btn btn-primary">Certificat</a>
										<?php endif; ?>
									</td>
								</tr>
								<?php
							endforeach; ?>
						</tbody>
					</table>
					</div>
				</div>
				<div class="col-6">
					<canvas id="repartition" style="max-height: 400px;"></canvas>
				</div>
			</div>
            
            <!-- Eto mifarana le tableau -->


        </div>
        <!-- Fin ny table exportena pdf-->
             
    </div>
</div>
<script src="<?php echo base_url('assets/js/chart.min.js'); ?>"></script>
<script>
const ctx = document.getElementById('repartition');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [<?= $stat["labels"] ?>],
        datasets: [{
            label: 'Repartition',
            data: [<?= $stat["points"] ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)', // Rouge
                'rgba(54, 162, 235, 0.7)', // Bleu
                'rgba(255, 206, 86, 0.7)', // Jaune
                'rgba(75, 192, 192, 0.7)', // Vert
                'rgba(153, 102, 255, 0.7)', // Violet
                'rgba(255, 159, 64, 0.7)' // Orange
            ],
            borderWidth: 1
        }]
    }
});
</script>



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
