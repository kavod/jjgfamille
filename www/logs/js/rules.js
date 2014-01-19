// Rules
var myrules = {
  '#open' : function(element){
    element.onclick = function(){
      var targetDiv = $('contents');
      new Effect.BlindDown(targetDiv,{duration: 0.5});
      new Effect.Fade(this);
      Effect.Appear('close', {delay: 1});
    }
  },
  '#close' : function(element){
    element.onclick = function(){
      var targetDiv = $('contents');
      new Effect.BlindUp(targetDiv,{duration: 0.5});
      new Effect.Fade(this);
      Effect.Appear('open', {delay: 1});
    }
  }
};