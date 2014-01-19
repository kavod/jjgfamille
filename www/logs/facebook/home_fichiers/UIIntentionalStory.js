/*    HTTP Host:  static.ak.fbcdn.net                                          */
/*    Generated:  March 26th 2009 4:10:56 PM PDT                               */
/*      Machine:  10.16.140.109                                                */
/*       Source:  Local Cache                                                  */
/*     Location:  rsrc:bwv1q3o7:en_US:/html/js/stream/UIIntentionalStory.js    */
/*       Locale:  en_US                                                        */
/*         Path:  js/stream/UIIntentionalStory.js                              */


UIIntentionalStory={setup:function(root,data){if(!data){return false;}
if(data.unfollow){this.createUnfollowMenu(root,data.unfollow);}},createUnfollowMenu:function(root,data){var menuRoot=root.scry('div.UIIntentionalStory_Hide')[0];if(!menuRoot){return;}
var title=_tx("Hide");var menu=new UIActionMenu();var list=new UISelectList();var listCallback=function(root,menu,list,checked,data){menu.hideMenu();list.reset();var unfollowData=copy_properties({storyID:root.id},data);UIIntentionalStream.instance.unfollow(unfollowData);}.bind(this,root,menu,list);list.setMode(UISelectList.SINGLE_SELECT_MODE).setCallback(listCallback).addItem(HTML(data.user.hideString),false,data.user);if(data.app){list.addItem(HTML(data.app.hideString),false,data.app);}
menu.setTitle(title).setContentCallback(list.getElement.bind(list)).setSuppressButton(true).paint();menuRoot.setContent(menu.root);}};

if (window.Bootloader) { Bootloader.done(["js\/stream\/UIIntentionalStory.js"]); }