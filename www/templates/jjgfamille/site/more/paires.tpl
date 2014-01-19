
<!-- Début du document -->
				<tr>
					<td colspan="3" align="center">
					<span class="forumlink">
		{LIEN_ACCUEIL} | {LIEN_ACTUALITE} | {LIEN_JJG} | {LIEN_DISCO} | {LIEN_MEDIAS} | {LIEN_TOURNEES} | {LIEN_LINKS} | {LIEN_FAMILLE} | {LIEN_PLUSPLUS}</span>
					</td>
				</tr>
				<tr>
					<td width="205" valign="top"><br /><br />
						{COLONNE_GAUCHE}
					</td>
					<td align="center" valign="top" colspan="2"><br />
<table style="text-align: left; width: 100%;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td  height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{NOM_RUB}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
        <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catleft" height="28"><center><b>{L_TITLE}</b></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
  <tr> 
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="row2" >
		<script language="JavaScript" type="text/javascript">
<!--
cartes=["c1","c2","c3","c4","c5","c6","c7","c8","c9","c10","t1","t2","t3","t4","t5","t6","t7","t8","t9","t10"];
cartes2=new Array();
choix=new Array();
choix2=new Array();
com=paire=0;
var cont,cont1,test,test2;
var coups;
control=false;
stop = false;

var t = 120;
function compte()
{
	if(t>0)
	{
		if(stop!=true)
		{
		t--;
		document.form.b.value=t;
		setTimeout("compte()",1000);
		}
	}
	else
	{
			rejoue();
			alert('Le temps est ecoulé, tu as perdu\nAllez retente ta chance');

	}
}

function genere()
{
	
	for (i=0; i<10; i++)
	 {
		do
		 {
			choix[i]=Math.floor(Math.random()*20);
			test=true;
			
			for (j=0; j<i; j++)
			 {
				if (choix[j]==choix[i])
					test=false;
			 }
		  }
		while (test==false)
		cartes2[i]=cartes[choix[i]];
	 }

	for (z=0, l=10; z<10, l<20; z++, l++)
	 {
		do
		 {
			choix2[z]=Math.floor(Math.random()*10);
			test2=true;
			
			for (k=0; k<z; k++)
			 {
				if (choix2[k]==choix2[z])
					test2=false;
			 }
		 }
		while (test2==false)
		cartes2[l]=cartes2[choix2[z]];
	 }
	alert("Le jeu est prêt !\nVous pouvez cliquer sur les photos retournées."); 
	document.form.start.style.display='none';
	control=true; 
	compte();
	coups=0;
}

