dateDefaut = new Date(Date.UTC(2012, 11, 20, 3, 0, 0));

optionsAffichageDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
//Permet d'afficher la date
//ex : console.log(dateDefaut.toLocaleDateString('fr-FR', optionsAffichageDate));

var loader = $("<img>").attr({"src":"./ressources/loading.gif"}).css({"width":"50px"});


