/**
 * The iframe player for Shadowbox.
 */

/**
 * Constructor. The iframe player class for Shadowbox.
 *
 * @constructor
 * @param   {Object}    obj     The content object
 * @param   {String}    id      The player id
 * @public
 */
S.iframe = function(obj, id) {
    this.obj = obj;
    this.id = id;

    // height/width default to full viewport height/width
    var overlay = get("sb-overlay");
    this.height = obj.height ? parseInt(obj.height, 10) : overlay.offsetHeight;
    this.width = obj.width ? parseInt(obj.width, 10) : overlay.offsetWidth;
}

S.iframe.prototype = {

    /**
     * Appends this iframe to the DOM.
     *
     * @param   {HTMLElement}   body    The body element
     * @param   {Object}        dims    The current Shadowbox dimensions
     * @public
     */
    append: function(body, dims) {
		var scrolling = '';
		if (this.obj.iframeScrolling === 'dynamic_noScrollFallback' && (S.isIE6 || S.isIE7)) {
			scrolling = 'no';
		} else if (this.obj.iframeScrolling !== 'no' && this.obj.iframeScrolling !== 'yes') {
			scrolling = 'auto';
		} else {
			scrolling = this.obj.iframeScrolling;
		}

        var html = '<iframe id="' + this.id + '" name="' + this.id + '" height="100%" ' +
            'width="100%" frameborder="0" marginwidth="0" marginheight="0" ' +
            'style="visibility:visible;" ' +
			'onload="this.style.visibility=\'visible\'" ' +
            'scrolling="' + scrolling + '"';

        if (S.isIE) {
            // prevent brief whiteout while loading iframe source
            html += ' allowtransparency="true"';

            // prevent "secure content" warning for https on IE6
            // see http://www.zachleat.com/web/2007/04/24/adventures-in-i-frame-shims-or-how-i-learned-to-love-the-bomb/
            if (S.isIE6)
                html += ' src="javascript:false;document.write(\'\');"';
        }

        html += '></iframe>';

        // use innerHTML method of insertion here instead of appendChild
        // because IE renders frameborder otherwise
        body.innerHTML = html;
    },

    /**
     * Removes this iframe from the DOM.
     *
     * @public
     */
    remove: function() {
        var el = get(this.id);
        if (el) {
            remove(el);
            if (S.isGecko)
                delete window.frames[this.id]; // needed for Firefox
        }
    },

    /**
     * An optional callback function to process after this content has been loaded.
     *
     * @public
     */
    onLoad: function() {
        var win = S.isIE ? get(this.id).contentWindow : window.frames[this.id];
        win.location.href = this.obj.content;

			// multiple timeouts with different time gaps to prevent an more performance
			// intensive intervall
			// Needed by Chrome and Safari, because they are post-loading content after
			// the layout was rendered. Unfortunatly the post-rendering triggers scrollbars!
		var iframeInstance = this;
		window.setTimeout(function(){iframeInstance.triggerResize(iframeInstance)}, 100);
		window.setTimeout(function(){iframeInstance.triggerResize(iframeInstance)}, 500);
		window.setTimeout(function(){iframeInstance.triggerResize(iframeInstance)}, 1000);
    },

	triggerResize: function(iframeInstance) {
		if (typeof iframeInstance !== 'object') {
			iframeInstance = this;
		}

		try {
			var win = window.frames[iframeInstance.id];
			if (typeof win !== 'undefined') {
				if (win.document.body === null) {
					window.setTimeout(function(){iframeInstance.triggerResize(iframeInstance)}, 10);
				} else {
					var dims = setDimensions(iframeInstance.height, iframeInstance.width);
					iframeInstance.onWindowResize(dims);
				}
			}
		} catch (e) {
			// catches e.g. security exceptions if the iframe content is not in the same domain
		}
	},

	onWindowResize: function(dims) {
		if (this.obj.iframeScrolling !== 'dynamic' &&
			this.obj.iframeScrolling !== 'dynamic_noScrollFallback'
		) {
			return;
		}

		var element = document.getElementById(this.id);
		var win = S.isIE ? get(this.id).contentWindow : window.frames[this.id];

		if (dims.oversized) {
			element.style.overflow = 'auto';
			if (this.obj.width <= dims.width) {
				element.style.overflowX = 'hidden';
			} else if (this.obj.height <= dims.height) {
				element.style.overflowY = 'hidden';
			}
			win.document.body.style.overflow = 'auto';
		} else {
			element.style.overflow = 'hidden';
			win.document.body.style.overflow = 'hidden';
		}
	}
}
