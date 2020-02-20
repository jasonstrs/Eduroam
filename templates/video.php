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
                    <input type="hidden" id="pageToken" value="">
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
                <p><button id="prev" type="button" class="btn btn-light" style="display:none;">Previous</button>
                <button id="next" type="button" class="btn btn-light" style="display:none;">Next</button></p>
            </div>
        </div>
    </div>
    <script src="js/video.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=init"></script>