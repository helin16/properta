$(function(){var b=0.8;var a=250;jQuery(window).on("mousewheel DOMMouseScroll",function(d){d.preventDefault();var f=d.originalEvent.wheelDelta/120||-d.originalEvent.detail/3;var e=jQuery(window).scrollTop();var c=e-parseInt(f*a);TweenMax.to(jQuery(window),b,{scrollTo:{y:c,autoKill:true},ease:Power1.easeOut,autoKill:true,overwrite:5})})});