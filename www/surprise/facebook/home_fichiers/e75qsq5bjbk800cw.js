/*    HTTP Host:  b.static.ak.fbcdn.net                                        */
/*    Generated:  March 25th 2009 3:28:11 PM PDT                               */
/*      Machine:  10.16.140.102                                                */
/*       Source:  Global Cache                                                 */
/*     Location:  js/e75qsq5bjbk800cw.pkg.js h:eorvzxj1                        */
/*       Locale:  en_US                                                        */
/*         Path:  js/e75qsq5bjbk800cw.pkg.js                                   */


var onloadRegister=window.onloadRegister||function(h){onloadhooks.push(h);};var onloadhooks=window.onloadhooks||[];var onafterloadRegister=window.onafterloadRegister||function(h){onafterloadhooks.push(h);};var onafterloadhooks=window.onafterloadhooks||[];function wait_for_load(element,e,f){f=bind(element,f,e);if(window.loaded){return f();}
switch((e||event).type){case'load':case'focus':onloadRegister(f);return;case'click':if(element.original_cursor===undefined){element.original_cursor=element.style.cursor;}
if(document.body.original_cursor===undefined){document.body.original_cursor=document.body.style.cursor;}
element.style.cursor=document.body.style.cursor='progress';onafterloadRegister(function(){element.style.cursor=element.original_cursor;document.body.style.cursor=document.body.original_cursor;element.original_cursor=document.body.original_cursor=undefined;if(element.tagName.toLowerCase()=='a'){var original_event=window.event;window.event=e;var ret_value=element.onclick.call(element,e);window.event=original_event;if(ret_value!==false&&element.href){window.location.href=element.href;}}else if(element.click){element.click();}});break;}
return false;};function bind(obj,method){var args=[];for(var ii=2;ii<arguments.length;ii++){args.push(arguments[ii]);}
var fn=function(){var _obj=obj||(this==window?false:this);var _args=args.slice();for(var jj=0;jj<arguments.length;jj++){_args.push(arguments[jj]);}
if(typeof(method)=="string"){if(_obj[method]){return _obj[method].apply(_obj,_args);}}else{return method.apply(_obj,_args);}};if(typeof method=='string'){fn.name=method;}else if(method&&method.name){fn.name=method.name;}
fn.toString=function(){return bind._toString(obj,args,method);};return fn;};var curry=bind(null,bind,null);bind._toString=bind._toString||function(obj,args,method){return(typeof method=='string')?('late bind<'+method+'>'):('bound<'+method.toString()+'>');};function goURI(uri,force_reload){uri=uri.toString();if(!force_reload&&window.PageTransitions&&PageTransitions.isInitialized()){PageTransitions.go(uri);}else if(window.location.href==uri){window.location.reload();}else{window.location.href=uri;}}
var PrimordialBootloader=window.PrimordialBootloader||{loaded:[],done:function(names){PrimordialBootloader.loaded.push(names);}};var Bootloader=window.Bootloader||{done:PrimordialBootloader.done};function loadExternalJavascript(urls,callback,body){if(urls instanceof Array){var url=urls.shift(0);loadExternalJavascript(url,function(){if(urls.length){loadExternalJavascript(urls,callback,body);}else{callback&&callback();}},body);}else{var node=body?document.body:document.getElementsByTagName('head')[0];var script=document.createElement('script');script.type='text/javascript';script.src=urls;if(callback){script.onerror=script.onload=callback;script.onreadystatechange=function(){if(this.readyState=="complete"||this.readyState=="loaded"){callback();}}}
node.appendChild(script);return script;}}
window.loadFirebugConsole&&window.loadFirebugConsole();

DOMStorage={_storage:{},_elements:{},_tokenCounter:1,_NOT_IN_DOM_CONST:1,_getElementStorage:function(elem){var token;token=(elem.__FB_TOKEN||(elem.__FB_TOKEN=[DOMStorage._tokenCounter++]))[0];DOMStorage._elements[token]=elem;return DOMStorage._storage[token]||(DOMStorage._storage[token]={});},_shouldDeleteData:function(element){if(!element.nodeName){return false;}
try{if(null!=element.offsetParent){return false;}}catch(ex){}
if(document.documentElement.contains){return!document.documentElement.contains(element);}else{return(document.documentElement.compareDocumentPosition(element)&DOMStorage._NOT_IN_DOM_CONST);}},setData:function(element,key,value){var element_store=DOMStorage._getElementStorage(element);element_store[key]=value;return element;},getData:function(element,key,default_value){var element_store=DOMStorage._getElementStorage(element);var value=element_store[key];if((undefined===value)&&(typeof element.getAttribute=='function')){var attr_val=element.getAttribute('data-'+key);value=(null===attr_val)?undefined:attr_val;}
if((default_value!==undefined)&&(value===undefined)){value=element_store[key]=default_value;}
return value;},removeData:function(element,key){var element_store=DOMStorage._getElementStorage(element);delete element_store[key];return element;},cleanup:function(){var elem_token,elem;for(elem_token in DOMStorage._elements){elem=DOMStorage._elements[elem_token];if(DOMStorage._shouldDeleteData(elem)){delete DOMStorage._storage[elem_token];delete DOMStorage._elements[elem_token];}}}};

function hasArrayNature(obj){if(!obj){return false;}
if(typeof obj!='object'){return false;}
if(obj instanceof Array){return true;}
if(!('length'in obj)){return false;}
if('callee'in obj){return true;}
if('push'in obj&&'pop'in obj){return true;}
return false;}
function copy_properties(u,v){if(!u||!v){throw new TypeError("Can not copy between types "+typeof(u)+" and "+typeof(v)+".");}
for(var k in v){u[k]=v[k];}
if(v.hasOwnProperty&&v.hasOwnProperty('toString')&&(typeof v.toString!='undefined')&&(u.toString!==v.toString)){u.toString=v.toString;}
return u;}
function arrayize(obj){if(!hasArrayNature(obj)){return[obj];}
return obj;}
function is_empty(obj){if(obj instanceof Array){return obj.length==0;}else if(obj instanceof Object){for(var i in obj){return false;}
return true;}else{return!obj;}}
var Bootloader={configurePage:function(reverse_map){var links=document.getElementsByTagName('link');this._cssLinks=[];for(var ii=0;ii<links.length;++ii){if(links[ii].rel!='stylesheet'){continue;}
for(var k in reverse_map){if(links[ii].href.indexOf(k)!==-1){var name=reverse_map[k][0],permanent=reverse_map[k][1];this._cssLinkMap[name]=this._cssLinks.length;if(permanent){this._permanent[name]=true;}
delete reverse_map[k];break;}}
this._cssLinks.push(links[ii]);}},loadComponents:function(components,callback){components=arrayize(components);var required_resources=[];for(var ii=0;ii<components.length;++ii){var component_resource_list=this._componentMap[components[ii]];if(!component_resource_list){throw new Error("Can not bootload `"+components[ii]+"'.");}
for(var jj=0;jj<component_resource_list.length;++jj){required_resources.push(component_resource_list[jj]);}}
this.loadResources(required_resources,callback);},loadResources:function(resources,callback,replace){resources=arrayize(resources);if(replace){var map={};for(var ii=0;ii<resources.length;++ii){map[resources[ii].name]=true;}
for(var k in this._requested){if(!(k in this._permanent)&&!(k in map)){this._unloadResource(k);}}}
var request_index=this._pending.length;var will_request=[];var pending_request=false;for(var ii=0;ii<resources.length;++ii){var rsrc=resources[ii];if(rsrc.permanent){this._permanent[rsrc.name]=true;}
if(this._loaded[rsrc.name]){continue;}
if(callback){if(!this._pending[request_index]){this._pending[request_index]={names:{},callback:callback};}
this._pending[request_index].names[rsrc.name]=true;pending_request=true;}
if(!this._requested[rsrc.name]){this.requested(rsrc.name);will_request.push(rsrc);}}
for(var ii=0;ii<will_request.length;++ii){this.requestResource(will_request[ii].type,will_request[ii].src,will_request[ii].name);}
if(!pending_request&&callback){this._invoke(callback);}},requestResource:function(type,source,name){var h=this._getHardpoint();switch(type){case'js':var script=document.createElement('script');script.src=source;script.type='text/javascript';h.appendChild(script);break;case'css':var link=null;for(var jj=0;jj<this._cssLinks.length;++jj){if(this._cssLinks[jj]._unused){link=this._cssLinks[jj];if(name){this._cssLinkMap[name]=jj;}
break;}}
if(!link){var link=document.createElement('link');link.rel="stylesheet";link.type="text/css";link.media="all";link.href=source;this._cssLinks.push(link);h.appendChild(link);}else{link.href=source;}
link._unused=false;var id=Bootloader._getDivIdForCSSComponent(name);var div=document.getElementById(id);if(!div){div=document.createElement('div');div.id=id;document.body.appendChild(div);setTimeout(Bootloader._pollCSS.bind(Bootloader,name,Bootloader._CSS_POLL_EXPIRATION),Bootloader._CSS_POLL_INTERVAL,false);}
break;default:throw new TypeError("Bad resource type `"+type+"'.");}},_getDivIdForCSSComponent:function(name){return'bootloader_'+name.replace(/[^a-z0-9]/ig,'_');},_pollCSS:function(name,remaining){var id=Bootloader._getDivIdForCSSComponent(name);var div=document.getElementById(id);if(!div){return;}
var expected='42';var computedStyle;var done=div.offsetHeight==expected||div.currentStyle&&div.currentStyle['height']==expected+'px'||window.getComputedStyle&&(computedStyle=document.defaultView.getComputedStyle(div,null))&&computedStyle.getPropertyValue('height')==expected+'px';if(done||remaining<=0){Bootloader.done([name]);div.parentNode.removeChild(div);}else{setTimeout(Bootloader._pollCSS.bind(Bootloader,name,remaining-Bootloader._CSS_POLL_INTERVAL),Bootloader._CSS_POLL_INTERVAL,false);}},done:function(names){var preloaded=PrimordialBootloader.loaded;PrimordialBootloader.loaded=[];for(var ii=0;ii<preloaded.length;++ii){Bootloader.done(preloaded[ii]);}
this.requested(names);for(var ii=0;ii<names.length;++ii){var loaded_resource=names[ii];this._loaded[loaded_resource]=true;for(var jj=0;jj<this._pending.length;++jj){var required_resources=this._pending[jj].names;delete required_resources[loaded_resource];if(is_empty(required_resources)){var callback=this._pending[jj].callback;this._pending.splice(jj,1);--jj;if(callback){this._invoke(callback);}}}}
if(window.Arbiter){var message={sender:this};Arbiter.inform(Arbiter.BOOTLOAD,message,Arbiter.BEHAVIOR_EVENT);}},requested:function(resources){resources=arrayize(resources);for(var ii=0;ii<resources.length;++ii){this._requested[resources[ii]]=true;}},enableBootload:function(map){copy_properties(this._componentMap,map);},_unloadResource:function(name){if(this._cssLinks&&(name in this._cssLinkMap)){var link_id=this._cssLinkMap[name];var link=this._cssLinks[link_id];link.href=Bootloader._UNUSED_CSS_URL;link._unused=true;delete this._cssLinkMap[name];delete this._requested[name];delete this._loaded[name];}},_invoke:function(callback){setTimeout(callback,0);},_getHardpoint:function(){if(!this._hardpoint){var n,heads=document.getElementsByTagName('head');if(heads.length){n=heads[0];}else{n=document.body;}
this._hardpoint=n;}
return this._hardpoint;},initialResourcesReady:function(){return this._initialResourcesReady;},loadInitialResources:function(resources){this._initialResourcesReady=false;this.loadResources(resources,bind(this,function(){this._initialResourcesReady=true;window.onResourceReady&&window.onResourceReady();}));},_initialResourcesReady:true,_requested:{},_permanent:{},_loaded:{},_pending:[],_componentMap:{},_cssLinkMap:{},_cssLinks:[],_hardpoint:null,_CSS_POLL_EXPIRATION:5000,_CSS_POLL_INTERVAL:20,_UNUSED_CSS_URL:'javascript:void(0)'};