function joue(n)
{
	
	if (control != true) 
	{
		alert("Vous n'avez pas cliqué sur DÉMARRER !"); 
		return false; 
	}
	
	switch(n)
         {
                case 0:
                if(document.A.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 1:
               if(document.B.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 2:
                if(document.C.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 3:
                if(document.D.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 4:
                if(document.E.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 5:
                if(document.F.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 6:
                if(document.G.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 7:
                if(document.H.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 8:
                if(document.I.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 9:
                if(document.J.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 10:
                if(document.K.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 11:
                if(document.L.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 12:
                if(document.M.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 13:
                if(document.N.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 14:
                if(document.O.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 15:
                if(document.P.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 16:
                if(document.Q.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 17:
                if(document.R.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 18:
                if(document.S.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break;
                case 19:
                if(document.T.src!='http://www.jjgfamille.com/images/more/inconnu.jpg')
		{
			alert('Cette carte est déja retournée');
			return false;
		}
                break; 
         }
	
	
	com++;
		
	if (com==1)
	 {
		
	 switch(n)
         {
                case 0:document.A.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 1:document.B.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 2:document.C.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 3:document.D.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 4:document.E.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 5:document.F.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 6:document.G.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 7:document.H.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 8:document.I.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 9:document.J.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 10:document.K.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 11:document.L.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 12:document.M.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 13:document.N.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 14:document.O.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 15:document.P.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 16:document.Q.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 17:document.R.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 18:document.S.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 19:document.T.src="../images/more/"+cartes2[n]+".jpg";
                break; 
         }
		
		cont=n;
		return false;
	 }
	else if (com==2)
	 {
		coups++;	
			switch(n)
         {
                case 0:document.A.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 1:document.B.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 2:document.C.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 3:document.D.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 4:document.E.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 5:document.F.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 6:document.G.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 7:document.H.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 8:document.I.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 9:document.J.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 10:document.K.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 11:document.L.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 12:document.M.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 13:document.N.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 14:document.O.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 15:document.P.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 16:document.Q.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 17:document.R.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 18:document.S.src="../images/more/"+cartes2[n]+".jpg";
                break;
                case 19:document.T.src="../images/more/"+cartes2[n]+".jpg";
                break; 
         }
		if (cartes2[n]==cartes2[cont] && n!= cont)
		 {
			com=0;
			paire++;
			alert("Vous avez trouvé une paire");
			if (paire==10)
			 {
				paire=0;
				alert("Vous avez gagné la partie en "+coups+" coups !");
				stop = true;
				return false;
			 }
			else
			{
				window.status="Nombre de paires trouvées: "+paire;
			}
		 }
		else
		 {
			cont1 = n;
			switch(cont1)
         {
                case 0:setTimeout('document.A.src="../images/more/inconnu.jpg";',1000);
                break;
                case 1:setTimeout('document.B.src="../images/more/inconnu.jpg";',1000);
                break;
                case 2:setTimeout('document.C.src="../images/more/inconnu.jpg";',1000);
                break;
                case 3:setTimeout('document.D.src="../images/more/inconnu.jpg";',1000);
                break;
                case 4:setTimeout('document.E.src="../images/more/inconnu.jpg";',1000);
                break;
                case 5:setTimeout('document.F.src="../images/more/inconnu.jpg";',1000);
                break;
                case 6:setTimeout('document.G.src="../images/more/inconnu.jpg";',1000);
                break;
                case 7:setTimeout('document.H.src="../images/more/inconnu.jpg";',1000);
                break;
                case 8:setTimeout('document.I.src="../images/more/inconnu.jpg";',1000);
                break;
                case 9:setTimeout('document.J.src="../images/more/inconnu.jpg";',1000);
                break;
                case 10:setTimeout('document.K.src="../images/more/inconnu.jpg";',1000);
                break;
                case 11:setTimeout('document.L.src="../images/more/inconnu.jpg";',1000);
                break;
                case 12:setTimeout('document.M.src="../images/more/inconnu.jpg";',1000);
                break;
                case 13:setTimeout('document.N.src="../images/more/inconnu.jpg";',1000);
                break;
                case 14:setTimeout('document.O.src="../images/more/inconnu.jpg";',1000);
                break;
                case 15:setTimeout('document.P.src="../images/more/inconnu.jpg";',1000);
                break;
                case 16:setTimeout('document.Q.src="../images/more/inconnu.jpg";',1000);
                break;
                case 17:setTimeout('document.R.src="../images/more/inconnu.jpg";',1000);
                break;
                case 18:setTimeout('document.S.src="../images/more/inconnu.jpg";',1000);
                break;
                case 19:setTimeout('document.T.src="../images/more/inconnu.jpg";',1000);
                break; 
         }
         
         switch(cont)
         {
                case 0:setTimeout('document.A.src="../images/more/inconnu.jpg";',2000);
                break;
                case 1:setTimeout('document.B.src="../images/more/inconnu.jpg";',1000);
                break;
                case 2:setTimeout('document.C.src="../images/more/inconnu.jpg";',1000);
                break;
                case 3:setTimeout('document.D.src="../images/more/inconnu.jpg";',1000);
                break;
                case 4:setTimeout('document.E.src="../images/more/inconnu.jpg";',1000);
                break;
                case 5:setTimeout('document.F.src="../images/more/inconnu.jpg";',1000);
                break;
                case 6:setTimeout('document.G.src="../images/more/inconnu.jpg";',1000);
                break;
                case 7:setTimeout('document.H.src="../images/more/inconnu.jpg";',1000);
                break;
                case 8:setTimeout('document.I.src="../images/more/inconnu.jpg";',1000);
                break;
                case 9:setTimeout('document.J.src="../images/more/inconnu.jpg";',1000);
                break;
                case 10:setTimeout('document.K.src="../images/more/inconnu.jpg";',1000);
                break;
                case 11:setTimeout('document.L.src="../images/more/inconnu.jpg";',1000);
                break;
                case 12:setTimeout('document.M.src="../images/more/inconnu.jpg";',1000);
                break;
                case 13:setTimeout('document.N.src="../images/more/inconnu.jpg";',1000);
                break;
                case 14:setTimeout('document.O.src="../images/more/inconnu.jpg";',1000);
                break;
                case 15:setTimeout('document.P.src="../images/more/inconnu.jpg";',1000);
                break;
                case 16:setTimeout('document.Q.src="../images/more/inconnu.jpg";',1000);
                break;
                case 17:setTimeout('document.R.src="../images/more/inconnu.jpg";',1000);
                break;
                case 18:setTimeout('document.S.src="../images/more/inconnu.jpg";',1000);
                break;
                case 19:setTimeout('document.T.src="../images/more/inconnu.jpg";',1000);
                break; 
         }
         	setTimeout('com=0;',1000);	
		 }
	 }
	else
	 {
		alert("Vous ne pouvez retourner que 2 photos à la fois.");
		return false;
	 }
}

function affiche()
{
	
	for (b=0; b<20; b++)
	 {
	switch(b)
         {
                case 0:document.A.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 1:document.B.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 2:document.C.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 3:document.D.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 4:document.E.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 5:document.F.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 6:document.G.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 7:document.H.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 8:document.I.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 9:document.J.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 10:document.K.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 11:document.L.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 12:document.M.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 13:document.N.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 14:document.O.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 15:document.P.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 16:document.Q.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 17:document.R.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 18:document.S.src="../images/more/"+cartes2[b]+".jpg";
                break;
                case 19:document.T.src="../images/more/"+cartes2[b]+".jpg";
                break; 
         }
	 }
	 stop = true;
}

function rejoue()
{
	location.reload();
}
-->
</script>
<p>
<span class="genmed">
<u><b>Règles du Jeu</b></u><br /><br />
Lorsque vous arrivez sur la page, le jeu se lance.<br />
Toutes les photos sont retournées.<br />
Cliquez sur une image puis une deuxième pour les comparer.<br />
Si les deux photos sont identiques vous avez trouvé une paire.<br />
Sinon elles se retournent .<br />
Et ainsi de suite jusqu'à trouver les 10 paires de photos.<br /><br />
<b>Enjoy it !!!</b><br/><form name="form">Temps restants:&nbsp;<input type="text" name="b" value="" size="2" class="post" readonly />&nbsp;secondes
</span>
</p>
<center>
	<img name="A"  src="../images/more/inconnu.jpg" alt="1er carte" height="116" width="72" border="2" onClick="joue(0);" />
	<img name="B" src="../images/more/inconnu.jpg" alt="2er carte" height="116" width="72" border="2" onClick="joue(1);" />
	<img name="C" src="../images/more/inconnu.jpg" alt="3er carte" height="116" width="72" border="2" onClick="joue(2);" />
	<img name="D" src="../images/more/inconnu.jpg" alt="4er carte" height="116" width="72" border="2" onClick="joue(3);" />
	<img name="E" src="../images/more/inconnu.jpg" alt="5er carte" height="116" width="72" border="2" onClick="joue(4);" />
	<br />
	<img name="F" src="../images/more/inconnu.jpg" alt="6er carte" height="116" width="72" border="2" onClick="joue(5);" />
	<img name="G" src="../images/more/inconnu.jpg" alt="7er carte" height="116" width="72" border="2" onClick="joue(6);" />
	<img name="H" src="../images/more/inconnu.jpg" alt="8er carte" height="116" width="72" border="2" onClick="joue(7);" />
	<img name="I" src="../images/more/inconnu.jpg" alt="9er carte" height="116" width="72" border="2" onClick="joue(8);" />
	<img name="J" src="../images/more/inconnu.jpg" alt="10er carte" height="116" width="72" border="2" onClick="joue(9);" />	
	<br />
	<img name="K" src="../images/more/inconnu.jpg" alt="11er carte" height="116" width="72" border="2" onClick="joue(10);" />
	<img name="L" src="../images/more/inconnu.jpg" alt="12er carte" height="116" width="72" border="2" onClick="joue(11);" />
	<img name="M" src="../images/more/inconnu.jpg" alt="13er carte" height="116" width="72" border="2" onClick="joue(12);" />
	<img name="N" src="../images/more/inconnu.jpg" alt="14er carte" height="116" width="72" border="2" onClick="joue(13);" />
	<img name="O" src="../images/more/inconnu.jpg" alt="15er carte" height="116" width="72" border="2" onClick="joue(14);" />
	<br />
	<img name="P" src="../images/more/inconnu.jpg" alt="16er carte" height="116" width="72" border="2" onClick="joue(15);" />
	<img name="Q" src="../images/more/inconnu.jpg" alt="17er carte" height="116" width="72" border="2" onClick="joue(16);" />
	<img name="R" src="../images/more/inconnu.jpg" alt="18er carte" height="116" width="72" border="2" onClick="joue(17);" />
	<img name="S" src="../images/more/inconnu.jpg" alt="19er carte" height="116" width="72" border="2" onClick="joue(18);" />
	<img name="T" src="../images/more/inconnu.jpg" alt="20er carte" height="116" width="72" border="2" onClick="joue(19);" />
	<br/><br/>
		
		<input type="button" name="start" value="Démarrer" class="mainoption" onClick="genere();" />
		<br/><br/>
		<input type="button" value="Nouvelle partie" class="mainoption" onClick="rejoue();" />
	</form>
</center>
<br />
	</td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
  	<td class="colonneGauche"></td>
	<td width="7" class="row2"></td>
	<td class="catLeft" height="28"><center><span class="cattitle"><a href="{U_RETOUR}"><b>{L_RETOUR}</b></a></center></td>
	<td width="7" class="row2"></td>
	<td class="colonneDroite"></td>
  </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinBG"></td>
      <td height="7" class="row2"></td>
      <td colspan="2" rowspan="2" class="coinBD"></td>
    </tr>
    <tr>
      <td class="ligneBas"></td>
    </tr>
  </tbody>
</table>

					</td>
				</tr>
				
				
				
				
<!-- FIN du document -->
