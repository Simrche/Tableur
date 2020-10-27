// POPUP ----------------------------------------

$(document).ready(function(){
	$('#popupFond').hide();
	$('#popupMilieu').hide();
})

$('#ajouter').click(function(){
	$('#popupFond').show('fast');
	$('#popupMilieu').show('fast');
});

$('#popupFond').click(function(){
	$('#popupFond').hide('fast');
	$('#popupMilieu').hide('fast');
});

// RECUP PARI -------------------------------------

const pariEnvoyer = document.getElementById('envoyer')
const titre = document.getElementById('titre')
const cote = document.getElementById('cote')
const mise = document.getElementById('mise')
const contenu = document.getElementById('contenu')
var titreP
var coteP
var miseP

// pariEnvoyer.addEventListener('click', function(){
// 	console.log('salut')
// 	titreP = titre.value
// 	coteP = cote.value
// 	miseP = mise.value
// 	contenu.innerHTML = "Le pari " + titreP + " avec une cote de " + coteP + " et une mise de " + miseP + " à fait gagner 100euro à"
// 	$('#popupFond').hide('fast');
// 	$('#popupMilieu').hide('fast');
// })