function chain(u,v){var fn,calls=[];for(var ii=0;ii<arguments.length;ii++){calls.push(arguments[ii]);}
fn=function(event){event=event||window.event;for(var ii=0;ii<calls.length;ii++){if(calls[ii]&&calls[ii].apply(this,arguments)===false){return false;}else if(event&&event.cancelBubble){return true;}}
return true;};fn.toString=function(){return chain._toString(calls);};return fn;}
chain._toString=chain._toString||function(calls){var ret='chained fns',call=calls.filter();for(var i=0;i<calls.length;i++){ret+='\n'+calls[i].toString();}
return ret;};function addEventBase(obj,type,fn,name_hash)
{if(obj.addEventListener){obj.addEventListener(type,fn,false);}
else if(obj.attachEvent)
{var fn_name=type+fn+name_hash;obj["e"+fn_name]=fn;obj[fn_name]=function(){obj["e"+fn_name](window.event);}
obj.attachEvent("on"+type,obj[fn_name]);}
return fn;}
function removeEventBase(obj,type,fn,name_hash)
{if(obj.removeEventListener){obj.removeEventListener(type,fn,false);}
else if(obj.detachEvent)
{var fn_name=type+fn+name_hash;if(obj[fn_name]){obj.detachEvent("on"+type,obj[fn_name]);obj[fn_name]=null;obj["e"+fn_name]=null;}}}
window.Event=window.Event||function(){};Event.prototype=Event.prototype||{};Event.prototype._inherits_from_prototype=true;function $E(e){e=e||window.event;e=e||{};if(!e._inherits_from_prototype){for(var k in Event.prototype){try{e[k]=Event.prototype[k];}catch(ignored){}}}
return e;}
Event.prototype.kill=function(){this.stop();this.prevent();return false;}
Event.prototype.prevent=function(){this.returnValue=false;this.preventDefault&&this.preventDefault();}
Event.prototype.stop=function(){this.cancelBubble=true;this.stopPropagation&&this.stopPropagation();}
Event.stop=function(e){return $E(e).stop();}
Event.kill=function(e){return $E(e).kill();}
Event.prevent=function(e){return $E(e).prevent();}
Event._DOMSTORAGE_KEY='Event.listeners';Event.Priority={TRADITIONAL:-10,NORMAL:0,LINK_CONTROLLER:100};Event.listen=function(element,event_name,handler,priority){if(typeof element=='string'){element=$(element,true);}
if(typeof priority=='undefined'){priority=Event.Priority.NORMAL;}
var handlers=DOMStorage.getData(element,Event._DOMSTORAGE_KEY,{});event_name=Event._normalizeName(event_name);Event._attachHandler(element,event_name);var type_handlers=handlers[event_name];if(!(priority in type_handlers)){type_handlers[priority]=[];}
var id=type_handlers[priority].length;var ref=new EventHandlerRef(handler,type_handlers[priority],id);type_handlers[priority].push(ref);return ref;};Event._normalizeName=function(event_name){event_name=event_name.toLowerCase();if(event_name.match(/^on/)){throw new TypeError("Bad event name `"+event_name+"': use `click', not `onclick'.");}
return event_name;};Event._attachHandler=function(element,event_name){var full_event_name='on'+event_name;var handlers=DOMStorage.getData(element,Event._DOMSTORAGE_KEY);if(event_name in handlers){if(element[full_event_name]!==Event._listenHandler){throw new Error("`"+full_event_name+"' listen handler gone!");}
return;}
handlers[event_name]={};var old_handler=element[full_event_name];element[full_event_name]=Event._listenHandler;if(old_handler){Event.listen(element,event_name,old_handler,Event.Priority.TRADITIONAL);}};Event._listenHandler=function(event){event=$E(event);var type=event.type;if(!DOMStorage.getData(this,Event._DOMSTORAGE_KEY)){throw new Error("Bad _listenHandler() context.");}
var type_handlers=DOMStorage.getData(this,Event._DOMSTORAGE_KEY)[type];if(!type_handlers){throw new Error("No registered handlers for `"+type+"'.");}
var priorities=Event._getOrderedPriorities();for(var pri_idx=0;pri_idx<priorities.length;pri_idx++){var priority=priorities[pri_idx];if(priority in type_handlers){var handlers=type_handlers[priority];for(var idx=0;idx<handlers.length;idx++){if(!handlers[idx]){continue;}
var result=handlers[idx].fire(this,event);if(result===false){return event.kill();}else if(event.returnValue===false){return false;}else if(event.cancelBubble){return event.stop();}}}}};Event._listenHandler.toString=function _toString(){return'Use Util.listeners() to see the list of listeners on an element.';};Event._getOrderedPriorities=function(){if(!Event._listenHandler._orderedPriorities){var ordered=values(Event.Priority);ordered.sort();Event._listenHandler._orderedPriorities=ordered;}
return Event._listenHandler._orderedPriorities;}
function EventHandlerRef(handler,container,index){this._handler=handler;this._container=container;this._index=index;}
copy_properties(EventHandlerRef.prototype,{remove:function(){delete this._handler;delete this._container[this._index];},fire:function(element,event){return this._handler.call(element,event);}});Event.prototype.getTarget=function(){var target=this.target||this.srcElement;if(target){return $(target);}
return null;}
Event.prototype.getModifiers=function(){var m={control:!!this.ctrlKey,shift:!!this.shiftKey,alt:!!this.altKey,meta:!!this.metaKey};m.access=ua.osx()?m.control:m.alt;m.any=m.control||m.shift||m.alt||m.meta;return m;}
function event_get_keypress_keycode(event){event=$E(event);if(!event){return false;}
switch(event.keyCode){case 63232:return 38;case 63233:return 40;case 63234:return 37;case 63235:return 39;case 63272:case 63273:case 63275:return null;case 63276:return 33;case 63277:return 34;}
if(event.shiftKey){switch(event.keyCode){case 33:case 34:case 37:case 38:case 39:case 40:return null;}}
return event.keyCode;}

function Arbiter(){copy_properties(this,{_listeners:[],_events:{}});copy_properties(this,Arbiter);}
copy_properties(Arbiter,{SUBSCRIBE_NEW:'new',SUBSCRIBE_ALL:'all',BEHAVIOR_EVENT:'event',BEHAVIOR_PERSISTENT:'persistent',BEHAVIOR_STATE:'state',ALL:'all',LIVEMESSAGE:'livemessage',BOOTLOAD:'bootload',PAGE_TRANSITION:'pagetransitions/transition',CONTEXT_CHANGE:'ui/context-change',PROFILE_PUBLISHER:'profile/publisher',REPLAYABLE_AJAX:'ajax/replayable',PAGECACHE_INVALIDATE:'pagecache/invalidate',NEW_NOTIFICATIONS:'chat/new_notifications',subscribe:function(types,callback,subscription_policy){var a=Arbiter._getInstance(this);types=types||Arbiter.ALL;a._listeners.push({callback:callback,types:types});subscription_policy=subscription_policy||Arbiter.SUBSCRIBE_ALL;if(subscription_policy==Arbiter.SUBSCRIBE_ALL){if(!(types instanceof Array)){types=[types];}
var e;var type;var ret;for(var idx=0;idx<types.length;idx++){type=types[idx];if(typeof type!="string"){throw new TypeError("Event types must be strings.");}
if(type in a._events){for(var ii=0;ii<a._events[type].length;ii++){e=a._events[type][ii];if(Arbiter._checkType(e[0],types)){ret=callback.apply(null,e);if(ret===false){a._events[type].splice(ii,1);ii--;}}}}}}else if(subscription_policy!=Arbiter.SUBSCRIBE_NEW){throw new TypeError("Bad subscription policy.");}
return{arbiterID:a._listeners.length-1};},unsubscribe:function(token){if(!('arbiterID'in token)){throw new TypeError("Not an arbiter token.");}
delete Arbiter._getInstance(this)._listeners[token.arbiterID];},inform:function(type,data,behavior){var a=Arbiter._getInstance(this);var e=[type,data];var idx=null;behavior=behavior||Arbiter.BEHAVIOR_EVENT;if(behavior==Arbiter.BEHAVIOR_PERSISTENT){idx=a._events.length;if(!(type in a._events)){a._events[type]=[];}
a._events[type].push(e);a._events[type]._stateful=false;}else if(behavior==Arbiter.BEHAVIOR_STATE){idx=0;a._events[type]=[e];a._events[type]._stateful=true;}else if(type in a._events){a._events[type]._stateful=false;}
var res;for(var ii=0;ii<a._listeners.length;ii++){if(a._listeners[ii]){if(Arbiter._checkType(e[0],a._listeners[ii].types)){res=a._listeners[ii].callback.apply(null,e);if(res===false){if(idx!==null){a._events[type].splice(idx,1);}
break;}}}}},query:function(type){var a=Arbiter._getInstance(this);if(!(type in a._events)){return null;}
if(!a._events[type]._stateful){throw new Error("Querying state of an unstateful event.");}
if(a._events[type].length){return a._events[type][0];}
return null;},_instance:null,_getInstance:function(self){if(self instanceof Arbiter){return self;}
if(!Arbiter._instance){Arbiter._instance=new Arbiter();}
return Arbiter._instance;},_checkType:function(event_type,callback_type){if(callback_type==Arbiter.ALL){return true;}
if(event_type==callback_type){return true;}
if(callback_type.length){for(var ii=0;ii<callback_type.length;ii++){if(callback_type[ii]==event_type){return true;}}}
return false;}});

Function.prototype.extend=function(superclass){if(typeof superclass!='string'){throw new TypeError('You must extend() with the name of a class, not the function object. '+'This generally means you need to replace "Dog.extend(Animal);" with '+'"Dog.extend(\'Animal\');".');}
if(!Metaprototype._arbiterHandle){Metaprototype._arbiterHandle=Arbiter.subscribe(Arbiter.BOOTLOAD,Metaprototype._onbootload.bind(Metaprototype));}
Metaprototype._queue(this,superclass);}
function Metaprototype(){}
copy_properties(Metaprototype,{_pending:[],_queue:function(subclass,superclass){this._pending.push({subclass:subclass,superclass:superclass});var src=this._pending;var dst=[];for(var ii=0;ii<src.length;++ii){var node=src[ii];for(var jj=0;jj<dst.length;++jj){if(window[dst[jj].superclass]==node.subclass){dst.splice(jj,0,node);break;}}
if(jj==dst.length){dst.push(node);}}
this._pending=dst;},_onbootload:function(type,data){this._update();},_update:function(){for(var ii=0;ii<this._pending.length;++ii){var node=this._pending[ii];var super_object=window[node.superclass];if(!super_object){continue;}
for(var jj=0;jj<this._pending.length;++jj){if(this._pending[jj].subclass==super_object){break;}}
if(jj==this._pending.length){this._pending.splice(ii,1);--ii;this._apply(node.subclass,super_object);}}},_apply:function(subclass,superclass){var superprototype=__metaprototype(superclass,0);var subprototype=__metaprototype(subclass,superprototype.prototype.__level+1);subprototype.parent=superprototype;}});function __metaprototype(obj,level){if(obj.__metaprototype){return obj.__metaprototype;}
var metaprototype=new Function();metaprototype.construct=__metaprototype_construct;metaprototype.prototype.construct=__metaprototype_wrap(obj,level,true);metaprototype.prototype.__level=level;metaprototype.base=obj;obj.prototype.parent=metaprototype;obj.__metaprototype=metaprototype;return metaprototype;}
function __metaprototype_construct(instance){__metaprototype_init(instance.parent);var parents=[];var obj=instance;while(obj.parent){parents.push(new_obj=new obj.parent());new_obj.__instance=instance;obj=obj.parent;}
instance.parent=parents[1];parents.reverse();parents.pop();instance.__parents=parents;instance.__instance=instance;return instance.parent.construct.apply(instance.parent,arguments);}
function __metaprototype_init(metaprototype){if(metaprototype.initialized)return;var base=metaprototype.base.prototype;if(metaprototype.parent){__metaprototype_init(metaprototype.parent);var parent_prototype=metaprototype.parent.prototype;for(i in parent_prototype){if(i!='__level'&&i!='construct'&&base[i]===undefined){base[i]=metaprototype.prototype[i]=parent_prototype[i]}}}
metaprototype.initialized=true;var level=metaprototype.prototype.__level;for(i in base){if(i!='parent'){base[i]=metaprototype.prototype[i]=__metaprototype_wrap(base[i],level);}}}
function __metaprototype_wrap(method,level,shift){if(typeof method!='function'||method.__prototyped){return method;}
var func=function(){var instance=this.__instance;if(instance){var old_parent=instance.parent;instance.parent=level?instance.__parents[level-1]:null;if(shift){var args=[];for(var i=1;i<arguments.length;i++){args.push(arguments[i]);}
var ret=method.apply(instance,args);}else{var ret=method.apply(instance,arguments);}
instance.parent=old_parent;return ret;}else{return method.apply(this,arguments);}}
func.__prototyped=true;return func;}
Function.prototype.bind=function(context){var argv=[arguments[0],this];var argc=arguments.length;for(var ii=1;ii<argc;ii++){argv.push(arguments[ii]);}
return bind.apply(null,argv);}
Function.prototype.curry=Function.prototype.bind.bind(null,null);Function.prototype.shield=function(context){if(typeof this!='function'){throw new TypeException();}
var bound=this.bind.apply(this,to_array(arguments));return function(){return bound();}};Function.prototype.defer=function(msec){if(typeof this!='function'){throw new TypeError();}
msec=msec||0;return setTimeout(this,msec);};Function.prototype.deferUntil=function(callback,timeout){if(typeof this!='function'){throw new TypeError();}
if(timeout&&typeof timeout!='number'){throw new TypeError();}
if(callback()){this();return;}
var orig=this,interval=null,start_time=(new Date()).getTime();var fn=function(){if(callback()||timeout&&((new Date()).getTime()-start_time)>=timeout){orig();interval&&clearInterval(interval);}}
interval=setInterval(fn,50)
return interval;};Function.prototype.recur=function(msec){if(typeof this!='function'){throw new TypeError();}
return setInterval(this,msec);};Function.prototype.occur=function(){if(typeof this!='function'){throw new TypeError();}
return this.apply(this,arguments);};Function.prototype.memoize=function(){if(typeof this!='function'){throw new TypeError();}
var cache={};var functor=this;return function(){var key=JSON.encode(arguments);if(!(key in cache)){cache[key]=functor.apply(this,arguments);}
return cache[key];};};Function.prototype.toString=(function(native_fn){return function(full){var raw_output=native_fn.call(this);if(full){return raw_output;}
var lines=raw_output.split('\n'),max_lines=5;if(lines.length>max_lines){lines.splice(3,lines.length-max_lines,'    ...');}
return lines.join('\n');};})(Function.prototype.toString);function bagofholding(){return undefined;}
function abstractMethod(){throw new Error('You must implement this function in your base class.');}
function identity(input){return input;}
function truth(){return true;}
function fireonce(fn){var fired=false;return function(){if(!fired){fired=true;return fn();}}}
function call_or_eval(obj,func,args_map){if(!func){return undefined;}
args_map=args_map||{};if(typeof(func)=='string'){var params=keys(args_map).join(', ');func=eval('({f: function('+params+') { '+func+'}})').f;}
if(typeof(func)!='function'){Util.error('handler was neither a function nor a string of JS code');return undefined;}
return func.apply(obj,values(args_map));}

function object(o){var F=new Function();F.prototype=o;return new F();}
function is_scalar(v){switch(typeof(v)){case'string':case'number':case'null':case'boolean':return true;}
return false;}
function keys(obj){if(hasArrayNature(obj)){throw new TypeError('keys() was passed an array.');}
var keys=[];for(var i in obj){keys.push(i);}
return keys;}
function values(obj){if(hasArrayNature(obj)){throw new TypeError('values() was passed an array; use to_array().');}
var values=[];for(var i in obj){values.push(obj[i]);}
return values;}
function count(obj){if(hasArrayNature(obj)){throw new TypeError('count() was passed an array.');}
var count=0;for(var i in obj){count++;}
return count;}
function are_equal(a,b){return JSON.encode(a)==JSON.encode(b);}
function merge(){var ret={};for(var i=0;i<arguments.length;i++){copy_properties(ret,arguments[i]);}
return ret;}
function obj_filter_keys(obj,keys){var ret={};for(var ii=0;ii<keys.length;ii++){var key=keys[ii];if(key in obj){ret[key]=obj[key];}}
return ret;}
function obj_intersect_keys(){var ret={};var _obj=arguments[0];oloop:for(var j in _obj){if(!_obj.hasOwnProperty(j)){continue;}
iloop:for(var ii=1;ii<arguments.length;ii++){var obj=arguments[ii];for(var k in obj){if(k===j){if(arguments.length-1===ii){ret[j]=_obj[j];}
continue iloop;}}
continue oloop;}}
return ret;}
function head(obj){for(var i in obj){return obj[i];}
return null;}

