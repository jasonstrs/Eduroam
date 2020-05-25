<div id="searchresult">
<?php 
	include_once "../libs/modele.php";
	include_once "../libs/maLibUtils.php";
	include_once "../libs/maLibSQL.pdo.php";
    include_once "../libs/maLibSecurisation.php";
    $type = valider('type');
    $page = valider('page');
    $search = valider('search');
    $date = valider('date');
    $apres = valider('apres');
    $avant = valider('avant');
    $notID = valider('notID');
    $serie = valider('serie');
    $videoParPage = valider('videoParPage');
    if($type=="watchvideo") {
        $videos = getVideosByDateSup($date, $notID, $videoParPage);
        if(sizeof($videos)!=$videoParPage) {
            $videos = array_merge($videos, getVideosByDateInf($date, $notID, $videoParPage));
        }
    }
    else {
        $videos = getVideos($search, $page, $videoParPage, $notID, $apres, $avant, $serie);
    }
    foreach ($videos as $video) { ?>
    <a href="index.php?view=watchvideo&id=<?php echo $video["videoId"]; ?>">
    <li id='<?php echo $video["id"]; ?>' class="media item">
        <div class="item-img"> 
            
                <img src="<?php echo $video["thumbnails"]; ?>"">
            
        </div>
        <div class="media-body item-txt"> 
            
                <span> <?php echo $video["title"]; ?> </span>
        </div>
    </li>

	<?php } ?>
</div>
	<br/>

