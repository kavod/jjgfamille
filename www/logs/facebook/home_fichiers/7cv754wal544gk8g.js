/*    HTTP Host:  b.static.ak.fbcdn.net                                        */
/*    Generated:  March 26th 2009 4:10:55 PM PDT                               */
/*      Machine:  10.16.139.101                                                */
/*       Source:  Local Cache                                                  */
/*     Location:  rsrc:bu7pss6i:en_US:/html/js/7cv754wal544gk8g.pkg.js:141     */
/*       Locale:  en_US                                                        */
/*         Path:  js/7cv754wal544gk8g.pkg.js                                   */


function getRadioFormValue(obj){for(i=0;i<obj.length;i++){if(obj[i].checked){return obj[i].value;}}
return null;}
function getElementsByTagNames(list,obj){if(!obj)var obj=document;var tagNames=list.split(',');var resultArray=new Array();for(var i=0;i<tagNames.length;i++){var tags=obj.getElementsByTagName(tagNames[i]);for(var j=0;j<tags.length;j++){resultArray.push(tags[j]);}}
var testNode=resultArray[0];if(!testNode)return[];if(testNode.sourceIndex){resultArray.sort(function(a,b){return a.sourceIndex-b.sourceIndex;});}
else if(testNode.compareDocumentPosition){resultArray.sort(function(a,b){return 3-(a.compareDocumentPosition(b)&6);});}
return resultArray;}
function get_all_form_inputs(root_element){if(!root_element){root_element=document;}
return getElementsByTagNames('input,select,textarea,button',root_element);}
function get_form_select_value(select){return select.options[select.selectedIndex].value;}
function set_form_select_value(select,value){for(var i=0;i<select.options.length;++i){if(select.options[i].value==value){select.selectedIndex=i;break;}}}
function get_form_attr(form,attr){var val=form[attr];if(typeof val=='object'&&val.tagName=='INPUT'){var pn=val.parentNode,ns=val.nextSibling,node=val;pn.removeChild(node);val=form[attr];ns?pn.insertBefore(node,ns):pn.appendChild(node);}
return val;}
function serialize_form_helper(data,name,value){var match=/([^\]]+)\[([^\]]*)\](.*)/.exec(name);if(match){data[match[1]]=data[match[1]]||{};if(match[2]==''){var i=0;while(data[match[1]][i]!=undefined){i++;}}else{i=match[2];}
if(match[3]==''){data[match[1]][i]=value;}else{serialize_form_helper(data[match[1]],i.concat(match[3]),value);}}else{data[name]=value;}}
function serialize_form_fix(data){var keys=[];for(var i in data){if(data instanceof Object){data[i]=serialize_form_fix(data[i]);}
keys.push(i);}
var j=0,is_array=true;keys.sort().each(function(i){if(i!=j++){is_array=false;}});if(is_array){var ret={};keys.each(function(i){ret[i]=data[i];});return ret;}else{return data;}}
function serialize_form(obj){var data={};var elements=obj.tagName=='FORM'?obj.elements:get_all_form_inputs(obj);for(var i=elements.length-1;i>=0;i--){if(elements[i].name&&!elements[i].disabled){if(!elements[i].type||((elements[i].type=='radio'||elements[i].type=='checkbox')&&elements[i].checked)||elements[i].type=='text'||elements[i].type=='password'||elements[i].type=='hidden'||elements[i].tagName=='TEXTAREA'||elements[i].tagName=='SELECT'){serialize_form_helper(data,elements[i].name,elements[i].value);}}}
return serialize_form_fix(data);}
function do_post(uri){var pieces=/(^([^?])+)\??(.*)$/.exec(uri.toString());var form=document.createElement('form');form.action=pieces[1];form.method='post';form.style.display='none';var sparam=/([\w]+)(?:=([^&]+)|&|$)/g;var param=null;if(ge('post_form_id')){pieces[3]+='&post_form_id='+$('post_form_id').value;}
while(param=sparam.exec(pieces[3])){var input=document.createElement('input');input.type='hidden';input.name=decodeURIComponent(param[1]);input.value=decodeURIComponent(param[2]);form.appendChild(input);}
DOM.getRootElement().appendChild(form);form.submit();return false;}
function dynamic_post(uri,params,target){var form=document.createElement('form');form.action=uri.toString();form.method='POST';form.style.display='none';if(target){form.target=target;}
if(ge('post_form_id')){params['post_form_id']=$('post_form_id').value;}
params['post_form_id_source']='dynamic_post';params['next']=htmlspecialchars(document.location.href);for(var param in params){if(typeof params[param]=='object'){if(params[param]instanceof Array){for(var i=0;i<params[param].length;i++){var v=params[param][i];form.appendChild(create_hidden_input(param+'['+i+']',v));}}else{for(var k in params[param]){var v=params[param][k];form.appendChild(create_hidden_input(param+'['+k+']',v));}}}else{form.appendChild(create_hidden_input(param,params[param]));}}
DOM.getRootElement().appendChild(form);form.submit();return false;}

