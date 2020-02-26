<div id="searchresult">
<?php 
	include_once "../libs/modele.php";
	include_once "../libs/maLibUtils.php";
	include_once "../libs/maLibSQL.pdo.php";
	include_once "../libs/maLibSecurisation.php"; 
    $search = valider('search');
    $page = valider('page');
    $notID = valider('notID');
    $videoParPage = valider('videoParPage');
    $videos = getVideos($search, $page, $videoParPage, $notID);
	foreach ($videos as $video) { ?>
    <li id='<?php echo $video["id"]; ?>' class="media item">
        <div class="item-img"> 
            <a href="index.php?view=watchvideo&id=<?php echo $video["videoId"]; ?>">
                <img src="<?php echo $video["thumbnails"]; ?>"">
            </a>
        </div>
        <div class="media-body item-txt"> 
            <a href="index.php?view=watchvideo&id=<?php echo $video["videoId"]; ?>"">
                <span> <?php echo $video["title"]; ?> </span>
            </a>
        </div>
    </li>

	<?php } ?>
</div>
	<br/>

