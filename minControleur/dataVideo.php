<?php
include_once "../libs/maLibUtils.php";
include_once "../libs/maLibSQL.pdo.php";
include_once "../libs/maLibSecurisation.php";
include_once "../libs/modele.php";
include_once "../libs/maLibPHPMailer.php";

if(!($action = valider("action","POST"))){
		header("Location:../index.php?view=accueil");
}

if( !($idU = valider("idUser","SESSION")))die("Non connecte");
$hash = valider("hash","SESSION");
if(!isSuperAdmin($idU,$hash) && !getDroitByUser($idU,"video"))die("Pas les droits");

$action = valider("action","POST");
switch($action){

	case 'add' : 
		$videos = $_POST['videos'];
		foreach($videos['items'] as $item){
			if(!verifExistVideo($item['id']['videoId'])) {
				addVideo($item['id']['videoId'], date("Y-m-d",strtotime($item['snippet']['publishedAt'])), $item['snippet']['title'], addslashes($item['snippet']['description']), $item['snippet']['thumbnails']['default']['url']);
			}
			else {
				setChecked($item['id']['videoId']);
			}
			//clearChecked();
		}
	break;

	case 'check' : 
		deleteUnchecked();
		clearChecked();
    break;
  
    case 'count' : 
        $search = valider("search","POST");
        $avant = valider("avant", "POST");
        $apres = valider("apres", "POST");
        $serie = valider("serie", "POST");
        echo getVideosCount($search, $avant, $apres, $serie);
	break;

}