function animation(obj){if(obj==undefined){Util.error("Creating animation on non-existant object");return;}
if(this==window){return new animation(obj);}else{this.obj=obj;this._reset_state();this.queue=[];this.last_attr=null;}}
animation.resolution=20;animation.offset=0;animation.prototype._reset_state=function(){this.state={attrs:{},duration:500}}
animation.prototype.stop=function(){this._reset_state();this.queue=[];return this;}
animation.prototype._build_container=function(){if(this.container_div){this._refresh_container();return;}
if(this.obj.firstChild&&this.obj.firstChild.__animation_refs){this.container_div=this.obj.firstChild;this.container_div.__animation_refs++;this._refresh_container();return;}
var container=document.createElement('div');container.style.padding='0px';container.style.margin='0px';container.style.border='0px';container.__animation_refs=1;var children=this.obj.childNodes;while(children.length){container.appendChild(children[0]);}
this.obj.appendChild(container);this.obj.style.overflow='hidden';this.container_div=container;this._refresh_container();}
animation.prototype._refresh_container=function(){this.container_div.style.height='auto';this.container_div.style.width='auto';this.container_div.style.height=this.container_div.offsetHeight+'px';this.container_div.style.width=this.container_div.offsetWidth+'px';}
animation.prototype._destroy_container=function(){if(!this.container_div){return;}
if(!--this.container_div.__animation_refs){var children=this.container_div.childNodes;while(children.length){this.obj.appendChild(children[0]);}
this.obj.removeChild(this.container_div);}
this.container_div=null;}
animation.ATTR_TO=1;animation.ATTR_BY=2;animation.ATTR_FROM=3;animation.prototype._attr=function(attr,value,mode){attr=attr.replace(/-[a-z]/gi,function(l){return l.substring(1).toUpperCase();});var auto=false;switch(attr){case'background':this._attr('backgroundColor',value,mode);return this;case'margin':value=animation.parse_group(value);this._attr('marginBottom',value[0],mode);this._attr('marginLeft',value[1],mode);this._attr('marginRight',value[2],mode);this._attr('marginTop',value[3],mode);return this;case'padding':value=animation.parse_group(value);this._attr('paddingBottom',value[0],mode);this._attr('paddingLeft',value[1],mode);this._attr('paddingRight',value[2],mode);this._attr('paddingTop',value[3],mode);return this;case'backgroundColor':case'borderColor':case'color':value=animation.parse_color(value);break;case'opacity':value=parseFloat(value,10);break;case'height':case'width':if(value=='auto'){auto=true;}else{value=parseInt(value,10);}
break;case'borderWidth':case'lineHeight':case'fontSize':case'marginBottom':case'marginLeft':case'marginRight':case'marginTop':case'paddingBottom':case'paddingLeft':case'paddingRight':case'paddingTop':case'bottom':case'left':case'right':case'top':case'scrollTop':case'scrollLeft':value=parseInt(value,10);break;default:throw new Error(attr+' is not a supported attribute!');}
if(this.state.attrs[attr]===undefined){this.state.attrs[attr]={};}
if(auto){this.state.attrs[attr].auto=true;}
switch(mode){case animation.ATTR_FROM:this.state.attrs[attr].start=value;break;case animation.ATTR_BY:this.state.attrs[attr].by=true;case animation.ATTR_TO:this.state.attrs[attr].value=value;break;}}
animation.prototype.to=function(attr,value){if(value===undefined){this._attr(this.last_attr,attr,animation.ATTR_TO);}else{this._attr(attr,value,animation.ATTR_TO);this.last_attr=attr;}
return this;}
animation.prototype.by=function(attr,value){if(value===undefined){this._attr(this.last_attr,attr,animation.ATTR_BY);}else{this._attr(attr,value,animation.ATTR_BY);this.last_attr=attr;}
return this;}
animation.prototype.from=function(attr,value){if(value===undefined){this._attr(this.last_attr,attr,animation.ATTR_FROM);}else{this._attr(attr,value,animation.ATTR_FROM);this.last_attr=attr;}
return this;}
animation.prototype.duration=function(duration){this.state.duration=duration?duration:0;return this;}
animation.prototype.checkpoint=function(distance,callback){if(distance===undefined){distance=1;}
this.state.checkpoint=distance;this.queue.push(this.state);this._reset_state();this.state.checkpointcb=callback;return this;}
animation.prototype.blind=function(){this.state.blind=true;return this;}
animation.prototype.hide=function(){this.state.hide=true;return this;}
animation.prototype.show=function(){this.state.show=true;return this;}
animation.prototype.ease=function(ease){this.state.ease=ease;return this;}
animation.prototype.go=function(){var time=(new Date()).getTime();this.queue.push(this.state);for(var i=0;i<this.queue.length;i++){this.queue[i].start=time-animation.offset;if(this.queue[i].checkpoint){time+=this.queue[i].checkpoint*this.queue[i].duration;}}
animation.push(this);return this;}
animation.prototype._frame=function(time){var done=true;var still_needs_container=false;var whacky_firefox=false;for(var i=0;i<this.queue.length;i++){var cur=this.queue[i];if(cur.start>time){done=false;continue;}
if(cur.checkpointcb){this._callback(cur.checkpointcb,time-cur.start);cur.checkpointcb=null;}
if(cur.started===undefined){if(cur.show){this.obj.style.display='block';}
for(var a in cur.attrs){if(cur.attrs[a].start!==undefined){continue;}
switch(a){case'backgroundColor':case'borderColor':case'color':var val=animation.parse_color(CSS.getStyle(this.obj,a=='borderColor'?'borderLeftColor':a));if(cur.attrs[a].by){cur.attrs[a].value[0]=Math.min(255,Math.max(0,cur.attrs[a].value[0]+val[0]));cur.attrs[a].value[1]=Math.min(255,Math.max(0,cur.attrs[a].value[1]+val[1]));cur.attrs[a].value[2]=Math.min(255,Math.max(0,cur.attrs[a].value[2]+val[2]));}
break;case'opacity':var val=CSS.getOpacity(this.obj);if(cur.attrs[a].by){cur.attrs[a].value=Math.min(1,Math.max(0,cur.attrs[a].value+val));}
break;case'height':var val=DOM.getBoxHeight(this.obj);if(cur.attrs[a].by){cur.attrs[a].value+=val;}
break;case'width':var val=DOM.getBoxWidth(this.obj);if(cur.attrs[a].by){cur.attrs[a].value+=val;}
break;case'scrollLeft':case'scrollTop':var val=(this.obj==document.body)?(document.documentElement[a]||document.body[a]):this.obj[a];if(cur.attrs[a].by){cur.attrs[a].value+=val;}
cur['last'+a]=val;break;default:var val=parseInt(CSS.getStyle(this.obj,a),10);if(cur.attrs[a].by){cur.attrs[a].value+=val;}
break;}
cur.attrs[a].start=val;}
if((cur.attrs.height&&cur.attrs.height.auto)||(cur.attrs.width&&cur.attrs.width.auto)){if(ua.firefox()<3){whacky_firefox=true;}
this._destroy_container();for(var a in{height:1,width:1,fontSize:1,borderLeftWidth:1,borderRightWidth:1,borderTopWidth:1,borderBottomWidth:1,paddingLeft:1,paddingRight:1,paddingTop:1,paddingBottom:1}){if(cur.attrs[a]){this.obj.style[a]=cur.attrs[a].value+(typeof cur.attrs[a].value=='number'?'px':'');}}
if(cur.attrs.height&&cur.attrs.height.auto){cur.attrs.height.value=DOM.getBoxHeight(this.obj);}
if(cur.attrs.width&&cur.attrs.width.auto){cur.attrs.width.value=DOM.getBoxWidth(this.obj);}}
cur.started=true;if(cur.blind){this._build_container();}}
var p=(time-cur.start)/cur.duration;if(p>=1){p=1;if(cur.hide){this.obj.style.display='none';}}else{done=false;}
var pc=cur.ease?cur.ease(p):p;if(!still_needs_container&&p!=1&&cur.blind){still_needs_container=true;}
if(whacky_firefox&&this.obj.parentNode){var parentNode=this.obj.parentNode;var nextChild=this.obj.nextSibling;parentNode.removeChild(this.obj);}
for(var a in cur.attrs){switch(a){case'backgroundColor':case'borderColor':case'color':this.obj.style[a]='rgb('+
animation.calc_tween(pc,cur.attrs[a].start[0],cur.attrs[a].value[0],true)+','+
animation.calc_tween(pc,cur.attrs[a].start[1],cur.attrs[a].value[1],true)+','+
animation.calc_tween(pc,cur.attrs[a].start[2],cur.attrs[a].value[2],true)+')';break;case'opacity':CSS.setOpacity(this.obj,animation.calc_tween(pc,cur.attrs[a].start,cur.attrs[a].value));break;case'height':case'width':this.obj.style[a]=pc==1&&cur.attrs[a].auto?'auto':animation.calc_tween(pc,cur.attrs[a].start,cur.attrs[a].value,true)+'px';break;case'scrollLeft':case'scrollTop':var val=(this.obj==document.body)?(document.documentElement[a]||document.body[a]):this.obj[a];if(cur['last'+a]!=val){delete cur.attrs[a];}else{var diff=animation.calc_tween(pc,cur.attrs[a].start,cur.attrs[a].value,true)-val;if(DOMScroll.usingScrollWrapper()){this.obj[a]=diff+val;}else{if(a=='scrollLeft'){window.scrollBy(diff,0);}else{window.scrollBy(0,diff);}}
cur['last'+a]=diff+val;}
break;default:this.obj.style[a]=animation.calc_tween(pc,cur.attrs[a].start,cur.attrs[a].value,true)+'px';break;}}
if(p==1){this.queue.splice(i--,1);this._callback(cur.ondone,time-cur.start-cur.duration);}}
if(whacky_firefox){parentNode[nextChild?'insertBefore':'appendChild'](this.obj,nextChild);}
if(!still_needs_container&&this.container_div){this._destroy_container();}
return!done;}
animation.prototype.ondone=function(fn){this.state.ondone=fn;return this;}
animation.prototype._callback=function(callback,offset){if(callback){animation.offset=offset;callback.call(this);animation.offset=0;}}
animation.calc_tween=function(p,v1,v2,whole){return(whole?parseInt:parseFloat)((v2-v1)*p+v1,10);}
animation.parse_color=function(color){var hex=/^#([a-f0-9]{1,2})([a-f0-9]{1,2})([a-f0-9]{1,2})$/i.exec(color);if(hex){return[parseInt(hex[1].length==1?hex[1]+hex[1]:hex[1],16),parseInt(hex[2].length==1?hex[2]+hex[2]:hex[2],16),parseInt(hex[3].length==1?hex[3]+hex[3]:hex[3],16)];}else{var rgb=/^rgba? *\(([0-9]+), *([0-9]+), *([0-9]+)(?:, *([0-9]+))?\)$/.exec(color);if(rgb){if(rgb[4]==='0'){return[255,255,255];}else{return[parseInt(rgb[1],10),parseInt(rgb[2],10),parseInt(rgb[3],10)];}}else if(color=='transparent'){return[255,255,255];}else{throw'Named color attributes are not supported.';}}}
animation.parse_group=function(value){var value=trim(value).split(/ +/);if(value.length==4){return value;}else if(value.length==3){return[value[0],value[1],value[2],value[1]];}else if(value.length==2){return[value[0],value[1],value[0],value[1]];}else{return[value[0],value[0],value[0],value[0]];}}
animation.push=function(instance){if(!animation.active){animation.active=[];}
animation.active.push(instance);if(!animation.timeout){animation.timeout=setInterval(animation.animate.bind(animation),animation.resolution,false);}
animation.animate(true);}
animation.animate=function(last){var time=(new Date()).getTime();for(var i=last===true?animation.active.length-1:0;i<animation.active.length;i++){try{if(!animation.active[i]._frame(time)){animation.active.splice(i--,1);}}catch(e){animation.active.splice(i--,1);}}
if(animation.active.length==0){clearInterval(animation.timeout);animation.timeout=null;}}
animation.ease={}
animation.ease.begin=function(p){return p*p;}
animation.ease.end=function(p){p-=1;return-(p*p)+1;}
animation.ease.both=function(p){if(p<=0.5){return(p*p)*2;}else{p-=1;return(p*p)*-2+1;}}

function URI(uri){if(uri===window){Util.error('what the hell are you doing');return;}
if(this===window){return new URI(uri||window.location.href);}
this.parse(uri||'');}
copy_properties(URI,{getRequestURI:function(respect_page_transitions){respect_page_transitions=respect_page_transitions===undefined||respect_page_transitions;if(respect_page_transitions&&window.PageTransitions&&PageTransitions.isInitialized()){return PageTransitions.getCurrentURI().getQualifiedURI();}else{return new URI(window.location.href);}},getMostRecentURI:function(){if(window.PageTransitions&&PageTransitions.isInitialized()){return PageTransitions.getMostRecentURI().getQualifiedURI();}else{return new URI(window.location.href);}},expression:/(((\w+):\/\/)([^\/:]*)(:(\d+))?)?([^#?]*)(\?([^#]*))?(#(.*))?/,arrayQueryExpression:/^(\w+)((?:\[\w*\])+)=?(.*)/,explodeQuery:function(q){if(!q){return{};}
var result={};q=q.replace(/%5B/ig,'[').replace(/%5D/ig,']');q=q.split('&');for(var ii=0,length=q.length;ii<length;ii++){var match=q[ii].match(URI.arrayQueryExpression);if(!match){var term=q[ii].split('=');result[URI.decodeComponent(term[0])]=term[1]===undefined?null:URI.decodeComponent(term[1]);}else{var indices=match[2].split(/\]\[|\[|\]/).slice(0,-1);var name=match[1];var value=URI.decodeComponent(match[3]||'');indices[0]=name;var resultNode=result;for(var i=0;i<indices.length-1;i++){if(indices[i]){if(resultNode[indices[i]]===undefined){if(indices[i+1]&&!indices[i+1].match(/\d+$/)){resultNode[indices[i]]={};}else{resultNode[indices[i]]=[];}}
resultNode=resultNode[indices[i]];}else{if(indices[i+1]&&!indices[i+1].match(/\d+$/)){resultNode.push({});}else{resultNode.push([]);}
resultNode=resultNode[resultNode.length-1];}}
if(resultNode instanceof Array&&indices[indices.length-1]==''){resultNode.push(value);}else{resultNode[indices[indices.length-1]]=value;}}}
return result;},implodeQuery:function(obj,name){name=name||'';var r=[];if(obj===null){r.push(URI.encodeComponent(name));}else if(obj instanceof Array){for(var ii=0;ii<obj.length;++ii){try{if(obj[ii]!==undefined){r.push(URI.implodeQuery(obj[ii],name?(name+'['+ii+']'):ii));}}catch(ignored){}}}else if(typeof(obj)=='object'){if(DOM.isNode(obj)){r.push('{node}');}else{for(var k in obj){try{if(obj[k]!==undefined){r.push(URI.implodeQuery(obj[k],name?(name+'['+k+']'):k));}}catch(ignored){}}}}else{r.push(URI.encodeComponent(name)+'='+URI.encodeComponent(obj));}
return r.join('&');},encodeComponent:function(raw){var parts=String(raw).split(/([\[\]])/);for(var i=0,length=parts.length;i<length;i+=2){parts[i]=window.encodeURIComponent(parts[i]);}
return parts.join('');},decodeComponent:function(encoded_s){return window.decodeURIComponent(encoded_s.replace(/\+/g,' '));}});copy_properties(URI.prototype,{parse:function(uri){var m=uri.toString().match(URI.expression);copy_properties(this,{protocol:m[3]||'',domain:m[4]||'',port:m[6]||'',path:m[7]||'',query_s:m[9]||'',fragment:m[11]||''});return this;},setProtocol:function(p){this.protocol=p;return this;},getProtocol:function(){return this.protocol;},setQueryData:function(o){this.query_s=URI.implodeQuery(o);return this;},addQueryData:function(o){return this.setQueryData(copy_properties(this.getQueryData(),o));},removeQueryData:function(keys){if(!(keys instanceof Array)){keys=[keys];}
var query=this.getQueryData();for(var i=0,length=keys.length;i<length;++i){delete query[keys[i]];}
return this.setQueryData(query);},getQueryData:function(){return URI.explodeQuery(this.query_s);},setFragment:function(f){this.fragment=f;return this;},getFragment:function(){return this.fragment;},setDomain:function(d){this.domain=d;return this;},getDomain:function(){return this.domain;},setPort:function(p){this.port=p;return this;},getPort:function(){return this.port;},setPath:function(p){this.path=p;return this;},getPath:function(){return this.path.replace(/^\/+/,'/');},toString:function(){var r='';this.protocol&&(r+=this.protocol+'://');this.domain&&(r+=this.domain);this.port&&(r+=':'+this.port);if(this.domain&&!this.path){r+='/';}
this.path&&(r+=this.path);this.query_s&&(r+='?'+this.query_s);this.fragment&&(r+='#'+this.fragment);return r;},valueOf:function(){return this.toString();},isFacebookURI:function(){if(!URI._facebookURIRegex){URI._facebookURIRegex=new RegExp('(^|\.)facebook\.('+env_get('tlds').join('|')+')([^.]*)$','i');}
return!this.domain||URI._facebookURIRegex.test(this.domain);},getRegisteredDomain:function(){if(!this.domain){return'';}
if(!this.isFacebookURI()){return null;}
var parts=this.domain.split('.');var index=parts.indexOf('facebook');return parts.slice(index).join('.');},getTld:function(true_tld){if(!this.domain){return'';}
var parts=this.domain.split('.');var tld=parts[parts.length-1];if(true_tld){return tld;}
var launched_tlds=env_get('tlds');if(launched_tlds.indexOf(tld)==-1){for(var i=0;i<launched_tlds.length;++i){var launched_tld=launched_tlds[i];if(new RegExp(launched_tld+'$').test(this.domain)){tld=launched_tld;break;}}}
return tld;},getUnqualifiedURI:function(){return new URI(this).setProtocol(null).setDomain(null).setPort(null);},getQualifiedURI:function(){var uri=new URI(this);if(!uri.getDomain()){var current=URI();uri.setProtocol(current.getProtocol()).setDomain(current.getDomain()).setPort(current.getPort());}
return uri;},isSameOrigin:function(asThisURI){var uri=asThisURI||window.location.href;if(!(uri instanceof URI)){uri=new URI(uri.toString());}
if(this.getProtocol()&&this.getProtocol()!=uri.getProtocol()){return false;}
if(this.getDomain()&&this.getDomain()!=uri.getDomain()){return false;}
return true;},coerceToSameOrigin:function(targetURI){var uri=targetURI||window.location.href;if(!(uri instanceof URI)){uri=new URI(uri.toString());}
if(this.isSameOrigin(uri)){return true;}
if(this.getProtocol()!=uri.getProtocol()){return false;}
var dst=uri.getDomain().split('.');var src=this.getDomain().split('.');var dst_part;if(uri.isFacebookURI()){while((dst_part=dst.pop())&&dst_part==src.pop()){if(dst_part=='facebook'){this.setDomain(uri.getDomain());return true;}}}
return false;},go:function(){goURI(this);},setSubdomain:function(subdomain){var uri=new URI(this).getQualifiedURI();var domains=uri.getDomain().split('.');if(domains.length<=2){domains.unshift(subdomain);}else{domains[0]=subdomain;}
return uri.setDomain(domains.join('.'));},getSubdomain:function(){if(!this.getDomain()){return'';}
var domains=this.getDomain().split('.');if(domains.length<=2){return'';}else{return domains[0];}}});

function AsyncRequest(uri){var dispatchResponse=bind(this,function(asyncResponse){if(!this._asyncResponse){this._asyncResponse=asyncResponse;}
try{this.clearStatusIndicator();if(this.initialHandler(asyncResponse)!==false){if(this.handler){try{this.handler(asyncResponse);}catch(exception){this.finallyHandler(asyncResponse);throw exception;}}
this.finallyHandler(asyncResponse);if(asyncResponse.instrument){Env.t_domcontent=(new Date()).getTime();Env.t_layout=Env.t_domcontent;var force_layout=document&&DOMScroll.getScrollRoot()&&DOMScroll.getScrollRoot().offsetWidth;Env.t_onload=(new Date()).getTime();Env.t_willonloadhooks=Env.t_onload;}
var onload=asyncResponse.onload;if(onload){for(var ii=0;ii<onload.length;ii++){try{eval('(function() {'+onload[ii]+'})();');}catch(exception){Util.error('An onload hook in response to a request to to URI %q threw an '+'exception: %x. (This is not a problem with AsyncRequest, it is '+'a problem with the registered hook.)',this.getURI(),exception);}}}
if(asyncResponse.instrument){Env.t_doneonloadhooks=(new Date()).getTime();}
var onafterload=asyncResponse.onafterload;if(onafterload){for(var ii=0;ii<onafterload.length;ii++){try{eval('(function() {'+onafterload[ii]+'})();');}catch(exception){Util.error('An onafterload hook in response to a request to to URI %q threw an '+'exception: %x. (This is not a problem with AsyncRequest, it is '+'a problem with the registered hook.)',this.getURI(),exception);}}}
var invalidate_cache=asyncResponse.invalidate_cache;if(invalidate_cache&&invalidate_cache.length){Arbiter.inform(Arbiter.PAGECACHE_INVALIDATE,invalidate_cache);}}
if(asyncResponse.cacheObservation&&typeof(TabConsoleCacheobserver)!='undefined'&&TabConsoleCacheobserver.instance){TabConsoleCacheobserver.getInstance().addAsyncObservation(asyncResponse.cacheObservation);}}catch(exception){Util.error('The user supplied handler function for an AsyncRequest to URI %q '+'threw an exception: %x. (This is not a problem with AsyncRequest, it '+'is a problem with the callback, which failed to catch the exception.)',this.getURI(),exception);}});var replayResponse=bind(this,function(){if(!this._asyncResponse){Util.warn('Unable to replay AsyncResponse for an AsyncRequest to '+this.getURI());return;}
Util.log('replaying the response for '+this.getURI());dispatchResponse(this._asyncResponse);});var dispatchErrorResponse=bind(this,function(asyncResponse,isTransport){try{this.clearStatusIndicator();var async_error=asyncResponse.getError();if(async_error==kError_Async_InternalCaptchaRequired){this._captchaHtml=asyncResponse.getPayload().captcha_html;this._displayCaptcha();}else if(async_error==kError_Async_ConfirmationRequired){var payload=asyncResponse.getPayload();this.requireConfirmation(payload.confirmation_message,payload.confirmation_title,payload.confirmation_button);this._displayConfirmation();}else if(this.initialHandler(asyncResponse)!==false){try{if(isTransport){this.transportErrorHandler(asyncResponse);}else{this.errorHandler(asyncResponse);}}catch(exception){this.finallyHandler(asyncResponse);throw exception;}
this.finallyHandler(asyncResponse);}}catch(exception){Util.error('Async error handler threw an exception for URI %q, when processing a '+'%d error: %x.',this.getURI(),asyncResponse.getError(),exception);}});var _interpretTransportResponse=bind(this,function(){if(this.getOption('suppressEvaluation')){var r=new AsyncResponse();r.payload=this.transport;return{asyncResponse:r};}
var shield="for (;;);";var shieldlen=shield.length;if(this.transport.responseText.length<=shieldlen){var kind=this.transport.responseText.length?('a '+this.transport.responseText.length+' byte'):'an empty';return{transportError:sprintf('An error occurred when making an AsyncRequest to %q. '+'The server returned '+kind+' response.',this.getURI())};}
var text=this.transport.responseText;var offset=0;while(text.charAt(offset)==" "||text.charAt(offset)=="\n"){offset++;}
if(offset&&text.substring(offset,offset+shieldlen)==shield){Util.error('Response for request to endpoint %q seems to be valid, but was '+'preceeded by whitespace. (This probably means that someone '+'committed whitespace in a header file.)',this.getURI());}
var safeResponse=text.substring(offset+shieldlen);var response;try{eval('response = ('+safeResponse+')');}catch(exception){return{transportError:sprintf('Evaluation failed for <a href="javascript:aiert(%e);">'+'response from %q</a>: %x.',this.transport.responseText,this.getURI(),exception)};}
return interpretResponse(response);});var interpretResponse=bind(this,function(response){if(response.redirect){return{redirect:response.redirect};}
var r=new AsyncResponse();if(typeof(response.payload)=='undefined'||typeof(response.error)=='undefined'||typeof(response.errorDescription)=='undefined'||typeof(response.errorSummary)=='undefined'||typeof(response.errorIsWarning)=='undefined'){Util.warn('AsyncRequest to endpoint %q returned a JSON response, but it '+'is not properly formatted. The endpoint needs to provide a '+'response including both error and payload information; use '+'the AsyncResponse PHP class to do this easily.',this.getURI());r.payload=response;}else{copy_properties(r,response);}
return{asyncResponse:r};});var invokeResponseHandler=bind(this,function(interp){if(typeof(interp.redirect)!='undefined'){(function(){this.setURI(interp.redirect).send();}).bind(this).defer();return;}
if(this.handler||this.errorHandler||this.transportErrorHandler){if(typeof(interp.transportError)!='undefined'){var r=new AsyncResponse();var errorDescription=Util.isDevelopmentEnvironment()?interp.transportError:_tx("Something went wrong. We're working on getting this fixed as soon as we can. You may be able to try again.");copy_properties(r,{error:1000,errorSummary:_tx("Oops"),errorDescription:errorDescription});if(this.transportErrorHandler){dispatchErrorResponse(r,true);}else{Util.error('Something bad happened; provide a transport error handler for '+'complete details.');}
return;}
var r=interp.asyncResponse;document.cookie="cavalry_transit_start_time=;"
+" expires=Mon, 26 Jul 1997 05:00:00 GMT;"
+" path=/;"
+" domain=.facebook.com";if(r.instrument){if(window.___t_measuring){r.instrument=false;}else{window.___t_arrival=(new Date()).getTime();window.___t_measuring=true;window.Env=window.Env||{};Env.start=(new Date()).getTime();cavalry_measure=[];}}
if(r.instrument){___tcss=0;___thtml=0;___tjs=(new Date()).getTime()-Env.start;}
if(r.getError()&&!r.getErrorIsWarning()){var fn=dispatchErrorResponse;}else{var fn=dispatchResponse;}
fn=fn.shield(null,r);fn=fn.defer.bind(fn);if(r.bootload){var is_transitional=false;if(this.preBootloadHandler){is_transitional=this.preBootloadHandler(r);}
Bootloader.loadResources(r.bootload,fn,is_transitional);}else{fn();}}});var invokeErrorHandler=bind(this,function(explicitError){try{if(!window.loaded){return;}}catch(ex){return;}
var r=new AsyncResponse();var err;try{err=explicitError||this.transport.status||1001;}catch(ex){err=1001;}
try{if(this.responseText==''){err=1002;}}catch(ignore){}
if(this.transportErrorHandler){var desc=sprintf('Transport error (#%d) while retrieving data from endpoint %q: %s',err,this.getURI(),AsyncRequest.getHTTPErrorDescription(err));if(!this.getOption('suppressErrorAlerts')){Util.error(desc);}
copy_properties(r,{error:err,errorSummary:AsyncRequest.getHTTPErrorSummary(err),errorDescription:desc});dispatchErrorResponse(r,true);}else{Util.error('Async request to %q failed with a %d error, but there was no error '+'handler available to deal with it.',this.getURI(),err);}});var handleResponse=function(response){var asyncResponse=this.interpretResponse(response);this.invokeResponseHandler(asyncResponse);}
var onStateChange=function(){try{if(this.transport.readyState==4){if(this.transport.status>=200&&this.transport.status<300){invokeResponseHandler(_interpretTransportResponse());}else{if(ua.safari()&&(typeof(this.transport.status)=='undefined')){invokeErrorHandler(1002);}else{invokeErrorHandler();}}
if(this.getOption('asynchronous')!==false){delete this.transport;}}}catch(exception){try{if(!window.loaded){return;}}catch(ex){return;}
delete this.transport;if(this.remainingRetries){--this.remainingRetries;this.send(true);}else{if(!this.getOption('suppressErrorAlerts')){Util.error('AsyncRequest exception when attempting to handle a state change: %x.',exception);}
invokeErrorHandler(1001);}}};copy_properties(this,{onstatechange:onStateChange,replayResponse:replayResponse,invokeResponseHandler:invokeResponseHandler,interpretResponse:interpretResponse,handleResponse:handleResponse,transport:null,method:'POST',uri:'',initialHandler:bagofholding,handler:null,errorHandler:null,transportErrorHandler:null,finallyHandler:bagofholding,statusElement:null,logNectar:true,data:{},context:{},readOnly:false,writeRequiredParams:['post_form_id'],remainingRetries:0,option:{asynchronous:true,suppressErrorHandlerWarning:false,suppressEvaluation:false,suppressErrorAlerts:false,retries:1,jsonp:false,bundle:false,useIframeTransport:false},_captchaHtml:'',_confirmationMessage:'',_confirmationTitle:'',_confirmationButton:'',_requiresConfirmation:false,_replayable:undefined,_replayKey:''});if(typeof ErrorDialog!="undefined"){this.errorHandler=ErrorDialog.showAsyncError;this.transportErrorHandler=ErrorDialog.showAsyncError;}
if(uri!=undefined){this.setURI(uri);}
return this;}
copy_properties(AsyncRequest,{getHTTPErrorSummary:function(errCode){return AsyncRequest._getHTTPError(errCode).summary;},getHTTPErrorDescription:function(errCode){return AsyncRequest._getHTTPError(errCode).description;},pingURI:function(uri,data,synchronous){data=data||{};return new AsyncRequest().setURI(uri).setData(data).setOption('asynchronous',!synchronous).setOption('suppressErrorHandlerWarning',true).setErrorHandler(bagofholding).setTransportErrorHandler(bagofholding).send();},receiveJSONPResponse:function(path,data){if(this._JSONPReceivers[path]){for(var ii=0;ii<this._JSONPReceivers[path].length;ii++){var request=this._JSONPReceivers[path][ii];if(request.transportIframe){(function(x){DOMScroll.getScrollRoot().removeChild(x);}).bind(null,request.transportIframe).defer();}
request.invokeResponseHandler(request.interpretResponse(data));}
delete this._JSONPReceivers[path];}},_hasBundledRequest:function(){return!is_empty(AsyncRequest._allBundledRequests);},registerBundledRequestProperties:function(properties){if(!AsyncRequest._hasBundledRequest()){var callback=properties.callback;callback&&callback();}else{copy_properties(AsyncRequest._bundledRequestProperties,properties);}},_bundleRequest:function(request){if(request.getOption('jsonp')||request.getOption('useIframeTransport')){Util.error('You cannot bundle AsyncRequest that uses jsonp or iframe transport.');request.setOption('bundle',false);return false;}else if(!request.uri.isFacebookURI()){Util.error('You can not bundle AsyncRequest sent to non-facebook URIs');request.setOption('bundle',false);return false;}else if(!request.getOption('asynchronous')){Util.error('We cannot bundle synchronous AsyncRequests');request.setOption('bundle',false);return false;}
var path=request.uri.getPath();if(path in AsyncRequest._allBundledRequests){Util.warn('Bundling multiple AsyncRequests to the same endpoint is not '+'supported. They will still be sent seqentially. Only the last '+'AsyncRequest to a unique endpoint is included in the bundle.');var old_request=AsyncRequest._allBundledRequests[path];old_request.setOption('bundle',false).send();}
if(is_empty(AsyncRequest._allBundledRequests)){setTimeout(function(){AsyncRequest._sendBundledRequests();},0);}
AsyncRequest._allBundledRequests[path]=request;return true;},_sendBundledRequests:function(){var bundled_requests=AsyncRequest._allBundledRequests;AsyncRequest._allBundledRequests={};var property={};copy_properties(property,AsyncRequest._bundledRequestProperties);AsyncRequest._bundledRequestProperties={};var on_done=function(){property.callback&&property.callback();};if(is_empty(bundled_requests)){on_done();return;}
var data={};for(var path in bundled_requests){var request=bundled_requests[path];data[path]=URI.implodeQuery(request.data);}
var query_data={data:data}
if(property.extra_data){copy_properties(query_data,property.extra_data);}
new AsyncRequest().setURI('/ajax/proxy.php').setData(query_data).setMethod('POST').setInitialHandler(property.onInitialResponse||truth).setHandler(function(r){var payload=r.getPayload();var responses=payload.responses;for(var path in bundled_requests){var request=bundled_requests[path];if(path in responses){var asyncResponse=request.interpretResponse(responses[path]);request.invokeResponseHandler(asyncResponse);}else{var response={transportError:sprintf('An error occurred when making an AsyncRequest to %q '+' in a bundled request.',path)};request.invokeResponseHandler(response);}}}).setTransportErrorHandler(function(response){var paths=[];var interp={transportError:response.errorDescription};for(var path in bundled_requests){paths.push(path);var request=bundled_requests[path];request.invokeResponseHandler(interp);}
Util.error('Transport error occured for bundled requests to '+
paths.join(', '));}).setFinallyHandler(function(r){on_done();}).send()},_getHTTPError:function(errCode){var e=AsyncRequest._HTTPErrors[errCode]||AsyncRequest._HTTPErrors[errCode-(errCode%100)]||{summary:'HTTP Error',description:'Unknown HTTP error #'+errCode};return e;},_HTTPErrors:{400:{summary:'Bad Request',description:'Bad HTTP request.'},401:{summary:'Unauthorized',description:'Not authorized.'},403:{summary:'Forbidden',description:'Access forbidden.'},404:{summary:'Not Found',description:'Web address does not exist.'},1000:{summary:'Bad Response',description:'Invalid response.'},1001:{summary:'No Network',description:'A network error occurred. Check that you are connected to the '+'internet.'},1002:{summary:'No Data',description:'The server did not return a response.'},1003:{summary:'Eval Error',description:'Exception thrown during JSON evaluation.'}},_JSONPReceivers:[],_allBundledRequests:{},_bundledRequestProperties:{}});copy_properties(AsyncRequest.prototype,{setMethod:function(m){this.method=m.toString().toUpperCase();return this;},getMethod:function(){return this.method;},setData:function(obj){this.data=obj;return this;},getData:function(){return this.data;},setContextData:function(key,value,enabled){enabled=enabled===undefined?true:enabled;if(enabled){this.context['_log_'+key]=value;}
return this;},setURI:function(uri){var uri_obj=URI(uri);if(this.getOption('useIframeTransport')&&!uri_obj.isFacebookURI()){Util.error('IframeTransport requests should only be used when going between '+'different Facebook subdomains.  This probably won\'t do what you want '+'if you\'re going to a non-Facebook URI.  Check out JSONP for that, '+'but that\'s also a bad idea to use.');return this;}
if(!this.getOption('jsonp')&&!this.getOption('useIframeTransport')&&!uri_obj.isSameOrigin()){Util.error('Asynchronous requests must specify relative URIs (like %q); this '+'ensures they conform to the Same Origin Policy (see %q). The '+'provided absolute URI (%q) is invalid, use a relative URI instead. '+'If you need to dispatch cross-domain requests, you can use JSONP, '+'but consider this decision carefully because there are tradeoffs and '+'JSONP is completely insecure.','/path/to/endpoint.php','http://www.mozilla.org/projects/security/components/same-origin.html',uri_obj.toString());return this;}
this.uri=uri_obj;return this;},getURI:function(){return this.uri.toString();},setInitialHandler:function(fn){this.initialHandler=fn;return this;},setHandler:function(fn){if(typeof(fn)!='function'){Util.error('AsyncRequest response handlers must be functions. Pass a function, '+'or use bind() to build one.');}else{this.handler=fn;}
return this;},getHandler:function(){return this.handler;},setErrorHandler:function(fn){if(typeof(fn)!='function'){Util.error('AsyncRequest error handlers must be functions. Pass a function, or '+'use bind() to build one.');}else{this.errorHandler=fn;}
return this;},setTransportErrorHandler:function(fn){this.transportErrorHandler=fn;return this;},getErrorHandler:function(){return this.errorHandler;},getTransportErrorHandler:function(){return this.transportErrorHandler;},setFinallyHandler:function(fn){this.finallyHandler=fn;return this;},setPreBootloadHandler:function(fn){this.preBootloadHandler=fn;return this;},disableNectar:function(){this.logNectar=false;return this;},setReadOnly:function(readOnly){if(typeof(readOnly)!='boolean'){Util.error('AsyncRequest readOnly value must be a boolean.');}else{this.readOnly=readOnly;}
return this;},setFBMLForm:function(){this.writeRequiredParams=["fb_sig"];return this;},getReadOnly:function(){return this.readOnly;},setStatusElement:function(element){this.statusElement=element;return this;},getStatusElement:function(){return this.statusElement;},clearStatusIndicator:function(){if(this.getStatusElement()){CSS.removeClass($(this.getStatusElement()),'async_saving');}},addStatusIndicator:function(){if(this.getStatusElement()){CSS.addClass($(this.getStatusElement()),'async_saving');}},specifiesWriteRequiredParams:function(){return this.writeRequiredParams.every(function(param){this.data[param]=this.data[param]||Env[param]||(ge(param)||{}).value;if(this.data[param]!==undefined){return true;}},this);},setReplayable:function(replayable,key){this._replayable=replayable;this._replayKey=key||'';return this;},setOption:function(opt,v){if(typeof(this.option[opt])!='undefined'){this.option[opt]=v;}else{Util.warn('AsyncRequest option %q does not exist; request to set it was ignored.',opt);}
return this;},getOption:function(opt){if(typeof(this.option[opt])=='undefined'){Util.warn('AsyncRequest option %q does not exist, get request failed.',opt);}
return this.option[opt];},abort:function(){if(this.transport){var old_handler=this.getTransportErrorHandler();this.setTransportErrorHandler(bagofholding);this.transport.abort();this.setTransportErrorHandler(old_handler);}},send:function(isRetry){isRetry=isRetry||false;if(this.requiresConfirmation()){this._displayConfirmation();return true;}
if(!this.uri){Util.error('Attempt to dispatch an AsyncRequest without an endpoint URI! This is '+'all sorts of silly and impossible, so the request failed.');return false;}
if(!this.errorHandler&&!this.getOption('suppressErrorHandlerWarning')){Util.warn('Dispatching an AsyncRequest that does not have an error handler. '+'You SHOULD supply one, or use AsyncRequest.pingURI(). If this '+'omission is intentional and well-considered, set the %q option to '+'suppress this warning.','suppressErrorHandlerWarning');}
if(this.getOption('jsonp')&&this.method!='GET'){this.setMethod('GET');}
if(this.getOption('useIframeTransport')&&this.method!='GET'){Util.warn('Iframe transport currently works only with GET.');this.setMethod('GET');}
if(!this.getReadOnly()){if(!this.specifiesWriteRequiredParams()){Util.error('You are making a POST request to %s without one or more of the '+'required parameters: %s. Requests which modify data and do not '+'verify the request origin through parameter validation are '+'vulnerable to CSRF attacks. You should either specify values for '+'these parameters explicitly by using setData(), put them in the '+'page as inputs, or mark this request as safe and idempotent by '+'using setReadOnly(). Consult the setReadOnly() documentation for '+'more information.',this.uri.toString(),this.writeRequiredParams.join(','));return false;}
if(this.method!='POST'){Util.error('You are making a GET request which modifies data; this violates '+'the HTTP spec and is generally a bad idea. Either change this '+'request to use POST or use setReadOnly() to mark the request as '+'idempotent and appropriate for HTTP GET. Consult the setReadOnly() '+'documentation for more information.');return false;}}
if((!this.getReadOnly()&&this._replayable!==false)||this._replayable){Arbiter.inform(Arbiter.REPLAYABLE_AJAX,this);}
if(!is_empty(this.context)){copy_properties(this.data,this.context);this.data['ajax_log']=1;}
if(!this.getReadOnly()&&this.method=='POST'&&this.data['post_form_id_source']===undefined){this.data['post_form_id_source']='AsyncRequest';}
if(this.getOption('bundle')&&env_get('ajax_bundle')&&AsyncRequest._bundleRequest(this)){return true;}
if(this.logNectar){var impid=env_get('nectar_last_impression_id');if(impid){this.data['nectar_impid']=impid;}
var navimpid=env_get('nectar_last_nav_impression_id');if(navimpid){this.data['nectar_navimpid']=navimpid;}}
else{this.data['nnctr']=1;}
var uri_str,query;if(this.method=='GET'){uri_str=this.uri.addQueryData(this.data).toString();query='';}else{uri_str=this.uri.toString();query=URI.implodeQuery(this.data);}
if(this.getOption('jsonp')||this.getOption('useIframeTransport')){var path=this.uri.getPath();if(!AsyncRequest._JSONPReceivers[path]){AsyncRequest._JSONPReceivers[path]=[];}
AsyncRequest._JSONPReceivers[path].push(this);if(this.getOption('jsonp')){(function(){DOMScroll.getScrollRoot().appendChild($N('script',{src:uri_str,type:"text/javascript"}))}).bind(this).defer();}else{var style={position:'absolute',top:'-1000px',left:'-1000px',width:'80px',height:'80px'};this.transportIframe=$N('iframe',{src:uri_str,style:style});DOMScroll.getScrollRoot().appendChild(this.transportIframe);}
return true;}
if(this.transport){Util.error('You must wait for an AsyncRequest to complete before sending another '+'request with the same object. To send two simultaneous requests, '+'create a second AsyncRequest object.');return false;}
var transport=null;try{transport=new XMLHttpRequest();}catch(ignored){};if(!transport){try{transport=new ActiveXObject("Msxml2.XMLHTTP");}catch(ignored){};}
if(!transport){try{transport=new ActiveXObject("Microsoft.XMLHTTP");}catch(ignored){};}
if(!transport){Util.error('Unable to build XMLHTTPRequest transport.');return false;}
transport.onreadystatechange=bind(this,'onstatechange');if(!isRetry){this.remainingRetries=0;if(this.getReadOnly()){this.remainingRetries=this.getOption('retries');}}
this.transport=transport;try{this.transport.open(this.method,uri_str,this.getOption('asynchronous'));}catch(ex){Util.error('Exception when opening Async transport to %q: %x',uri,ex);return false;}
var svn_rev=env_get('svn_rev');if(svn_rev){this.transport.setRequestHeader('X-SVN-Rev',String(svn_rev));}
if(this.method=='POST'){this.transport.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}
this.addStatusIndicator();this.transport.send(query);return true;},_displayCaptcha:function(){Dialog.createCaptchaDialog(this._captchaHtml,this.finallyHandler).setHandler(this._displayCaptchaDialogHandler.bind(this)).show();},_displayCaptchaDialogHandler:function(){var captcha_data=serialize_form($('captcha'));copy_properties(this.data,captcha_data);this.send();},requireConfirmation:function(message,title,button){this._confirmationMessage=message;this._confirmationTitle=title;this._confirmationButton=button;this._requiresConfirmation=true;return this;},requiresConfirmation:function(){if(this._requiresConfirmation){if(this.data.confirmed){this._requriesConfirmation=false;}}
return this._requiresConfirmation;},_displayConfirmation:function(){var message=this._confirmationMessage||_tx("Are you sure you want to perform this action?");var html='<div class="confirmation_message">'
+HTML(message)
+'</div>';var title=this._confirmationTitle||_tx("Confirmation Required");var button=this._confirmationButton||Dialog.CONFIRM;Dialog.createConfirmationDialog(html,title,button,this.finallyHandler.bind(this)).setHandler(this._displayConfirmationHandler.bind(this)).show();},_displayConfirmationHandler:function(){this.data.confirmed=1;this._requiresConfirmation=false;this.send();}});function AsyncResponse(payload){copy_properties(this,{error:0,errorSummary:null,errorDescription:null,onload:null,payload:payload||null});return this;}
copy_properties(AsyncResponse.prototype,{getPayload:function(){return this.payload;},getError:function(){return this.error;},getErrorSummary:function(){return this.errorSummary;},getErrorDescription:function(){return this.errorDescription;},getErrorIsWarning:function(){return this.errorIsWarning;}});

function intl_set_xmode(xmode){(new AsyncRequest()).setURI('/ajax/intl/save_xmode.php').setData({xmode:xmode}).setHandler(function(){document.location.reload();}).send();}
function intl_set_cmode(cmode){(new AsyncRequest()).setURI('/ajax/intl/save_xmode.php').setData({cmode:cmode}).setHandler(function(){document.location.reload();}).send();}
function intl_set_vmode(vmode){(new AsyncRequest()).setURI('/ajax/intl/save_xmode.php').setData({vmode:vmode}).setHandler(function(){document.location.reload();}).send();}
function intl_set_amode(amode){(new AsyncRequest()).setURI('/ajax/intl/save_xmode.php').setData({amode:amode,app:false}).setHandler(function(){document.location.reload();}).send();}
function intl_set_locale(obj,source,locale){if(!locale){var locale=obj.options[obj.selectedIndex].value;}
new AsyncRequest().setURI('/ajax/intl/beta_locale_check.php').setData({locale:locale}).setHandler(function(response){data=response.getPayload();if(data.rtl_unsupported){if(data.app_is_installed){new Dialog().setTitle('Limited Support For This Language').setBody('Although you can browse Facebook using this language, translation for this language '+'is only supported for Safari 3, Firefox 3 and Opera browsers for now. Please switch to one of those '+'browsers to translate Facebook to help us launch this language sooner! ').setButtons([Dialog.OK]).setHandler(intl_save_locale.bind(null,locale,true,null,source)).show();}}else if(data.locale_is_beta){if(data.app_is_installed){intl_save_locale(locale,true,null,source);}else{var async=new AsyncRequest().setURI('/ajax/intl/beta_locale_dialog.php?locale='+locale);new Dialog().setAsync(async).show();}}else{intl_save_locale(locale,true,null,source);}}).send();}
function intl_save_locale(locale,reload,location,source){new AsyncRequest().setURI('/ajax/intl/save_locale.php').setData({locale:locale,source:source}).setHandler(function(response){if(reload){document.location.reload();}else{document.location=location;}}).send();}
function intl_toggle_beta_locale_install(obj){if(obj.checked){show($('beta_locale_install'));}else{hide($('beta_locale_install'));}}
function intl_set_cookie_locale(locale,uri){var old_locale=getCookie('locale');new AsyncRequest().setURI('/ajax/intl/save_locale_cookie_logging.php').setData({new_locale:locale,old_locale:old_locale,source:'LOGGED_OUT'}).setReadOnly(true).send();setCookie('locale',locale,7*24*3600000);if(URI.getRequestURI().getTld()!='com'){transferCookieToComTld('locale',function(success){if(success){clearCookie('locale');}
goURI(uri);});}else{goURI(uri);}}
function intl_disable_rooster_save(obj){var save=document.getElementById('install_translation_app');save.disabled=!obj.checked;var container=document.getElementById('install_container');if(obj.checked){container.style.display='block';}else{container.style.display='none';}}
function intl_confirm_rooster_and_install_app(uid,divid){document.location='add.php?api_key=efa7a7045708fcadede8d705e39b1642';}
function intl_locale_is_rtl(){var body=DOM.find(document,'body');return('rtl'==CSS.getStyle(body,'direction'));}
function intl_is_left_click(e){if(e.which==null){if(e.button<2)return true;}else{if(e.which<2)return true;}
return false;}
function intl_left_click_cancelBubble(e){if(intl_is_left_click(e)){e.cancelBubble=true;}}

function generic_dialog(className,modal){this.className=className;this.content=null;this.obj=null;this.popup=null;this.overlay=null;this.modal=null;this.modal_settings={},this.iframe=null;this.hidden_objects=[];if(modal==true){this.modal=true;}
this.auto_focus=true;}
generic_dialog.dialog_stack=null;generic_dialog.prototype.setClassName=function(className){if(this.obj){CSS.addClass(this.obj,className);}
this.className=className;};generic_dialog.hide_all=function(){if(generic_dialog.dialog_stack!==null){var stack=generic_dialog.dialog_stack.clone();generic_dialog.dialog_stack=null;for(var i=stack.length-1;i>=0;i--){stack[i].hide();}}};generic_dialog.prototype.should_hide_objects=!ua.windows();generic_dialog.prototype.should_use_iframe=ua.ie()<7||(ua.osx()&&ua.firefox());generic_dialog.prototype.set_auto_focus=function(auto_focus){this.auto_focus=auto_focus;}
generic_dialog.prototype.show_dialog=function(html){if(generic_dialog.dialog_stack===null){onunloadRegister(generic_dialog.hide_all,true);}
if(!this.obj){this.build_dialog();}
set_inner_html(this.content,html,true);var imgs=this.content.getElementsByTagName('img');for(var i=0;i<imgs.length;i++){imgs[i].onload=chain(imgs[i].onload,this.hide_objects.bind(this));}
this.show();if(this.auto_focus){this.focus_first_textbox_or_button.bind(this).defer();}
this.on_show_callback&&this.on_show_callback();return this;}
generic_dialog.prototype.set_callback=function(callback){this.on_show_callback=callback;return this;}
generic_dialog.prototype.focus_first_textbox_or_button=function(){var selectors=['input[type="text"]','textarea','input[type="password"]','input[type="button"]','input[type="submit"]'];var nodes=[];for(var ii=0;ii<selectors.length&&nodes.length==0;ii++){nodes=DOM.scry(this.content,selectors[ii]);}
if(nodes.length>0){var node=nodes[0];try{if(elementY(node)>0&&elementX(node)>0){node.focus();}}catch(e){};}
return true;}
generic_dialog.prototype.set_top=function(top){return this;}
generic_dialog.prototype.set_modal_setting=function(key,val){this.modal_settings[key]=val;return this;}
generic_dialog.prototype.get_modal_setting=function(key){return this.modal_settings[key];}
generic_dialog.prototype.make_modal=function(dark){if(dark){this.set_modal_setting(dark,true);}
if(this.modal){return;}
this.modal=true;if(ua.ie()==7){this.build_iframe();}
this.build_overlay();this.reset_iframe();}
generic_dialog.prototype.show_loading=function(loading_html){if(!loading_html){loading_html=_tx("Loading...");}
return this.show_dialog('<div class="dialog_loading">'+loading_html+'</div>');}
generic_dialog.prototype.show_ajax_dialog_custom_loader=function(html,src,post_vars,use_async_response){if(html){this.show_loading(html);}
var handler=function(use_async_response,response){var html=use_async_response?response.getPayload():response.getPayload().responseText;this.show_dialog(html);}.bind(this,use_async_response);var error_handler=function(response){ErrorDialog.showAsyncError(response);this.hide(false);}.bind(this);var async=new AsyncRequest().setOption('suppressEvaluation',!use_async_response).setURI(src).setData(post_vars||{}).setHandler(handler).setErrorHandler(error_handler).setTransportErrorHandler(error_handler);if(!post_vars){async.setMethod('GET').setReadOnly(true);}
async.send();return this;}
generic_dialog.prototype.show_ajax_dialog=function(src,post_vars,use_async_response){post_vars=post_vars||false;var load=_tx("Loading...");return this.show_ajax_dialog_custom_loader(load,src,post_vars,use_async_response);}
generic_dialog.prototype.show_prompt=function(title,content){return this.show_dialog('<h2 class="dialog_title"><span>'+title+'</span></h2><div class="dialog_content">'+content+'</div>');}
generic_dialog.prototype.show_message=function(title,content,button){if(button==null){button=_tx("Okay");}
return this.show_choice(title,content,button,function(){generic_dialog.get_dialog(this).fade_out(100)});}
generic_dialog.prototype.show_choice=function(title,content,button1,button1js,button2,button2js,buttons_msg,button3,button3js){var buttons='<div class="dialog_buttons" id="dialog_buttons">';if(typeof(buttons_msg)!='undefined'){buttons+='<div class="dialog_buttons_msg">';buttons+=buttons_msg;buttons+='</div>';}
buttons+='<input class="inputsubmit" type="button" value="'+button1+'" id="dialog_button1" />';if(button2){var button2_class='inputsubmit';if(button2==_tx("Cancel")){button2_class+=' inputaux';}
buttons+='<input class="'+button2_class+'" type="button" value="'+button2+'" id="dialog_button2" />';}
if(button3){var button3_class='inputsubmit';if(button3==_tx("Cancel")){button3_class+=' inputaux';}
buttons+='<input class="'+button3_class+'" type="button" value="'+button3+'" id="dialog_button3" />';}
this.show_prompt(title,this.content_to_markup(content)+buttons);var inputs=this.obj.getElementsByTagName('input');if(button3){button1obj=inputs[inputs.length-3];button2obj=inputs[inputs.length-2];button3obj=inputs[inputs.length-1];}else if(button2){button1obj=inputs[inputs.length-2];button2obj=inputs[inputs.length-1];}else{button1obj=inputs[inputs.length-1];}
if(button1js&&button1){if(typeof button1js=='string'){eval('button1js = function() {'+button1js+'}');}
button1obj.onclick=button1js;}
if(button2js&&button2){if(typeof button2js=='string'){eval('button2js = function() {'+button2js+'}');}
button2obj.onclick=button2js;}
if(button3js&&button3){if(typeof button3js=='string'){eval('button3js = function() {'+button3js+'}');}
button3obj.onclick=button3js;}
if(!this.modal){document.onkeyup=function(e){var keycode=(e&&e.which)?e.which:event.keyCode;var btn2_exists=(typeof button2obj!='undefined');var btn3_exists=(typeof button3obj!='undefined');var is_webkit=ua.safari();if(is_webkit&&keycode==13){button1obj.click();}
if(keycode==27){if(btn3_exists){button3obj.click();}else if(btn2_exists){button2obj.click();}else{button1obj.click();}}
document.onkeyup=function(){}}
this.button_to_focus=button1obj;button1obj.offsetWidth&&button1obj.focus();}
return this;}
generic_dialog.prototype.content_to_markup=function(content){return(typeof content=='string')?'<div class="dialog_body">'+content+'</div>':'<div class="dialog_summary">'+content.summary+'</div><div class="dialog_body">'+content.body+'</div>';}
generic_dialog.prototype.hide=function(temporary){if(this.obj){this.obj.style.display='none';}
if(this.iframe){this.iframe.style.display='none';}
if(this.overlay){this.overlay.style.display='none';}
if(this.timeout){clearTimeout(this.timeout);this.timeout=null;return;}
if(this.hidden_objects.length){for(var i=0,il=this.hidden_objects.length;i<il;i++){this.hidden_objects[i].style.visibility='';}
this.hidden_objects=[];}
clearInterval(this.active_hiding);if(!temporary){if(generic_dialog.dialog_stack){var stack=generic_dialog.dialog_stack;for(var i=stack.length-1;i>=0;i--){if(stack[i]==this){stack.splice(i,1);}}
if(stack.length){stack[stack.length-1].show();}}
if(this.obj){this.obj.parentNode.removeChild(this.obj);this.obj=null;}
if(this.close_handler){this.close_handler();}}
return this;}
generic_dialog.prototype.fade_out=function(interval,timeout,callback){if(!this.popup){return this;}
try{animation(this.obj).duration(timeout||0).checkpoint().to('opacity',0).hide().duration(interval||350).ondone(function(){callback&&callback();this.hide();}.bind(this)).go();}catch(e){this.hide();}
return this;}
generic_dialog.prototype.show=function(){if(this.obj&&this.obj.style.display){this.obj.style.visibility='hidden';this.obj.style.display='';this.reset_dialog();this.obj.style.visibility='';this.obj.dialog=this;}else{this.reset_dialog();}
this.hide_objects();clearInterval(this.active_hiding);this.active_hiding=setInterval(this.active_resize.bind(this),500);var stack=generic_dialog.dialog_stack?generic_dialog.dialog_stack:generic_dialog.dialog_stack=[];if(stack.length){var current_dialog=stack[stack.length-1];if(current_dialog!=this&&!current_dialog.is_stackable){current_dialog.hide();}}
for(var i=stack.length-1;i>=0;i--){if(stack[i]==this){stack.splice(i,1);}else{stack[i].hide(true);}}
stack.push(this);return this;}
generic_dialog.prototype.active_resize=function(){if(this.last_offset_height!=this.content.offsetHeight){this.hide_objects();this.last_offset_height=this.content.offsetHeight;}}
generic_dialog.prototype.hide_objects=function(){var hide=[],objects=[];var ad_locs=['',0,1,2,4,5,9,3];for(var i=0;i<ad_locs.length;i++){var ad_div=ge('ad_'+ad_locs[i]);if(ad_div!=null){hide.push(ad_div);}}
var rect={x:elementX(this.content),y:elementY(this.content),w:this.content.offsetWidth,h:this.content.offsetHeight};if(this.should_hide_objects){var iframes=document.getElementsByTagName('iframe');for(var i=0;i<iframes.length;i++){if(iframes[i].className.indexOf('share_hide_on_dialog')!=-1){objects.push(iframes[i]);}}}
var swfs=getElementsByTagNames('embed,object');for(var i=0;i<swfs.length;i++){if((swfs[i].getAttribute('wmode')||'').toLowerCase()!='transparent'||this.should_hide_objects){objects.push(swfs[i]);}}
for(var i=0;i<objects.length;i++){var node=objects[i].offsetHeight?objects[i]:objects[i].parentNode;swf_rect={x:elementX(node),y:elementY(node),w:node.offsetWidth,h:node.offsetHeight};if(!DOM.contains(this.content,objects[i])&&rect.y+rect.h>swf_rect.y&&swf_rect.y+swf_rect.h>rect.y&&rect.x+rect.w>swf_rect.x&&swf_rect.x+swf_rect.w>rect.w&&this.hidden_objects.indexOf(node)==-1){hide.push(node);}}
for(var i=0;i<hide.length;i++){this.hidden_objects.push(hide[i]);hide[i].style.visibility='hidden';}}
generic_dialog.prototype.build_dialog=function(){if(!this.obj){this.obj=document.createElement('div');}
CSS.setClass(this.obj,'generic_dialog'+(this.className?' '+this.className:''));this.obj.style.display='none';onloadRegister(function(){DOM.getRootElement().appendChild(this.obj);}.bind(this));if(this.should_use_iframe||(this.modal&&ua.ie()==7)){this.build_iframe();}
if(!this.popup){this.popup=document.createElement('div');CSS.setClass(this.popup,'generic_dialog_popup');}
this.popup.style.left=this.popup.style.top='';this.obj.appendChild(this.popup);if(this.modal){this.build_overlay();}}
generic_dialog.prototype.build_iframe=function(){if(!this.iframe&&!(this.iframe=ge('generic_dialog_iframe'))){this.iframe=document.createElement('iframe');this.iframe.id='generic_dialog_iframe';this.iframe.src="/common/blank.html";}
this.iframe.frameBorder='0';onloadRegister(function(){DOM.getRootElement().appendChild(this.iframe);}.bind(this));}
generic_dialog.prototype.build_overlay=function(){this.overlay=document.createElement('div');this.overlay.id='generic_dialog_overlay';if(this.get_modal_setting('dark')){CSS.addClass(this.overlay,'dark_dialog_overlay');}
this.overlay.style.height=Vector2.getDocumentDimensions().y+'px';onloadRegister(function(){DOM.getRootElement().appendChild(this.overlay);}.bind(this));}
generic_dialog.prototype.reset_dialog=function(){if(!this.popup){return;}
onloadRegister(function(){this.reset_dialog_obj();this.reset_iframe();}.bind(this));}
generic_dialog.prototype.reset_iframe=function(){if(!this.should_use_iframe&&!(this.modal&&ua.ie()==7)){return;}
if(this.modal){this.iframe.style.left='0px';this.iframe.style.top='0px';this.iframe.style.width='100%';var documentHeight=Vector2.getDocumentDimensions().y;if(documentHeight>10000){documentHeight=10000;}
this.iframe.style.height=documentHeight+'px';}else{this.iframe.style.left=elementX(this.frame)+'px';this.iframe.style.top=elementY(this.frame)+'px';this.iframe.style.width=this.frame.offsetWidth+'px';this.iframe.style.height=this.frame.offsetHeight+'px';}
this.iframe.style.display='';}
generic_dialog.prototype.reset_dialog_obj=function(){}
generic_dialog.get_dialog=function(obj){while(!obj.dialog&&obj.parentNode){obj=obj.parentNode;}
return obj.dialog?obj.dialog:false;}
function pop_dialog(className,callback_function,modal){this.top=125;this.parent.construct(this,className,modal);this.on_show_callback=callback_function;}
pop_dialog.extend('generic_dialog');pop_dialog.prototype.do_expand_animation=false;pop_dialog.prototype.kill_expand_animation=true;pop_dialog.prototype.show_ajax_dialog=function(src,post_vars,title,use_async_response){post_vars=post_vars||false;if(this.do_expand_animation&&!this.kill_expand_animation){var load=null;this.show_loading_title(title);}else{var load=_tx("Loading...");}
return this.show_ajax_dialog_custom_loader(load,src,post_vars,use_async_response);}
pop_dialog.prototype.show_message=function(title,content,button){if(this.do_expand_animation&&!this.kill_expand_animation){this.show_loading_title(title);}else{this.show_loading();}
return this.parent.show_message(title,content,button);}
pop_dialog.prototype.show_dialog=function(html,prevent_expand_animation){var new_dialog=this.parent.show_dialog(html);if(this.do_expand_animation&&!prevent_expand_animation&&!this.kill_expand_animation){function check_done_loading_title(callback,i){var i=(i?i:0);if(this.done_loading_title!=true&&i<10){i++;setTimeout(check_done_loading_title.bind(this,callback,i),50);}else{callback&&callback();}}
function check_for_complete_images(content,callback,attempt){var complete_images=0;var images=content.getElementsByTagName('img');var safari2=ua.safari()<3;for(var i=0;i<images.length;i++){var imageobj=images[i];if(image_has_loaded(imageobj)){complete_images++;}}
if(complete_images!=images.length){if(attempt<20){attempt++;setTimeout(function(){check_for_complete_images(content,callback,attempt);},100);}else{callback();}}else{callback();}}
var divs=this.content.getElementsByTagName('div');for(var i=0;i<divs.length;i++){if(divs[i].className=='dialog_content'){expand_animation_div=divs[i];break;}}
var container_div=document.createElement('div');container_div.style.padding='0px';container_div.style.margin='0px';container_div.style.overflow='visible';expand_animation_div.parentNode.insertBefore(container_div,expand_animation_div);container_div.appendChild(expand_animation_div);expand_animation_div.style.overflow='hidden';check_for_complete_images(expand_animation_div,function(){check_done_loading_title.bind(this,function(){this.content.getElementsByTagName('h2')[0].className='';animation(expand_animation_div).to('height','auto').from(0).from('opacity',0).to(1).ease(animation.ease.both).show().duration(200).ondone(function(){container_div.parentNode.insertBefore(expand_animation_div,container_div);container_div.parentNode.removeChild(container_div);if(!this.button_to_focus){var inputs=this.obj.getElementsByTagName('input');for(var i=0;i<inputs.length;i++){if(inputs[i].type=='button'&&inputs[i].id=='dialog_button1'){this.button_to_focus=inputs[i];break;}}}
if(this.button_to_focus){setTimeout(function(){this.button_to_focus.focus();}.bind(this),50);}
expand_animation_div.style.overflow='visible'
this.do_expand_animation=false;this.show();}.bind(this,{expand_animation_div:expand_animation_div,container_div:container_div})).go();}.bind(this))();}.bind(this,{expand_animation_div:expand_animation_div}),0);}
return new_dialog;}
pop_dialog.prototype.build_dialog=function(){this.parent.build_dialog();CSS.addClass(this.obj,'pop_dialog');if(intl_locale_is_rtl()){CSS.addClass(this.obj,'pop_dialog_rtl');}
set_inner_html(this.popup,'<table id="pop_dialog_table" class="pop_dialog_table">'+'<tr><td class="pop_topleft"></td><td class="pop_border pop_top"></td><td class="pop_topright"></td></tr>'+'<tr><td class="pop_border pop_side"></td><td class="pop_content" id="pop_content"></td><td class="pop_border pop_side"></td></tr>'+'<tr><td class="pop_bottomleft"></td><td class="pop_border pop_bottom"></td><td class="pop_bottomright"></td></tr>'+'</table>');this.frame=this.popup.getElementsByTagName('tbody')[0];this.content=this.popup.getElementsByTagName('td')[4];}
pop_dialog.prototype.reset_dialog_obj=function(){this.popup.style.top=Vector2.getScrollPosition().y+this.top+'px';}
pop_dialog.prototype.set_top=function(top){this.top=top;}
pop_dialog.prototype.show_prompt=function(title,content){if(!this.do_expand_animation||this.kill_expand_animation){return this.show_dialog('<h2 class="dialog_title"><span>'+title+'</span></h2><div class="dialog_content">'+content+'</div>');}
return this.show_dialog('<h2 class="dialog_loading"><span>'+title+'</span></h2><div class="dialog_content" style="display:none;">'+content+'</div>');}
pop_dialog.prototype.show_loading_title=function(title){if(!this.kill_expand_animation){this.do_expand_animation=true;this.show_dialog('<h2 class="dialog_loading"><span>'+title+'</span></h2>',true);setTimeout(function(){this.done_loading_title=true;}.bind(this),200);}else{this.show_loading();}}
pop_dialog.prototype.get_popup_dialog=function(){return DOM.find(this.popup,"table.pop_dialog_table");}
function contextual_dialog(className){this.parent.construct(this,className);}
contextual_dialog.extend('generic_dialog');contextual_dialog.prototype.set_context=function(obj){this.context=obj;return this;}
contextual_dialog.prototype.set_modal=function(mod){this.modal=mod;return this;}
contextual_dialog.prototype.build_dialog=function(){this.parent.build_dialog();this.obj.className+=' contextual_dialog';this.popup.innerHTML='<div class="contextual_arrow"><span>^_^keke1</span></div><div class="contextual_dialog_content"></div>';this.arrow=this.popup.getElementsByTagName('div')[0];this.content=this.frame=this.popup.getElementsByTagName('div')[1];}
contextual_dialog.prototype.reset_dialog_obj=function(){var x=elementX(this.context);var documentOffsetWidth=DOMScroll.getScrollRoot().offsetWidth;var center=(documentOffsetWidth-this.popup.offsetWidth)/2;if(x<documentOffsetWidth/2){this.arrow.className='contextual_arrow_rev';var left=Math.min(center,x+this.context.offsetWidth-this.arrow_padding_x);var arrow=x-left+this.context.offsetWidth+this.arrow_padding_x;}else{this.arrow.className='contextual_arrow';var left=Math.max(center,x-this.popup.offsetWidth+this.arrow_padding_x);var arrow=x-left-this.arrow_padding_x-this.arrow_width;}
if(isNaN(left)){left=0;}
if(isNaN(arrow)){arrow=0;}
this.popup.style.top=(elementY(this.context)+this.context.offsetHeight-this.arrow.offsetHeight+this.arrow_padding_y)+'px';this.popup.style.left=left+'px';this.arrow.style.backgroundPosition=arrow+'px';}
contextual_dialog.prototype._remove_resize_events=function(){if(this._scroll_events){for(var i=0;i<this._scroll_events.length;i++){removeEventBase(this._scroll_events[i].obj,this._scroll_events[i].event,this._scroll_events[i].func);}}
this._scroll_events=[];}
contextual_dialog.prototype.show=function(){this._remove_resize_events();var obj=this.context;while(obj){if(obj.id!='content'&&(obj.scrollHeight&&obj.offsetHeight&&obj.scrollHeight!=obj.offsetHeight)||(obj.scrollWidth&&obj.offsetWidth&&obj.scrollWidth!=obj.offsetWidth)){var evt={obj:obj,event:'scroll',func:this.reset_dialog_obj.bind(this)};addEventBase(evt.obj,evt.event,evt.func);}
obj=obj.parentNode;}
var evt={obj:window,event:'resize',func:this.reset_dialog_obj.bind(this)};addEventBase(evt.obj,evt.event,evt.func);this.parent.show();}
contextual_dialog.prototype.hide=function(temp){this._remove_resize_events();this.parent.hide(temp);}
contextual_dialog.prototype.arrow_padding_x=5;contextual_dialog.prototype.arrow_padding_y=10;contextual_dialog.prototype.arrow_width=13;contextual_dialog.hide_all=function(callback){if(generic_dialog.dialog_stack){for(var i=0;i<generic_dialog.dialog_stack.length;i++){if(generic_dialog.dialog_stack[i].context&&generic_dialog.dialog_stack[i].arrow){generic_dialog.dialog_stack[i].hide();}}}
callback&&callback();}

var
kError_Global_ValidationError=1346001,kError_Login_GenericError=1348009,kError_Chat_NotAvailable=1356002,kError_Chat_SendOtherNotAvailable=1356003,kError_Async_NotLoggedIn=1357001,kError_Async_LoginChanged=1357003,kError_Async_CSRFCheckFailed=1357004,kError_Chat_TooManyMessages=1356008,kError_Platform_CallbackValidationFailure=1349007,kError_Platform_ApplicationResponseInvalid=1349008,kError_Gifts_NoGiftSelected=1391001,kError_Gifts_NoReceiverSpecified=1391003,kError_Gifts_NoMessageAttached=1391004,kError_RestrictionMessage_Featureblock=1395001,kError_RestrictionMessage_Featurewarning=1395002,kError_RestrictionMessage_Spamwarning=1395003,kError_Async_InternalCaptchaRequired=1357007,kError_Recruiting_MessageDeliveryFailed=1405001,kError_Intern_UnknownError=1408001,kError_Privacy_FriendListNameAlreadyExists=1409001,kError_Mobile_InvalidWapLocale=1347008,kError_Gifts_MessageTooLong=1391007,kError_Inbox_DuplicateMessages=1415001,kError_Async_ConfirmationRequired=1357008,kError_Gifter_GiftNotMoved=1416001,kError_Gifter_GiftNotCreated=1416002,kError_Gifter_GiftNotUpdated=1416003,kError_Gifter_DesignerNotAdded=1416004,kError_Gifter_GiftsNotLoaded=1416005,kError_Megaphone_InvalidHideData=1419001,kError_Megaphone_StoryNotFound=1419002,kError_Megaphone_InternalError=1419003,kError_Megaphone_HandleHideFailed=1419004,kError_Screenname_LimiteExceeded=1423001,kError_Screenname_AllocationError=1423002,kError_OpenId_RegistrationGeneralError=1428001,kError_OpenId_SignatureError=1428002,kError_OpenId_MissingRequiredInformation=1428003,kError_OpenId_ProtocolError=1428004,kError_OpenId_ProtocolErrorWithMessage=1428005,kError_OpenId_EmailAlreadyTaken=1428006;

function Rect(t,r,b,l,domain){if(this===window){if(t instanceof Rect){return t;}
return Rect.getElementBounds($(t));}
copy_properties(this,{t:t,r:r,b:b,l:l,domain:domain||'pure'});};copy_properties(Rect.prototype,{w:function(){return this.r-this.l;},h:function(){return this.b-this.t;},area:function(){return this.w()*this.h();},toString:function(){return'(('+this.l+', '+this.t+'), ('+this.r+', '+this.b+'))';},intersects:function(v){v=Rect(v).convertTo(this.domain);var u=this;if(u.l>v.r||v.l>u.r||u.t>v.b||v.t>u.b){return false;}
return true;},intersectingArea:function(v){v=Rect(v).convertTo(this.domain);var u=this;if(!this.intersects(v)){return null;}
return new Rect(Math.max(u.t,v.t),Math.min(u.r,v.r),Math.min(u.b,v.b),Math.max(u.l,v.l)).area();},contains:function(v){v=Rect(v).convertTo(this.domain);var u=this;if(v instanceof Vector2){return(u.l<=v.x&&u.r>=v.x&&u.t<=v.y&&u.b>=v.y);}else{return(u.l<=v.l&&u.r>=u.r&&u.t<=v.t&&u.b>=v.b);}},canContain:function(v){v=Rect(v).convertTo(this.domain);return(v.h()<=this.h())&&(v.w()<=this.w());},forceBelow:function(v,min){min=min||0;v=Rect(v).convertTo(this.domain);if(v.b>this.t){return this.offset(0,(v.b-this.t)+min);}
return this;},offset:function(x,y){return new Rect(this.t+y,this.r+x,this.b+y,this.l+x,this.domain);},expand:function(x,y){return new Rect(this.t,this.r+x,this.b+y,this.l,this.domain);},scale:function(x,y){y=y||x;return new Rect(this.t,this.l+(this.w()*x),this.t+(this.h()*y),this.l,this.domain);},setDimensions:function(x,y){return new Rect(this.t,this.l+x,this.t+y,this.l,this.domain);},setPosition:function(x,y){return new Rect(x,this.w(),this.h(),y,this.domain);},boundWithin:function(v){var x=0,y=0;if(this.l<v.l){x=v.l-this.l;}else if(this.r>v.r){x=v.r-this.r;}
if(this.t<v.t){y=v.t-this.t;}else if(this.b>v.b){y=v.b-this.b;}
return this.offset(x,y);},setElementBounds:function(el){this.getPositionVector().setElementPosition(el);this.getDimensionVector().setElementDimensions(el);return this;},getPositionVector:function(){return new Vector2(this.l,this.t,this.domain);},getDimensionVector:function(){return new Vector2(this.w(),this.h(),'pure');},convertTo:function(newDomain){if(this.domain==newDomain){return this;}
if(newDomain=='pure'){return new Rect(this.t,this.r,this.b,this.l,'pure');}
if(this.domain=='pure'){Util.error('Unable to convert a pure rect to %q coordinates.',newDomain);return new Rect(0,0,0,0);}
var p=new Vector2(this.l,this.t,this.domain).convertTo(newDomain);return new Rect(p.y,p.x+this.w(),p.y+this.h(),p.x,newDomain);},constrict:function(x,y){if(typeof(y)=='undefined'){y=x;}
x=x||0;return new Rect(this.t+y,this.r-x,this.b-y,this.l+x,this.domain);},expandX:function(){return new Rect(this.t,Number.POSITIVE_INFINITY,this.b,Number.NEGATIVE_INFINITY);},expandY:function(){return new Rect(number.NEGATIVE_INFINITY,this.r,Number.POSITIVE_INFINITY,this.l);}});copy_properties(Rect,{newFromVectors:function(pos,dim){return new Rect(pos.y,pos.x+dim.x,pos.y+dim.y,pos.x,pos.domain);},getElementBounds:function(el){return Rect.newFromVectors(Vector2.getElementPosition(el),Vector2.getElementDimensions(el));},getViewportBounds:function(){return Rect.newFromVectors(Vector2.getScrollPosition(),Vector2.getViewportDimensions());},getDocumentBounds:function(){return Rect.newFromVectors(new Vector2(0,0,'document'),Vector2.getDocumentDimensions());}});

function dropmenu(clickTarget){if(this==window){return new dropmenu(clickTarget);}else{this.className=null;this.menu=null;this.menuClickArea=null;this.showHandler=null;this.hideHandler=null;this.alignment=null;this.direction=null;this.isShown=false;this.canHide=false;this.show_hooks=[];this.hide_hooks=[];this.clickTarget=$(clickTarget);this.displayTarget=$(clickTarget);this.id=null;this.rtl=false;this._clickToHide=true;this._markupContentCallback=bagofholding;this.clickHandle=this.clickTarget.listen('click',this.toggle.bind(this));this.container=$('dropmenu_container')||document.body;return this;}}
dropmenu.ALIGN_RIGHT=1;dropmenu.ALIGN_LEFT=2;dropmenu.DIRECTION_UP=3;dropmenu.DIRECTION_DOWN=4;dropmenu.INSTANCES={};dropmenu.prototype.setPosition=function(alignment){this.alignment=alignment;return this;}
dropmenu.prototype.setDirection=function(direction){this.direction=direction;return this;}
dropmenu.prototype.setMenuClickArea=function(id){this.menuClickArea=$(id);return this;}
dropmenu.prototype.setDisplayTarget=function(id){this.displayTarget=$(id);return this;}
dropmenu.prototype.setClickToHide=function(click_to_hide){this._clickToHide=click_to_hide;return this;}
dropmenu.prototype.setMarkupContent=function(id,className,markup){this.menuContent=markup;this.className=className;this.id=id;return this;}
dropmenu.prototype.setMarkupContentCallback=function(fn){this._markupContentCallback=fn;return this;}
dropmenu.prototype._getMarkupContent=function(){return this.menuContent||this._markupContentCallback();}
dropmenu.prototype.registerHTMLMenu=function(menu_id){this.registered_menu_id=menu_id;return this;}
dropmenu.prototype.addHook=function(type,fn){this[type+'_hooks'].push(fn);return this;}
dropmenu.prototype.removeHook=function(type,fn){for(var i=0;i<this[type+'_hooks'].length;i++){if(fn==this[type+'_hooks'][i]){this[type+'_hooks'].splice(i,1);return true;}}
return this;}
dropmenu.prototype.toggle=function(e){if(!this.isShown){this._show();this.canHide=false;}else{this._hide();}
$E(e).prevent();}
dropmenu.prototype.show=function(){this._show();}
dropmenu.prototype.hide=function(){if(!this.menu){return;}
this._hide();}
dropmenu.prototype.destroy=function(){if(this.menu&&this.menu.parentNode){this.menu.parentNode.removeChild(this.menu);this.menu=null;}}
dropmenu.prototype._buildMenu=function(){if(intl_locale_is_rtl()&&!this.rtl){this.alignment=(this.alignment==dropmenu.ALIGN_RIGHT)?dropmenu.ALIGN_LEFT:dropmenu.ALIGN_RIGHT;this.rtl=true;}
if(this.registered_menu_id){this.menu=$(this.registered_menu_id);if(this.alignment||this.direction){this.container.appendChild(this.menu);}}else{this._buildDynamicMenu();}
dropmenu.INSTANCES[this.id]=this;this.menuClickArea=this.menuClickArea||DOM.scry(this.menu,'div.menu_content');this.menuClickArea.onclick=chain(this.menuClickArea.onclick,Event.stop);var menu_links=DOM.scry(this.menu,'a');for(var i=0;i<menu_links.length;i++){addEventBase(menu_links[i],'click',function(){if(this._clickToHide){this._hide();}}.bind(this),this.menu_id+'_link_'+i);}}
dropmenu.prototype._buildDynamicMenu=function(){this.menu=document.createElement('div');this.menu.className='dropdown_menu hidden_elem '+(this.className?' '+this.className:'');this.menu.id='dropdown_menu_'+this.id;var markupContent=this._getMarkupContent();if(!is_scalar(markupContent)){DOM.setContent(this.menu,markupContent);}else{set_inner_html(this.menu,markupContent);}
this.container.appendChild(this.menu);}
dropmenu.prototype._positionMenu=function(){if(this.alignment||this.direction||(!this.alignment&&!this.direction&&!this.registered_menu_id)){if(this.menu.parentNode!=this.container){this.container.appendChild(this.menu);}
var menuPos=Vector2.getElementPosition(this.displayTarget,'document');var contPos=Vector2.getElementPosition(this.container,'document');var x=menuPos.x-contPos.x;var y=menuPos.y-contPos.y+this.displayTarget.offsetHeight;if(this.alignment==dropmenu.ALIGN_RIGHT||this.direction==dropmenu.DIRECTION_UP){CSS.removeClass(this.menu,'hidden_elem');this.menu.style.left='-9999px';this.menu.style.top='-9999px';if(this.alignment==dropmenu.ALIGN_RIGHT){var menu_width=this.menu.offsetWidth;x=x+this.displayTarget.offsetWidth-menu_width;}
if(this.direction==dropmenu.DIRECTION_UP){var menu_height=this.menu.offsetHeight;y=y-this.displayTarget.offsetHeight-menu_height+1;}
CSS.addClass(this.menu,'hidden_elem');}
this.menu.style.left=x+'px';this.menu.style.top=y+'px';}}
dropmenu.prototype._onclick=function(event){this._hide();return false;}
dropmenu.prototype._show=function(){if(!this.menu){this._buildMenu();}
this._positionMenu();CSS.removeClass(this.menu,'hidden_elem');var hide=this._documentHideHandler.bind(this);this.click_event=addEventBase(document.body,'click',hide,this.menu.id);onbeforeunloadRegister(hide);this.isShown=true;for(var i=0;i<this.show_hooks.length;i++){this.show_hooks[i]();}}
dropmenu.prototype._documentHideHandler=function(e){if(!this.canHide){this.canHide=true;}else{this._hide();}}
dropmenu.prototype._hide=function(){if(this.menu){CSS.addClass(this.menu,'hidden_elem');removeEventBase(document.body,'click',this.click_event,this.menu.id);}
this.click_event=null;this.isShown=false;for(var i=0;i<this.hide_hooks.length;i++){this.hide_hooks[i]();}
if(!this.registered_menu_id){this.destroy();}}
dropmenu.prototype._build_menu_shim=function(){this.shim=null;if(ua.ie()<7){this.shim=document.createElement('iframe');CSS.setClass(shim,'iframe_shim');this.container.appendChild(this.shim);}}
dropmenu.getExistingInstance=function(id){return dropmenu.INSTANCES[id];}
function flyout_menu(clickTarget){if(this==window){return new flyout_menu(clickTarget);}else{this.title='';this.parent.construct(this,clickTarget);}}
flyout_menu.extend('dropmenu');flyout_menu.prototype.setMarkupContent=function(id,className,title,markup){this.parent.setMarkupContent(id,className,markup);this.title=title;return this;}
flyout_menu.prototype.setIconPosition=function(iconElem){this.iconElem=iconElem;return this;}
flyout_menu.prototype._buildDynamicMenu=function(){this.menu=document.createElement('div');CSS.addClass(this.menu,(this.className||'')+' flyout_menu hidden_elem');if(this.alignment==dropmenu.ALIGN_RIGHT){CSS.addClass(this.menu,'flyout_menu_left');}
this.menu.id='flyout_menu_'+this.id;var menuContentId='content_'+this.id;var html=[];html.push('<div class="flyout_menu_header_shadow">');html.push('<div class="flyout_menu_header clearfix">');html.push('<div class="flyout_menu_mask"></div>');html.push('<div class="flyout_menu_title">'+this.title+'</div>');html.push('</div></div>');html.push('<div class="flyout_menu_content_shadow">');html.push('<div class="menu_content" id="content_'+this.id+'">');html.push('</div></div>');set_inner_html(this.menu,html.join(''));this.container.appendChild(this.menu);if(!is_scalar(this._getMarkupContent())){DOM.setContent($(menuContentId),this._getMarkupContent());}else{set_inner_html($(menuContentId),this._getMarkupContent());}
this.menuClickArea=$(menuContentId);}
flyout_menu.prototype._positionMenu=function(){if(this.alignment||(!this.alignment&&!this.registered_menu_id)){var x;var icon_anchor=this.iconElem?this.iconElem:this.clickTarget;switch(this.alignment){case dropmenu.ALIGN_LEFT:case null:x=elementX(icon_anchor)-elementX(this.container);break;case dropmenu.ALIGN_RIGHT:this.menu.style.left='-9999px';this.menu.style.top='-9999px';CSS.removeClass(this.menu,'hidden_elem');var menuWidth=Vector2.getElementDimensions(this.menu).x;var right_anchor_pos=Rect.getElementBounds(icon_anchor).r-elementX(this.container);var padding=4;x=right_anchor_pos-menuWidth+padding*2;CSS.addClass(this.menu,'hidden_elem');break;}
var y=elementY(icon_anchor)-elementY(this.container);this.menu.style.left=x+'px';this.menu.style.top=y+'px';}}
function hover_menu(clickTarget){if(this==window){return new hover_menu(clickTarget);}else{this.parent.construct(this,clickTarget);this.timeOut=0;this.clickHandle.remove();this.enterTimer=null;this.exitTimer=null;}}
hover_menu.extend('dropmenu');hover_menu.prototype.setTimeoutInterval=function(time){this.timeOut=time;return this;}
hover_menu.prototype._clickTarget_onmouseover=function(target,e){this.enterTimer=setTimeout(function(){this._show();}.bind(this),this.timeOut);clearTimeout(this.exitTimer);}
hover_menu.prototype._clickTarget_onmouseout=function(target,e){e=e||window.event;var relatedTarget=(e.relatedTarget)?e.relatedTarget:e.toElement;if(DOM.contains(target,relatedTarget)){return;}
if(!DOM.contains(this.menu,relatedTarget)){this.exitTimer=setTimeout(function(){this._hide();}.bind(this),this.timeOut);}
clearTimeout(this.enterTimer);}
hover_menu.prototype._menu_onmouseover=function(target,e){clearTimeout(this.exitTimer);}
hover_menu.prototype._menu_onmouseout=function(target,e){e=e||window.event;var relatedTarget=(e.relatedTarget)?e.relatedTarget:e.toElement;if(DOM.contains(target,relatedTarget)){return;}
this.exitTimer=setTimeout(function(){this._hide();}.bind(this),this.timeOut);clearTimeout(this.enterTimer);}
hover_menu.prototype.initialize=function(){if(!this.menu){this._buildMenu();}
this.clickTarget.listen('mouseover',this._clickTarget_onmouseover.bind(this,this.clickTarget));this.clickTarget.listen('mouseout',this._clickTarget_onmouseout.bind(this,this.clickTarget));this.menu.listen('mouseout',this._menu_onmouseout.bind(this,this.menu));this.menu.listen('mouseover',this._menu_onmouseover.bind(this,this.menu));this._positionMenu();}

function rand32(){return Math.floor(Math.random()*4294967295);}

var Emote={_initialized:false,_imageBase:null,_emoteMap:null,_emoteOrderMap:null,_imageURLs:null,_regex:null,initImageURL:function(imageURL){Emote._imageURL=imageURL;},_init:function(){var staticBase=env_get('static_base');Emote._imageBase=staticBase+'images/emote/';Emote._blankImgSrc=staticBase+'images/blank.gif';var emoteOrder=['smile','frown','tongue','grin','gasp','wink','glasses','sunglasses','grumpy','unsure','cry','devil','angel','kiss','heart','kiki','squint','confused','upset','pacman','colonthree'];Emote._emoteMap={':-)':['\\:\\-\\)','smile'],':)':['\\:\\)','smile'],':]':['\\:\\]','smile'],'=)':['=\\)','smile'],':-(':['\\:\\-\\(','frown'],':(':['\\:\\(','frown'],':[':['\\:\\[','frown'],'=(':['=\\(','frown'],':-P':['\\:\\-P','tongue'],':P':['\\:P','tongue'],':-p':['\\:\\-p','tongue'],':p':['\\:p','tongue'],'=P':['=P','tongue'],':-D':['\\:\\-D','grin'],':D':['\\:D','grin'],'=D':['=D','grin'],':-O':['\\:\\-O','gasp'],':O':['\\:O','gasp'],':-o':['\\:\\-o','gasp'],':o':['\\:o','gasp'],';-)':['\\;\\-\\)','wink'],';)':['\\;\\)','wink'],'8-)':['8\\-\\)','glasses'],'8)':['8\\)','glasses'],'B-)':['B\\-\\)','glasses'],'B)':['B\\)','glasses'],'8-|':['8\\-\\|','sunglasses'],'8|':['8\\|','sunglasses'],'B-|':['B\\-\\|','sunglasses'],'B|':['B\\|','sunglasses'],'>:(':['>\\:\\(','grumpy'],'>:-(':['>\\:\\-\\(','grumpy'],':/':['\\:/','unsure'],':-/':['\\:\\-/','unsure'],':\\':['\\:\\\\','unsure'],':-\\':['\\:\\-\\\\','unsure'],":'(":["\\:'\\(",'cry'],'3:)':['3\\:\\)','devil'],'3:-)':['3\\:\\-\\)','devil'],'O:)':['O\\:\\)','angel'],'O:-)':['O\\:\\-\\)','angel'],':-*':['\\:\\-\\*','kiss'],':*':['\\:\\*','kiss'],'<3':['<3','heart'],'^_^':['\\^_\\^','kiki'],'-_-':['\\-_\\-','squint'],'o.O':['o\\.O','confused'],'O.o':['O\\.o','confused'],'>:O':['>\\:O','upset'],'>:-O':['>\\:\\-O','upset'],'>:o':['>\\:o','upset'],'>:-o':['>\\:\\-o','upset'],':v':['\\:v','pacman'],':|]':['\\:\\|\\]','robot'],':3':['\\:3','colonthree'],':putnam:':['\\:putnam\\:','putnam']};var regexArr=[];for(var match in Emote._emoteMap){regexArr.push(Emote._emoteMap[match][0]);}
var regexStr='(?:^|\\s|\'|"|\\.)('+regexArr.join('|')+')(?:\\s|\'|"|\\.|,|!|\\?|<br>|$)';Emote._regex=new RegExp(regexStr);Emote._emoteOrderMap={};for(var i=0;i<emoteOrder.length;i++){Emote._emoteOrderMap[emoteOrder[i]]=i;}
Emote._initialized=true;},htmlEmote:function(str,txtFn){if(typeof txtFn!='function'){txtFn=htmlize;}
if(!Emote._initialized){Emote._init();}
var start=0;var strRemaining=str;var retArr=[];while(true){var matchObj=Emote._regex.exec(strRemaining);if(!matchObj||!matchObj.length){break;}
var match=matchObj[1];var matchKey=Emote._emoteMap[match][1];var matchIndex=strRemaining.indexOf(match);var chunk=strRemaining.substring(0,matchIndex);if(chunk){retArr.push(txtFn(chunk));}
retArr.push('<span class="emote_text">');retArr.push(match);retArr.push('</span><img class="emote_img" ');var matchOrder;if(typeof(matchOrder=Emote._emoteOrderMap[matchKey])=='undefined'){retArr.push('src="');retArr.push(Emote._imageBase);retArr.push(matchKey);retArr.push('.gif" ');}else{var matchPos=matchOrder*-16;retArr.push('src="');retArr.push(Emote._blankImgSrc);retArr.push('" style="background:url(');retArr.push(Emote._imageURL);retArr.push(') ');retArr.push(matchPos);retArr.push('px top no-repeat" ');}
retArr.push('alt="');retArr.push(match);retArr.push('" />');strRemaining=strRemaining.substring(matchIndex+match.length);}
if(strRemaining){retArr.push(txtFn(strRemaining));}
return retArr.join('');}};

function html_wordwrap(str,wrap_limit,txt_fn){if(typeof wrap_limit=='undefined'){wrap_limit=60;}
if(typeof txt_fn!='function'){txt_fn=htmlize;}
var regex=new RegExp("\\S{"+(wrap_limit+1)+"}",'g');var start=0;var str_remaining=str;var ret_arr=[];var matches=str.match(regex);if(matches){for(var i=0;i<matches.length;i++){var match=matches[i];var match_index=start+str_remaining.indexOf(match);var chunk=str.substring(start,match_index);if(chunk){ret_arr.push(txt_fn(chunk));}
ret_arr.push(txt_fn(match)+'<wbr/>');start=match_index+match.length;str_remaining=str.substring(start);}}
if(str_remaining){ret_arr.push(txt_fn(str_remaining));}
return ret_arr.join('');}
function text_get_hyperlinks(str){if(typeof(str)!='string'){return[];}
return str.match(/(?:(?:ht|f)tps?):\/\/[^\s<]*[^\s<\.)]/ig);}
function html_hyperlink(str,txt_fn,url_fn,reroute){var accepted_delims={'<':'>','*':'*','{':'}','[':']',"'":"'",'"':'"','#':'#','+':'+','-':'-','(':')'};if(typeof(str)=='undefined'||!str.toString){return'';}
if(typeof txt_fn!='function'){txt_fn=htmlize;}
if(typeof url_fn!='function'){url_fn=htmlize;}
var str=str.toString();var http_matches=text_get_hyperlinks(str);var start=0;var str_remaining=str;var ret_arr=[];var str_remaining=str;if(http_matches){var post_form_elem=reroute?ge('post_form_id'):null;var post_form_id=post_form_elem?post_form_elem.value:'';for(var i=0;i<http_matches.length;i++){var http_url=http_matches[i];var http_index=start+str_remaining.indexOf(http_url);var str_len=http_url.length;var non_url=str.substring(start,http_index);if(non_url){ret_arr.push(txt_fn(non_url));}
var trailing='';if(http_index>0){var delim=str[http_index-1];if(typeof accepted_delims[delim]!='undefined'){var end_delim=accepted_delims[delim];var end_delim_index=http_url.indexOf(end_delim);if(end_delim_index!=-1){trailing=txt_fn(http_url.substring(end_delim_index));http_url=http_url.substring(0,end_delim_index);}}}
var http_str=url_fn(http_url);if(reroute){var http_url_quote_escape="http://www.facebook.com/l.php?u="+
URI.encodeComponent(http_url)+'&h='+post_form_id;}else{var http_url_quote_escape=http_url.replace(/"/g,'%22');}
ret_arr.push('<a href="'+http_url_quote_escape+'" target="_blank" rel="nofollow">'+
http_str+'</a>'+trailing);start=http_index+str_len;str_remaining=str.substring(start);}}
if(str_remaining){ret_arr.push(txt_fn(str_remaining));}
return ret_arr.join('');}
function nl2br(text){if(typeof(text)=='undefined'||!text.toString){return'';}
return text.toString().replace(/\n/g,'<br />');}
function is_email(email){return/^([\w!.%+\-])+@([\w\-])+(?:\.[\w\-]+)+$/.test(email);}

function UISelectList(){this._callback=bagofholding;this.container=$N('div',{className:'UISelectList clearfix'});this._mode=UISelectList.MULTI_SELECT_MODE;this._inputName='UISelectList_name_'+gen_unique();this._inputs=null;this._labels=null;}
copy_properties(UISelectList,{MULTI_SELECT_MODE:1,SINGLE_SELECT_MODE:2,MULTI_SELECT_MODE_CHECKED_CLASS_NAME:'UISelectList_check_Checked',SINGLE_SELECT_MODE_CHECKED_CLASS_NAME:'UISelectList_radio_Checked'});UISelectList.prototype={setMode:function(mode){if(mode!=UISelectList.MULTI_SELECT_MODE&&mode!=UISelectList.SINGLE_SELECT_MODE){Util.error('invalid mode %s passed to UISelectList.selectMode',mode);return this;}
if(DOM.scry(this.container,'div.UISelectList_Item').length){Util.error("You have to set `mode' before adding any items to "+"UISelectList");return this;}
this._mode=mode;return this;},setCallback:function(fn){this._callback=fn;return this;},addItem:function(label,checked,key){var item={label:label,checked:checked,key:key};this._renderItem(item);return this;},addItems:function(new_items){for(var k=0;k<new_items.length;k++){this.addItem(new_items[k].label,new_items[k].checked,new_items[k].key);}},getElement:function(){return this.container;},reset:function(){var inputs=this._getInputs();var labels=this._getLabels();for(var i=0;i<inputs.length;i++){inputs[i].checked=inputs[i].defaultChecked;CSS.conditionClass(labels[i],this._getCheckedClass(),inputs[i].checked);}},_renderItem:function(item){var input_id='UISelectList'+gen_unique();var input=$N('input',{type:this._getInputType(),id:input_id,name:this._inputName});input.checked=item.checked;input.defaultChecked=item.checked;var link=$N('a',{className:'UISelectList_Label',href:'#'},item.label);if(item.checked){link.addClass(this._getCheckedClass());}
link.listen('click',this._linkClicked.bind(this,input));input.listen('click',this._clicked.bind(this,input,link,item.key));this.container.appendContent($N('div',{className:'UISelectList_Item'},[input,link]));},_getInputs:function(){return this._inputs||(this._inputs=DOM.scry(this.container,'input'));},_getLabels:function(){return this._labels||(this._labels=DOM.scry(this.container,'a.UISelectList_Label'));},_getInputType:function(){if(this._mode==UISelectList.MULTI_SELECT_MODE){return'checkbox';}
return'radio';},_getCheckedClass:function(){if(this._mode==UISelectList.MULTI_SELECT_MODE){return UISelectList.MULTI_SELECT_MODE_CHECKED_CLASS_NAME;}
return UISelectList.SINGLE_SELECT_MODE_CHECKED_CLASS_NAME;},_linkClicked:function(input,e){input.click();return false;},_clicked:function(input,label,key,e){var clickedElemChecked;if(this._mode==UISelectList.SINGLE_SELECT_MODE){var inputs=this._getInputs();var labels=this._getLabels();if(inputs.length!=labels.length){Util.log('error');return $E(e).stop();}
for(var i=0;i<inputs.length;i++){var checked=input==inputs[i];CSS.conditionClass(labels[i],this._getCheckedClass(),checked);}
clickedElemChecked=true;}else{clickedElemChecked=input.checked;CSS.conditionClass(label,this._getCheckedClass(),input.checked);}
this._callback(clickedElemChecked,key);$E(e).stop();}}
function UICheckList(){return new UISelectList();}

function Dialog(model){Dialog._setup();this._pd=new pop_dialog();this._pd._dialog_object=this;this._show_loading=true;this._onload_handlers=[];if(model){this._setFromModel(model);}}
copy_properties(Dialog,{OK:{name:'ok',label:_tx("Okay")},CANCEL:{name:'cancel',label:_tx("Cancel"),className:'inputaux'},CLOSE:{name:'close',label:_tx("Close")},SAVE:{name:'save',label:_tx("Save")},SUBMIT:{name:'submit',label:_tx("Submit")},CONFIRM:{name:'confirm',label:_tx("Confirm")},DELETE:{name:'delete',label:_tx("Delete")}});copy_properties(Dialog,{OK_AND_CANCEL:[Dialog.OK,Dialog.CANCEL],_STANDARD_BUTTONS:[Dialog.OK,Dialog.CANCEL,Dialog.CLOSE,Dialog.SAVE,Dialog.SUBMIT],newButton:function(name,label,className,handler){var button={name:name,label:label}
if(className){button.className=className;}
if(handler){button.handler=handler;}
return button;},getCurrent:function(){var stack=generic_dialog.dialog_stack;if(!stack||stack.length==0){return null;}
return stack[stack.length-1]._dialog_object||null;},createCaptchaDialog:function(captchaHtml,closeHandler){var dialog=new Dialog().setClassName('captcha_dialog').setTitle(_tx("Security Check")).setBody(captchaHtml).setButtons([Dialog.SUBMIT,Dialog.CANCEL]).setCloseHandler(closeHandler).setModal().onloadRegister(create_captcha);return dialog;},createConfirmationDialog:function(confirmationHtml,title,button,closeHandler){var dialog=new Dialog().setClassName('confirm_dialog').setTitle(title).setBody(confirmationHtml).setButtons([button,Dialog.CANCEL]).setCloseHandler(closeHandler).setModal();return dialog;},showFormAjax:function(title,uri,button_label,reload_page_on_success){var dialog=new Dialog().setTitle(title);var form_id='dialog_ajax_form__'+gen_unique();var buttons=[Dialog.newButton(button_label.toLowerCase(),button_label),Dialog.CANCEL];dialog.setShowLoading(true).show();var preSubmitErrorHandler=function(response){if(response.getError()!=true){dialog.hide();ErrorDialog.showAsyncError(response);}else{dialog.setBody(response.getPayload()).setButtons(Dialog.OK).clearHandler().show();}};var preSubmitHandler=function(response){var contents='<form id="'+
form_id+'" onsubmit="return false;">'+
response.getPayload()+'</form>';dialog.setBody(contents).setButtons(buttons).setHandler(submitHandler).show();};var submitHandler=function(){new AsyncRequest().setURI(uri).setData(serialize_form(ge(form_id))).setHandler(postSubmitHandler).setErrorHandler(postSubmitErrorHandler).send();};var postSubmitHandler=function(response){dialog.setBody(response.getPayload()).setButtons([Dialog.OK]).show();if(reload_page_on_success){window.location.reload();}else{dialog.setAutohide(750);}};var postSubmitErrorHandler=function(response){if(response.getError()==kError_Global_ValidationError){preSubmitHandler(response);}else if(response.getError()!=true){ErrorDialog.showAsyncError(response);}else{preSubmitErrorHandler(response);}};new AsyncRequest().setURI(uri).setReadOnly(true).setHandler(preSubmitHandler).setErrorHandler(preSubmitErrorHandler).send();},_basicMutator:function(private_key){return function(value){this[private_key]=value;this._dirty();return this;};},_findButton:function(buttons,name){for(var i=0;i<buttons.length;++i){if(buttons[i].name==name){return buttons[i];}}
return null;},_setup:function(){if(Dialog._is_set_up){return;}
Dialog._is_set_up=true;var filter=function(event,type){return type=='onkeyup'&&KeyEventController.filterEventModifiers(event,type);};KeyEventController.registerKey('ESCAPE',Dialog._handleEscapeKey,filter);},_handleEscapeKey:function(event,type){var dialog=Dialog.getCurrent();if(!dialog){return true;}
var buttons=dialog._buttons;if(!buttons){return true;}
var cancel_button=Dialog._findButton(buttons,'cancel');if(cancel_button){var button_to_simulate=cancel_button;}else if(buttons.length==1){var button_to_simulate=buttons[0];}else{return true;}
dialog.handleButton(button_to_simulate);return false;}});copy_properties(Dialog.prototype,{show:function(){this._showing=true;this._dirty();return this;},hide:function(){this._showing=false;if(this._autohide_timeout){clearTimeout(this._autohide_timeout);this._autohide_timeout=null;}
if(!generic_dialog.dialog_stack||generic_dialog.dialog_stack.length==1){this._pd.fade_out(250);}else{this._pd.hide();}
return this;},getRoot:function(){return this._pd.obj;},setShowing:function(){this.show();return this;},setHiding:function(){this.hide();return this;},setTitle:Dialog._basicMutator('_title'),setBody:Dialog._basicMutator('_body'),setExtraData:Dialog._basicMutator('_extra_data'),setShowLoading:Dialog._basicMutator('_show_loading'),setFullBleed:Dialog._basicMutator('_full_bleed'),setImmediateRendering:Dialog._basicMutator('_immediate_rendering'),setUserData:Dialog._basicMutator('_user_data'),getUserData:function(){return this._user_data;},setAutohide:function(autohide){if(autohide){if(this._showing){this._autohide_timeout=setTimeout(bind(this,'hide'),autohide);}else{this._autohide=autohide;}}else{this._autohide=null;if(this._autohide_timeout){clearTimeout(this._autohide_timeout);this._autohide_timeout=null;}}
return this;},setSummary:Dialog._basicMutator('_summary'),setButtons:function(buttons){if(!(buttons instanceof Array)){buttons=[buttons];}
for(var i=0;i<buttons.length;++i){if(typeof(buttons[i])=='string'){var button=Dialog._findButton(Dialog._STANDARD_BUTTONS,buttons[i]);if(!button){Util.error('Unknown button: '+buttons[i]);}
buttons[i]=button;}}
this._buttons=buttons;this._dirty();return this;},setButtonsMessage:Dialog._basicMutator('_buttons_message'),setStackable:Dialog._basicMutator('_is_stackable'),setHandler:function(handler){this._handler=handler;return this;},clearHandler:function(){return this.setHandler(null);},setPostURI:function(post_uri,asynchronous){if(asynchronous===undefined){asynchronous=true;}
if(asynchronous){this.setHandler(this._submitForm.bind(this,'POST',post_uri));}else{this.setHandler(function(){dynamic_post(post_uri,this.getFormData());this.hide();}.bind(this));}
return this;},setGetURI:function(get_uri){this.setHandler(this._submitForm.bind(this,'GET',get_uri));return this;},setModal:function(modal){if(modal===undefined){modal=true;}
if(this._showing&&this._modal&&!modal){Util.error("At the moment we don't support un-modal-ing a modal dialog");}
this._modal=modal;return this;},setDarkModal:function(dark){if(dark===undefined){dark=true;}
if(dark){this.setModal();}
this._pd.set_modal_setting('dark',dark);return this;},setContentWidth:function(width,fixed){this._content_width=width;if(fixed){this._resize(fixed);}else{this._dirty();}
return this;},setClassName:Dialog._basicMutator('_class_name'),setCloseHandler:function(close_handler){this._close_handler=call_or_eval.bind(null,this,close_handler);this._pd.close_handler=this._close_handler;return this;},setFooter:Dialog._basicMutator('_footer'),setAutoFocus:Dialog._basicMutator('_auto_focus'),onloadRegister:function(handler){this._onload_handlers.push(handler.bind(this));return this;},setAsync:function(async_request){var handler=function(response){if(this._async_request!=async_request){return;}
this._async_request=null;var payload=response.getPayload();if(typeof(payload)=='string'){this.setBody(payload);}else{this._setFromModel(payload);}
this._update(true);}.bind(this);var hide=bind(this,'hide');async_request.setHandler(chain(async_request.getHandler(),handler)).setErrorHandler(chain(hide,async_request.getErrorHandler())).setTransportErrorHandler(chain(hide,async_request.getTransportErrorHandler())).send();this._async_request=async_request;this._dirty();return this;},_dirty:function(){if(!this._is_dirty){this._is_dirty=true;if(this._immediate_rendering){this._update();}else{bind(this,'_update').defer();}}},_update:function(even_if_not_dirty){if(!this._is_dirty&&even_if_not_dirty!==true){return;}
this._is_dirty=false;if(!this._showing){return;}
if(this._autohide&&!this._async_request&&!this._autohide_timeout){this._autohide_timeout=setTimeout(bind(this,'hide'),this._autohide);}
if(this._class_name){this._pd.setClassName(this._class_name);}
if(this._full_bleed){this._pd.setClassName('full_bleed');}
this._pd.set_auto_focus(this._auto_focus===undefined||this._auto_focus);if(!this._async_request||!this._show_loading){var html=[];if(this._title){html.push('<h2 class="dialog_title"><span>'+this._title+'</span></h2>');}
html.push('<div class="dialog_content">');if(this._summary){html.push('<div class="dialog_summary">');html.push(this._summary);html.push('</div>');}
html.push('<div class="dialog_body">');html.push(this._body);html.push('</div>');if((this._buttons&&this._buttons.length>0)||this._buttons_message){html.push('<div class="dialog_buttons">');if(this._buttons_message){html.push('<div class="dialog_buttons_msg">');html.push(this._buttons_message);html.push('</div>');}
if(this._buttons){this._buttons.forEach(function(button){html.push('<input class="inputsubmit '+(button.className||'')+'"'
+' type="button"'
+(button.name?(' name="'+button.name+'"'):'')
+' value="'+htmlspecialchars(button.label)+'"'
+' onclick="Dialog.getCurrent().handleButton(this.name);" />');},this);}
html.push('</div>');}
if(this._footer){html.push('<div class="dialog_footer">');html.push(this._footer);html.push('</div>');}
html.push('</div>');this._pd.show_dialog(html.join(''));for(var i=0;i<this._onload_handlers.length;++i){try{this._onload_handlers[i]();}catch(ex){Util.error('Uncaught exception in dialog onload hook: %x',ex);}}
this._onload_handlers=[];}else{var title=this._title||_tx("Loading...");this._pd.show_loading_title(title);}
if(this._modal){this._pd.make_modal();}
if(this._content_width){this._resize();}
this._pd.is_stackable=this._is_stackable;this._pd.close_handler=this._close_handler;},handleButton:function(button){if(typeof(button)=='string'){button=Dialog._findButton(this._buttons,button);}
if(!button){Util.error('Huh?  How did this button get here?');return;}
if(call_or_eval(button,button.handler)===false){return;}
if(button!=Dialog.CANCEL){if(call_or_eval(this,this._handler,{button:button})===false){return;}}
this.hide();},getButtonElement:function(button){if(typeof(button)=='string'){button=Dialog._findButton(this._buttons,button);}
if(!button||!button.name){return null;}
var inputs=DOM.scry(this._pd.popup,'input');var name_filter=function(elem){return elem.name==button.name;};return inputs.filter(name_filter)[0]||null;},_submitForm:function(method,uri,button){var data=this.getFormData();data[button.name]=button.label;if(this._extra_data){copy_properties(data,this._extra_data);}
var async_request=new AsyncRequest().setURI(uri).setData(data).setMethod(method).setReadOnly(method=='GET');this.setAsync(async_request);return false;},getFormData:function(){var dialog_content_divs=DOM.scry(this._pd.content,'div.dialog_content');if(dialog_content_divs.length!=1){Util.error(dialog_content_divs.length
+" dialog_content divs in this dialog?  Weird.");}
return serialize_form(dialog_content_divs[0]);},_setFromModel:function(model){for(var propertyName in model){var mutator=this['set'+propertyName.substr(0,1).toUpperCase()
+propertyName.substr(1)];if(!mutator){Util.error("Unknown Dialog property: "+propertyName);}
mutator.call(this,model[propertyName]);}},_resize:function(fixed){var popup=this._pd.get_popup_dialog();var offsetLeft=popup.offsetLeft;popup.style.width=(this._content_width+42)+'px';if(fixed){popup.style.marginLeft=offsetLeft+'px';}}});function ErrorDialog(){this.parent.construct(this);this.setClassName('errorDialog').setModal(true);return this;}
ErrorDialog.extend('Dialog');copy_properties(ErrorDialog,{showAsyncError:function(response){try{return(new ErrorDialog()).showError(response.getErrorSummary(),response.getErrorDescription());}catch(ex){aiert(response);}}});copy_properties(ErrorDialog.prototype,{showError:function(title,message){return this.setTitle(title).setBody(message).setButtons([Dialog.OK]).show();}});

var Drag={};Drag.currentDraggable=null;Drag.grab=function(draggable){if(Drag.currentDraggable){Drag._onmouseup();}
draggable.lastDragOver=null;Drag.attachDragEvents();Drag.currentDraggable=draggable;}
Drag.attachDragEvents=function(){document.onselectstart=function(){document.onselectstart=null;return false;}
if(Drag.dragEventsAttached){return;}
Drag.dragEventsAttached=true;Event.listen(document,'mousemove',Drag._onmousemove);Event.listen(document,'mouseup',Drag._onmouseup);}
Drag.droppables={};Drag.addDroppable=function(namespace,droppable){(Drag.droppables[namespace]=Drag.droppables[namespace]||[]).push(droppable);}
Drag.removeDroppable=function(namespace,droppable){Drag.droppables[namespace]=Drag.droppables[namespace].filter(function(a){return a!=droppable;});}
Drag._onmousemove=function(event){if(!Drag.currentDraggable){return;}
var cursorPosition=Vector2.getEventPosition(event),currentDraggable=Drag.currentDraggable,droppables=Drag.droppables[currentDraggable.namespace];if(currentDraggable.namespace&&currentDraggable.active&&droppables){var zIndexesDict={};droppables.each(function(droppable){zIndexesDict[droppable.zIndex]=droppable.zIndex;});var zIndexes=[];for(var i in zIndexesDict){zIndexes.push(zIndexesDict[i]);}
zIndexes.sort();var lastDragOver=currentDraggable.lastDragOver,currentDragOver=null;for(var z=zIndexes.length;z>=0;z--){if(lastDragOver&&lastDragOver.dom!=null&&lastDragOver.zIndex==zIndexes[z]&&lastDragOver.pointInside(cursorPosition)){currentDragOver=lastDragOver;break;}else{for(var i=0;i<droppables.length;i++){if(zIndexes[z]!=droppables[i].zIndex){continue;}
if(lastDragOver!=droppables[i]&&currentDraggable.dom!=droppables[i].dom&&droppables[i].pointInside(cursorPosition)){currentDragOver=droppables[i];z=-1;break;}}}}
if(currentDragOver&&currentDragOver!=lastDragOver){currentDragOver.ondragover(currentDraggable);}
if(currentDragOver){currentDragOver.ondragmove(currentDraggable,cursorPosition.sub(Vector2.getElementPosition(currentDragOver.dom)));}
currentDraggable.lastDragOver=currentDragOver;}
Drag.currentDraggable._onmousemove(cursorPosition);}
Drag._onmouseup=function(e){document.onselectstart=null;if(Drag.currentDraggable){Drag.currentDraggable._ondrop();Drag.currentDraggable=null;}}
function Draggable(element){if(!element){throw new Error('Element should be a DOM node');}
if(this==window){if(element instanceof Array){var collection=[];element.each(function(instance){collection.push(new Draggable(instance));});return new Collection(Draggable,collection);}else{return new Draggable(element);}}else{this.data={};this.handles=[];this.dom=element;this.boundingBox=null;this.addHandle(this.dom);}}
Draggable.prototype.destroy=function(){this.handles.each(function(handle){this.removeHandle(handle.obj);}.bind(this));this.data=this.dom=null;}
Draggable.prototype._onclick=function(event){if(this.active){return Event.kill(event);}}
Draggable.prototype._ongrab=function(vector){this.ongrab();if(this.active){if(!this.oldPosition){this.oldPosition=this.dom.style.position;}
this.dom.style.position=this.absolute?'absolute':'relative';vector.sub(this.cursorPositionVector).setElementPosition(this.dom);}}
Draggable.prototype._onmousedown=function(event){var target=$E(event).getTarget();if(DOM.isNode(target,['input','select','textarea','object','embed'])){return true;}
var vector=Vector2.getEventPosition(event);this.draggableInitialVector=Vector2.getElementPosition(this.dom);this.cursorPositionVector=vector.sub(this.draggableInitialVector);Drag.grab(this,event);if(this.gutter){this.cursorInitialVector=vector;}else{this._setActive(true);this._ongrab(vector);}
return Event.kill(event);}
Draggable.prototype._onmousemove=function(vector){if(!this.active){if(vector.distanceTo(this.cursorInitialVector)>=this.gutter){this._setActive(true);this._ongrab(vector);}}
if(this.active){var sub_vector=Vector2.getElementPosition(this.dom).sub(new Vector2(parseInt(this.dom.style.left?this.dom.style.left:CSS.getStyle(this.dom,'left'),10)||0,parseInt(this.dom.style.top?this.dom.style.top:CSS.getStyle(this.dom,'top'),10)||0));var vector2=vector.sub(sub_vector).sub(this.cursorPositionVector);if(this.boundingBox){var box=Rect.newFromVectors(vector2,Vector2.getElementDimensions(this.dom));box=box.boundWithin(this.boundingBox);vector2=box.getPositionVector(box);if(this.boundingBox.w()==0){var final_vector=new Vector2(this.draggableInitialVector.x,vector2.y,'document');}else if(this.boundingBox.h()==0){var final_vector=new Vector2(vector2.x,this.draggableInitialVector.y,'document');}else{var final_vector=vector2;}}else{var final_vector=vector2;}
final_vector.setElementPosition(this.dom);this.ondrag(vector);}}
Draggable.prototype._ondrop=function(){if(this.active){(function(){this._setActive(false);}).bind(this).defer();this.ondrop();if(this.lastDragOver){this.lastDragOver.ondrop(this);}}}
Draggable.prototype.killDrag=function(){this._setActive(false);Drag._onmouseup();}
Draggable.prototype.setBoundingBox=function(bounding_box){this.boundingBox=bounding_box;return this;}
Draggable.prototype.resetPosition=function(){this.dom.style.position=this.oldPosition;this.oldPosition=null;this.dom.style.left=null;this.dom.style.top=null;return this;}
Draggable.prototype.setUseAbsolute=function(absolute){this.absolute=absolute;return this;}
Draggable.prototype.ondrag=bagofholding;Draggable.prototype.setDragHandler=function(func){this.ondrag=func;return this;}
Draggable.prototype.ongrab=bagofholding;Draggable.prototype.setGrabHandler=function(func){this.ongrab=func;return this;}
Draggable.prototype.ondrop=bagofholding;Draggable.prototype.setDropHandler=function(func){this.ondrop=func;return this;}
Draggable.prototype.gutter=0;Draggable.prototype.setGutter=function(gutter){this.gutter=gutter;return this;}
Draggable.prototype.setNamespace=function(namespace){this.namespace=namespace;return this;}
Draggable.prototype.handles=null;Draggable.prototype.addHandle=function(handle){if(this.handles.length==1&&this.handles[0].obj==this.dom){this.removeHandle(this.dom);}
this.handles.push({obj:handle,evt:[Event.listen(handle,'mousedown',this._onmousedown.bind(this)),Event.listen(handle,'click',this._onclick.bind(this)),Event.listen(handle,'drag',Event.kill),Event.listen(handle,'selectstart',Event.kill)]});return this;}
Draggable.prototype.removeHandle=function(handle){this.handles=this.handles.filter(function(a){if(a.obj!=handle){return true;}else{a.evt.each(function(evt){evt.remove();});return false;}});}
Draggable.prototype.getDOM=function(){return this.dom;}
Draggable.prototype.setKey=function(key,value){this.data[key]=value;return this;}
Draggable.prototype.getKey=function(key){return this.data[key];}
Draggable.prototype._setActive=function(state){this.dom.activeDrag=this.active=state;for(var i=0;i<this.handles.length;i++){this.handles[i].obj.activeDrag=state;}}
function Droppable(element){if(!element){throw new Error('Element should be a DOM node');}
if(this==window){if(element instanceof Array){var collection=[];element.each(function(instance){collection.push(new Droppable(instance));});return new Collection(Droppable,collection);}else{return new Droppable(element);}}else{this.data={};this.dom=element;this.namespace=null;}}
Droppable.prototype.destroy=function(){if(this.namespace){Drag.removeDroppable(this.namespace,this);}
this.data=this.dom=null;}
Droppable.prototype.setNamespace=function(namespace){if(this.namespace){Drag.removeDroppable(namespace,this);}
this.namespace=namespace;Drag.addDroppable(namespace,this);return this;}
Droppable.prototype.zIndex=0;Droppable.prototype.setZIndex=function(index){this.zIndex=index;return this;}
Droppable.prototype.pointInside=function(vector){var position=Vector2.getElementPosition(this.dom);return position.x<=vector.x&&this.dom.offsetWidth+position.x>vector.x&&position.y<=vector.y&&this.dom.offsetHeight+position.y>vector.y;}
Droppable.prototype.ondragover=bagofholding;Droppable.prototype.setDragOverHandler=function(func){this.ondragover=func;return this;}
Droppable.prototype.ondragmove=bagofholding;Droppable.prototype.setDragMoveHandler=function(func){this.ondragmove=func;return this;}
Droppable.prototype.ondrop=bagofholding;Droppable.prototype.setDropHandler=function(func){this.ondrop=func;return this;}
Droppable.prototype.getDOM=Draggable.prototype.getDOM;Droppable.prototype.setKey=Draggable.prototype.setKey;Droppable.prototype.getKey=Draggable.prototype.getKey;

nectar_onafterload_link_handler=function(link){var last_imp=env_get('nectar_last_impression_id');var last_nav_imp=env_get('nectar_last_nav_impression_id');new AsyncSignal('/ajax/nectar.php',{'nectar_impid':last_imp,'nectar_navimpid':last_nav_imp,'_log_nectar_isaction':true,'nectar_url':link.href}).send();return true;}
onafterloadRegister(function(){LinkController.registerFallbackHandler(nectar_onafterload_link_handler,LinkController.ALL_TARGETS|LinkController.ALL_KEY_MODIFIERS)});

var HistoryManager={_IFRAME_BASE_URI:'http://static.ak.facebook.com/common/history_manager.html',history:null,current:0,fragment:null,_setIframeSrcFragment:function(src){src=src.toString();var index=HistoryManager.history.length-1;HistoryManager.iframe.src=HistoryManager._IFRAME_BASE_URI+'?|index='+index+'#'+encodeURIComponent(src);return HistoryManager;},getIframeSrcFragment:function(){return decodeURIComponent(URI(HistoryManager.iframe.contentWindow.document.location.href).getFragment());},nextframe:function(frame,replace){if(replace){HistoryManager._setIframeSrcFragment(frame);return;}
if(frame!==undefined){HistoryManager.iframeQueue.push(frame);}else{HistoryManager.iframeQueue.splice(0,1);HistoryManager.iframeTimeout=null;HistoryManager.checkURI();}
if(HistoryManager.iframeQueue.length&&!HistoryManager.iframeTimeout){var src=HistoryManager.iframeQueue[0];HistoryManager.iframeTimeout=setTimeout(function(){HistoryManager._setIframeSrcFragment(src);},100,false);}},isInitialized:function(){return!!HistoryManager._initialized;},init:function(){if(URI.getRequestURI(false).getProtocol().toLowerCase()=='https'){return;}
if(!env_get('ALLOW_TRANSITION_IN_IFRAME')&&window!=window.top){return;}
if(HistoryManager._initialized){return HistoryManager;}
var uri=URI();var cur_fragment=uri.getFragment()||'';copy_properties(HistoryManager,{_initialized:true,fragment:cur_fragment,orig_fragment:cur_fragment,history:[uri],callbacks:[],lastChanged:new Date().getTime(),canonical:URI('#'),fragmentTimeout:null,user:0,iframeTimeout:null,iframeQueue:[],enabled:true,debug:bagofholding});if(ua.safari()<500||ua.firefox()<2){HistoryManager.enabled=false;return HistoryManager;}
if(ua.ie()<8){HistoryManager.iframe=document.createElement('iframe');copy_properties(HistoryManager.iframe.style,{width:'0',height:'0',frameborder:'0',left:'0',top:'0',position:'absolute'});onloadRegister(function(){HistoryManager._setIframeSrcFragment(cur_fragment);document.body.insertBefore(HistoryManager.iframe,document.body.firstChild);});}else{setInterval(HistoryManager.checkURI,42,false);}
HistoryManager._updateRefererURI(URI.getRequestURI(false));return HistoryManager;},registerURIHandler:function(callback){HistoryManager.callbacks.push(callback);return HistoryManager;},setCanonicalLocation:function(loc){HistoryManager.canonical=URI(loc);return HistoryManager;},notify:function(uri){if(uri==HistoryManager.orig_fragment){uri=HistoryManager.canonical.getFragment();}
for(var ii=0;ii<HistoryManager.callbacks.length;ii++){try{if(HistoryManager.callbacks[ii](uri)){return true;}}catch(ex){Util.error('Uncaught exception in HistoryManager URI handler callback: %x',ex);}}
return false;},checkURI:function(){if(new Date().getTime()-HistoryManager.lastChanged<400){return;}
if(HistoryManager.iframeQueue.length){return;}
if(ua.safari()&&window.history.length==200){if(!HistoryManager.warned){HistoryManager.warned=true;Util.error('Your history length is over 200 and you are in Safari; things will '+'start behaving oddly now. This is a known bug.');}
return;}
var frag=URI().getFragment();if(ua.ie()<8){frag=HistoryManager.getIframeSrcFragment();}
if(frag!=HistoryManager.fragment){HistoryManager.debug([frag,' vs ',HistoryManager.fragment,'whl: ',window.history.length,'QHL: ',HistoryManager.history.length].join(' '));for(var ii=HistoryManager.history.length-1;ii>=0;--ii){if(HistoryManager.history[ii].getFragment()==frag){break;}}
++HistoryManager.user;if(ii>=0){HistoryManager.go(ii-HistoryManager.current);}else{HistoryManager.go('#'+frag);}
--HistoryManager.user;}
delete frag;},_updateRefererURI:function(uri){uri=uri.toString();if(uri.charAt(0)!='/'&&uri.indexOf('//')==-1){return;}
setCookie('x-referer',URI(uri).getQualifiedURI().setFragment('').toString());},go:function(href,now,replace){HistoryManager.debug('go: '+href);if(now===undefined){now=true;}
if(!HistoryManager.enabled){if(!now){return false;}}
if(typeof(href)=='number'){if(!href){return false;}
var dst=href+HistoryManager.current;var loc=Math.max(0,Math.min(HistoryManager.history.length-1,dst));HistoryManager.current=loc;dst=HistoryManager.history[loc].getFragment()||HistoryManager.orig_fragment;HistoryManager.fragment=dst;HistoryManager.lastChanged=new Date().getTime();if(ua.ie()<8){if(HistoryManager.fragmentTimeout){clearTimeout(HistoryManager.fragmentTimeout);}
HistoryManager._temporary_fragment=dst;HistoryManager.fragmentTimeout=setTimeout(function(){window.location.hash='#'+dst;delete HistoryManager._temporary_fragment;},750,false);if(!HistoryManager.user){HistoryManager.nextframe(dst,replace);}}else if(!HistoryManager.user){go_or_replace(window.location,window.location.href.split('#')[0]+'#'+dst,replace);}
if(now){HistoryManager.notify(dst);}
HistoryManager._updateRefererURI(dst);return false;}
href=URI(href);if(href.getDomain()==URI().getDomain()){href=URI('#'+href.getUnqualifiedURI());}
var cur=HistoryManager.history[HistoryManager.current].getFragment();var tgt=href.getFragment();if(tgt==cur||(cur==HistoryManager.orig_fragment&&tgt==HistoryManager.canonical.getFragment())){if(now){HistoryManager.notify(tgt);}
HistoryManager._updateRefererURI(tgt);return false;}
if(replace){HistoryManager.current--;}
var wipe=(HistoryManager.history.length-HistoryManager.current)-1;HistoryManager.history.splice(HistoryManager.current+1,wipe);HistoryManager.history.push(URI(href));return HistoryManager.go(1,now,replace);},getCurrentFragment:function(){var cur_fragment=HistoryManager._temporary_fragment!==undefined?HistoryManager._temporary_fragment:URI.getRequestURI(false).getFragment();return cur_fragment==HistoryManager.orig_fragment?HistoryManager.canonical.getFragment():cur_fragment;}};var PageTransitions={_transition_handlers:[],_scroll_positions:{},isInitialized:function(){return!!PageTransitions._initialized;},_init:function(){if(URI.getRequestURI(false).getProtocol().toLowerCase()=='https'){return;}
if(!env_get('ALLOW_TRANSITION_IN_IFRAME')&&window!=window.top){return;}
if(PageTransitions._initialized){return PageTransitions;}
PageTransitions._initialized=true;var req_uri=URI.getRequestURI(false);var canonical_uri=req_uri.getUnqualifiedURI();copy_properties(PageTransitions,{_current_uri:canonical_uri,_most_recent_uri:canonical_uri,_next_uri:canonical_uri});var canonical_uri_frag;if(req_uri.getFragment().startsWith('/')){canonical_uri_frag=req_uri.getFragment();}else{canonical_uri_frag=canonical_uri;}
HistoryManager.init().setCanonicalLocation('#'+canonical_uri_frag).registerURIHandler(PageTransitions._historyManagerHandler);LinkController.registerFallbackHandler(PageTransitions._rewriteHref,LinkController.ALL_TARGETS|LinkController.ALL_KEY_MODIFIERS);LinkController.registerFallbackHandler(PageTransitions._onlinkclick);FormController.registerFallbackHandler(PageTransitions._onformsubmit);window.onscroll=chain(window.onscroll,function(){var frag=HistoryManager.getCurrentFragment();if(PageTransitions._current_uri==frag){PageTransitions._scroll_positions[frag]=Vector2.getScrollPosition();}});return PageTransitions;},registerHandler:function(transition_handler){PageTransitions._init();if(PageTransitions._transition_handlers.contains(transition_handler)){Util.warn('Registering a transition handler that\'s already been '
+'registered.  Ur probably doin it wrong.');}
PageTransitions._transition_handlers.push(transition_handler);},getCurrentURI:function(){if(!PageTransitions._current_uri){Util.warn('You\'ve requested the current URI, but there is no "current" '
+'URI.  This is probably because you\'re in the middle of a '
+'page transition.  That\'s an awkward time to ask for the '
+'current URI, and you should probably avoid this situation.  '
+'For now, I\'m just gonna return the most recent page URI, '
+'since that\'s better than returning null.');return new URI(PageTransitions._most_recent_uri);}
return new URI(PageTransitions._current_uri);},getMostRecentURI:function(){return new URI(PageTransitions._most_recent_uri);},getNextURI:function(){return new URI(PageTransitions._next_uri);},_rewriteHref:function(link){var old_href=link.getAttribute('href');var new_href=_computeRelativeURI(PageTransitions._most_recent_uri.getQualifiedURI(),old_href).toString();if(old_href!=new_href){link.setAttribute('href',new_href);}},_onlinkclick:function(link){_BusyUIManager.lookBusy(link);PageTransitions.go(link.getAttribute('href'));return false;},go:function(uri,replace){var qualified_uri=new URI(uri).removeQueryData('quickling').getQualifiedURI();var unqualified_uri=qualified_uri.getUnqualifiedURI();delete PageTransitions._scroll_positions[unqualified_uri];_BusyUIManager.lookBusy();PageTransitions._loadPage(qualified_uri,function(handled){if(handled){HistoryManager.go(qualified_uri.toString(),false,replace);}else{go_or_replace(window.location,qualified_uri,replace);}});},_historyManagerHandler:function(uri_s){if(uri_s.charAt(0)!='/'){return false;}
PageTransitions._loadPage(new URI(uri_s),function(handled){if(!handled){go_or_replace(window.location,uri_s,true);}});return true;},_loadPage:function(uri,ondone){if(uri.getFragment()&&are_equal(URI(uri).setFragment(null).getQualifiedURI(),URI(PageTransitions._current_uri).setFragment(null).getQualifiedURI())){PageTransitions._current_uri=PageTransitions._most_recent_uri=uri;PageTransitions._adjustScrollForCurrentURI();_BusyUIManager.stopLookingBusy();return;}
var scroll_position=PageTransitions._scroll_positions[PageTransitions._current_uri];PageTransitions._current_uri=null;PageTransitions._next_uri=uri;if(scroll_position){DOMScroll.scrollTo(scroll_position,false);}
var handle_transition=function(){var handled=PageTransitions._handleTransition(uri);ondone&&ondone(handled);};var beforeleave_warning=_runHooks('onbeforeleavehooks');if(beforeleave_warning){_BusyUIManager.stopLookingBusy();PageTransitions._warnBeforeLeaving(beforeleave_warning,handle_transition);}else{handle_transition();}},_handleTransition:function(uri){window.onbeforeleavehooks=undefined;_BusyUIManager.lookBusy();for(var i=PageTransitions._transition_handlers.length-1;i>=0;--i){if(PageTransitions._transition_handlers[i](uri)===true){var message={sender:this,uri:uri};Arbiter.inform(Arbiter.PAGE_TRANSITION,message);return true;}else{PageTransitions._transition_handlers.splice(i,1);}}
return false;},transitionComplete:function(){_BusyUIManager.stopLookingBusy();PageTransitions._current_uri=PageTransitions._most_recent_uri=PageTransitions._next_uri;PageTransitions._adjustScrollForCurrentURI();},_warnBeforeLeaving:function(warning_text,continuation){new Dialog().setTitle(_tx("Are you sure you want to navigate away from this page?")).setSummary(_tx("Press {ok} to continue, or {cancel} to stay on the current page.",{ok:_tx("Okay"),cancel:_tx("Cancel")})).setBody(htmlize(warning_text)).setButtons(Dialog.OK_AND_CANCEL).setHandler(continuation).setModal().show();},_adjustScrollForCurrentURI:function(){var current_uri=PageTransitions._current_uri;var scroll_position=PageTransitions._scroll_positions[current_uri];if(scroll_position){DOMScroll.scrollTo(scroll_position,false);return;}
function get_anchor(name){return(name||null)&&($$(sprintf('a[name=%e]',name))[0]||ge(name));}
var anchor=get_anchor(current_uri.getFragment());if(anchor){var anchor_position=Vector2.getElementPosition(anchor);anchor_position.x=0;DOMScroll.scrollTo(anchor_position);}},_onformsubmit:function(form){var old_action=new URI(form.getAttribute('action')||'');var new_action=_computeRelativeURI(PageTransitions._most_recent_uri,old_action);form.setAttribute('action',new_action.toString());var method=form.method?form.method.toUpperCase():'GET';if(method=='GET'){PageTransitions.go(new_action.addQueryData(serialize_form(form)));return false;}else{}}};function _computeRelativeURI(original,delta){var ret=new URI(),delta_=delta;original=new URI(original);delta=new URI(delta);if(!delta.isFacebookURI()){return delta_;}
var source=original;var components=['Protocol','Domain','Port','Path','QueryData','Fragment'];components.forEach(function(component){var combine_paths=component=='Path'&&source===original;if(combine_paths){ret.setPath(_computeRelativePath(original.getPath(),delta.getPath()));}
if(!is_empty(delta['get'+component]())){source=delta;}
if(!combine_paths){ret['set'+component](source['get'+component]());}});return ret;}
function _computeRelativePath(original,delta){if(!delta){return original;}
if(delta.charAt(0)=='/'){return delta;}
var parts=original.split('/').slice(0,-1);if(parts[0]!==''){Util.warn('Original path is not absolute.');}
delta.split('/').forEach(function(part){if(part=='.'){}else if(part=='..'){if(parts.length>1){parts=parts.slice(0,-1);}}else{parts.push(part);}});return parts.join('/');}
function go_or_replace(location_obj,target_url,replace){target_url=target_url.toString();if(replace&&!(ua.ie()<8)){location_obj.replace(target_url);}else if(location_obj.href==target_url){location_obj.reload();}else{location_obj.href=target_url;}}
var _BusyUIManager={_looking_busy:false,_original_cursors:[],lookBusy:function(link_element){if(link_element){_BusyUIManager._giveProgressCursor(link_element);}
if(_BusyUIManager._looking_busy){return;}
_BusyUIManager._looking_busy=true;_BusyUIManager._giveProgressCursor(document.body);},stopLookingBusy:function(){if(!_BusyUIManager._looking_busy){return;}
_BusyUIManager._looking_busy=false;while(_BusyUIManager._original_cursors.length){var element_and_cursor=_BusyUIManager._original_cursors.pop();var element=element_and_cursor[0];var cursor=element_and_cursor[1];if(element.style){element.style.cursor=cursor||'';}}},_giveProgressCursor:function(element){if(!ua.safari()){_BusyUIManager._original_cursors.push([element,element.style.cursor]);element.style.cursor='progress';}}};

function MenuBar(core_menu_id){this.core_menu_id=core_menu_id;this.core_menu=$(core_menu_id);this.menus=DOM.scry(this.core_menu,'li.fb_menu');this.timeout=250;}
copy_properties(MenuBar.prototype,{setTimeoutInterval:function(timeout){this.timeout=timeout;return this;},init:function(){var i;for(i=0;i<this.menus.length;i++){var menu=this.menus[i];var dropdown_id=menu.id+'_dropdown';if(ge(dropdown_id)){var menu_anchor=menu.firstChild.firstChild;var dropdown=$(dropdown_id);hover_menu(menu_anchor).registerHTMLMenu(dropdown_id).setPosition(dropmenu.ALIGN_LEFT).setTimeoutInterval(this.timeout).addHook('show',bind(this,'_onShowCallback',menu_anchor,dropdown)).addHook('hide',bind(this,'_onHideCallback',menu_anchor)).initialize();}}},_onShowCallback:function(clickTarget,menuElement){CSS.addClass(clickTarget,'hover');var scroller=window['ScrollArea']&&ScrollArea.getInnerInstance(menuElement);if(scroller){scroller.moveTo(0);}},_onHideCallback:function(clickTarget){CSS.removeClass(clickTarget,'hover');}});

function search_selector_onfound(result){var n;if(!(n=ge('n'))){return;}
n.value=result?result.i:-1;}
function search_result_selector_onsubmit(result){$('search').init.value=ge('filter_init')?$('filter_init').value:'';$('search').sf.value=ge('filter_sf')?$('filter_sf').value:'';$('search').submit();this.hide();this.advance_focus();}
function search_logged_ajax(data){new AsyncSignal('/ajax/search_log.php',data).send();}
function search_log_2nd_action(data){new AsyncRequest().setURI('/ajax/search_log_2nd_action.php').setMethod('POST').setReadOnly(true).setContextData('clicktype',data).setHandler(function(){}).send();}
function search_typeahead_log(data,evt,timestart){if(!data){return;}
var moddata=data;if(evt){moddata.evt=evt;}
moddata.t=(new Date()).getTime();if(timestart){moddata.dt=moddata.t-timestart;}
new AsyncSignal('/ajax/typeahead_log.php',moddata).send();}
var SearchDashboardKeyboardHandler=function(){return{right_arrow_key_handler:function(event,type){if(event.ctrlKey){if($('search_dashboard_next_session').href){goURI($('search_dashboard_next_session').href);}}else{if($('search_dashboard_next_query').href){goURI($('search_dashboard_next_query').href);}}
return false;},left_arrow_key_handler:function(event,type){if(event.ctrlKey){if($('search_dashboard_prev_session').href){goURI($('search_dashboard_prev_session').href);}}else{if($('search_dashboard_prev_query').href){goURI($('search_dashboard_prev_query').href);}}
return false;},right_arrow_key_filter:function(event,type){return true;}}}();

if(!this.JSON){this.JSON=function(){function f(n){return n<10?'0'+n:n;}
Date.prototype.toJSON=function(){return this.getUTCFullYear()+'-'+
f(this.getUTCMonth()+1)+'-'+
f(this.getUTCDate())+'T'+
f(this.getUTCHours())+':'+
f(this.getUTCMinutes())+':'+
f(this.getUTCSeconds())+'Z';};var m={'\b':'\\b','\t':'\\t','\n':'\\n','\f':'\\f','\r':'\\r','"':'\\"','\\':'\\\\'};function stringify(value,whitelist){var a,i,k,l,v;switch(typeof value){case'string':return(new RegExp('[\x00-\x1f\\\\"]')).test(value)?'"'+value.replace(/[\x00-\x1f\\"]/g,function(a){var c=m[a];if(c){return c;}
c=a.charCodeAt();return'\\u00'+Math.floor(c/16).toString(16)+
(c%16).toString(16);})+'"':'"'+value+'"';case'number':return isFinite(value)?String(value):'null';case'boolean':return String(value);case'null':return'null';case'object':if(DOM.isNode(value)){return null;}
if(!value){return'null';}
if(typeof value.toJSON==='function'){return stringify(value.toJSON());}
a=[];if(typeof value.length==='number'&&!(propertyIsEnumerable(value,'length'))){l=value.length;for(i=0;i<l;i+=1){a.push(stringify(value[i],whitelist)||'null');}
return'['+a.join(',')+']';}
if(whitelist){l=whitelist.length;for(i=0;i<l;i+=1){k=whitelist[i];if(typeof k==='string'){v=stringify(value[k],whitelist);if(v){a.push(stringify(k)+':'+v);}}}}else{for(k in value){if(typeof k==='string'){v=stringify(value[k],whitelist);if(v){a.push(stringify(k)+':'+v);}}}}
return'{'+a.join(',')+'}';}}
return{stringify:stringify,parse:function(text,filter){var j;function walk(k,v){var i,n;if(v&&typeof v==='object'){for(i in v){if(Object.prototype.hasOwnProperty.apply(v,[i])){n=walk(i,v[i]);if(n!==undefined){v[i]=n;}}}}
return filter(k,v);}
if(text&&/^[\],:{}\s]*$/.test(text.replace(/\\./g,'@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(:?[eE][+\-]?\d+)?/g,']').replace(/(?:^|:|,)(?:\s*\[)+/g,''))){j=eval('('+text+')');return typeof filter==='function'?walk('',j):j;}
throw new SyntaxError('decodeJSON');}};}();}
this.JSON.encode=this.JSON.stringify;this.JSON.decode=this.JSON.parse;function propertyIsEnumerable(o,p){if(o.propertyIsEnumerable){return o.propertyIsEnumerable(p);}
for(var prop in o){if(prop==p)return true;}
return false;}

if (window.Bootloader) { Bootloader.done(["js\/7cv754wal544gk8g.pkg.js"]); }