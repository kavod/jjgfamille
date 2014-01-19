// Rules
/**
 * Variable contenant l'ensemble des évènements liés à des objets de la page
 */
var myrules = 
{
	/** Menu rubrique */
	'#f4_menu_rub' : function(element)
	{
		/** variable indiquant si le menu est ouvert ou non */
		element.ouvert = false;
		/** chrono pour l'ouverture du menu */
		element.timer_ouverture;
		/** chrono pour la fermeture du menu */
		element.timer_fermeture;

		/** Passage au dessus d'un menu déroulant */
		element.onmouseover = function(e)
		{
			/** Si une fermeture était en cours, la stopper */
			clearTimeout(this.timer_fermeture);
			var menu = $('f4_menu_rub_dropdown');
			/** Ouverture du menu dans 0.3 sec... si cette ouverture n'est pas stoppée */
			this.timer_ouverture = setTimeout(function() {derouler(element,menu)},300);
		};
		
		/** Sortie d'un menu déroulant */
		element.onmouseout = function(e)
		{
			/** Si une ouverture était en cours, la stopper */
			clearTimeout(this.timer_ouverture);
			var menu = $('f4_menu_rub_dropdown');
			/** Fermeture du menu dans 0.3 sec... si cette fermeture n'est pas stoppée */
			this.timer_fermeture = setTimeout(function() {enrouler(element,menu,e)},300);
		}
	
	}
};

/**
 * Dérouler un menu
 * @param bouton Element d'ouverture du menu
 * @param menu Element à dérouler
 */
function derouler(bouton,menu)
{
	if (!bouton.ouvert)
	{
		bouton.ouvert = true;
		new Effect.BlindDown(menu,{duration: 0});
	}
}

/**
 * Enrouler un menu
 * @param bouton Element de fermeture du menu
 * @param menu Element à enrouler
 * @param e window.event
 */
function enrouler(bouton,menu,e)
{
	if (bouton.ouvert)
	{
		if (!e) var e = window.event;
		var tg = (window.event) ? e.srcElement : e.target;
	
		if (tg == bouton) return;
		var reltg = (e.relatedTarget) ? e.relatedTarget : e.toElement;

		while (reltg != bouton && reltg.nodeName != 'BODY')
		{
			reltg= reltg.parentNode
		}

		if (reltg == bouton) return;
		
		bouton.ouvert = false;
		
		new Effect.BlindUp(menu,{duration: 0});
	}
}

articles = new Array();
articles[0] = new Array("f0","f1","m2");
articles[1] = new Array("f0","f1");
articles[2] = new Array("m2");

function filtrer(filtre)
{
	for (i=0;i<articles[0].length;i++)
	{
		document.getElementById(articles[0][i]).className = "hidden_elem";
	}

	for (i=0;i<articles[filtre].length;i++)
	{
		document.getElementById(articles[filtre][i]).className = (i==0) ? "UIIntentionalStory_First " : "";
		document.getElementById(articles[filtre][i]).className += " UIStory UIIntentionalStory aid_696027168 commentable_item no_comments collapsed_comments autoexpand_mode";
	}
	for (i=0;i<articles.length;i++)
	{
		document.getElementById('filtre_' + i).className = (i==0) ? "UIFilterList_FirstItem " : "";
		document.getElementById('filtre_' + i).className += " UIFilterList_Item UIFilterList_HasIcon";
	}
	
	document.getElementById('filtre_' + filtre).className += " UIFilterList_Selected";
}
/*
function load_home()
{
	var xhr=null;
	
	if (window.XMLHttpRequest) 
	{ 
		xhr = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) 
	{
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	//on définit l'appel de la fonction au retour serveur
	xhr.onreadystatechange = function() { alert(xhr); };
	
	//on appelle le fichier reponse.txt
	xhr.open("GET", "http://www.jjgfamille.com/test/famille4.php", true);
	xhr.send(null);
}*/
