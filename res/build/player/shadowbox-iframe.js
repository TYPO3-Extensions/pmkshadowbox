(function(){var A=Shadowbox;var B=A.lib;var D=A.getClient();Shadowbox.iframe=function(E,C){this.id=E;this.obj=C;this.height=this.obj.height?parseInt(this.obj.height,10):B.getViewportHeight();this.width=this.obj.width?parseInt(this.obj.width,10):B.getViewportWidth()};Shadowbox.iframe.prototype={markup:function(E){var C={tag:"iframe",id:this.id,name:this.id,height:"100%",width:"100%",frameborder:"0",marginwidth:"0",marginheight:"0",scrolling:A.getIframeScrollingOption()};if(D.isIE){C.allowtransparency="true";if(!D.isIE7){C.src='javascript:false;document.write("");'}}return C},onLoad:function(){var C=(D.isIE)?B.get(this.id).contentWindow:window.frames[this.id];C.location=this.obj.content},remove:function(){var C=B.get(this.id);if(C){B.remove(C);if(D.isGecko){delete window.frames[this.id]}}}}})();
