<style>
        .certificate {
            width: 900px;
            height: 700px;
            border: 10px solid #ddd;
            padding: 20px;
            text-align: center;
            position: relative;
            background-size: cover;
        }
        .certificate .header {
            font-size: 48px;
            color: #FFD700;
        }
        .certificate .subheader {
            font-size: 36px;
            margin: 20px 0;
        }
        .certificate .content {
            font-size: 24px;
            margin: 40px 0;
        }
        .certificate .footer {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            display: flex;
            justify-content: space-between;
        }
        .certificate .footer .signature {
            text-align: center;
        }
    </style>
 
 <!-- Content wrapper -->
 <div class="content-wrapper">
            <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Certification /</span> Rang 1</h4>

        <button type="button" class="btn btn-primary"  onClick="addPdf()" id="export">Exporter PDF </button>

        <hr>
           <div class="row" id="table">
                    
                    <div class="card mb-4">
                       <!--<h5 class="card-header">Certification</h5>-->

                        <div class="card-body">
                            <div class="certificate">
                                <div class="header">RUNNING CHAMPION</div>
                                <div class="subheader">ULTIMATE TEAM RACE</div>
                                <?php
                                    $i = 1;
                                    foreach ($allEquipe as $equipe): ?> 
                                        
                                    <div class="content">
                                        This is to certify that the team <strong><?php echo $equipe['nom_equipe']; ?></strong> <br>
                                        has successfully accomplished the Track & Field match from Team Company. <br>
                                        We truly appreciate the hard work, persistence and teamwork, leads to ultimate victory.
                                    </div>
                                    <div class="subheader">
                                            Team: <?php echo $equipe['nom_equipe']; ?> <br>
                                            Points: <?php echo $equipe['points_total']; ?> <br>
                                            Rank: <?php echo $equipe['rang']; ?>
                                    </div>
                                   
                                <?php 
                                $i++;
                                endforeach;
                                ?>       
                                
                                <div class="footer">
                                    <div class="signature">
                                        Signature <br> ____________________
                                    </div>
                                    
                                </div>
                            </div>

                                  
                        </div> <!-- / card body -->
                    </div> <!-- / card -->
            </div> <!-- / row -->
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