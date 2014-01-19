/*    HTTP Host:  static.ak.fbcdn.net                                          */
/*    Generated:  March 26th 2009 12:20:50 PM PDT                              */
/*      Machine:  10.16.140.106                                                */
/*       Source:  Local Cache                                                  */
/*     Location:  rsrc:9sxoh8fu:nu_ll:/html/js/67x0r33w19gk4kcs.pkg.js:141     */
/*       Locale:  nu_ll                                                        */
/*         Path:  js/67x0r33w19gk4kcs.pkg.js                                   */


function PageCache(max_page_num,max_ttl){if(this===window){return new PageCache(max_page_num,max_ttl);}
this._MAX_PAGE_NUM=typeof max_page_num=='undefined'?5:max_page_num;this._MAX_TTL=typeof max_ttl=='undefined'?600000:max_ttl;this._storage={}}
copy_properties(PageCache.prototype,{_normalizeURI:function(uri){return new URI(uri).getUnqualifiedURI().setFragment('').removeQueryData('ref').toString();},addPage:function(uri,properties){uri=this._normalizeURI(uri);if(!this._storage[uri]){this._storage[uri]={};}
var page=this._storage[uri];copy_properties(page,properties);page.accessTime=page.genTime=(new Date()).getTime();this._clearCache();},updatePage:function(uri,obj){uri=this._normalizeURI(uri);if(!this._storage[uri]){return;}
copy_properties(this._storage[uri],obj);},isPageInCache:function(uri){return!!this._storage[this._normalizeURI(uri)];},invalidatePage:function(uri){uri=this._normalizeURI(uri);delete this._storage[uri];},getPage:function(uri){this._clearCache();uri=this._normalizeURI(uri);var page=this._storage[uri];if(!page){return null;}
page.accessTime=(new Date()).getTime();return page;},_clearCache:function(){var cur_time=(new Date()).getTime();var oldest=null
var page_num=0;for(var uri in this._storage){var page=this._storage[uri];var ttl=page.ttl||this._MAX_TTL;if(page.genTime<cur_time-ttl){delete this._storage[uri];continue;}
if(!oldest||this._storage[oldest].accessTime>page.accessTime){oldest=uri;}
page_num++;}
if(page_num>this._MAX_PAGE_NUM&&oldest){delete this._storage[oldest];}}});

