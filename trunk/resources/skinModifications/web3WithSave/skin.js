/**
 * Just another nice skin with no title/info bar animations
 *
 * @author Peter Klein <pmk@io.dk>
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */

function showBars(callback) {
	if (callback) {
		callback();
	}
}

function hideBars(anim, callback) {
	if (callback) {
		callback();
	}
}

function toggleLoading(on, callback) {
    var loading = get("sb-loading"),
        playerName = S.getCurrent().player,
		save = get("sb-nav-save"),
		print = get("sb-nav-print"),
        anim = (playerName == "img" || playerName == "html"); // fade on images & html

    save.style.display = (playerName != "img") ? "none" : "";
    print.style.display = (playerName == "img" || (playerName == "iframe" && /(www\.)?youtube\.com/i.test(S.getCurrent().link.hostname) == false)) ? "" : "none";

	var wrapped = '';
	var fromOpacityValue = 0;
    if (on) {
        S.setOpacity(loading, 0);
        loading.style.display = 'block';

		fromOpacityValue = 1;
        wrapped = function() {
            S.clearOpacity(loading);
            if (callback)
                callback();
        }
    } else {
        wrapped = function() {
            loading.style.display = 'none';
            S.clearOpacity(loading);
            if (callback)
                callback();
        }
    }

	if (anim) {
		animate(loading, 'opacity', fromOpacityValue, S.options.fadeDuration, wrapped);
	} else {
		wrapped();
	}
}

pngIds = [];
S.skin.markup = "" +
'<div id="sb-container">' +
    '<div id="sb-overlay"></div>' +
    '<div id="sb-wrapper">' +
		'<div id="sb-border">' +
	        '<div id="sb-wrapper-inner">' +
	            '<div id="sb-body">' +
	                '<div id="sb-body-inner"></div>' +
	                '<div id="sb-loading">' +
	                    '<div id="sb-loading-inner"><span>{loading}</span></div>' +
	                '</div>' +
	            '</div>' +
	        '</div>' +
	        '<div id="sb-info">' +
	            '<div id="sb-info-inner">' +
					'<div id="sb-title"><div id="sb-title-inner"></div></div>' +
					'<div id="sb-nav2">' +
	                    '<a id="sb-nav-save" title="Save" onclick="Shadowbox.setSave()"></a>' +
	                    '<a id="sb-nav-print" title="Print" onclick="Shadowbox.print()"></a>' +
						'<a id="sb-nav-close" title="{close}" onclick="Shadowbox.close()"></a>' +
					'</div>' +
					'<div style="clear:both"></div>' +
	                '<div id="sb-counter"></div>' +
	                '<div id="sb-nav">' +
	                    '<a id="sb-nav-previous" title="{previous}" onclick="Shadowbox.previous()"></a>' +
	                    '<a id="sb-nav-play" title="{play}" onclick="Shadowbox.play()"></a>' +
	                    '<a id="sb-nav-pause" title="{pause}" onclick="Shadowbox.pause()"></a>' +
	                    '<a id="sb-nav-next" title="{next}" onclick="Shadowbox.next()"></a>' +
	                '</div>' +
	            '</div>' +
	        '</div>' +
        '</div>' +
    '</div>' +
'</div>';

S.print = function(){
	var url = S.getCurrent()["content"];
	if (S.getCurrent().player == "img") {
		url = "index.php?eID=pmkshadowbox&mode=print&image=" + url;
	}
	else {
		url = url + (url.indexOf("?")>0 ? "&" : "?") + "print=2";
	}
	window.open(url);
	return false;
};

S.setSave = function(){
	var sv = get("sb-nav-save");
	if (sv) sv.href = "index.php?eID=pmkshadowbox&mode=save&image=" + S.getCurrent()["content"];
};