function to_array(obj){var ret=[]
for(var i=0,l=obj.length;i<l;++i){ret.push(obj[i]);}
return ret;}
var $A=to_array;Array.prototype.alloc=function(length){return length?new Array(length):[];}
Array.prototype.map=function(callback,thisObject){if(this==window){throw new TypeError();}
if(typeof(callback)!=="function"){throw new TypeError();}
var ii;var len=this.length;var r=this.alloc(len);for(ii=0;ii<len;++ii){if(ii in this){r[ii]=callback.call(thisObject,this[ii],ii,this);}}
return r;};Array.prototype.forEach=function(callback,thisObject){this.map(callback,thisObject);return this;};Array.prototype.each=function(callback,thisObject){return this.forEach.apply(this,arguments);}
Array.prototype.filter=function(callback,thisObject){callback=callback||identity;if(this==window){throw new TypeError();}
if(typeof(callback)!=="function"){throw new TypeError();}
var ii,val,len=this.length,r=this.alloc();for(ii=0;ii<len;++ii){if(ii in this){val=this[ii];if(callback.call(thisObject,val,ii,this)){r.push(val);}}}
return r;};Array.prototype.every=function(callback,thisObject){return(this.filter(callback,thisObject).length==this.length);}
Array.prototype.some=function(callback,thisObject){return(this.filter(callback,thisObject).length>0);}
Array.prototype.pull=function(callback){if(this==window){throw new TypeError();}
if(typeof(callback)=='string'){var grip_key=callback;callback=function(){return this[grip_key]};}
if(typeof(callback)!=='function'){throw new TypeError();}
var args=Array.prototype.slice.call(arguments,1);var len=this.length;var r=this.alloc(len);for(ii=0;ii<len;++ii){if(ii in this){r[ii]=callback.apply(this[ii],args);}}
return r;}
Array.prototype.pullEach=function(callback){this.pull.apply(this,arguments);return this;}
Array.prototype.filterEach=function(callback){var map=this.pull.apply(this,arguments);var len=this.length;var r=this.alloc();for(var ii=0;ii<len;++ii){if(ii in this){r.push(this[ii]);}}
return r;}
Array.prototype.reduce=null;Array.prototype.reduceRight=null;Array.prototype.sort=(function(sort){return function(callback){return(this==window)?null:(callback?sort.call(this,function(a,b){return callback(a,b)}):sort.call(this));}})(Array.prototype.sort);Array.prototype.reverse=(function(reverse){return function(){return(this==window)?null:reverse.call(this);}})(Array.prototype.reverse);Array.prototype.concat=(function(concat){return function(){return(this==window)?null:concat.apply(this,arguments);}})(Array.prototype.concat);Array.prototype.slice=(function(slice){return function(){return(this==window)?null:slice.apply(this,arguments);}})(Array.prototype.slice);Array.prototype.clone=Array.prototype.slice;if(Array.prototype.indexOf){Array.prototype.indexOf=(function(indexOf){return function(val,index){return(this==window)?null:indexOf.apply(this,arguments);}})(Array.prototype.indexOf);}else{Array.prototype.indexOf=function(val,index){if(this==window){throw new TypeError();}
var len=this.length;var from=Number(index)||0;from=(from<0)?Math.ceil(from):Math.floor(from);if(from<0){from+=len;}
for(;from<len;from++){if(from in this&&this[from]===val){return from;}}
return-1;};}
Array.prototype.contains=function(val){return this.indexOf(val)!=-1;};Array.prototype.remove=function(val){var index=this.indexOf(val);if(index!=-1){this.splice(index,1);}}
function mapToInt(array){return array.map(function(val,i){return parseInt(val,10);});}
function unique(array){var obj={};var res=[];for(var i=0;i<array.length;i++){var val=array[i];if(!obj[val]){res.push(val);}
obj[val]=1;}
return res;}

function List(length){if(arguments.length>1){for(var ii=0;ii<arguments.length;ii++){this.push(arguments[ii]);}}else{this.resize(length||0);}}
List.prototype.length=0;List.prototype.size=function(){return this.length;}
List.prototype.resize=function(new_size){this.length=new_size;return this;}
List.prototype.alloc=function(n){return new List(n);}
List.prototype.toString=function(){return'['+this.join(', ')+']';}
List.prototype.push=Array.prototype.push;List.prototype.pop=Array.prototype.pop;List.prototype.join=Array.prototype.join;List.prototype.map=Array.prototype.map;List.prototype.forEach=Array.prototype.forEach;List.prototype.each=Array.prototype.each;List.prototype.filter=Array.prototype.filter;List.prototype.every=Array.prototype.every;List.prototype.some=Array.prototype.some;List.prototype.pull=Array.prototype.pull;List.prototype.pullEach=Array.prototype.pullEach;List.prototype.pullFilter=Array.prototype.pullFilter;List.prototype.splice=Array.prototype.splice;function SortedList(compareFunction,uniqueElements){this._compareFunction=compareFunction||SortedList._defaultCompareFunction;if(uniqueElements===undefined){uniqueElements=false;}
this._unique=uniqueElements;}
SortedList.prototype=new List();SortedList.prototype.binarySearch=function(element){var low=0,high=this.length-1,mid=0;while(low<=high){var mid=low+Math.floor((high-low)/2);var cmp=this._compareFunction(element,this[mid]);if(cmp<0){high=mid-1;}else if(cmp>0){low=mid+1;}else{return mid;}}
return-(low+1);}
SortedList.prototype.contains=function(element){return this.binarySearch(element)>=0;}
SortedList.prototype.push=function(){this.concat(arguments);return this.length;}
SortedList.prototype.concat=function(array){for(var i=0;i<array.length;i++){var element=array[i];var idx=this._getInsertionPoint(element);if(idx!==null){Array.prototype.splice.apply(this,[idx,0,element]);}}
return this;}
SortedList.prototype.indexOf=Array.prototype.indexOf;SortedList.prototype.remove=Array.prototype.remove;SortedList.prototype.splice=function(){if(arguments.length>2){throw new Error('splice doesn\'t support adding elements. Use push instead.');}
Array.prototype.splice.apply(this,[arguments[0],arguments[1]]);}
SortedList.prototype.clear=function(){this.length=0;}
SortedList.prototype._getInsertionPoint=function(element){var ret=this.binarySearch(element);if(ret>=0&&this._unique){return null;}
if(ret<0){ret=-(ret+1);}
return ret;}
SortedList._defaultCompareFunction=function(a,b){if(a<b){return-1;}else if(a>b){return 1;}
return 0;}

function Augment(name,generator){this.name=name;this.generator=generator;this.properties=null;}
copy_properties(Augment.prototype,{augmentObject:function(target){if(!target){return target;}
try{if(!target.__augment){target.__augment={};}
if(!target.__augment[this.name]){target.__augment[this.name]=true;copy_properties(target,this.getProperties());}}catch(e){}
return target;},getProperties:function(){if(!this.properties){this.properties=this.generator();}
return this.properties;}});

function HTML(content){if(this===window){if(content instanceof HTML){return content;}
return new HTML(content);}
this._content=content;this._defer=false;this._extra_action='';this._nodes=null;this._inline_js=bagofholding;this._has_option_elements=false;return this;}
copy_properties(HTML.prototype,{toString:function(){var str=this._content;if(this._extra_action){str+='<script type="text/javascript">'+this._extra_action
+'</scr'+'ipt>';}
return str;},setAction:function(js){this._extra_action=js;return this;},getAction:function(){this._fillCache();var fn=function(){this._inline_js();eval_global(this._extra_action);}.bind(this);if(this.getDeferred()){return fn.defer.bind(fn);}else{return fn;}},setDeferred:function(defer){this._defer=!!defer;return this;},getDeferred:function(){return this._defer;},getContent:function(){return this._content;},getNodes:function(){this._fillCache();return this._nodes;},hasOptionElements:function(){this._fillCache();return this._has_option_elements;},_fillCache:function(){if(null!==this._nodes){return;}
var html=this._content;if(html===null){return;}
html=html.replace(/(<(\w+)[^>]*?)\/>/g,function(all,front,tag){return tag.match(/^(abbr|br|col|img|input|link|meta|param|hr|area|embed)$/i)?all:front+'></'+tag+'>';});var tags=html.trim().toLowerCase(),wrapper_elem=document.createElement('div'),dummy_span=false;var wrap=(!tags.indexOf('<opt')&&[1,'<select multiple="multiple" class="__WRAPPER">','</select>'])||(!tags.indexOf('<leg')&&[1,'<fieldset class="__WRAPPER">','</fieldset>'])||(tags.match(/^<(thead|tbody|tfoot|colg|cap)/)&&[1,'<table class="__WRAPPER">','</table>'])||(!tags.indexOf('<tr')&&[2,'<table><tbody class="__WRAPPER">','</tbody></table>'])||((!tags.indexOf('<td')||!tags.indexOf('<th'))&&[3,'<table><tbody><tr class="__WRAPPER">','</tr></tbody></table>'])||(!tags.indexOf('<col')&&[2,'<table><tbody></tbody><colgroup class="__WRAPPER">','</colgroup></table>'])||null;if(null===wrap){wrapper_elem.className='__WRAPPER';if(ua.ie()){wrap=[0,'<span style="display:none">&nbsp;</span>',''];dummy_span=true;}else{wrap=[0,'',''];}}
wrapper_elem.innerHTML=wrap[1]+html+wrap[2];;while(wrap[0]--){wrapper_elem=wrapper_elem.lastChild;}
if(dummy_span){wrapper_elem.removeChild(wrapper_elem.firstChild);}
if(wrapper_elem.className!='__WRAPPER'){Util.warn('HTML._fillCache: HTML markup is not well formed.');}
if(0!=wrapper_elem.getElementsByTagName('option').length){this._has_option_elements=true;}
if(ua.ie()){var tbody;if(!tags.indexOf('<table')&&-1==tags.indexOf('<tbody')){tbody=wrapper_elem.firstChild&&wrapper_elem.firstChild.childNodes;}else if(wrap[1]=='<table>'&&-1==tags.indexOf('<tbody')){tbody=wrapper_elem.childNodes;}else{tbody=[];}
for(var ii=tbody.length-1;ii>=0;--ii){if(tbody[ii].nodeName&&tbody[ii].nodeName.toLowerCase()=='tbody'&&tbody[ii].childNodes.length==0){tbody[ii].parentNode.removeChild(tbody[ii]);}}}
var scripts=wrapper_elem.getElementsByTagName('script');var callbacks=[];for(var i=0;i<scripts.length;i++){if(scripts[i].src){callbacks.push(Bootloader.requestResource.bind(Bootloader,'js',scripts[i].src));}else{callbacks.push(eval_global.bind(null,scripts[i].innerHTML));}}
for(var i=scripts.length-1;i>=0;i--){scripts[i].parentNode.removeChild(scripts[i]);}
var extracted_js=function(){for(var ii=0;ii<callbacks.length;ii++){callbacks[ii]();}};this._nodes=to_array(wrapper_elem.childNodes);this._inline_js=extracted_js;}});

function Vector2(x,y,domain){copy_properties(this,{x:parseFloat(x),y:parseFloat(y),domain:domain||'pure'});};copy_properties(Vector2.prototype,{toString:function(){return'('+this.x+', '+this.y+')';},add:function(vx,vy){var x=this.x,y=this.y,l=arguments.length;if(l==1){if(vx.domain!='pure'){vx=vx.convertTo(this.domain);}
x+=vx.x;y+=vx.y;}else if(l==2){x+=parseFloat(vx);y+=parseFloat(arguments[1]);}else{Util.warn('Vector2.add called with %d arguments, should be one (a vector) or '+'two (x and y coordinates).',l);}
return new Vector2(x,y,this.domain);},mul:function(sx,sy){if(typeof(sy)=="undefined"){sy=sx;}
return new Vector2(this.x*sx,this.y*sy,this.domain);},sub:function(v){var x=this.x,y=this.y,l=arguments.length;if(l==1){if(v.domain!='pure'){v=v.convertTo(this.domain);}
x-=v.x;y-=v.y;}else if(l==2){x-=parseFloat(v);y-=parseFloat(arguments[1]);}else{Util.warn('Vector2.add called with %d arguments, should be one (a vector) or '+'two (x and y coordinates).',l);}
return new Vector2(x,y,this.domain);},distanceTo:function(v){return this.sub(v).magnitude();},magnitude:function(){return Math.sqrt((this.x*this.x)+(this.y*this.y));},convertTo:function(newDomain){if(newDomain!='pure'&&newDomain!='viewport'&&newDomain!='document'){Util.error('Domain %q is not valid; legitimate coordinate domains are %q, %q, '+'%q.',newDomain,'pure','viewport','document');return new Vector2(0,0);}
if(newDomain==this.domain){return new Vector2(this.x,this.y,this.domain);}
if(newDomain=='pure'){return new Vector2(this.x,this.y);}
if(this.domain=='pure'){Util.error('Unable to covert a pure vector to %q coordinates; a pure vector is '+'abstract and does not exist in any document coordinate system. If '+'you need to hack around this, create the vector explicitly in some '+'document coordinate domain, by passing a third argument to the '+'constructor. But you probably don\'t, and are just using the class '+'wrong. Stop doing that.',newDomain);return new Vector2(0,0);}
var o=Vector2.getScrollPosition('document');var x=this.x,y=this.y;if(this.domain=='document'){x-=o.x;y-=o.y;}else{x+=o.x;y+=o.y;}
return new Vector2(x,y,newDomain);},setElementPosition:function(el){var p=this.convertTo('document');el.style.left=parseInt(p.x)+'px';el.style.top=parseInt(p.y)+'px';return this;},setElementDimensions:function(el){return this.setElementWidth(el).setElementHeight(el);},setElementWidth:function(el){el.style.width=parseInt(this.x,10)+'px';return this;},setElementHeight:function(el){el.style.height=parseInt(this.y,10)+'px';return this;}});copy_properties(Vector2,{compass:{east:'e',west:'w',north:'n',south:'s',center:'center',northeast:'ne',northwest:'nw',southeast:'se',southwest:'sw'},getEventPosition:function(e,domain){domain=domain||'document';e=$E(e);var x=e.pageX||(e.clientX+
(document.documentElement.scrollLeft||document.body.scrollLeft));var y=e.pageY||(e.clientY+
(document.documentElement.scrollTop||document.body.scrollTop));var v=new Vector2(x,y,'document');if(DOMScroll.getScrollWrapper()){v=v.add(Vector2.getScrollPosition());}
return v.convertTo(domain);},getScrollPosition:function(domain){domain=domain||'document';var wrapper=DOMScroll.getScrollWrapper();if(wrapper){var x=wrapper.scrollLeft;var y=wrapper.scrollTop;}else{var x=document.body.scrollLeft||document.documentElement.scrollLeft;var y=document.body.scrollTop||document.documentElement.scrollTop;}
return(new Vector2(x,y,'document').convertTo(domain));},getElementPosition:function(el,domain){domain=domain||'document';if(!el){return;}
if(ua.safari()<500&&el.tagName=='TR'){el=el.firstChild;}
var left=el.offsetLeft;var top=el.offsetTop;var op=el.offsetParent;var root=DOMScroll.getScrollWrapper()||document.body;var fixed=false;while(el.parentNode&&root!=el.parentNode&&document.body!=el.parentNode){el=el.parentNode;if(!isNaN(el.scrollTop)){if(!(ua.opera()<9.50)||!operaIgnoreScroll[window.getComputedStyle(el,'').getPropertyValue('display')]){top-=el.scrollTop;left-=el.scrollLeft;}}
if(op==el){if(ua.safari()<500&&el.tagName=='TR'){top+=el.firstChild.offsetTop;left+=el.firstChild.offsetLeft;}else{top+=el.offsetTop;left+=el.offsetLeft;}
op=el.offsetParent;}
if(op&&CSS.getStyle(op,'position')=='fixed'){fixed=true;top+=op.offsetTop;left+=op.offsetLeft;break;}}
if(fixed){var scrollPosition=Vector2.getScrollPosition('document');left+=scrollPosition.x;top+=scrollPosition.y;}
return(new Vector2(left,top,'document').convertTo(domain));},getElementDimensions:function(el,useClient){if(ua.safariPreWebkit()&&el.nodeName=='TR'){var tds=el.getElementsByTagName('td');var dimensions=Vector2.getElementCompassPoint(tds[tds.length-1],Vector2.compass.southeast,useClient).sub(Vector2.getElementPosition(tds[0],'document',useClient));return dimensions;}
var x=(useClient?el.clientWidth:el.offsetWidth)||0;var y=(useClient?el.clientHeight:el.offsetHeight)||0;return new Vector2(x,y);},getHiddenElementDimensions:function(el){var element=$(el);var els=element.style;var originalVisibility=els.visibility;var originalPosition=els.position;var originalDisplay=els.display;if(originalDisplay=='none'){els.visibility='hidden';els.position='absolute';els.display='block';}
var originalDimensions=Vector2.getElementDimensions(element);els.display=originalDisplay;els.position=originalPosition;els.visibility=originalVisibility;return originalDimensions;},getElementCompassPoint:function(el,which,useClient){which=which||Vector2.compass.southeast;var p=Vector2.getElementPosition(el);var d=Vector2.getElementDimensions(el,useClient);var c=Vector2.compass;switch(which){case c.east:return p.add(d.x,d.y*.5);case c.west:return p.add(0,d.y*.5);case c.north:return p.add(d.x*.5,0);case c.south:return p.add(d.x*.5,d.y);case c.center:return p.add(d.mul(.5));case c.northwest:return p;case c.northeast:return p.add(d.x,0);case c.southwest:return p.add(0,d.y);case c.southeast:return p.add(d);}
Util.error('Unknown compass point %s.',which);return p;},getViewportDimensions:function(){var x=(window&&window.innerWidth)||(document&&document.documentElement&&document.documentElement.clientWidth)||(document&&document.body&&document.body.clientWidth)||0;var y=(window&&window.innerHeight)||(document&&document.documentElement&&document.documentElement.clientHeight)||(document&&document.body&&document.body.clientHeight)||0;return new Vector2(x,y,'viewport');},getDocumentDimensions:function(){var wrapper=DOMScroll.getScrollWrapper();var x=(wrapper&&wrapper.scrollWidth)||(document&&document.documentElement&&document.documentElement.scrollWidth)||(document&&document.body&&document.body.scrollWidth)||0;var y=(wrapper&&wrapper.scrollHeight)||(document&&document.documentElement&&document.documentElement.scrollHeight)||(document&&document.body&&document.body.scrollHeight)||0;return new Vector2(x,y,'document');}});var mouseX=function(e){return Vector2.getEventPosition(e).x;}
var mouseY=function(e){return Vector2.getEventPosition(e).y;}
var pageScrollX=function(){return Vector2.getScrollPosition().x;}
var pageScrollY=function(){return Vector2.getScrollPosition().y;}
var getViewportWidth=function(){return Vector2.getViewportDimensions().x;}
var getViewportHeight=function(){return Vector2.getViewportDimensions().y;}
var operaIgnoreScroll={'table':true,'inline-table':true,'inline':true};function elementX(obj){return Vector2.getElementPosition(obj,'document').x;}
function elementY(obj){return Vector2.getElementPosition(obj,'document').y;}

