/*    HTTP Host:  static.ak.fbcdn.net                                          */
/*    Generated:  March 24th 2009 2:02:51 PM PDT                               */
/*      Machine:  10.16.139.107                                                */
/*       Source:  Global Cache                                                 */
/*     Location:  js/video/histogram_monitor.js h:3pg9874j                     */
/*       Locale:  nu_ll                                                        */
/*         Path:  js/video/histogram_monitor.js                                */


function VideoHistogram(){this.videos={};this.video_payloads={};this.listening=false;}
VideoHistogram.prototype.start=function(swf_id){var new_video=document[swf_id]||window[swf_id];this.videos[swf_id]=new_video;this.listening=true;}
VideoHistogram.prototype.videoFinished=function(swf_id,payload){this.videos[swf_id]=null;this.setPayload(swf_id,payload);this.updateServer();}
VideoHistogram.prototype.setPayload=function(swf_id,payload){this.video_payloads[swf_id]=payload;}
VideoHistogram.prototype.updateServer=function(){var big_payload=[];for(var swf_id in this.video_payloads){var video_report=this.video_payloads[swf_id];this.video_payloads[swf_id]=null;if(video_report){big_payload.push(video_report);}}
var json_payload=JSON.encode(big_payload);new AsyncSignal('/video/motion_log.php',{'h':json_payload}).send();}
VideoHistogram.prototype.checkStatus=function(){if(this.listening){for(var v in this.videos){if(this.videos[v]){this.videos[v].reportTime();}}
this.updateServer();}}
video_histogram=new VideoHistogram();onbeforeunloadRegister(function(){video_histogram.checkStatus();});

if (window.Bootloader) { Bootloader.done(["js\/video\/histogram_monitor.js"]); }