/*    HTTP Host:  b.static.ak.fbcdn.net                                        */
/*    Generated:  March 25th 2009 9:41:26 AM PDT                               */
/*      Machine:  10.16.139.105                                                */
/*       Source:  Local Cache                                                  */
/*     Location:  rsrc:3gtfes95:nu_ll:/html/js/pymk_refresh.js                 */
/*       Locale:  nu_ll                                                        */
/*         Path:  js/pymk_refresh.js                                           */


function pymk_refresh(onResponse,onError){if(window.pymk_refreshing){return;}
var possible=['pymk_hp_box'];var locations=[];for(var i=0;i<possible.length;i++){if(ge(possible[i])){locations.push(possible[i]);}}
if(locations.length==0){return;}
var data={'locations':locations};var _onResponse=function(response){window.pymk_refreshing=false;var divs=response.getPayload();for(var id in divs){if(ge(id)&&divs[id].length>0){$(id).setContent(HTML(divs[id]));}}
if(onResponse){onResponse(response);}}
var _onError=function(response){window.pymk_refreshing=false;if(onError){onError(response);}}
new AsyncRequest().setURI('/ajax/pymk_refresh.php').setData(data).setOption('bundle',true).setHandler(_onResponse).setErrorHandler(_onError).send();window.pymk_refreshing=true;}

if (window.Bootloader) { Bootloader.done(["js\/pymk_refresh.js"]); }