var DOMScroll={_scrollWrapper:0,usingScrollWrapper:function(){return env_get('use_scroll_wrapper');},getScrollWrapper:function(){if(DOMScroll._scrollWrapper===0){DOMScroll._scrollWrapper=DOMScroll.usingScrollWrapper()?ge('scroll_wrapper'):null;}
return DOMScroll._scrollWrapper;},getScrollRoot:function(){return DOMScroll.getScrollWrapper()||document.body;},SCROLL_CHANGE:'scroll_change',_hasScrollListeners:false,_isScrolled:null,registerScrollChangeHandler:function(cb){Arbiter.subscribe(DOMScroll.SCROLL_CHANGE,cb);if(!DOMScroll._hasScrollListeners){DOMScroll._hasScrollListeners=true;Event.listen(window,'resize',DOMScroll.updateScrollState);}},updateScrollState:function(){if(DOMScroll.usingScrollWrapper()){var wrapper=DOMScroll.getScrollWrapper();var offset_dim=Vector2.getElementDimensions(wrapper);var client_dim=Vector2.getElementDimensions(wrapper,true);var is_scrolled_x=(offset_dim.y>client_dim.y);var is_scrolled_y=(offset_dim.x>client_dim.x);}else{var viewport_dim=Vector2.getViewportDimensions();var document_dim=Vector2.getDocumentDimensions();var is_scrolled_x=(document_dim.x>viewport_dim.x);var is_scrolled_y=(document_dim.y>viewport_dim.y);}
is_scrolled_x+=0;is_scrolled_y+=0;var changed=(DOMScroll._isScrolled===null)||(is_scrolled_x!=DOMScroll._isScrolled.x)||(is_scrolled_y!=DOMScroll._isScrolled.y);if(changed){DOMScroll._isScrolled=new Vector2(is_scrolled_x,is_scrolled_y);var message={sender:DOMScroll,is_scrolled:DOMScroll.getScrollState()};Arbiter.inform(DOMScroll.SCROLL_CHANGE,message,Arbiter.BEHAVIOR_STATE);}},getScrollState:function(){if(DOMScroll._isScrolled===null){DOMScroll.updateScrollState();}
return DOMScroll._isScrolled;},_scrollbarSize:null,_initScrollbarSize:function(){var inner=$N('p');inner.style.width='100%';inner.style.height='200px';var outer=$N('div');outer.style.position='absolute';outer.style.top='0px';outer.style.left='0px';outer.style.visibility='hidden';outer.style.width='200px';outer.style.height='150px';outer.style.overflow='hidden';outer.appendChild(inner);document.body.appendChild(outer);var w1=inner.offsetWidth;outer.style.overflow='scroll';var w2=inner.offsetWidth;if(w1==w2){w2=outer.clientWidth;}
document.body.removeChild(outer);DOMScroll._scrollbarSize=w1-w2;if(DOMScroll._scrollbarSize<5){DOMScroll._scrollbarSize=15;}},getScrollbarSize:function(){if(DOMScroll._scrollbarSize===null){DOMScroll._initScrollbarSize();}
return DOMScroll._scrollbarSize;},scrollTo:function(v,use_animation,center){use_animation=use_animation||use_animation===undefined;if(!(v instanceof Vector2)){var x=Vector2.getScrollPosition().x;var y=Vector2.getElementPosition($(v)).y;y=y-Math.min(0,Math.max(Vector2.getViewportDimensions().y/3,100));v=new Vector2(x,y,'document');}
if(center){v.y-=Vector2.getViewportDimensions().y/2;}
v=v.convertTo('document');var wrapper=DOMScroll.getScrollWrapper();if(use_animation&&window.animation){var root=wrapper||document.body;animation(root).to('scrollTop',v.y).to('scrollLeft',v.x).ease(animation.ease.end).duration(750).go();}else if(wrapper){wrapper.scrollTop=v.y;wrapper.scrollLeft=v.x;}else if(window.scrollTo){window.scrollTo(v.x,v.y);}}};