var Quickling={isActive:function(){return Quickling._is_active||false;},init:function(version,page_cache_enabled){if(Quickling._is_initialized){return;}
copy_properties(Quickling,{_is_initialized:true,_is_active:true,_is_page_cache_enabled:page_cache_enabled,_is_in_transition:false,_version:version});Quickling._instrumentTimeoutFunc('setInterval');Quickling._instrumentTimeoutFunc('setTimeout');PageTransitions.registerHandler(Quickling._transitionHandler);if(page_cache_enabled){Quickling._cache=new PageCache();Quickling._invalidate_msgs=[];Arbiter.subscribe(Arbiter.NEW_NOTIFICATIONS,Quickling._onNotifications);Arbiter.subscribe(Arbiter.REPLAYABLE_AJAX,Quickling._onReplayableAjax);Arbiter.subscribe(Arbiter.PAGECACHE_INVALIDATE,Quickling._onCacheInvalidates);}},_onNotifications:function(type,notifications){Util.log('Invalidate PageCache due to new notifications');Quickling._cache=new PageCache();},_onCacheInvalidates:function(type,msgs){if(Quickling._is_page_cache_enabled&&msgs&&msgs.length){Quickling._invalidate_msgs=Quickling._invalidate_msgs.concat(msgs);}},_refresh_pagelets:function(){if(is_empty(window.__listeners)){return;}
for(var ii=0;ii<Quickling._invalidate_msgs;ii++){var msg=Quickling._invalidate_msgs[ii];if(msg in window.__listeners){window.__listeners[msg].forEach(function(pagelet){pagelet.refresh();});}}},_onReplayableAjax:function(type,request){if(Quickling._is_in_transition){return;}
var regex=Quickling._whitelist_regex;if(!regex){regex=Quickling._whitelist_regex=new RegExp(env_get('pagecache_whitelist_regex'));}
if(regex.test(URI(request.getURI()).getPath())){return;}
var cur_uri=PageTransitions.getMostRecentURI();var page;if(page=Quickling._cache.getPage(cur_uri)){if(request._replayKey){for(var ii=0;ii<page.replay_ajax.length;ii++){if(page.replay_ajax[ii][0]==request._replayKey){page.replay_ajax.splice(ii,1);ii--;}}}
page.replay_ajax.push([request._replayKey,request]);}},_startQuicklingTransition:function(){Quickling._is_in_transition=true;window.channelManager&&window.channelManager.setActionRequest(true);},_stopQuicklingTransition:function(){(function(){Quickling._is_in_transition=false;}).defer();},goHashOrGoHere:function(where){var uri=URI.getRequestURI();var hash=uri.getFragment();if(hash.startsWith('/')){var dest_url=hash;}else{var dest_url=where;}
PageTransitions.go(dest_url,true);},_isPageActive:function(uri){if(uri=='#'){return false;}
var uri=new URI(uri);if(uri.getDomain()&&uri.getDomain()!=URI().getDomain()){return false;}
var regex=Quickling._isPageActive.regex;if(!regex){regex=Quickling._isPageActive.regex=new RegExp(env_get('quickling_inactive_page_regex'));}
var testURIString=uri.getPath();var queryData=uri.getQueryData();if(queryData){testURIString+='?'+URI.implodeQuery(queryData);}
if(regex.test(testURIString)){return false;}
return true;},_invoke_callbacks:function(hooks){if(hooks){for(var ii=0;ii<hooks.length;ii++){try{eval('(function() {'+hooks[ii]+'})();');}catch(exception){Util.error('Error %x in executing cached hooks: %s',exception,hooks[ii].toString());}}}},_transitionHandler:function(uri){if(Quickling._isTimeToRefresh()){return false;}
if(!Quickling._isPageActive(uri)){return false;}
removeHook('onafterloadhooks');removeHook('onloadhooks');_runHooks('onleavehooks');Quickling._startQuicklingTransition();var page;if(Quickling._is_page_cache_enabled&&(page=Quickling._cache.getPage(uri))){Quickling._preBootloadHandler();function on_bootload_done(){document.title=page.title||'Facebook';var body_class=page.body_class||'';CSS.setClass(document.body,body_class
+(CSS.hasClass(document.body,'chat_body')?' chat_body':''));var content_div=$('content');content_div.style.visibility="hidden";DOM.setContent(content_div,HTML(page.html).setDeferred(true));if(content_div&&content_div.style.height=='1234px'){content_div.style.height='';}
PageTransitions.transitionComplete();Quickling._invoke_callbacks(page.onload);Quickling._refresh_pagelets();Quickling._invoke_callbacks(page.onpagecache);page.replay_ajax.forEach(function(pair){var request=pair[1];request.replayResponse();});Quickling._invoke_callbacks(page.onafterload);AsyncRequest.registerBundledRequestProperties({callback:function(){setTimeout(function(){$('content').style.visibility="visible";Quickling._stopQuicklingTransition();},20);},onInitialResponse:Quickling._onInitialResponse,extra_data:{uri:uri.getQualifiedURI().toString(),version:Quickling._version}});}
Bootloader.loadResources(page.bootload,on_bootload_done,true);}else{var quickling_param={version:Quickling._version};uri=new URI(uri).addQueryData({quickling:quickling_param});new AsyncRequest().setURI(uri.getPath()).setData(uri.getQueryData()).setPreBootloadHandler(Quickling._preBootloadHandler).setInitialHandler(Quickling._onInitialResponse).setHandler(Quickling._onresponse).setFinallyHandler(PageTransitions.transitionComplete).setMethod('GET').setReadOnly(true).setOption('useIframeTransport',true).send();}
return true;},_preBootloadHandler:function(response){var content_div=ge('content');if(content_div){content_div.style.height='1234px';DOM.empty(content_div);}
DOMScroll.scrollTo(new Vector2(0,0,'document'),false);return response&&!response.getPayload().redirect;},_onInitialResponse:function(response){var payload=response.getPayload();if(payload.redirect){if(payload.force||!Quickling._isPageActive(payload.redirect)){go_or_replace(window.location,URI(payload.redirect).removeQueryData('quickling'),true);}else{PageTransitions.go(payload.redirect,true);}
return false;}
if(payload.version&&payload.version!=Quickling._version){go_or_replace(window.location,URI(payload.uri).removeQueryData('quickling'),true);return false;}
return true;},_onresponse:function(response,exec_callbacks){var payload=response.payload;document.title=payload.title||'Facebook';var body_class=payload.body_class||'';CSS.setClass(document.body,body_class
+(CSS.hasClass(document.body,'chat_body')?' chat_body':''));if(payload.hasOnbeforeshow){$('content').style.visibility='hidden';}
for(var div_id in payload.content){var div=ge(div_id);var content=payload.content[div_id];if(div){if(content===undefined||content===null){Util.warn('Content for div id: '+div_id+' is null');}else{var html_content=HTML(content).setDeferred(true);DOM.setContent(div,html_content);}}else{Util.warn('Unknown content div id: '+div_id);}}
if(Quickling._is_page_cache_enabled&&payload.page_cache_ttl){Quickling._cache.addPage(PageTransitions.getNextURI(),{title:payload.title,body_class:payload.body_class,html:payload.content['content'],onload:response.onload,onafterload:response.onafterload,bootload:response.bootload,onpagecache:payload.onpagecache,ttl:payload.page_cache_ttl,replay_ajax:[]});}
var content_div=ge('content');if(content_div&&content_div.style.height=='1234px'){content_div.style.height='';}
Quickling._stopQuicklingTransition();if(exec_callbacks){setTimeout(function(){Quickling._invoke_callbacks(response.onload);Quickling._invoke_callbacks(response.onafterloads);},0);}},_isTimeToRefresh:function(){Quickling._load_count=(Quickling._load_count||0)+1;return Quickling._load_count>=10;},_instrumentTimeoutFunc:function(original_name){window[original_name+'_native']=(function(orig){var _native=function _native(func,delay){return orig(func,delay);};return _native;})(window[original_name]);window[original_name]=function _setTimeout(func,delay,clear_on_quickling_event){var timeout_id=window[original_name+'_native'](func,delay);if(delay>0){onunloadRegister(function(){clearInterval(timeout_id);},clear_on_quickling_event);}
return timeout_id;};}};

if (window.Bootloader) { Bootloader.done(["js\/67x0r33w19gk4kcs.pkg.js"]); }