/* Resultat du print_r($videos) lorsque l'on demande 5 résultat à l'API Youtube
Array
(
    [kind] => youtube#searchListResponse
    [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/qDCKiRTKfGfgrgVwWSiWF9iBqac"
    [nextPageToken] => CAUQAA
    [regionCode] => FR
    [pageInfo] => Array
        (
            [totalResults] => 415
            [resultsPerPage] => 5
        )

    [items] => Array
        (
            [0] => Array
                (
                    [kind] => youtube#searchResult
                    [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/E8Myp6f8stlIz-S27SFD-zKNx4o"
                    [id] => Array
                        (
                            [kind] => youtube#video
                            [videoId] => egYaJSANywk
                        )

                    [snippet] => Array
                        (
                            [publishedAt] => 2020-02-16T22:48:27.000Z
                            [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                            [title] => Balkany libéré, Griveaux retiré &amp; Marlène trop dévouée ! (J&#39;SUIS PAS CONTENT ! #S06E06)
                            [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                            [thumbnails] => Array
                                (
                                    [default] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/egYaJSANywk/default.jpg
                                            [width] => 120
                                            [height] => 90
                                        )

                                    [medium] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/egYaJSANywk/mqdefault.jpg
                                            [width] => 320
                                            [height] => 180
                                        )

                                    [high] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/egYaJSANywk/hqdefault.jpg
                                            [width] => 480
                                            [height] => 360
                                        )

                                )

                            [channelTitle] => J'suis pas content TV
                            [liveBroadcastContent] => none
                        )

                )

            [1] => Array
                (
                    [kind] => youtube#searchResult
                    [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/rpCQBDNRD46y3HdKNoFObbD49_M"
                    [id] => Array
                        (
                            [kind] => youtube#video
                            [videoId] => xji-m3VWSSg
                        )

                    [snippet] => Array
                        (
                            [publishedAt] => 2020-02-11T00:26:22.000Z
                            [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                            [title] => L&#39;épisode du bout de ma vie ! [J&#39;SUIS PAS CONTENT ! - Hors-Série]
                            [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                            [thumbnails] => Array
                                (
                                    [default] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/xji-m3VWSSg/default.jpg
                                            [width] => 120
                                            [height] => 90
                                        )

                                    [medium] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/xji-m3VWSSg/mqdefault.jpg
                                            [width] => 320
                                            [height] => 180
                                        )

                                    [high] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/xji-m3VWSSg/hqdefault.jpg
                                            [width] => 480
                                            [height] => 360
                                        )

                                )

                            [channelTitle] => J'suis pas content TV
                            [liveBroadcastContent] => none
                        )

                )

            [2] => Array
                (
                    [kind] => youtube#searchResult
                    [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/OFOml0eJAm4xgRW2IA_cxVtKeD8"
                    [id] => Array
                        (
                            [kind] => youtube#video
                            [videoId] => 6pyuSfiLjdU
                        )

                    [snippet] => Array
                        (
                            [publishedAt] => 2020-01-17T19:29:38.000Z
                            [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                            [title] => Ségolène au chomage, Macron au partage &amp; Rokhaya au largage  ! (J&#39;SUIS PAS CONTENT ! #S06E05)
                            [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                            [thumbnails] => Array
                                (
                                    [default] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/6pyuSfiLjdU/default.jpg
                                            [width] => 120
                                            [height] => 90
                                        )

                                    [medium] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/6pyuSfiLjdU/mqdefault.jpg
                                            [width] => 320
                                            [height] => 180
                                        )

                                    [high] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/6pyuSfiLjdU/hqdefault.jpg
                                            [width] => 480
                                            [height] => 360
                                        )

                                )

                            [channelTitle] => J'suis pas content TV
                            [liveBroadcastContent] => none
                        )

                )

            [3] => Array
                (
                    [kind] => youtube#searchResult
                    [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/5Rdht9niyfHzGpTLQ7omjSyS_qY"
                    [id] => Array
                        (
                            [kind] => youtube#video
                            [videoId] => l9SxhPd4P6E
                        )

                    [snippet] => Array
                        (
                            [publishedAt] => 2020-01-14T16:52:27.000Z
                            [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                            [title] => Retrogaming LREM, Pierre-Alain le malin &amp; Marlène la mathématicienne ! (J&#39;SUIS PAS CONTENT! #S06E04)
                            [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                            [thumbnails] => Array
                                (
                                    [default] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/l9SxhPd4P6E/default.jpg
                                            [width] => 120
                                            [height] => 90
                                        )

                                    [medium] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/l9SxhPd4P6E/mqdefault.jpg
                                            [width] => 320
                                            [height] => 180
                                        )

                                    [high] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/l9SxhPd4P6E/hqdefault.jpg
                                            [width] => 480
                                            [height] => 360
                                        )

                                )

                            [channelTitle] => J'suis pas content TV
                            [liveBroadcastContent] => none
                        )

                )

            [4] => Array
                (
                    [kind] => youtube#searchResult
                    [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/qqSjGwOfBk7-fQa4Nen-Je9AXPA"
                    [id] => Array
                        (
                            [kind] => youtube#video
                            [videoId] => JIXPGDxIf-w
                        )

                    [snippet] => Array
                        (
                            [publishedAt] => 2020-01-10T19:51:02.000Z
                            [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                            [title] => Carlos Ghosn au Libran &amp; Sac plastiques dans 20 ans ! (J&#39;SUIS PAS CONTENT ! #06SE03)
                            [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                            [thumbnails] => Array
                                (
                                    [default] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/JIXPGDxIf-w/default.jpg
                                            [width] => 120
                                            [height] => 90
                                        )

                                    [medium] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/JIXPGDxIf-w/mqdefault.jpg
                                            [width] => 320
                                            [height] => 180
                                        )

                                    [high] => Array
                                        (
                                            [url] => https://i.ytimg.com/vi/JIXPGDxIf-w/hqdefault.jpg
                                            [width] => 480
                                            [height] => 360
                                        )

                                )

                            [channelTitle] => J'suis pas content TV
                            [liveBroadcastContent] => none
                        )

                )

        )

    [result] => Array
        (
            [kind] => youtube#searchListResponse
            [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/qDCKiRTKfGfgrgVwWSiWF9iBqac"
            [nextPageToken] => CAUQAA
            [regionCode] => FR
            [pageInfo] => Array
                (
                    [totalResults] => 415
                    [resultsPerPage] => 5
                )

            [items] => Array
                (
                    [0] => Array
                        (
                            [kind] => youtube#searchResult
                            [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/E8Myp6f8stlIz-S27SFD-zKNx4o"
                            [id] => Array
                                (
                                    [kind] => youtube#video
                                    [videoId] => egYaJSANywk
                                )

                            [snippet] => Array
                                (
                                    [publishedAt] => 2020-02-16T22:48:27.000Z
                                    [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                                    [title] => Balkany libéré, Griveaux retiré &amp; Marlène trop dévouée ! (J&#39;SUIS PAS CONTENT ! #S06E06)
                                    [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                                    [thumbnails] => Array
                                        (
                                            [default] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/egYaJSANywk/default.jpg
                                                    [width] => 120
                                                    [height] => 90
                                                )

                                            [medium] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/egYaJSANywk/mqdefault.jpg
                                                    [width] => 320
                                                    [height] => 180
                                                )

                                            [high] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/egYaJSANywk/hqdefault.jpg
                                                    [width] => 480
                                                    [height] => 360
                                                )

                                        )

                                    [channelTitle] => J'suis pas content TV
                                    [liveBroadcastContent] => none
                                )

                        )

                    [1] => Array
                        (
                            [kind] => youtube#searchResult
                            [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/rpCQBDNRD46y3HdKNoFObbD49_M"
                            [id] => Array
                                (
                                    [kind] => youtube#video
                                    [videoId] => xji-m3VWSSg
                                )

                            [snippet] => Array
                                (
                                    [publishedAt] => 2020-02-11T00:26:22.000Z
                                    [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                                    [title] => L&#39;épisode du bout de ma vie ! [J&#39;SUIS PAS CONTENT ! - Hors-Série]
                                    [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                                    [thumbnails] => Array
                                        (
                                            [default] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/xji-m3VWSSg/default.jpg
                                                    [width] => 120
                                                    [height] => 90
                                                )

                                            [medium] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/xji-m3VWSSg/mqdefault.jpg
                                                    [width] => 320
                                                    [height] => 180
                                                )

                                            [high] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/xji-m3VWSSg/hqdefault.jpg
                                                    [width] => 480
                                                    [height] => 360
                                                )

                                        )

                                    [channelTitle] => J'suis pas content TV
                                    [liveBroadcastContent] => none
                                )

                        )

                    [2] => Array
                        (
                            [kind] => youtube#searchResult
                            [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/OFOml0eJAm4xgRW2IA_cxVtKeD8"
                            [id] => Array
                                (
                                    [kind] => youtube#video
                                    [videoId] => 6pyuSfiLjdU
                                )

                            [snippet] => Array
                                (
                                    [publishedAt] => 2020-01-17T19:29:38.000Z
                                    [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                                    [title] => Ségolène au chomage, Macron au partage &amp; Rokhaya au largage  ! (J&#39;SUIS PAS CONTENT ! #S06E05)
                                    [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                                    [thumbnails] => Array
                                        (
                                            [default] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/6pyuSfiLjdU/default.jpg
                                                    [width] => 120
                                                    [height] => 90
                                                )

                                            [medium] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/6pyuSfiLjdU/mqdefault.jpg
                                                    [width] => 320
                                                    [height] => 180
                                                )

                                            [high] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/6pyuSfiLjdU/hqdefault.jpg
                                                    [width] => 480
                                                    [height] => 360
                                                )

                                        )

                                    [channelTitle] => J'suis pas content TV
                                    [liveBroadcastContent] => none
                                )

                        )

                    [3] => Array
                        (
                            [kind] => youtube#searchResult
                            [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/5Rdht9niyfHzGpTLQ7omjSyS_qY"
                            [id] => Array
                                (
                                    [kind] => youtube#video
                                    [videoId] => l9SxhPd4P6E
                                )

                            [snippet] => Array
                                (
                                    [publishedAt] => 2020-01-14T16:52:27.000Z
                                    [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                                    [title] => Retrogaming LREM, Pierre-Alain le malin &amp; Marlène la mathématicienne ! (J&#39;SUIS PAS CONTENT! #S06E04)
                                    [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                                    [thumbnails] => Array
                                        (
                                            [default] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/l9SxhPd4P6E/default.jpg
                                                    [width] => 120
                                                    [height] => 90
                                                )

                                            [medium] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/l9SxhPd4P6E/mqdefault.jpg
                                                    [width] => 320
                                                    [height] => 180
                                                )

                                            [high] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/l9SxhPd4P6E/hqdefault.jpg
                                                    [width] => 480
                                                    [height] => 360
                                                )

                                        )

                                    [channelTitle] => J'suis pas content TV
                                    [liveBroadcastContent] => none
                                )

                        )

                    [4] => Array
                        (
                            [kind] => youtube#searchResult
                            [etag] => "Fznwjl6JEQdo1MGvHOGaz_YanRU/qqSjGwOfBk7-fQa4Nen-Je9AXPA"
                            [id] => Array
                                (
                                    [kind] => youtube#video
                                    [videoId] => JIXPGDxIf-w
                                )

                            [snippet] => Array
                                (
                                    [publishedAt] => 2020-01-10T19:51:02.000Z
                                    [channelId] => UC9NB2nXjNtRabu3YLPB16Hg
                                    [title] => Carlos Ghosn au Libran &amp; Sac plastiques dans 20 ans ! (J&#39;SUIS PAS CONTENT ! #06SE03)
                                    [description] => Pour me soutenir sur T I P E E E : https://www.tipeee.com/j-suis-pas-content · Réseaux Sociaux : D I S C O R D : https://discord.gg/R5J9f27 T W I T T E R ...
                                    [thumbnails] => Array
                                        (
                                            [default] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/JIXPGDxIf-w/default.jpg
                                                    [width] => 120
                                                    [height] => 90
                                                )

                                            [medium] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/JIXPGDxIf-w/mqdefault.jpg
                                                    [width] => 320
                                                    [height] => 180
                                                )

                                            [high] => Array
                                                (
                                                    [url] => https://i.ytimg.com/vi/JIXPGDxIf-w/hqdefault.jpg
                                                    [width] => 480
                                                    [height] => 360
                                                )

                                        )

                                    [channelTitle] => J'suis pas content TV
                                    [liveBroadcastContent] => none
                                )

                        )

                )

        )

)

 */



?>