function Stack(){this.stack=[];try{var metaStack=[];try{({}).llama();}catch(e){if(e.stack){var regex=/^[^@]*?@(.+?):([0-9]+)$/mg;for(line=regex.exec(e.stack);line;line=regex.exec()){metaStack.push([line[1],line[2]]);}}}
var frame=arguments.callee,stale=[];for(var frame=arguments.callee,i=0;frame;frame=frame.caller,++i){i&&this.stack.push({func:frame,args:frame.arguments,file:metaStack[i]?metaStack[i][0]:null,line:metaStack[i]?metaStack[i][1]:null,toString:Stack.frameToString});if(stale.indexOf(frame)>=0){break;}
stale.push(frame);}}catch(e){}}
Stack.prototype.shift=function(n){this.stack.splice(0,n);return this;}
Stack.recurssion={toString:bind(Stack,'frameToString')};Stack.functionGetName=function(fn,default_name){return(fn&&fn.name)||(/^function *([^(]*)\(/.exec(fn)||[]).pop()||(default_name===undefined?'(no name)':default_name);}
Stack.frameSrcToString=function(file,line){if(!file){return'?';}else if(file.indexOf('TabConsole.getInstance().onresult')>0){return'IceSpider';}else if(file.indexOf('with (__scope__.vars)')>0){return'FireBug';}else{return file+(line?':'+line:'');}}
Stack.frameToString=function(){if(this==Stack.recurssion){return'* * recurssion * *';}
var str=Stack.argToString(this.func)+'(';for(var i=0;i<this.args.length;i++){str+=(i?', ':'')+Stack.argToString(this.args[i]);}
return str+') @ '+Stack.frameSrcToString(this.file,this.line);}
Stack.argToString=function(arg){if(arg instanceof Function){return Stack.functionGetName(arg);}if(arg instanceof Array){return'Array';}else if(arg instanceof Object){return'Object';}else if(typeof arg=='string'){return'"'+arg.replace(/("|\\)/g,'\\$1')+'"';}else{return arg+'';}}
Stack.prototype.toString=function(){if(!this.stack.length){return'No stack trace available.';}
var str='';for(var i=0;i<this.stack.length;i++){str+=(i?'\n':'')+'#'+i+' '+this.stack[i];}
return str;}

String.prototype.trim=function(){if(this==window){return null;}
return this.replace(/^\s*|\s*$/g,'');}
function trim(text){try{return String(text.toString()).trim();}catch(ignored){return'';}}
String.prototype.startsWith=function(substr){if(this==window){return null;}
return this.substring(0,substr.length)==substr;};String.prototype.endsWith=function(substr){if(this==window){return null;}
return this.length>=substr.length&&this.substring(this.length-substr.length)==substr;};String.prototype.split=(function(split){return function(separator,limit){var flags="";if(separator===null||limit===null){return[];}else if(typeof separator=='string'){return split.call(this,separator,limit);}else if(separator===undefined){return[this.toString()];}else if(separator instanceof RegExp){if(!separator._2||!separator._1){flags=separator.toString().replace(/^[\S\s]+\//,"");if(!separator._1){if(!separator.global){separator._1=new RegExp(separator.source,"g"+flags);}else{separator._1=1;}}}
separator1=separator._1===1?separator:separator._1;var separator2=(separator._2?separator._2:separator._2=new RegExp("^"+separator1.source+"$",flags));if(limit===undefined||limit<0){limit=false;}else{limit=Math.floor(limit);if(!limit)return[];}
var match,output=[],lastLastIndex=0,i=0;while((limit?i++<=limit:true)&&(match=separator1.exec(this))){if((match[0].length===0)&&(separator1.lastIndex>match.index)){separator1.lastIndex--;}
if(separator1.lastIndex>lastLastIndex){if(match.length>1){match[0].replace(separator2,function(){for(var j=1;j<arguments.length-2;j++){if(arguments[j]===undefined)match[j]=undefined;}});}
output=output.concat(this.substring(lastLastIndex,match.index),(match.index===this.length?[]:match.slice(1)));lastLastIndex=separator1.lastIndex;}
if(match[0].length===0){separator1.lastIndex++;}}
return(lastLastIndex===this.length)?(separator1.test("")?output:output.concat("")):(limit?output:output.concat(this.substring(lastLastIndex)));}else{return split.call(this,separator,limit);}}})(String.prototype.split);

function escapeURI(u)
{if(encodeURIComponent){return encodeURIComponent(u);}
if(escape){return escape(u);}}
function htmlspecialchars(text){if(typeof(text)=='undefined'||text===null||!text.toString){return'';}
if(text===false){return'0';}else if(text===true){return'1';}
return text.toString().replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/'/g,'&#039;').replace(/</g,'&lt;').replace(/>/g,'&gt;');}
function htmlize(text){return htmlspecialchars(text).replace(/\n/g,'<br />');}
function escape_js_quotes(text){if(typeof(text)=='undefined'||!text.toString){return'';}
return text.toString().replace(/\\/g,'\\\\').replace(/\n/g,'\\n').replace(/\r/g,'\\r').replace(/"/g,'\\x22').replace(/'/g,'\\\'').replace(/</g,'\\x3c').replace(/>/g,'\\x3e').replace(/&/g,'\\x26');}

function sprintf(){if(arguments.length==0){Util.warn('sprintf() was called with no arguments; it should be called with at '+'least one argument.');return'';}
var args=['This is an argument vector.'];for(var ii=arguments.length-1;ii>0;ii--){if(typeof(arguments[ii])=="undefined"){Util.log('You passed an undefined argument (argument '+ii+') to sprintf(). '+'Pattern was: `'+(arguments[0])+'\'.','error');args.push('');}else if(arguments[ii]===null){args.push('');}else if(arguments[ii]===true){args.push('true');}else if(arguments[ii]===false){args.push('false');}else{if(!arguments[ii].toString){Util.log('Argument '+(ii+1)+' to sprintf() does not have a toString() '+'method. The pattern was: `'+(arguments[0])+'\'.','error');return'';}
args.push(arguments[ii]);}}
var pattern=arguments[0];pattern=pattern.toString().split('%');var patlen=pattern.length;var result=pattern[0];for(var ii=1;ii<patlen;ii++){if(args.length==0){Util.log('Not enough arguments were provide to sprintf(). The pattern was: '+'`'+(arguments[0])+'\'.','error');return'';}
if(!pattern[ii].length){result+="%";continue;}
var p=0;var m=0;var r='';var padChar=' ';var padSize=null;var maxSize=null;var rawPad='';var pos=0;if(m=pattern[ii].match(/^('.)?(?:(-?\d+\.)?(-?\d+)?)/)){if(m[2]!==undefined&&m[2].length){padSize=parseInt(rawPad=m[2]);}
if(m[3]!==undefined&&m[3].length){if(padSize!==null){maxSize=parseInt(m[3]);}else{padSize=parseInt(rawPad=m[3]);}}
pos=m[0].length;if(m[1]!==undefined&&m[1].length){padChar=m[1].charAt(1);}else{if(rawPad.charAt(0)==0){padChar='0';}}}
switch(pattern[ii].charAt(pos)){case's':case'#':raw=htmlspecialchars(args.pop().toString());break;case'h':raw=args.pop().toString();break;case'd':raw=parseInt(args.pop()).toString();break;case'f':raw=parseFloat(args.pop()).toString();break;case'q':raw="`"+htmlspecialchars(args.pop().toString())+"'";break;case'e':raw="'"+escape_js_quotes(args.pop().toString())+"'";break;case'L':var list=args.pop();for(var ii=0;ii<list.length;ii++){list[ii]="`"+htmlspecialchars(args.pop().toString())+"'";}
if(list.length>1){list[list.length-1]='and '+list[list.length-1];}
raw=list.join(', ');break;case'x':var x=args.pop();var line=null;var src=null;try{if(typeof(x['line'])!='undefined'){line=x.line;}else if(typeof(x['lineNumber'])!='undefined'){line=x.lineNumber;}
if(typeof(x['sourceURL'])!='undefined'){src=x['sourceURL'];}else if(typeof(x['fileName'])!='undefined'){src=x['fileName'];}}catch(exception){}
var s='[An Exception]';try{s=x.message||x.toString();}catch(exception){}
raw=s+' [at '+Stack.frameSrcToString(src,line)+']';break;default:raw="%"+pattern[ii].charAt(pos+1);break;}
if(padSize!==null){if(raw.length<Math.abs(padSize)){var padding='';var padlen=(Math.abs(padSize)-raw.length);for(var ll=0;ll<padlen;ll++){padding+=padChar;}
if(padSize<0){raw+=padding;}else{raw=padding+raw;}}}
if(maxSize!==null){if(raw.length>maxSize){raw=raw.substr(0,maxSize);}}
result+=raw+pattern[ii].substring(pos+1);}
if(args.length>1){Util.log('Too many arguments ('+(args.length-1)+' extras) were passed to '+'sprintf(). Pattern was: `'+(arguments[0])+'\'.','error');}
return result;}

function env_get(k){return typeof(window['Env'])!='undefined'&&Env[k];}
function muffinize(str){var muffin_top='a';var muffin_bottom='d';var muffin=[muffin_top,muffin_bottom].join('')
return str.replace(/muffin/g,muffin);}
var Util={_suppress:false,fallbackErrorHandler:function(msg){aiert(msg);},isDevelopmentEnvironment:function(){return env_get('dev');},warn:function(){Util.log(sprintf.apply(null,arguments),'warn');},error:function(){Util.log(sprintf.apply(null,arguments),'error');},log:function(msg,type){if(Util._suppress){return;}
if(Util.isDevelopmentEnvironment()){type=type||'log';if(typeof(console)!='undefined'&&console[type]){console[type](msg);}else if(typeof(window.TabConsole)!='undefined'){var con=TabConsole.getInstance();if(con){con.log(HTML(msg),type);}}else if(Util.fallbackErrorHandler){Util.fallbackErrorHandler(msg);}}else{if(type=='error'){if((typeof(window['Env'])!='undefined')&&(Env.rlog)&&(typeof(window['debug_rlog'])=='function')){msg+='\n\n'+Util.stack();debug_rlog(msg);}}}},setSuppressed:function(suppress){Util._suppress=suppress;},stack:function(){return(new Stack()).toString();},trace:function(){Util.log(Util.stack());},keyForValue:function(obj,val){for(var i in obj){if(obj[i]==val){return i;}}},listeners:function(element,type){if(type.indexOf('on')!==0){type='on'+type;}
var none_found='Sorry, no listeners were found';if(!element[type]){return none_found;}else if(typeof element[type]=='string'){return element[type]||none_found;}else if(element[type]!==Event._listenHandler){return element[type].toString()||none_found;}else{var all_handlers=DOMStorage.getData(element,Event._DOMSTORAGE_KEY),type_handlers=(all_handlers&&all_handlers[type.substring(2)])||{},output=[],priorities=Event._getOrderedPriorities(),found=false;for(var ii=0;ii<priorities.length;ii++){var pri_val=priorities[ii];if(pri_val in type_handlers){var pri_name=Util.keyForValue(Event.Priority,pri_val);if(found){output.push('\n');}
output.push('*** '+pri_name+' Listeners ***');var handlers=type_handlers[pri_val];for(var idx=0;idx<handlers.length;idx++){if(handlers[idx]){found=true;output.push('    '+handlers[idx]._handler.toString().replace(/\n/g,'\n    '));}}}}
return found?output.join('\n'):none_found;}}};chain._toString=function(calls){var indent='\n |  ',first_indent=' |--',last_indent='\n    ',filtered_fns=calls.filter(),output=['Chained Functions ('+filtered_fns.length+')'+indent];for(var ii=0;ii<filtered_fns.length;ii++){var last=(ii==filtered_fns.length-1),ind=last?last_indent:indent;output.push(filtered_fns[ii]?first_indent
+filtered_fns[ii].toString().replace(/\n/g,ind)
+(!last?indent:''):'');}
return output.join('\n');};bind._toString=function(obj,args,method){if(typeof method!='string'&&typeof method!='function'){return'';}
var env=Stack.functionGetName(obj&&obj.constructor,'UnknownType'),late=(typeof method=='string'),b_type=late?'Late Binding Function':'Bound Function',m_name=(late&&method)||(method.toString==Function.prototype.toString&&Stack.functionGetName(method,false))||Util.keyForValue(obj,method)||method.toString().replace(/\n/g,'\n           '),arg_list;if(late){arg_list=args.map(Stack.argToString).join(', ');}else{var fn_str=Function.prototype.toString.call(method);fn_str=fn_str.substr(fn_str.indexOf('(')+1);fn_str=fn_str.substr(0,fn_str.indexOf(')'));arg_list=fn_str.split(',').pull(''.trim).concat(args.slice(method.length).map(function(elm,i){return'undeclared_'+(i+1);})).filter().map(function(param,i){return args[i]===undefined?'<'+param+'>':param+' = '+Stack.argToString(args[i]);}).join(', ')||'no arguments';}
return b_type
+'\n  scope  : '+env
+'\n  params : '+arg_list
+'\n  method : '+m_name;};

function show(){for(var i=0;i<arguments.length;i++){var element=ge(arguments[i]);if(element&&element.style)element.style.display='';}
return false;}
function hide(){for(var i=0;i<arguments.length;i++){var element=ge(arguments[i]);if(element&&element.style)element.style.display='none';}
return false;}
function shown(el){el=ge(el);return(el.style.display!='none'&&!(el.style.display==''&&el.offsetWidth==0));}
function toggle(){for(var i=0;i<arguments.length;i++){var element=$(arguments[i]);element.style.display=CSS.getStyle(element,"display")=='block'?'none':'block';}
return false;}
function toggleDisplayNone(){for(var i=0;i<arguments.length;i++){var element=$(arguments[i]);if(shown(element)){hide(element);}else{show(element);}}
return false;}
function set_inner_html(obj,html,defer_js_execution){DOM.setContent(obj,HTML(html).setDeferred(!!defer_js_execution));}
function eval_global(js){if('string'!=typeof(js)){throw new Error('JS sent to eval_global is not a string.  Only strings '+'are permitted.');}else if(''==js){return;}
var obj=document.createElement('script');obj.type='text/javascript';try{obj.appendChild(document.createTextNode(js));}catch(e){obj.text=js;}
document.body.appendChild(obj);}
function expandCollapseInplace(topElemId,bottomElemId){topElem=ge(topElemId);bottomElem=ge(bottomElemId);if(!topElem||!bottomElem){return false;}
topElemHeight=topElem.clientHeight;if(shown(bottomElemId)){bottomElemHeight=bottomElem.clientHeight;newHeight=topElemHeight+bottomElemHeight;topElem.style.height=newHeight+'px';CSS.addClass(bottomElem,'hidden_elem');}else{CSS.removeClass(bottomElem,'hidden_elem');bottomElemHeight=bottomElem.clientHeight;newHeight=topElemHeight-bottomElemHeight;topElem.style.height=newHeight+'px';}
return true;}

var ua={ie:function(){return ua._populate()||this._ie;},firefox:function(){return ua._populate()||this._firefox;},opera:function(){return ua._populate()||this._opera;},safari:function(){return ua._populate()||this._safari;},safariPreWebkit:function(){return ua._populate()||this._safari<500;},windows:function(){return ua._populate()||this._windows;},osx:function(){return ua._populate()||this._osx;},linux:function(){return ua._populate()||this._linux;},_populated:false,_populate:function(){if(ua._populated){return;}
ua._populated=true;var agent=/(?:MSIE.(\d+\.\d+))|(?:(?:Firefox|GranParadiso|Iceweasel).(\d+\.\d+))|(?:Opera.(\d+\.\d+))|(?:AppleWebKit.(\d+(?:\.\d+)?))/.exec(navigator.userAgent);var os=/(Mac OS X)|(Windows;)|(Linux)/.exec(navigator.userAgent);if(agent){ua._ie=agent[1]?parseFloat(agent[1]):NaN;if(ua._ie>=8&&!window.HTMLCollection){ua._ie=7;}
ua._firefox=agent[2]?parseFloat(agent[2]):NaN;ua._opera=agent[3]?parseFloat(agent[3]):NaN;ua._safari=agent[4]?parseFloat(agent[4]):NaN;}else{ua._ie=ua._firefox=ua._opera=ua._safari=NaN;}
if(os){ua._osx=!!os[1];ua._windows=!!os[2];ua._linux=!!os[3];}else{ua._osx=ua._windows=ua._linux=false;}}};

var DOM={tryElement:function(id,no_augment){if(typeof(id)=='undefined'){Util.error('Tried to get "undefined" element!');return null;}
var obj;var aug=no_augment?identity:DOM._getNodeAugment();if(typeof(id)=='string'){if(id=='book'){Util.error('FB95: Trying to get #book element from JS. #book no'+'longer exists.');}
obj=document.getElementById(id);if(!(ua.ie()>=7&&ua.ie()<8)){return aug(obj);}
if(!obj){return null;}else if(typeof(obj.id)=='string'&&obj.id==id){return aug(obj);}else{var candidates=document.getElementsByName(id);if(!candidates||!candidates.length){return null;}
var maybe=[];for(var ii=0;ii<candidates.length;ii++){var c=candidates[ii];if(!c.id&&id){continue;}
if(typeof(c.id)=='string'&&c.id!=id){continue;}
maybe.push(candidates[ii]);}
if(!maybe.length){return null;}
return aug(maybe[0]);}}
return aug(id);},getElement:function(id,no_augment){var el=DOM.tryElement.apply(null,$A(arguments),no_augment);if(!el){Util.warn('Tried to get element %q, but it is not present in the page. (Use '+'ge() to test for the presence of an element.)',arguments[0]);}
return el;},find:function(element,selector_str){var elements=DOM.scry(element,selector_str);if(1!=elements.length){Util.error('DOM.find located %d elements that matched the selector `%s\''+'.  Please only use find when you are sure that 1 element '+'should match (like $).  Otherwise, please use DOM.scry.',elements.length,selector_str);return null;}
return elements[0];},scry:function(element,selector_str,no_augment){var selectors=selector_str.split(' ');var candidates=[element||document];for(var i=0;i<selectors.length;i++){if(candidates.length==0){break;}
if(selectors[i]==''){continue;}
var selector=selectors[i];var new_candidates=[];selector=selector.replace(/\./g,' .');selector=selector.replace(/\#/g,' #');selector=selector.replace(/\[/g,' [');var sub_selectors=selector.split(' ');var tag=sub_selectors[0]||'*';var id_selector=sub_selectors[1]&&sub_selectors[1].charAt(0)=='#';if(i==0&&tag=='*'&&Util.isDevelopmentEnvironment()&&!id_selector){Util.error('DOM.scry was called without a tag in the selector. You '+'should probably use DOM.scry like `%s` instead of `%s`.','div'+selector_str,selector_str);}
if(id_selector){var elem=ge(sub_selectors[1].slice(1),true);if(elem&&('*'==tag||elem.tagName.toLowerCase()==tag)){for(var iter=0;iter<candidates.length;iter++){if(document==candidates[iter]||DOM.contains(candidates[iter],elem)){new_candidates=[elem];break;}}}}else{var tag_candidates=[];var candidate_l=candidates.length;for(var ii=0;ii<candidate_l;ii++){var elements=candidates[ii].getElementsByTagName(tag);var elements_l=elements.length;for(var jj=0;jj<elements_l;jj++){tag_candidates.push(elements[jj]);}}
var is_class;var class_regexp;for(var sub_iter=1;sub_iter<sub_selectors.length;sub_iter++){var sub_selector=sub_selectors[sub_iter];if(sub_selector.charAt(0)=='.'){is_class=true;class_regexp=new RegExp('\\b'+sub_selector.substring(1)+'\\b');}else{is_class=false;}
for(var ii=0;ii<tag_candidates.length;ii++){var tag_candidate=tag_candidates[ii];if(!tag_candidate){continue;}
if(is_class){if(!class_regexp.test(tag_candidate.className)){delete tag_candidates[ii];}
continue;}else{var class_selector=sub_selector.slice(1,sub_selector.length-1);if(class_selector.indexOf('=')==-1){if(tag_candidate.getAttribute(class_selector)===null){delete tag_candidates[ii];continue;}}else{var parts=class_selector.split('=');var attr=parts[0];var value=parts[1];value=value.slice(1,value.length-1);if(tag_candidate.getAttribute(attr)!=value){delete tag_candidates[ii];continue;}}}}}
for(var ii=0;ii<tag_candidates.length;ii++){if(tag_candidates[ii]){new_candidates.push(tag_candidates[ii]);}}}
candidates=new_candidates;}
var list=null;if(!no_augment){var augment=DOM._getNodeAugment();for(var ii=0;ii<candidates.length;ii++){augment(candidates[ii]);}
list=new NodeList();list.push.apply(list,$A(candidates));}else{list=candidates;}
return list;},getBoxWidth:function(obj){var pL=parseInt(CSS.getStyle(obj,'paddingLeft'),10),pR=parseInt(CSS.getStyle(obj,'paddingRight'),10),bL=parseInt(CSS.getStyle(obj,'borderLeftWidth'),10),bR=parseInt(CSS.getStyle(obj,'borderRightWidth'),10);return obj.offsetWidth-(pL?pL:0)-(pR?pR:0)-(bL?bL:0)-
(bR?bR:0);},getBoxHeight:function(obj){var pT=parseInt(CSS.getStyle(obj,'paddingTop'),10),pB=parseInt(CSS.getStyle(obj,'paddingBottom'),10),bT=parseInt(CSS.getStyle(obj,'borderTopWidth'),10),bW=parseInt(CSS.getStyle(obj,'borderBottomWidth'),10);return obj.offsetHeight-(pT?pT:0)-(pB?pB:0)-(bT?bT:0)-
(bW?bW:0);},setText:function(el,text){if(ua.firefox()){el.textContent=text;}else{el.innerText=text;}},getText:function(el){if(!el){return'';}else if(el.nodeType==DOM.NODE_TYPES.TEXT){return el.data;}else{return ua.firefox()?el.textContent:el.innerText;}},_getSelectionPrivate:function(onlyTestForSupport){var result=onlyTestForSupport?false:'';if(document.selection&&document.selection.createRange&&document.selection.createRange.text){result=onlyTestForSupport?true:document.selection.createRange().text;}
else if(document.getSelection){result=onlyTestForSupport?true:document.getSelection();}
else if(window.getSelection){result=onlyTestForSupport?true:window.getSelection();}
return result;},getSelectionSupported:function(){return DOM._getSelectionPrivate(true);},getSelection:function(){return DOM._getSelectionPrivate(false);},create:function(element,attributes,children,no_augment){element=document.createElement(element);if(attributes){attributes=copy_properties({},attributes);if(attributes.style){copy_properties(element.style,attributes.style);delete attributes.style;}
for(var k in attributes){if(k.toLowerCase().indexOf('on')==0){Event.listen(element,k.substr(2),attributes[k]);delete attributes[k];}}
copy_properties(element,attributes);}
if(children!=undefined){DOM.setContent(element,children);}
var aug=no_augment?identity:DOM._getNodeAugment();return aug(element);},setID:function(element,id){element.id=id;},prependContent:function(parent,content){if(!DOM.isNode(parent)){throw new Error('DOM.prependContent: reference element is not a node');}
var append_fn=function(fragment){if(parent.firstChild){parent.insertBefore(fragment,parent.firstChild);}else{parent.appendChild(fragment);}};return DOM._addContent(content,append_fn,parent);},insertAfter:function(reference_element,content){if(!DOM.isNode(reference_element)||!reference_element.parentNode){throw new Error('DOM.insertAfter: reference element is not a node');}
var append_fn=function(fragment){if(reference_element.nextSibling){reference_element.parentNode.insertBefore(fragment,reference_element.nextSibling);}else{reference_element.parentNode.appendChild(fragment);}};return DOM._addContent(content,append_fn,reference_element.parentNode);},insertBefore:function(content,reference_element){if(!DOM.isNode(reference_element)||!reference_element.parentNode){throw new Error('DOM.insertBefore: reference element is not a node or '+'does not have a parent.');}
var append_fn=function(fragment){reference_element.parentNode.insertBefore(fragment,reference_element);};return DOM._addContent(content,append_fn,reference_element.parentNode);},setContent:function(el,content){if(!DOM.isNode(el)){throw new Error('DOM.setContent: reference element is not a node');}
DOM.empty(el);return DOM.appendContent(el,content,el);},appendContent:function(reference_element,content){if(!DOM.isNode(reference_element)){throw new Error('DOM.appendContent: reference element is not a node');}
var append_fn=function(fragment){reference_element.appendChild(fragment);};return DOM._addContent(content,append_fn,reference_element);},replace:function(reference_element,content){if(!DOM.isNode(reference_element)||!reference_element.parentNode){throw new Error('DOM.replace: reference element must be a node with a'+' parent');}
var append_fn=function(fragment){reference_element.parentNode.replaceChild(fragment,reference_element);};DOM._addContent(content,append_fn,reference_element.parentNode);},_gettingCaretPosition:false,getCaretPosition:function(element){element=$(element);if(!DOM.isNode(element,['input','textarea'])){return{start:undefined,end:undefined};}
if(!document.selection){return{start:element.selectionStart,end:element.selectionEnd};}
if(DOM.isNode(element,'input')){var range=document.selection.createRange();return{start:-range.moveStart('character',-element.value.length),end:-range.moveEnd('character',-element.value.length)};}else{if(!DOM._gettingCaretPosition){DOM._gettingCaretPosition=true;element.focus();DOM._gettingCaretPosition=false;}
var range=document.selection.createRange();var range2=range.duplicate();range2.moveToElementText(element);range2.setEndPoint('StartToEnd',range);var end=element.value.length-range2.text.length;range2.setEndPoint('StartToStart',range);return{start:element.value.length-range2.text.length,end:end};}},setCaretPosition:function(obj,start,end){obj=$(obj);if(document.selection){if(obj.tagName=='TEXTAREA'){var i=obj.value.indexOf("\r",0);while(i!=-1&&i<end){end--;if(i<start){start--;}
i=obj.value.indexOf("\r",i+1);}}
var range=obj.createTextRange();range.collapse(true);range.moveStart('character',start);if(end!=undefined){range.moveEnd('character',end-start);}
range.select();}else{obj.selectionStart=start;var sel_end=end==undefined?start:end;obj.selectionEnd=Math.min(sel_end,obj.value.length);obj.focus();}},remove:function(element){element=$(element,true);if(element.parentNode){element.parentNode.removeChild(element);if(ua.ie()<8){try{element.outerHTML='';}catch(ignored){}}}},empty:function(element){element=$(element,true);while(element.firstChild){DOM.remove(element.firstChild);}},contains:function(outer_obj,inner_obj){outer_obj=ge(outer_obj,true);inner_obj=ge(inner_obj,true);if(!outer_obj||!inner_obj){return false;}else if(outer_obj===inner_obj){return true;}else if(DOM.isNode(outer_obj,'#text')){return false;}else if(DOM.isNode(inner_obj,'#text')){return DOM.contains(outer_obj,inner_obj.parentNode);}else if(outer_obj.contains){return outer_obj.contains(inner_obj);}else if(outer_obj.compareDocumentPosition){return!!(outer_obj.compareDocumentPosition(inner_obj)&16);}else{return false;}},getRootElement:function(){var elem=null;if(window.Quickling&&Quickling.isActive()){elem=ge('content');}
return elem||DOMScroll.getScrollRoot();},isNode:function(o,of_type){if(typeof(Node)=='undefined'){Node=null;}
try{if(!o||!((Node!=undefined&&o instanceof Node)||o.nodeName)){return false;}}catch(ignored){return false;}
if(typeof(of_type)!=='undefined'){of_type=arrayize(of_type).map(function(i){return(i+'').toUpperCase()});var name,type;try{name=new String(o.nodeName).toUpperCase();type=o.nodeType;}catch(ignored){return false;}
for(var ii=0;ii<of_type.length;ii++){try{if(name==of_type[ii]||type==of_type[ii]){return true;}}catch(ignored){}}
return false;}
return true;},NODE_TYPES:{ELEMENT:1,ATTRIBUTE:2,TEXT:3,CDATA_SECTION:4,ENTITY_REFERENCE:5,ENTITY:6,PROCESSING_INSTRUCTION:7,COMMENT:8,DOCUMENT:9,DOCUMENT_TYPE:10,DOCUMENT_FRAGMENT:11,NOTATION_NODE:12},_addContent:function(content,append_fn,target_element){var item,elements=[],callbacks=[];var fragment=document.createDocumentFragment();if(!(content instanceof Array)){content=[content];}
for(var ii=0;ii<content.length;ii++){item=content[ii];if(item instanceof HTML){callbacks.push(item.getAction());var new_nodes=item.getNodes(),cloned_item;for(var jj=0;jj<new_nodes.length;jj++){cloned_item=(ua.safari()||(ua.ie()&&item.hasOptionElements()))?new_nodes[jj]:new_nodes[jj].cloneNode(true);elements.push(cloned_item);fragment.appendChild(cloned_item);}}else if(is_scalar(item)){var text=document.createTextNode(item);elements.push(text);fragment.appendChild(text);}else if(DOM.isNode(item)){elements.push(item);fragment.appendChild(item);}else if(item instanceof Array){Util.error('DOM._addContent: Nested arrays not supported');}else if(item!==null){Util.error('DOM._addContent: No way to set content %q.',item);}}
append_fn(fragment);for(var ii=0;ii<callbacks.length;ii++){callbacks[ii]();}
if(0<elements.length&&DOM.contains(document.documentElement,target_element)){Arbiter.inform('DOM.contentJustAdded',elements);Arbiter.inform.bind(Arbiter,'DOM.contentAdded',elements).defer();}
return elements;},_nodeAugment:null,_getNodeAugment:function(){if(!DOM._nodeAugment){var aug=new Augment('NodeAugment',function(){var bind1st=function(fn){return function(){return fn.apply(null,[this].concat($A(arguments)));}}
return{toString:function(){return'[Node]';},setContent:bind1st(DOM.setContent),prependContent:bind1st(DOM.prependContent),appendContent:bind1st(DOM.appendContent),replace:bind1st(DOM.replace),remove:bind1st(DOM.remove),empty:bind1st(DOM.empty),scry:bind1st(DOM.scry),find:bind1st(DOM.find),listen:bind1st(Event.listen),addClass:bind1st(CSS.addClass),removeClass:bind1st(CSS.removeClass),hasClass:bind1st(CSS.hasClass),toggleClass:bind1st(CSS.toggleClass),getStyle:bind1st(CSS.getStyle),setStyle:bind1st(CSS.setStyle)}});DOM._nodeAugment=aug.augmentObject.bind(aug);}
return DOM._nodeAugment;}};function NodeList(length){if(!NodeList._augmented){var augment=NodeList._getAugment();augment.augmentObject(NodeList.prototype);NodeList._augmented=true;}
List.call(this,length);}
NodeList.prototype=new List();copy_properties(NodeList.prototype,{toString:function(){return'[NodeList]';}});copy_properties(NodeList,{_augmented:false,_getAugment:function(){return new Augment('NodeListAugment',function(){var binditerator=function(iterator,fn){return function(){var args=$A(arguments);return this[iterator](function(value,idx,list){return fn.apply(null,[value].concat(args));});}}
var selfreduce=function(fn){return function(){fn.apply(this,$A(arguments));return this;}};var mergereduce=function(type,fn){return function(){var unmerged=fn.apply(this,$A(arguments));var result=new type();for(var ii=0;ii<unmerged.length;ii++){result.push.apply(result,$A(unmerged[ii]));}
return result;}}
return{scry:mergereduce(NodeList,binditerator('map',DOM.scry)),addClass:selfreduce(binditerator('map',CSS.addClass)),removeClass:selfreduce(binditerator('map',CSS.removeClass)),hasClass:binditerator('every',CSS.hasClass),toggleClass:selfreduce(binditerator('map',CSS.toggleClass)),getStyle:binditerator('map',CSS.getStyle),setStyle:selfreduce(binditerator('map',CSS.setStyle))};});}});function $N(element,attributes,content){if(typeof attributes!='object'||DOM.isNode(attributes)||attributes instanceof Array||attributes instanceof HTML){content=attributes;attributes=null;}
return DOM.create(element,attributes,content);}
var ge=DOM.tryElement;var $$=function _$$(rules){if(Util.isDevelopmentEnvironment()&&rules&&!/^[a-zA-Z1-6]+$/.test(rules)&&-1==rules.indexOf('#')){Util.warn('$$() has been called with `%s\' as a selector. You should not use only '+'class or attribute selectors from the document element, because these '+'can not be efficiently queried. Call DOM.find() or DOM.scry() with a '+'root element, or look at DOM.scry() for more information.',rules);}
return DOM.scry.apply(null,[document].concat($A(arguments)));}
var $=DOM.getElement;

function DOMControl(root){copy_properties(this,{root:root&&$(root),updating:false});if(root){root.getControl=identity.bind(null,this);}}
copy_properties(DOMControl.prototype,{getRoot:function(){return this.root;},beginUpdate:function(){if(this.updating){return false;}
this.updating=true;return true;},endUpdate:function(){this.updating=false;},update:function(e){if(!this.beginUpdate()){return this;}
this.onupdate(e);this.endUpdate();}});

function TextInputControl(textinput){this.parent.construct(this,textinput);copy_properties(this,{placeholderText:null,maxLength:this.getRoot().maxLength||null,radio:null,focused:false,interval:null,nativePlaceholder:false});var r=this.getRoot();if((String(r.type).toLowerCase()=='search')&&ua.safari()){this.nativePlaceholder=true;this.setPlaceholderText(r.getAttribute('placeholder'));}
addEventBase(r,'focus',this.onfocus.bind(this));addEventBase(r,'blur',this.onblur.bind(this));var up=this.update.bind(this);Event.listen(r,'keydown',up);Event.listen(r,'keyup',up);Event.listen(r,'keypress',up);this.setFocused(false);}
TextInputControl.extend('DOMControl');copy_properties(TextInputControl.prototype,{associateWithRadioButton:function(element){this.radio=element&&$(element);return this;},setMaxLength:function(maxlength){this.maxLength=maxlength;this.getRoot().maxLength=this.maxLength||null;return this;},getValue:function(){if(!this.focused&&this.getRoot().value==this.placeholderText){return null;}
return this.getRoot().value;},isEmpty:function(){var v=this.getValue();return(v===null||v=='');},setValue:function(value){this.getRoot().value=value;this.update();return this;},clear:function(){return this.setValue('');},isFocused:function(){return this.focused;},setFocused:function(focused){var empty=this.isEmpty();this.focused=focused;if(this.placeholderText&&!this.nativePlaceholder){var r=this.getRoot();var v=r.value;if(this.focused){CSS.removeClass(r,'DOMControl_placeholder');if(empty){this.clear();}}else if(empty){CSS.addClass(r,'DOMControl_placeholder');this.setValue(this.placeholderText);}}
this.update();return this;},setPlaceholderText:function(text){this.placeholderText=text;if(this.nativePlaceholder){this.getRoot().setAttribute('placeholder',text);}
return this.setFocused(this.isFocused());},getPlaceholderText:function(){return this.placeholderText;},onupdate:function(){if(this.radio){if(this.focused){this.radio.checked=true;}}
var root=this.getRoot();if(this.maxLength>0){if(root.value.length>this.maxLength){var value=root.value;var remove_length=value.length-this.maxLength;var pos_pair=DOM.getCaretPosition(root);var remove_behind_pos=pos_pair.end||value.length;root.value=value.substring(0,remove_behind_pos-remove_length)+
value.substring(remove_behind_pos);if(typeof pos_pair.start!='undefined'){DOM.setCaretPosition(root,pos_pair.start,Math.max(pos_pair.start,pos_pair.end-remove_length));}}}
this.setFocused(this.focused);},onfocus:function(){this.setFocused(true);if(this.interval){clearInterval(this.interval);}
this.interval=setInterval(this.update.bind(this),150);return this;},onblur:function(){this.setFocused(false);if(this.interval){this.interval=clearInterval(this.interval);}
return this;}});function placeholderSetup(id){if(!ge(id)){Util.warn('Setting up a placeholder for an element which does not exist: %q.',id);return;}
if(!$(id).getAttribute('placeholder')){Util.warn('Setting up a placeholder for an element with no placeholder text: %q.',id);return;}
return new TextInputControl($(id)).setPlaceholderText($(id).getAttribute('placeholder'));}

function TextAreaControl(textarea){copy_properties(this,{autogrow:false,shadow:null,originalHeight:null,metricsValue:null});this.parent.construct(this,textarea);};TextAreaControl.extend('TextInputControl');copy_properties(TextAreaControl.prototype,{setAutogrow:function(autogrow){this.autogrow=autogrow;this.refreshShadow();CSS.addClass(this.getRoot(),'DOMControl_autogrow');return this;},onupdate:function(){this.parent.onupdate();var r=this.getRoot();if(this.autogrow&&r.value!=this.metricsValue){this.metricsValue=r.value;if(CSS.getStyle(r,'fontSize')==""){return false;}
copy_properties(this.shadow.style,{fontSize:parseInt(CSS.getStyle(r,'fontSize'),10)+'px',fontFamily:CSS.getStyle(r,'fontFamily'),width:(Vector2.getElementDimensions(r).x-8)+'px'});DOM.setContent(this.shadow,HTML(htmlize(r.value)));if(this.isEmpty()&&this.originalHeight){r.style.height=this.originalHeight+'px';}else{r.style.height=Math.max(this.originalHeight,Vector2.getElementDimensions(this.shadow).y+15)+'px';}}},refreshShadow:function(){if(this.autogrow){this.shadow=$N('div',{className:'DOMControl_shadow'});DOM.getRootElement().appendChild(this.shadow);var r=this.getRoot();this.originalHeight=parseInt(CSS.getStyle(r,'height'))||Vector2.getElementDimensions(this.getRoot()).y;}else{if(this.shadow){DOM.remove(this.shadow);}
this.shadow=null;}}});function autogrow_textarea(element){element=$(element);if(!element._hascontrol){element._hascontrol=true;new TextAreaControl(element).setAutogrow(true);}}

var CSS={hasClass:function(element,className){element=$(element);if(element&&className&&element.className){return new RegExp('(?: |^)'+trim(className)+'(?: |$)').test(element.className);}
return false;},addClass:function(element,className){element=$(element);if(element&&className){if(!CSS.hasClass(element,className)){className=trim(className);if(element.className){element.className+=' '+className;}else{element.className=className;}}}
return this;},removeClass:function(element,className){element=$(element);if(element&&className&&element.className){className=trim(className);element.className=element.className.split(' ').filter(function(ii){if(ii!=className){return true;}}).join(' ');}
return this;},conditionClass:function(element,className,shouldShow){element=$(element);if(shouldShow){CSS.addClass(element,className);}else{CSS.removeClass(element,className);}},chooseClass:function(element,expression,trueClass,falseClass){CSS.conditionClass(element,trueClass,expression);CSS.conditionClass(element,falseClass,!expression);},setClass:function(element,className){element=$(element,true);element.className=className;return this;},toggleClass:function(element,className){element=$(element);if(CSS.hasClass(element,className)){return CSS.removeClass(element,className);}else{return CSS.addClass(element,className);}},setStyle:function(element,name,value){element.style[name]=value;return element;},getStyle:function(element,property){element=$(element);function hyphenate(property){return property.replace(/[A-Z]/g,function(match){return'-'+match.toLowerCase();});}
if(window.getComputedStyle){return window.getComputedStyle(element,null).getPropertyValue(hyphenate(property));}
if(document.defaultView&&document.defaultView.getComputedStyle){var computedStyle=document.defaultView.getComputedStyle(element,null);if(computedStyle)
return computedStyle.getPropertyValue(hyphenate(property));if(property=="display")
return"none";Util.error("Can't retrieve requested style %q due to a bug in Safari",property);}
if(element.currentStyle){return element.currentStyle[property];}
return element.style[property];},setOpacity:function(element,opacity){element=$(element);var opaque=(opacity==1);try{element.style.opacity=(opaque?'':''+opacity);}catch(ignored){}
try{element.style.filter=(opaque?'':'alpha(opacity='+(opacity*100)+')');}catch(ignored){}},getOpacity:function(element){element=$(element);var opacity=CSS.getStyle(element,'filter');var val=null;if(opacity&&(val=/(\d+(?:\.\d+)?)/.exec(opacity))){return parseFloat(val.pop())/100;}else if(opacity=CSS.getStyle(element,'opacity')){return parseFloat(opacity);}else{return 1.0;}},Cursor:{kGrabbable:'grabbable',kGrabbing:'grabbing',kEditable:'editable',set:function(element,name){element=$(element);element=element||document.body;switch(name){case CSS.Cursor.kEditable:name='text';break;case CSS.Cursor.kGrabbable:if(ua.firefox()){name='-moz-grab';}else{name='move';}
break;case CSS.Cursor.kGrabbing:if(ua.firefox()){name='-moz-grabbing';}else{name='move';}
break;}
element.style.cursor=name;}}};

function _ElementController(tag_name,event_name){copy_properties(this,{_controlled_tag_name:tag_name,_controlled_event_name:event_name,_handlers:[],_fallback_handlers:[]});var controller=this;this._onevent=function(e){return controller._handle.bind(controller)(this,$E(e));};}
copy_properties(_ElementController.prototype,{ALL:1,ALL_TARGETS:2,ALL_KEY_MODIFIERS:4,_ALL_UNUSED_1:8,_ALL_UNUSED_2:16,registerHandler:function(callback,filters,prepend){this._registerHandler(this._handlers,callback,filters,prepend);},registerFallbackHandler:function(callback,filters,prepend){this._registerHandler(this._fallback_handlers,callback,filters,prepend);},bindAll:function(root_element){if(!root_element||root_element.nodeType!=DOM.NODE_TYPES.ELEMENT){return;}
var tabconsole=ge('tabconsole');if(tabconsole){if((root_element.id&&root_element.id.substring(0,8)=='cacheobs')||DOM.contains(tabconsole,root_element)){return;}}
var should_insert=ua.firefox()&&!DOM.contains(document.documentElement,root_element);if(should_insert){var invisible_div=ge('an_invisible_div');if(!invisible_div){invisible_div=DOM.create('div',{id:'an_invisible_div'});invisible_div.style.display='none';DOMScroll.getScrollRoot().appendChild(invisible_div);}
invisible_div.appendChild(root_element);}
var element,event_name=this._controlled_event_name.substring(2),onevent=this._onevent,elements=root_element.getElementsByTagName(this._controlled_tag_name);try{for(var i=elements.length-1;i>=0;--i){element=elements[i];Event.listen(element,event_name,onevent,Event.Priority.LINK_CONTROLLER);}
if(DOM.isNode(root_element,this._controlled_tag_name)){Event.listen(root_element,event_name,onevent,Event.Priority.LINK_CONTROLLER);}}catch(ex){Util.error('Uncaught exception while reading %s handler for element with contents %h: %s',event_name,element.innerHTML,ex);}
if(should_insert){invisible_div.removeChild(root_element);}},_handle:function(element,event){var handlers=this.getHandlers();for(var i=0;i<handlers.length;++i){var callback=handlers[i].callback;var filters=handlers[i].filters;try{if(this._filter(filters,element,event)){var abort=callback(element,event);if(abort===false){return Event.kill(event);}}}catch(exception){Util.error('Uncaught exception in %s handler: %x',this._controlled_event_name,exception);}}},getHandlers:function(){return this._handlers.concat(this._fallback_handlers);},_init:function(){if(this._initialized){return;}
this._initialized=true;onloadRegister(function(){this.bindAll(document.body);Arbiter.subscribe('DOM.contentAdded',function(type,data){for(var ii=0;ii<data.length;ii++){this.bindAll(data[ii]);}}.bind(this),Arbiter.SUBSCRIBE_NEW);}.bind(this));},_registerHandler:function(handler_array,callback,filters,prepend){this._init();var args={callback:callback,filters:filters||0};if(prepend){handler_array.unshift(args);}else{handler_array.push(args);}},_filter:function(filters,element,event){if(filters&this.ALL){return true;}
if(!(filters&this.ALL_TARGETS)){if(element.target){return false;}}
if(!(filters&this.ALL_KEY_MODIFIERS)){if(event&&$E(event).getModifiers().any){return false;}}
return true;}});var LinkController=new _ElementController('a','onclick');copy_properties(LinkController,{ALL_PROTOCOLS:LinkController._ALL_UNUSED_1,ALL_BUTTONS:LinkController._ALL_UNUSED_2,_filter:function(filters,element,event){if(!_ElementController.prototype._filter.apply(this,arguments)){return false;}
var href=element.getAttribute('href');if(!href||href=='#'){return false;}
if(!(filters&this.ALL_PROTOCOLS)){if(!LinkController.usesWebProtocol(element)){return false;}}
if(!(filters&this.ALL_BUTTONS)){if(ua.safari()>=525&&event&&event.which!=1){return false;}}
return true;},getProtocol:function(link){var href,protocol;return(href=link.getAttribute('href'))&&(protocol=href.match(/^(\w+):/))&&protocol[1].toLowerCase();},usesWebProtocol:function(link){var protocol=LinkController.getProtocol(link);return!protocol||protocol=='http'||protocol=='https';}});var FormController=new _ElementController('form','onsubmit');

function AsyncSignal(uri,data){this.data=data||{};this.uri=uri;this.handler=null;}
AsyncSignal.prototype.setHandler=function(h){this.handler=h;return this;}
AsyncSignal.prototype.send=function(){var h=this.handler,d=this.data,u=this.uri,s=[],i=new Image(),a=document.getElementById('post_form_id');d.asyncSignal=Math.floor(Math.random()*10000)+1;if(a){d.post_form_id=a.value;}
for(var k in d){s.push(encodeURIComponent(k)+'='+encodeURIComponent(d[k]));}
if(u.indexOf('?')==-1){u+='?';}
u+=s.join('&');if(h){i.onload=i.onerror=(function(i,h){return function(){h((i.height==1));}})(i,h);}
i.src=u;return this;}

function setCookie(cookieName,cookieValue,nMilliSecs){if(nMilliSecs){var thisMoment=new Date();var expire=new Date();expire.setTime(thisMoment.getTime()+nMilliSecs);}
document.cookie=cookieName+"="+encodeURIComponent(cookieValue)+"; "+
(nMilliSecs?"expires="+expire.toGMTString()+"; ":"")+"path=/; domain=."+
window.location.hostname.replace(/^.*(facebook\..*)$/i,'$1');}
function clearCookie(cookieName){document.cookie=cookieName+"=; expires=Mon, 26 Jul 1997 05:00:00 GMT; "+"path=/; domain=."+
window.location.hostname.replace(/^.*(facebook\..*)$/i,'$1');}
function getCookie(name){var nameEQ=name+"=";var ca=document.cookie.split(';');for(i=0;i<ca.length;i++){var c=ca[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(nameEQ)==0){return decodeURIComponent(c.substring(nameEQ.length,c.length))}}
return null;}
function transferCookieToComTld(cookieName,handler){handler=handler||bagofholding;var cookieNames;if(cookieName instanceof Array){cookieNames=cookieName;}else{cookieNames=[cookieName];}
var data={};for(var i=0;i<cookieNames.length;i++){var value=getCookie(cookieNames[i]);if(value){data[cookieNames[i]]=value;}}
var domain=window.location.hostname.replace(/facebook.*/,'facebook.com');var uri='http://'+domain+'/common/cookie_transfer.php';new AsyncSignal(uri,data).setHandler(handler).send();}

window.onloadRegister=function(handler){window.loaded?_runHook(handler):_addHook('onloadhooks',handler);};function onafterloadRegister(handler){window.loaded?_runHook(handler):_addHook('onafterloadhooks',handler);}
function _include_quickling_events_default(){return!window.loading_page_chrome;}
function onbeforeunloadRegister(handler,include_quickling_events){if(include_quickling_events===undefined){include_quickling_events=_include_quickling_events_default();}
if(include_quickling_events){_addHook('onbeforeleavehooks',handler);}else{_addHook('onbeforeunloadhooks',handler);}}
function onunloadRegister(handler,include_quickling_events){if(include_quickling_events===undefined){include_quickling_events=_include_quickling_events_default();}
if(include_quickling_events){_addHook('onleavehooks',handler);}else{_addHook('onunloadhooks',handler);}}
function _readyToLoad(){return!window.bootloader_pending&&(!window.Bootloader||Bootloader.initialResourcesReady())&&window.loading_begun;}
function onResourceReady(){if(_readyToLoad()){_onloadHook();_runHooks('onafterloadhooks');}}
function _onloadHook(){window.loading_begun=true;if(_readyToLoad()){!window.loaded&&window.Env&&(Env.t_willonloadhooks=(new Date()).getTime());_runHooks('onloadhooks');!window.loaded&&window.Env&&(Env.t_doneonloadhooks=(new Date()).getTime());window.loaded=true;}}
function _runHook(handler){try{handler();}catch(ex){Util.error('Uncaught exception in hook (run after page load): %x',ex);}}
function _runHooks(hooks){var isbeforeunload=hooks=='onbeforeleavehooks'||hooks=='onbeforeunloadhooks';var warn=null;do{var h=window[hooks];if(!isbeforeunload){window[hooks]=null;}
if(!h){break;}
for(var ii=0;ii<h.length;ii++){try{if(isbeforeunload){warn=warn||h[ii]();}else{h[ii]();}}catch(ex){Util.error('Uncaught exception in hook (%q) %q: %x',hooks,h[ii],ex);}}
if(isbeforeunload){break;}}while(window[hooks]);if(isbeforeunload&&warn){return warn;}}
function _addHook(hooks,handler){(window[hooks]?window[hooks]:(window[hooks]=[])).push(handler);}
function removeHook(hooks){window[hooks]=[];}
function _bootstrapEventHandlers(){if(document.addEventListener){if(ua.safari()){var timeout=setInterval(function(){if(/loaded|complete/.test(document.readyState)){(window.Env&&(Env.t_domcontent=(new Date()).getTime()));_onloadHook();clearTimeout(timeout);}},3);}else{document.addEventListener("DOMContentLoaded",function(){(window.Env&&(Env.t_domcontent=(new Date()).getTime()));_onloadHook();},true);}}else{var src='javascript:void(0)';if(window.location.protocol=='https:'){src='//:';}
document.write('<script onreadystatechange="if (this.readyState==\'complete\') {'+'(window.Env&&(Env.t_domcontent=(new Date()).getTime()));'+'this.parentNode.removeChild(this);_onloadHook();}" defer="defer" '+'src="'+src+'"><\/script\>');}
window.onload=chain(window.onload,function(){(window.Env&&(Env.t_layout=(new Date()).getTime()));var force_layout=document&&document.body&&document.body.offsetWidth;(window.Env&&(Env.t_onload=(new Date()).getTime()));_onloadHook();if(_readyToLoad()){_runHooks('onafterloadhooks');}});window.onbeforeunload=function(){var warn=_runHooks('onbeforeleavehooks')||_runHooks('onbeforeunloadhooks');if(!warn){window.loaded=false;}
return warn;};window.onunload=chain(window.onunload,function(){_runHooks('onleavehooks');_runHooks('onunloadhooks');});}
function keep_window_set_as_loaded(){if(window.loaded==false){window.loaded=true;_runHooks('onloadhooks');_runHooks('onafterloadhooks');}}

function gen_unique(){return++gen_unique._counter;}
gen_unique._counter=0;function create_hidden_input(name,value){return $N('input',{name:name,id:name,value:value,type:'hidden'});}
var KEYS={BACKSPACE:8,TAB:9,RETURN:13,ESC:27,SPACE:32,LEFT:37,UP:38,RIGHT:39,DOWN:40,DELETE:46};var KeyCodes={Up:63232,Down:63233,Left:63234,Right:63235};function getTableRowShownDisplayProperty(){if(ua.ie()<8){return'inline';}else{return'table-row';}}
function showTableRow()
{for(var i=0;i<arguments.length;i++){var element=ge(arguments[i]);if(element&&element.style)element.style.display=getTableRowShownDisplayProperty();}
return false;}
function getParentRow(el){el=ge(el);while(el.tagName&&el.tagName!="TR"){el=el.parentNode;}
return el;}
function adjustImage(obj){var block=obj.parentNode;while(CSS.getStyle(block,'display')!='block'&&block.parentNode){block=block.parentNode;}
var width=block.offsetWidth;if(obj.offsetWidth>width){try{if(ua.ie()<8){var img_div=document.createElement('div');img_div.style.filter='progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+obj.src.replace('"','%22')+'", sizingMethod="scale")';img_div.style.width=width+'px';img_div.style.height=Math.floor(((width/obj.offsetWidth)*obj.offsetHeight))+'px';if(obj.parentNode.tagName=='A'){img_div.style.cursor='pointer';}
obj.parentNode.insertBefore(img_div,obj);obj.parentNode.removeChild(obj);}else{throw 1;}}catch(e){obj.style.width=width+'px';}}
CSS.removeClass(obj,'img_loading');}
function imageConstrainSize(src,maxX,maxY,placeholderid){var image=new Image();image.onload=function(){if(image.width>0&&image.height>0){var width=image.width;var height=image.height;if(width>maxX||height>maxY){var desired_ratio=maxY/maxX;var actual_ratio=height/width;if(actual_ratio>desired_ratio){width=width*(maxY/height);height=maxY;}else{height=height*(maxX/width);width=maxX;}}
var placeholder=ge(placeholderid);if(placeholder){var newimage=document.createElement('img');newimage.src=src;newimage.width=width;newimage.height=height;placeholder.parentNode.insertBefore(newimage,placeholder);placeholder.parentNode.removeChild(placeholder);}}}
image.src=src;}
function require_password_confirmation(onsuccess,oncancel){if((!getCookie('sid')||getCookie('sid')=='0')||getCookie('pk')){onsuccess();return;}
require_password_confirmation.onsuccess=onsuccess;require_password_confirmation.oncancel=oncancel;(new pop_dialog()).show_ajax_dialog('/ajax/password_check_dialog.php');}
function search_validate(search_input_id){var search_input=$(search_input_id);if(search_input.value!=""&&search_input.value!=search_input.getAttribute('placeholder')){return true;}else{search_input.focus();return false;}}
function abTest(data,inline)
{AsyncRequest.pingURI('/ajax/abtest.php',{data:data,"post_form_id":null},true);if(!inline){return true;}}
function ac(metadata)
{new AsyncSignal('/ajax/ac.php',{'meta':metadata}).send();return true;}
function alc(metadata)
{AsyncRequest.pingURI('/ajax/alc.php',{'meta':metadata},true);return true;}
function scribe_log(category,message){AsyncRequest.pingURI('/ajax/scribe_log.php',{'category':category,'message':message,'post_form_id':null},true);}
function image_has_loaded(obj){try{if((obj.mimeType!=null&&obj.complete&&obj.mimeType!='')||(obj.naturalHeight!=null&&obj.complete&&obj.naturalHeight!=0)){return true;}else if(ua.safari()<3){var new_image=new Image();new_image.src=obj.src;if(new_image.complete==true){return true;}
delete new_image;}}catch(exception){return true;}}
function image_has_failed(obj){if((obj.complete==null&&obj.width==20&&obj.height==20)||(obj.mimeType!=null&&obj.complete&&obj.mimeType=='')||(obj.naturalHeight!=null&&obj.complete&&obj.naturalHeight==0)){return true;}}
function show_search_profile(user_id){var async=new AsyncRequest().setURI('/ajax/search_profile.php').setData({id:user_id}).setMethod('GET').setReadOnly(true);new Dialog().setAsync(async).setButtons(Dialog.CLOSE).setContentWidth(490).show();}
function _search_profile_link_handler(link){var uri=new URI(link.href);if(uri.getPath()=='/s.php'){var query=uri.getQueryData();if(query.k==100000080){show_search_profile(query.id);return false;}}}
onloadRegister(function(){LinkController.registerHandler(_search_profile_link_handler);});function warn_if_unsaved(form_id){var form=ge(form_id);if(!form){Util.error("warn_if_unsaved couldn't find form in order to save its "
+"original state.  This is probably because you called "
+"render_start_form_with_unsaved_warning to render a form, "
+"but then didn't echo it into page.  To get around this, you "
+"can call render_start_form, and then call warn_if_unsaved "
+"yourself once you've caused the form to appear.");return;}
if(!_unsaved_forms_to_check_for){_unsaved_forms_to_check_for={};LinkController.registerHandler(_check_for_unsaved_forms);}
form.original_state=serialize_form(form);_unsaved_forms_to_check_for[form_id]=true;}
function _check_for_unsaved_forms(link){for(var form_id in _unsaved_forms_to_check_for){var form=ge(form_id);if(form&&form.original_state&&!are_equal(form.original_state,serialize_form(form))){var href=link.href;var submit=_find_first_submit_button(form);var buttons=[];if(submit){buttons.push({name:'save',label:_tx("Save"),handler:function(){submit.click();}});}
buttons.push({name:'dont_save',label:_tx("Don't Save"),className:'inputaux',handler:function(){window.location.href=href;}});buttons.push(Dialog.CANCEL);new Dialog().setTitle(_tx("Unsaved Changes")).setBody(_tx("Some of your changes have not been saved.  Would you like to save your changes now?")).setButtons(buttons).setModal().show();return false;}}}
function _find_first_submit_button(root_element){var inputs=root_element.getElementsByTagName('input');for(var i=0;i<inputs.length;++i){if(inputs[i].type.toUpperCase()=='SUBMIT'){return inputs[i];}}
return null;}
_unsaved_forms_to_check_for=undefined;function textLimit(ta,count){var text=ge(ta);if(text.value.length>count){text.value=text.value.substring(0,count);if(arguments.length>2){$(arguments[2]).style.display='block';}}}
function textLimitStrict(text_id,limit,message_id,count_id,submit_id){var text=ge(text_id);if(text){var len=text.value.length;var diff=len-limit;if(diff>0){if(diff>25000){text.value=text.value.substring(0,limit+25000);diff=25000;}
$(message_id).style.display='block';$(count_id).innerHTML=diff;$(submit_id).disabled=true;}else if(len==0){$(message_id).style.display='none';$(submit_id).disabled=true;$(count_id).innerHTML=1;}else{if($(count_id).innerHTML!=0){$(count_id).innerHTML=0;$(message_id).style.display='none';$(submit_id).disabled=false;}}}}
function city_selector_onfound(input,obj){input.value=obj?obj.i:-1;}
function city_selector_onselect(success){if(window[success]){window[success]();}}
_bootstrapEventHandlers();if(navigator&&navigator.userAgent&&document.domain.toLowerCase().match(/(^|\.)facebook\..*/)&&!(parseInt((/Gecko\/([0-9]+)/.exec(navigator.userAgent)||[]).pop())<=20060508)){document.domain=window.location.hostname.replace(/^.*(facebook\..*)$/i,'$1');}

function KeyEventController(){copy_properties(this,{handlers:{}});document.onkeyup=this.onkeyevent.bind(this,'onkeyup');document.onkeydown=this.onkeyevent.bind(this,'onkeydown');document.onkeypress=this.onkeyevent.bind(this,'onkeypress');}
copy_properties(KeyEventController,{instance:null,getInstance:function(){return KeyEventController.instance||(KeyEventController.instance=new KeyEventController());},defaultFilter:function(event,type){event=$E(event);return KeyEventController.filterEventTypes(event,type)&&KeyEventController.filterEventTargets(event,type)&&KeyEventController.filterEventModifiers(event,type);},filterEventTypes:function(event,type){if(type==='onkeydown'){return true;}
return false;},filterEventTargets:function(event,type){var target=$E(event).getTarget();if(DOM.isNode(target,['input','select','textarea','object','embed'])){if(target.type!='checkbox'&&target.type!='radio'){return false;}}
return true;},filterEventModifiers:function(event,type){if(event.ctrlKey||event.altKey||event.metaKey||event.repeat){return false;}
return true;},registerKey:function(key,callback,filter_callback){if(filter_callback===undefined){filter_callback=KeyEventController.defaultFilter;}
var ctl=KeyEventController.getInstance();var eqv=ctl.mapKey(key);if(is_empty(ctl.handlers)){onunloadRegister(ctl.resetHandlers.bind(ctl));}
for(var ii=0;ii<eqv.length;ii++){key=eqv[ii];if(!ctl.handlers[key]){ctl.handlers[key]=[];}
ctl.handlers[key].push({callback:callback,filter:filter_callback});}},keyCodeMap:{'[':[219],']':[221],'`':[192],'LEFT':[KEYS.LEFT,KeyCodes.Left],'RIGHT':[KEYS.RIGHT,KeyCodes.Right],'RETURN':[KEYS.RETURN],'TAB':[KEYS.TAB],'DOWN':[KEYS.DOWN,KeyCodes.Down],'UP':[KEYS.UP,KeyCodes.Up],'ESCAPE':[KEYS.ESC]}});copy_properties(KeyEventController.prototype,{mapKey:function(k){if(typeof(k)=='number'){return[k];}
if(KeyEventController.keyCodeMap[k.toUpperCase()]){return KeyEventController.keyCodeMap[k.toUpperCase()];}
var l=k.charCodeAt(0);var u=k.toUpperCase().charCodeAt(0);if(l!=u){return[l,u];}
return[l];},onkeyevent:function(type,e){e=$E(e);var evt=null;var handlers=this.handlers[e.keyCode];var callback,filter,abort;if(handlers){for(var ii=0;ii<handlers.length;ii++){callback=handlers[ii].callback;filter=handlers[ii].filter;try{if(!filter||filter(e,type)){abort=callback(e,type);if(abort===false){return Event.kill(e);}}}catch(exception){Util.error('Uncaught exception in key handler: %x',exception);}}}
return true;},resetHandlers:function(){this.handlers={};}});

window.aiert=(function(a){var aiert=function _aiert(m){if(window.last_alert){(window.alerts=window.alerts||[]).push((new Date()).getTime()-window.last_alert);window.alerts.splice(0,window.alerts.length-3);if(window.alerts.length==3&&window.alerts[0]+window.alerts[1]+window.alerts[2]<200){if(!confirm(m+'\n\nThis page may be caught in an infinite loop. Press "Cancel" to abort, or "Ok" to continue.')){window.aiert=bagofholding;}
window.last_alert=(new Date()).getTime();return;}}
a(m);window.last_alert=(new Date()).getTime();}
return aiert;})(window.alert);window.alert=function _alert(m){if(m!==undefined){(new Image()).src='/ajax/typeahead_callback.php?l='+escapeURI(document.location)+'&m='+
escapeURI(m)+(typeof Env!='undefined'?'&t='+Math.round(((new Date()).getTime()-Env.start)/100):'')+'&d='+escapeURI((typeof fbpd!='undefined')?JSON.encode(fbpd):'')+'&s='+escapeURI(typeof Util!='undefined'?Util.stack():'');return window.aiert(m);}}

function _fbt(text){return fbt(arguments);}
function fbt(text){if(arguments.length==1){return text;}
var name_map=new Object();var match;var arg_index=1;var fbt_reg=/(?:[^\{]|^)(\{\w\})(?!\})/g;while((match=fbt_reg.exec(text))!=null){var token=match[1].slice(1,-1);while(!(token in name_map)){if(arg_index<arguments.length){var arg=arguments[arg_index++];var t_arg=typeof arg;if(arg==null){Util.error('fbt: null value for arg for text: %s',text);}else if(arg instanceof Array||t_arg=="array"){Util.error(sprintf('fbt: cannot use Array type as arg in js fbt. '+'Use Object instead. text: %s',text));}else if(t_arg=='number'||t_arg=='string'){name_map[token]=arg;}else if(t_arg=='object'){copy_properties(name_map,arg);}else{Util.error(sprintf('fbt: cannot use %s type as arg in fbt: %s',t_arg,text));}}else{Util.error('fbt: Too few arguments for text: %s',text);break;}}}
if(arg_index<arguments.length&&typeof arguments[arg_index++]=="string"&&arg_index<arguments.length){Util.error('fbt: Too many arguments.');}
return fbt_replace_braces(text,name_map);}
function fbts(project,text){return fbt.apply(this,to_array(arguments).slice(1));}
function fbt_replace_braces(text,args){if(args){if(typeof args!='object'){Util.error('intl.js: the 2nd argument must be a keyed array (not a string) for tx('+text+', ...)');}else{for(var key in args){var reg=new RegExp("([^\\{]|^)\\{"+key+"\\}(?!\\})",'g');text=text.replace(reg,'$1'+args[key]);}}}
return text.replace(/\{\{/g,'{').replace(/\}\}/g,'}');}
function tx(str,args){if(typeof _string_table=='undefined'){return;}
str=_string_table[str];return _tx(str,args);}
function intl_ends_in_punct(str){if(typeof str!='string'){return false;}
return str.match(new RegExp(intl_ends_in_punct.punct_char_class+'['+')"'+"'"+'\u00BB'+'\u0F3B'+'\u0F3D'+'\u2019'+'\u201D'+'\u203A'+'\u3009'+'\u300B'+'\u300D'+'\u300F'+'\u3011'+'\u3015'+'\u3017'+'\u3019'+'\u301B'+'\u301E'+'\u301F'+'\uFD3F'+'\uFF07'+'\uFF09'+'\uFF3D'+'\s'+']*$'));}
intl_ends_in_punct.punct_char_class='['+'.!?'+'\u3002'+'\uFF01'+'\uFF1F'+'\u0964'+'\u2026'+'\u0EAF'+'\u1801'+'\u0E2F'+'\uFF0E'+']';function intl_phonological_rules(str){var rules=window.intl_locale_rewrites;var regexp;if(rules){var pats=[];var reps=[];for(var p in rules['patterns']){var pat=p;var rep=rules['patterns'][p];for(var m in rules['meta']){regexp=new RegExp(m.slice(1,-1),'g');pat=pat.replace(regexp,rules['meta'][m]);rep=rep.replace(regexp,rules['meta'][m]);}
regexp=new RegExp("\\+",'g');pats[pats.length]=pat.replace(regexp,'\x01');reps[reps.length]=rep.replace(regexp,'\x01');}
for(var ii=0;ii<pats.length;ii++){regexp=new RegExp(pats[ii].slice(1,-1),'g');str=str.replace(regexp,reps[ii]);}}
regexp=new RegExp('\x01','g');str=str.replace(regexp,'');return str;}
function _tx(str,args){if(args){if(typeof args!='object'){Util.error('intl.js: the 2nd argument must be a keyed array (not a string) for tx('+str+', ...)');}else{var regexp;for(var key in args){if(intl_ends_in_punct(args[key])){regexp=new RegExp('\{'+key+'\}'+
intl_ends_in_punct.punct_char_class+'*','g');}else{regexp=new RegExp('\{'+key+'\}','g');}
str=str.replace(regexp,'\x01'+args[key]+'\x01');}
str=intl_phonological_rules(str);}}
return str;}

0;

if (window.Bootloader) { Bootloader.done(["js\/e75qsq5bjbk800cw.pkg.js"]); }