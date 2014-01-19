<!--

function show_calendar(str_target, str_date)
	{
	var arr_months = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
	
	var week_days = ["Dim","Lun","Mar","Mer","Jeu","Ven","Sam"];
	
	var n_weekstart = 1;

	var dt_datetime = (str_date == null || str_date =="" ?  new Date() : str2dt(str_date));
	
	var dt_prev_month = new Date(dt_datetime);
	dt_prev_month.setMonth(dt_datetime.getMonth()-1);
	var dt_next_month = new Date(dt_datetime);
	dt_next_month.setMonth(dt_datetime.getMonth()+1);
	
	var dt_prev_year = new Date(dt_datetime);
	dt_prev_year.setFullYear(dt_prev_year.getFullYear()-1);
	var dt_next_year = new Date(dt_datetime);
	dt_next_year.setFullYear(dt_next_year.getFullYear()+1);
	
	var dt_firstday = new Date(dt_datetime);
	dt_firstday.setDate(1);
	dt_firstday.setDate(1-(7+dt_firstday.getDay()-n_weekstart)%7);
	var dt_lastday = new Date(dt_next_month);
	dt_lastday.setDate(0);
	
	var str_buffer = new String (
		"<html>"+
			"<head>"+
			"	<title>Calendrier</title>"+
			"</head>"+
		"<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"White\">"+
		"<table class=\"clsOTable\" cellspacing=\"0\" border=\"0\" width=\"100%\">"+
		"<tr>"+
		"<td bgcolor=\"#B79B52\">"+
			"<table cellspacing=\"1\" cellpadding=\"2\" border=\"0\" width=\"100%\">"+
				"<tr>"+
					"<td colspan=\"7\">"+
						"<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">"+
							"<tr>"+
								"<td nowrap width=\"99%\" bgcolor=\"#B79B52\">"+
									"<a href=\"javascript:window.opener.show_calendar('"+str_target+"', '"+ dt2dtstr(dt_prev_year)+"');\">"+
									"<img src=\"../images/prev_year.gif\" width=\"16\" height=\"16\" border=\"0\"></a> "+
									"<a href=\"javascript:window.opener.show_calendar('"+str_target+"', '"+ dt2dtstr(dt_prev_month)+"');\">"+
									"<img src=\"../images/prev_month.gif\" width=\"16\" height=\"16\" border=\"0\"></a>"+
									"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">&nbsp;<b>"
									+arr_months[dt_datetime.getMonth()]+" "+dt_datetime.getFullYear()+"</b></font>"+
								"</td>"+
								"<td nowrap align=\"right\" colspan=\"2\" bgcolor=\"#B79B52\" align=\"right\">"+
									"<a href=\"javascript:window.opener.show_calendar('"+str_target+"', '"+dt2dtstr(dt_next_month)+"');\">"+
									"<img src=\"../images/next_month.gif\" width=\"16\" height=\"16\" border=\"0\"></a> "+
									"<a href=\"javascript:window.opener.show_calendar('"+str_target+"', '"+dt2dtstr(dt_next_year)+"');\">"+
									"<img src=\"../images/next_year.gif\" width=\"16\" height=\"16\" border=\"0\"></a>"+
								"</td>"+
							"</tr>"+
						"</table>"+
					"</td>"+
				"</tr>"

	);

	var dt_current_day = new Date(dt_firstday);
	// print weekdays titles
	str_buffer += "<tr>";
	for (var n=0; n<7; n++)
		str_buffer += "	<td width=\"14%\" bgcolor=\"#E7CD82\">"+
		"<font color=\"white\" face=\"tahoma, verdana\" size=\"2\">"+
		week_days[(n_weekstart+n)%7]+"</font></td>";
	// print calendar table
	str_buffer += "</tr>";
	while (dt_current_day.getMonth() == dt_datetime.getMonth() ||
		dt_current_day.getMonth() == dt_firstday.getMonth()) {
		// print row header
		str_buffer += "<tr>";
		for (var n_current_wday=0; n_current_wday<7; n_current_wday++) {
				if (dt_current_day.getDate() == dt_datetime.getDate() &&
					dt_current_day.getMonth() == dt_datetime.getMonth())
					// print current date
					str_buffer += "	<td bgcolor=\"#FFC156\" align=\"right\">";
				else if (dt_current_day.getDay() == 0 || dt_current_day.getDay() == 6)
					// weekend days
					str_buffer += "	<td bgcolor=\"#F7DB92\" align=\"right\">";
				else
					// print working days of current month
					str_buffer += "	<td bgcolor=\"#FFEFC3\" align=\"right\">";

				if (dt_current_day.getMonth() == dt_datetime.getMonth())
					// print days of current month
					str_buffer += "<a href=\"javascript:window.opener."+str_target+
					".value='"+dt2dtstr(dt_current_day)+"'; window.close();\">"+
					"<font color=\"black\" face=\"tahoma, verdana\" size=\"2\">";
				else 
					// print days of other months
					str_buffer += "<a href=\"javascript:window.opener."+str_target+
					".value='"+dt2dtstr(dt_current_day)+"'; window.close();\">"+
					"<font color=\"gray\" face=\"tahoma, verdana\" size=\"2\">";
				str_buffer += dt_current_day.getDate()+"</font></a></td>";
				dt_current_day.setDate(dt_current_day.getDate()+1);
		}
		// print row footer
		str_buffer += "</tr>";
	}
	// print calendar footer
	str_buffer +=
		"</table>" +
		"</tr></td></table>" +
		"</body>" +
		"</html>";

	var hauteur=250;
	var largeur=200;
	var options="width="+hauteur+",height="+largeur+",status=no,resizable=yes,top="+ (screen.height-hauteur)/2 +",left="+ (screen.width-largeur)/2;
	var vWinCal = window.open("blanc.php", "Calendar",options);
	vWinCal.opener = self;
	var calc_doc = vWinCal.document;
	calc_doc.write (str_buffer);
	calc_doc.close();
	vWinCal.focus();
	}

function str2dt (str_date)
	{
	var re_date = /^(\d+)\/(\d+)\/(\d+)$/;
	if (!re_date.exec(str_date))
		return (new Date ());
	return (new Date (RegExp.$3, RegExp.$2-1, RegExp.$1));
	}

function dt2dtstr (dt_date)
	{
	jour=dt_date.getDate();
	mois=dt_date.getMonth()+1;
	annee=dt_date.getFullYear();
	if(jour<10)
		jour='0'+jour;
	if(mois<10)
		mois='0'+mois;
	
	return (new String (jour+"/"+mois+"/"+annee));
	}
//-->



