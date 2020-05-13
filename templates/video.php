<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
}

$search = valider("search","GET");
$series = getSeries();
?>
    <link rel="stylesheet" href="css/video.css">
    <div class="page-header">
      <h1>Vidéos</h1>
    </div> <br/>
    <div class="lead">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="#" class="menu p-4" autocomplete="off">
                    <input type="hidden" id="hiddenpage" name="hiddenpage" value="1"/>
                    <input type="hidden" id="nbserie" name="hiddenpage" value="1"/>
                    <div class="input-group mb-3">
                        <input id="search" type="text" class="form-control" placeholder="Rechercher" aria-label="Rechercher" aria-describedby="search" value="<?php echo stripslashes($search) ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="search-button">
                               <img src="./ressources/icons/search.svg" alt="" title="search">
                            </button>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-outline-secondary" type="button" id="disp-filtres">
                            Plus d'options
                        </button>
                        <div id="filtres" class="hidden"> 
                            <div class="row">
                                <div class="col-md-6">
                                    Posté après le : <br/>
                                    <input class="form-control date" type="text" name="jour" id="posteApres" size=7 readonly>
                                </div>
                                <div class="col-md-6">
                                    Posté avant le : <br/>
                                    <input class="form-control date" type="text" name="jour" id="posteAvant" size=7 readonly>
                                </div>
                                <div class="col-md-12">
                                    <span style="text-align:left;">Série : </span>
                                    <select id="selectSerie" class="form-control">
                                        <option value="-1">Selectionner une série</option>
                                        <?php foreach ($series as $serie) { ?>
                                        <option value="<?php echo $serie['id_serie']?>"><?php echo $serie['nom']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <ul id="results"></ul>
                <nav id="pagination" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item page-down disabled" id="previouspageli">
                            <a class="page-link shadow-none" id="previouspage" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item page-number active" id="pageinfli" ><a class="page-link shadow-none" id="pageinf" href="#">1</a></li>
                        <li class="page-item page-number" id="pagemidli"><a class="page-link shadow-none" id="pagemid" href="#">2</a></li>
                        <li class="page-item page-number" id="pagesupli"><a class="page-link shadow-none" id="pagesup" href="#">3</a></li>
                        <li class="page-item page-up" id="nextpageli">
                            <a class="page-link shadow-none" id="nextpage" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- <button id="actualiser" type="button" class="btn btn-light">Actualiser</button> </br> -->
            </div>
        </div>
    </div>
    <script src="js/video.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=init"></script>