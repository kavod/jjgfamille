/*    HTTP Host:  static.ak.fbcdn.net                                          */
/*    Generated:  March 25th 2009 9:41:32 AM PDT                               */
/*      Machine:  10.16.139.101                                                */
/*       Source:  Local Cache                                                  */
/*     Location:  rsrc:b318tcm4:nu_ll:/html/js/lib/ui/UIPagelet.js             */
/*       Locale:  nu_ll                                                        */
/*         Path:  js/lib/ui/UIPagelet.js                                       */


function UIPagelet(element,src,context_data,data){this._element=ge(element||$N('div'));this._src=src||null;this._context_data=context_data||{};this._data=data||{};}
copy_properties(UIPagelet.prototype,{getElement:function(){return this._element;},go:function(src,data){if(arguments.length>=2||typeof src=='string'){this._src=src;this._data=data||{};}else if(arguments.length==1){this._data=src;}
this.refresh();return this;},refresh:function(){var handler=function(response){this._element.setContent(HTML(response.getPayload()));}.bind(this);new AsyncRequest().setURI(this._src).setMethod('GET').setData({data:JSON.encode(merge(this._context_data,this._data))}).setReadOnly(true).setHandler(handler).setOption('bundle',true).send();return this;}});

if (window.Bootloader) { Bootloader.done(["js\/lib\/ui\/UIPagelet.js"]); }