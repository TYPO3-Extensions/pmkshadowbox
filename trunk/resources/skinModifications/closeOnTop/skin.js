/**
 * Close Button On Top
 *
 * Differences:
 * - Just moves the closing link to the title bar.
 *
 * @author Stefan Galinski <stefan.galinski@gmail.com>
 */

S.skin.markup = "" +
'<div id="sb-container">' +
    '<div id="sb-overlay"></div>' +
    '<div id="sb-wrapper">' +
        '<div id="sb-title">' +
			'<div id="sb-nav-top">' +
				'<a id="sb-nav-close" title="{close}" onclick="Shadowbox.close()"></a>' +
			'</div>' +
            '<div id="sb-title-inner"></div>' +
        '</div>' +
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
                '<div id="sb-counter"></div>' +
                '<div id="sb-nav">' +
                    '<a id="sb-nav-next" title="{next}" onclick="Shadowbox.next()"></a>' +
                    '<a id="sb-nav-play" title="{play}" onclick="Shadowbox.play()"></a>' +
                    '<a id="sb-nav-pause" title="{pause}" onclick="Shadowbox.pause()"></a>' +
                    '<a id="sb-nav-previous" title="{previous}" onclick="Shadowbox.previous()"></a>' +
                '</div>' +
            '</div>' +
        '</div>' +
    '</div>' +
'</div>';
