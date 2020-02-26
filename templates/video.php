<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
    die("");
}

$search=valider("search","GET");

?>
    <link rel="stylesheet" href="css/video.css">
    <div class="page-header">
      <h1>Vidéos</h1>
    </div> <br/>
    <div class="lead">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="#">
                <input type="hidden" id="hiddenpage" name="hiddenpage" value="1"/>
                <input type="hidden" id="nbserie" name="hiddenpage" value="1"/>
                    <div class="input-group mb-3">
                        <input id="search" type="text" class="form-control" placeholder="Rechercher" aria-label="Rechercher" aria-describedby="search" value="<?php echo $search ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="search-button">
                               <img src="./ressources/icons/search.svg" alt="" title="search">
                            </button>
                        </div>
                    </div>
                </form>
                <ul id="results"></ul>
                <!-- <p><button id="prev" type="button" class="btn btn-light" style="display:none;">Previous</button>
                <button id="next" type="button" class="btn btn-light" style="display:none;">Next</button></p> -->
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
                <button id="actualiser" type="button" class="btn btn-light">Actualiser</button> </br>
            </div>
        </div>
    </div>
    <script src="js/video.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=init"></script>