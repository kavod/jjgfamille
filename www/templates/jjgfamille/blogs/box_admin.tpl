<!-- BEGIN admin -->
<table style="text-align: left; width: 305px;" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="5" height="0"></td>
      <td width="7" height="0"></td>
      <td height="0"></td>
      <td width="7" height="0"></td>
      <td width="5" height="0"></td>
    </tr>
    <tr>
      <td colspan="2" rowspan="2" class="coinHG"></td>
      <td class="ligneHaut"></td>
      <td colspan="2" rowspan="2" class="coinHD"></td>
    </tr>
    <tr>
      <td height="7" class="row2"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td class="degradeGauche"></td>
      <th valign="middle" align="center" height="28" nowrap="nowrap" class="thCornerL">{admin.L_ADMIN_BLOG}</th>
      <td class="degradeDroite"></td>
      <td class="colonneDroite"></td>
    </tr>
    <tr>
      <td class="colonneGauche"></td>
      <td width="7" class="row2"></td>
      <td class="row2" style="vertical-align: top;"><span class="genmed">
      <a href="{admin.U_ADMIN}">{admin.L_ADMIN}</a><br /><br />
      <a href="{admin.U_MY_BLOG}">{admin.L_VIEW_MY_BLOG}</a><br /><br />
      <form method="post" action="{admin.U_ADD}">
      <strong>{admin.L_ADD}</strong><br />
      <input type="hidden" name="mode" value="newtopic" />
      <select name="forum_id" onChange="this.form.submit()">
        <option value="0">--</option>
<!-- BEGIN cate -->
	<option value="{admin.cate.CATE_ID}">{admin.cate.CATE_NAME}</option>
<!-- END cate -->
      </select></form>
	</span></td>
      <td width="7"  class="row2"></td>
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
<!-- END admin -->