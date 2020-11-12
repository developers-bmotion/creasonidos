/* global pysOptions */

// https://bitbucket.org/pixelyoursite/pys_pro_7/issues/7/possible-ie-11-error
// https://tc39.github.io/ecma262/#sec-array.prototype.includes
if (!Array.prototype.includes) {
    Object.defineProperty(Array.prototype, 'includes', {
        value: function (searchElement, fromIndex) {

            if (this == null) {
                throw new TypeError('"this" is null or not defined');
            }

            // 1. Let O be ? ToObject(this value).
            var o = Object(this);

            // 2. Let len be ? ToLength(? Get(O, "length")).
            var len = o.length >>> 0;

            // 3. If len is 0, return false.
            if (len === 0) {
                return false;
            }

            // 4. Let n be ? ToInteger(fromIndex).
            //    (If fromIndex is undefined, this step produces the value 0.)
            var n = fromIndex | 0;

            // 5. If n ≥ 0, then
            //  a. Let k be n.
            // 6. Else n < 0,
            //  a. Let k be len + n.
            //  b. If k < 0, let k be 0.
            var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

            function sameValueZero(x, y) {
                return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
            }

            // 7. Repeat, while k < len
            while (k < len) {
                // a. Let elementK be the result of ? Get(O, ! ToString(k)).
                // b. If SameValueZero(searchElement, elementK) is true, return true.
                if (sameValueZero(o[k], searchElement)) {
                    return true;
                }
                // c. Increase k by 1.
                k++;
            }

            // 8. Return false
            return false;
        }
    });
}

if (!String.prototype.startsWith) {
    Object.defineProperty(String.prototype, 'startsWith', {
        enumerable: false,
        configurable: false,
        writable: false,
        value: function (searchString, position) {
            position = position || 0;
            return this.indexOf(searchString, position) === position;
        }
    });
}

if (!String.prototype.trim) {
    (function () {
        String.prototype.trim = function () {
            return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
        };
    })();
}

! function ($, options) {

    if (options.debug) {
        console.log('PYS:', options);
    }

    var dummyPinterest = function () {

        /**
         * Public API
         */
        return {

            isEnabled: function () {},

            disable: function () {},

            loadPixel: function () {},

            fireEvent: function (name, data) {
                return false;
            },

            onAdSenseEvent: function () {},

            onClickEvent: function (params) {},

            onWatchVideo: function (params) {},

            onCommentEvent: function () {},

            onFormEvent: function (params) {},

            onDownloadEvent: function (params) {},

            onWooAddToCartOnButtonEvent: function (product_id) {},

            onWooAddToCartOnSingleEvent: function (product_id, qty, is_variable, is_external, $form) {},

            onWooRemoveFromCartEvent: function (cart_item_hash) {},

            onWooAffiliateEvent: function (product_id) {},

            onWooPayPalEvent: function () {},

            onEddAddToCartOnButtonEvent: function (download_id, price_index, qty) {},

            onEddRemoveFromCartEvent: function (item) {}

        }

    }();

    var dummyBing = function () {

        /**
         * Public API
         */
        return {

            isEnabled: function () {},

            disable: function () {},

            loadPixel: function () {},

            fireEvent: function (name, data) {
                return false;
            },

            onAdSenseEvent: function () {},

            onClickEvent: function (params) {},

            onWatchVideo: function (params) {},

            onCommentEvent: function () {},

            onFormEvent: function (params) {},

            onDownloadEvent: function (params) {},

            onWooAddToCartOnButtonEvent: function (product_id) {},

            onWooAddToCartOnSingleEvent: function (product_id, qty, is_variable, is_external, $form) {},

            onWooRemoveFromCartEvent: function (cart_item_hash) {},

            onWooAffiliateEvent: function (product_id) {},

            onWooPayPalEvent: function () {},

            onEddAddToCartOnButtonEvent: function (download_id, price_index, qty) {},

            onEddRemoveFromCartEvent: function (item) {}

        }

    }();

    var Utils = function (options) {

        var Pinterest = dummyPinterest;

        var Bing = dummyBing;

        var gtag_loaded = false;

        function loadPixels() {

            if (!options.gdpr.all_disabled_by_api) {

                if (!options.gdpr.facebook_disabled_by_api) {
                    Facebook.loadPixel();
                }

                if (!options.gdpr.analytics_disabled_by_api) {
                    Analytics.loadPixel();
                }

                if (!options.gdpr.google_ads_disabled_by_api) {
                    GAds.loadPixel();
                }

                if (!options.gdpr.pinterest_disabled_by_api) {
                    Pinterest.loadPixel();
                }

                if (!options.gdpr.bing_disabled_by_api) {
                    Bing.loadPixel();
                }

            }

        }

        /**
         * WATCHVIDEO UTILS
         */

        function isJSApiAttrEnabled(url) {
            return url.indexOf('enablejsapi') > -1;
        }

        function isOriginAttrEnabled(url) {
            return url.indexOf('origin') > -1;
        }

        // Returns key/value pairs of percentages: number of seconds to achieve
        function getVideoCompletionMarks(duration) {

            var marks = {};
            var points = [0, 10, 50, 90, 100];

            for (var i = 0; i < points.length; i++) {

                var _point = points[i];
                var _mark = _point + '%';
                var _time = duration * _point / 100;

                if (_point === 100) {
                    _time = _time - 1;
                }

                // 10% => 123
                marks[_mark] = Math.floor(_time);

            }

            return marks;

        }

        // Determine if the element is a YouTube video or not
        function tagIsYouTubeVideo(tag) {
            var src = tag.src || '';
            return src.indexOf('youtube.com/embed/') > -1 || src.indexOf('youtube.com/v/') > -1;
        }

        // Turn embed objects into iframe objects and ensure they have the right parameters
        function normalizeYouTubeIframe(tag) {

            var loc = window.location;
            var a = document.createElement('a');
            a.href = tag.src;
            a.hostname = 'www.youtube.com';
            a.protocol = loc.protocol;
            var tmpPathname = a.pathname.charAt(0) === '/' ? a.pathname : '/' + a.pathname; // IE10 shim

            if (!isJSApiAttrEnabled(a.search)) {
                a.search = (a.search.length > 0 ? a.search + '&' : '') + 'enablejsapi=1';
            }

            // for security reasons, YouTube wants an origin parameter set that matches our hostname
            if (!isOriginAttrEnabled(a.search) && loc.hostname.indexOf('localhost') === -1) {

                var port = loc.port ? ':' + loc.port : '';
                var origin = loc.protocol + '%2F%2F' + loc.hostname + port;

                a.search = a.search + '&origin=' + origin;

            }

            if (tag.type === 'application/x-shockwave-flash') {

                var newIframe = document.createElement('iframe');
                newIframe.height = tag.height;
                newIframe.width = tag.width;
                tmpPathname = tmpPathname.replace('/v/', '/embed/');

                tag.parentNode.parentNode.replaceChild(newIframe, tag.parentNode);

                tag = newIframe;

            }

            a.pathname = tmpPathname;

            if (tag.src !== a.href + a.hash) {
                tag.src = a.href + a.hash;
            }

            return tag;

        }

        // Add event handlers for events emitted by the YouTube API
        function addYouTubeEvents(iframe) {

            var player = YT.get(iframe.id);

            if (!player) {
                player = new YT.Player(iframe, {});
            }

            if (typeof iframe.pauseFlag === 'undefined') {

                iframe.pauseFlag = false;
                player.addEventListener('onStateChange', function (evt) {
                    onYouTubePlayerStateChange(evt, iframe);
                });

            }

        }

        // Event handler for events emitted from the YouTube API
        function onYouTubePlayerStateChange(evt, iframe) {

            var stateIndex = evt.data;
            var player = evt.target;
            var targetVideoUrl = player.getVideoUrl();
            var targetVideoId = targetVideoUrl.match(/[?&]v=([^&#]*)/)[1]; // Extract the ID
            var playerState = player.getPlayerState();
            var marks = getVideoCompletionMarks(player.getDuration());

            iframe.playTracker = iframe.playTracker || {};

            if (playerState === YT.PlayerState.PLAYING && !iframe.timer) {

                clearInterval(iframe.timer);

                // check every second to see if we've hit any of our percentage viewed marks
                iframe.timer = setInterval(function () {
                    checkYouTubeCompletion(player, marks, iframe.videoId);
                }, 1000);

            } else {

                clearInterval(iframe.timer);
                iframe.timer = false;

            }

            // playlist edge-case handler
            if (stateIndex === YT.PlayerState.PLAYING) {
                iframe.playTracker[targetVideoId] = true;
                iframe.videoId = targetVideoId;
                iframe.pauseFlag = false;
            }

            if (!iframe.playTracker[iframe.videoId]) {
                return false; // this video hasn't started yet, so this is spam
            }

            if (stateIndex === YT.PlayerState.PAUSED) {

                if (!iframe.pauseFlag) {
                    iframe.pauseFlag = true;
                } else {
                    return false; // we don't want to fire consecutive pause events
                }

            }

        }

        // Trigger event if YouTube video mark was reached
        function checkYouTubeCompletion(player, marks, videoId) {

            var currentTime = player.getCurrentTime();

            player[videoId] = player[videoId] || {};

            for (var key in marks) {

                if (marks[key] <= currentTime && !player[videoId][key]) {
                    player[videoId][key] = true;

                    var data = player.getVideoData();

                    if (key === '0%') {
                        key = 'play';
                    }

                    var params = {
                        video_type: 'youtube',
                        video_id: videoId,
                        video_title: data.title,
                        event_trigger: key
                    };

                    Facebook.onWatchVideo(params);
                    Analytics.onWatchVideo(params);
                    GAds.onWatchVideo(params);
                    Pinterest.onWatchVideo(params);
                    Bing.onWatchVideo(params);

                }

            }

        }

        // Determine if the element is a Vimeo video or not
        function tagIsVimeoVideo(tag) {
            var src = tag.src || '';
            return src.indexOf('player.vimeo.com/video/') > -1;
        }

        // Trigger event if Vimeo video mark was reached
        function checkVimeoCompletion(player) {

            player.getCurrentTime().then(function (seconds) {

                for (var key in player.pysMarks) {

                    if (player.pysMarks[key] <= seconds && !player.pysCompletedMarks[key]) {

                        player.pysCompletedMarks[key] = true;

                        if (key === '0%') {
                            key = 'play';
                        }

                        var params = {
                            video_type: 'vimeo',
                            video_id: player.pysVideoId,
                            video_title: player.pysVideoTitle,
                            event_trigger: key
                        };

                        Facebook.onWatchVideo(params);
                        Analytics.onWatchVideo(params);
                        GAds.onWatchVideo(params);
                        Pinterest.onWatchVideo(params);
                        Bing.onWatchVideo(params);

                    }

                }

            });

        }

        /**
         * COOKIES UTILS
         */

        var utmTerms = ['utm_source', 'utm_media', 'utm_campaign', 'utm_term', 'utm_content'];

        var requestParams = [];

        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        function getTrafficSource() {

            try {

                var referrer = document.referrer.toString(),
                    source;

                var direct = referrer.length === 0;
                var internal = direct ? false : referrer.indexOf(options.siteUrl) === 0;
                var external = !direct && !internal;
                var cookie = typeof Cookies.get('pysTrafficSource') === 'undefined' ? false : Cookies.get('pysTrafficSource');

                if (external === false) {
                    source = cookie ? cookie : 'direct';
                } else {
                    source = cookie && cookie === referrer ? cookie : referrer;
                }

                if (source !== 'direct') {

                    var url = document.createElement('a');
                    url.href = source;

                    // leave only domain (Issue #70)
                    return url.hostname;

                } else {
                    return source;
                }

            } catch (e) {
                console.error(e);
                return 'direct';
            }

        }

        /**
         * Return query variables object with where property name is query variable
         * and property value is query variable value.
         */
        function getQueryVars() {

            try {

                var result = {},
                    tmp = [];

                window.location.search
                    .substr(1)
                    .split("&")
                    .forEach(function (item) {

                        tmp = item.split('=');

                        if (tmp.length > 1) {
                            result[tmp[0]] = tmp[1];
                        }

                    });

                return result;

            } catch (e) {
                console.error(e);
                return {};
            }

        }

        /**
         * Return UTM terms from request query variables or from cookies.
         */
        function getUTMs() {

            try {

                var terms = [];
                var queryVars = getQueryVars();

                $.each(utmTerms, function (index, name) {

                    var value;

                    if (Cookies.get('pys_' + name)) {
                        value = Cookies.get('pys_' + name);
                    } else if (queryVars.hasOwnProperty(name)) {
                        value = queryVars[name];
                    }

                    // do not allow email in request params (Issue #70)
                    terms[name] = filterEmails(value);

                });

                return terms;

            } catch (e) {
                console.error(e);
                return [];
            }

        }

        function filterEmails(value) {
            return validateEmail(value) ? undefined : value;
        }

        /**
         * PUBLIC API
         */
        return {

            filterEmails: function (value) {
                return filterEmails(value);
            },

            setupPinterestObject: function () {
                Pinterest = window.pys.Pinterest || Pinterest;
                return Pinterest;
            },

            setupBingObject: function () {
                Bing = window.pys.Bing || Bing;
                return Bing;
            },

            // Clone all object members to another and return it
            copyProperties: function (from, to) {
                for (var key in from) {
                    to[key] = from[key];
                }
                return to;
            },

            // Returns array of elements with given tag name
            getTagsAsArray: function (tag) {
                return [].slice.call(document.getElementsByTagName(tag));
            },

            /**
             * Load and initialize YouTube API
             *
             * @link: https://developers.google.com/youtube/iframe_api_reference
             */
            initYouTubeAPI: function () {

                // maybe load YouTube JS API
                if (typeof window.YT === 'undefined') {
                    var tag = document.createElement('script');
                    tag.src = '//www.youtube.com/iframe_api';
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                }

                // initialize when API is ready
                window.onYouTubeIframeAPIReady = function () {

                    // collect all possible YouTube tags
                    var potentialVideos = Utils.getTagsAsArray('iframe').concat(Utils.getTagsAsArray('embed'));

                    // turn videos into trackable videos with events
                    for (var i = 0; i < potentialVideos.length; i++) {
                        if (tagIsYouTubeVideo(potentialVideos[i])) {
                            var iframe = normalizeYouTubeIframe(potentialVideos[i]);
                            addYouTubeEvents(iframe);
                        }
                    }

                    // bind to dynamically added videos
                    $(document).on("load",function () {
                        var el = evt.target || evt.srcElement;
                        var isYT = checkIfYouTubeVideo(el);

                        // We only bind to iFrames with a YouTube URL with the enablejsapi=1 and
                        // origin=<<hostname>> parameters
                        if (el.tagName === 'IFRAME' && isYT && isJSApiAttrEnabled(el.src) && isOriginAttrEnabled(el.src)) {
                            addYouTubeEvents(el);
                        }
                    });

                };

            },

            /**
             * Load and initialize Vimeo API
             *
             * @link: https://github.com/vimeo/player.js
             */
            initVimeoAPI: function () {

                $(document).ready(function () {

                    var potentialVideos = Utils.getTagsAsArray('iframe').concat(Utils.getTagsAsArray('embed'));

                    for (var i = 0; i < potentialVideos.length; i++) {

                        if (!tagIsVimeoVideo(potentialVideos[i])) {
                            continue;
                        }

                        var player = new Vimeo.Player(potentialVideos[i]);

                        player.getDuration().then(function (pl,seconds) {
                            pl.pysMarks = getVideoCompletionMarks(seconds);
                        }.bind(null,player));

                        player.getVideoTitle().then(function (pl,title) {
                            pl.pysVideoTitle = title;
                        }.bind(null,player));

                        player.getVideoId().then(function (pl,id) {
                            pl.pysVideoId = id;
                        }.bind(null,player));

                        player.pysCompletedMarks = {};

                        player.on('play', function () {

                            if (this.pysTimer) {
                                return;
                            }

                            clearInterval(this.pysTimer);

                            var player = this;

                            this.pysTimer = setInterval(function () {
                                checkVimeoCompletion(player);
                            }, 1000);

                        });

                        player.on('pause', function () {
                            clearInterval(this.pysTimer);
                            this.pysTimer = false;
                        });

                        player.on('ended', function () {
                            clearInterval(this.pysTimer);
                            this.pysTimer = false;
                        });

                    }

                });

            },

            manageCookies: function () {

                try {

                    var expires = 0.5; // half day
                    var source = getTrafficSource();

                    // manage traffic source cookie
                    if (source !== 'direct') {
                        Cookies.set('pysTrafficSource', source, { expires: expires });
                    } else {
                        Cookies.remove('pysTrafficSource');
                    }

                    var queryVars = getQueryVars();

                    // manage utm cookies
                    $.each(utmTerms, function (index, name) {

                        if (Cookies.get('pys_' + name) === undefined && queryVars.hasOwnProperty(name)) {
                            Cookies.set('pys_' + name, queryVars[name], { expires: expires });
                        }

                    });

                } catch (e) {
                    console.error(e);
                }

            },

            initializeRequestParams: function () {

                if (options.trackTrafficSource) {
                    requestParams.traffic_source = getTrafficSource();
                }

                if (options.trackUTMs) {

                    var utms = getUTMs();

                    $.each(utmTerms, function (index, term) {
                        if (term in utms) {
                            requestParams[term] = utms[term];
                        }
                    });

                }

                var date = new Date(),
                    days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    months = ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ],
                    hours = ['00-01', '01-02', '02-03', '03-04', '04-05', '05-06', '06-07', '07-08',
                        '08-09', '09-10', '10-11', '11-12', '12-13', '13-14', '14-15', '15-16', '16-17',
                        '17-18', '18-19', '19-20', '20-21', '21-22', '22-23', '23-24'
                    ];

                requestParams.event_day = days[date.getDay()];
                requestParams.event_month = months[date.getMonth()];
                requestParams.event_hour = hours[date.getHours()];

            },

            getRequestParams: function () {
                return requestParams;
            },

            /**
             * DOWNLOAD DOCS
             */

            getLinkExtension: function (link) {

                // Remove anchor, query string and everything before last slash
                link = link.substring(0, (link.indexOf("#") === -1) ? link.length : link.indexOf("#"));
                link = link.substring(0, (link.indexOf("?") === -1) ? link.length : link.indexOf("?"));
                link = link.substring(link.lastIndexOf("/") + 1, link.length);

                // If there's a period left in the URL, then there's a extension
                if (link.length > 0 && link.indexOf('.') !== -1) {
                    link = link.substring(link.indexOf(".") + 1); // Remove everything but what's after the first period
                    return link;
                } else {
                    return "";
                }
            },

            getLinkFilename: function (link) {

                // Remove anchor, query string and everything before last slash
                link = link.substring(0, (link.indexOf("#") === -1) ? link.length : link.indexOf("#"));
                link = link.substring(0, (link.indexOf("?") === -1) ? link.length : link.indexOf("?"));
                link = link.substring(link.lastIndexOf("/") + 1, link.length);

                // If there's a period left in the URL, then there's a extension
                if (link.length > 0 && link.indexOf('.') !== -1) {
                    return link;
                } else {
                    return "";
                }
            },

            /**
             * CUSTOM EVENTS
             */

            setupMouseOverClickEvents: function (eventId, triggers) {

                // Non-default binding used to avoid situations when some code in external js
                // stopping events propagation, eg. returns false, and our handler will never called
                $(document).onFirst('mouseover', triggers.join(','), function () {

                    // do not fire event multiple times
                    if ($(this).hasClass('pys-mouse-over-' + eventId)) {
                        return true;
                    } else {
                        $(this).addClass('pys-mouse-over-' + eventId);
                    }

                    Utils.fireDynamicEvent(eventId);

                });

            },

            setupCSSClickEvents: function (eventId, triggers) {

                // Non-default binding used to avoid situations when some code in external js
                // stopping events propagation, eg. returns false, and our handler will never called
                $(document).onFirst('click', triggers.join(','), function () {
                    Utils.fireDynamicEvent(eventId);
                });

            },

            setupURLClickEvents: function () {

                // Non-default binding used to avoid situations when some code in external js
                // stopping events propagation, eg. returns false, and our handler will never called
                $('a[data-pys-event-id]').onFirst('click', function (evt) {

                    $(this).attr('data-pys-event-id').split(',').forEach(function (eventId) {

                        eventId = parseInt(eventId);

                        if (isNaN(eventId) === false) {
                            Utils.fireDynamicEvent(eventId);
                        }

                    });

                });

            },

            setupScrollPosEvents: function (eventId, triggers) {

                var scrollPosThresholds = {},
                    docHeight = $(document).height() - $(window).height();

                // convert % to absolute positions
                $.each(triggers, function (index, scrollPos) {

                    // convert % to pixels
                    scrollPos = docHeight * scrollPos / 100;
                    scrollPos = Math.round(scrollPos);

                    scrollPosThresholds[scrollPos] = eventId;

                });

                $(document).scroll(function () {

                    var scrollPos = $(window).scrollTop();

                    $.each(scrollPosThresholds, function (threshold, eventId) {

                        // position has not reached yes
                        if (scrollPos <= threshold) {
                            return true;
                        }

                        // fire event only once
                        if (eventId === null) {
                            return true;
                        } else {
                            scrollPosThresholds[threshold] = null;
                        }

                        Utils.fireDynamicEvent(eventId);

                    });

                });

            },
            setupCommentEvents : function (eventId,triggers) {
                $('form.comment-form').submit(function () {
                    Utils.fireDynamicEvent(eventId);
                });
            },
            /**
             * Events
             */

            isEventInTimeWindow: function (eventName, event, prefix) {

                if(event.hasOwnProperty("hasTimeWindow") && event.hasTimeWindow) {
                    var cookieName = prefix+"_"+eventName;
                    var now = new Date().getTime();

                    if(Cookies.get(cookieName) !== undefined) {

                        var lastTimeFire = Cookies.get(cookieName);
                        var fireTime = event.timeWindow * 60*60*1000;

                        if( now - lastTimeFire > fireTime) {
                            Cookies.set(cookieName,now, { expires: event.timeWindow / 24.0} );
                        } else {
                            return false;
                        }
                    } else {
                        Cookies.set(cookieName,now, { expires: event.timeWindow / 24.0} );
                    }
                }
                return true
            },

            fireDynamicEvent: function (eventId) {

                if (!options.dynamicEventsParams.hasOwnProperty(eventId)) {
                    return;
                }

                var event = {};

                if (options.dynamicEventsParams[eventId].hasOwnProperty('facebook')) {

                    event = Utils.copyProperties(options.dynamicEventsParams[eventId]['facebook'], {});
                    if(Utils.isEventInTimeWindow(event.name,event,"dyn_facebook_"+eventId)) {

                        Facebook.fireEvent(event.name, event);
                    }
                }

                if (options.dynamicEventsParams[eventId].hasOwnProperty('ga')) {

                    event = Utils.copyProperties(options.dynamicEventsParams[eventId]['ga'], {});
                    if(Utils.isEventInTimeWindow(event.action,event,"dyn_ga_"+eventId)) {
                        Analytics.fireEvent(event.action, {params: event.params});
                    }

                }

                if (options.dynamicEventsParams[eventId].hasOwnProperty('google_ads')) {

                    event = Utils.copyProperties(options.dynamicEventsParams[eventId]['google_ads'], {});
                    if(Utils.isEventInTimeWindow(event.action,event,"dyn_google_ads_"+eventId)) {
                        GAds.fireEvent(event.action, {params: event.params, ids: event.ids, conversion_labels: event.conversion_labels});
                    }
                }

                if (options.dynamicEventsParams[eventId].hasOwnProperty('pinterest')) {

                    event = Utils.copyProperties(options.dynamicEventsParams[eventId]['pinterest'], {});
                    if(Utils.isEventInTimeWindow(event.name,event,"dyn_pinterest_"+eventId)) {
                        Pinterest.fireEvent(event.name, {params: event.params});
                    }

                }

                if (options.dynamicEventsParams[eventId].hasOwnProperty('bing')) {

                    event = Utils.copyProperties(options.dynamicEventsParams[eventId]['bing'], {});
                    if(Utils.isEventInTimeWindow(event.name,event,"dyn_bing_"+eventId)) {
                        Bing.fireEvent(event.name, {params: event.params});
                    }

                }

            },

            fireStaticEvents: function (pixel) {

                if (options.staticEvents.hasOwnProperty(pixel)) {

                    $.each(options.staticEvents[pixel], function (eventName, events) {
                        $.each(events, function (index, eventData) {

                            eventData.fired = eventData.fired || false;

                            if (!eventData.fired && Utils.isEventInTimeWindow(eventName,eventData,'static_' + pixel+"_")) {


                                var fired = false;

                                // fire event
                                if ('facebook' === pixel) {
                                    fired = Facebook.fireEvent(eventName, eventData);
                                } else if ('ga' === pixel) {
                                    fired = Analytics.fireEvent(eventName, eventData);
                                } else if ('google_ads' === pixel) {
                                    fired = GAds.fireEvent(eventName, eventData);
                                } else if ('pinterest' === pixel) {
                                    fired = Pinterest.fireEvent(eventName, eventData);
                                } else if ('bing' === pixel) {
                                    fired = Bing.fireEvent(eventName, eventData);
                                }

                                // prevent event double event firing
                                eventData.fired = fired;
                            }

                        });
                    });

                }

            },

            /**
             * Load tag's JS
             *
             * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/
             * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/custom-dims-mets
             */
            loadGoogleTag: function (id) {

                if (!gtag_loaded) {

                    (function (window, document, src) {
                        var a = document.createElement('script'),
                            m = document.getElementsByTagName('script')[0];
                        a.async = 1;
                        a.src = src;
                        m.parentNode.insertBefore(a, m);
                    })(window, document, '//www.googletagmanager.com/gtag/js?id=' + id);

                    window.dataLayer = window.dataLayer || [];
                    window.gtag = window.gtag || function gtag() {
                        dataLayer.push(arguments);
                    };

                    gtag('js', new Date());

                    gtag_loaded = true;

                }

            },

            /**
             * GDPR
             */

            loadPixels: function () {

                if (options.gdpr.ajax_enabled) {

                    // retrieves actual PYS GDPR filters values which allow to avoid cache issues
                    $.get({
                        url: options.ajaxUrl,
                        dataType: 'json',
                        data: {
                            action: 'pys_get_gdpr_filters_values'
                        },
                        success: function (res) {

                            if (res.success) {

                                options.gdpr.all_disabled_by_api = res.data.all_disabled_by_api;
                                options.gdpr.facebook_disabled_by_api = res.data.facebook_disabled_by_api;
                                options.gdpr.analytics_disabled_by_api = res.data.analytics_disabled_by_api;
                                options.gdpr.google_ads_disabled_by_api = res.data.google_ads_disabled_by_api;
                                options.gdpr.pinterest_disabled_by_api = res.data.pinterest_disabled_by_api;
                                options.gdpr.bing_disabled_by_api = res.data.bing_disabled_by_api;

                            }

                            loadPixels();

                        }
                    });

                } else {
                    loadPixels();
                }

            },

            consentGiven: function (pixel) {

                /**
                 * Cookiebot
                 */
                if (options.gdpr.cookiebot_integration_enabled && typeof Cookiebot !== 'undefined') {

                    var cookiebot_consent_category = options.gdpr['cookiebot_' + pixel + '_consent_category'];

                    if (options.gdpr[pixel + '_prior_consent_enabled']) {
                        if (Cookiebot.consented === false || Cookiebot.consent[cookiebot_consent_category]) {
                            return true;
                        }
                    } else {
                        if (Cookiebot.consent[cookiebot_consent_category]) {
                            return true;
                        }
                    }

                    return false;

                }

                /**
                 * Ginger – EU Cookie Law
                 */
                if (options.gdpr.ginger_integration_enabled) {

                    var ginger_cookie = Cookies.get('ginger-cookie');

                    if (options.gdpr[pixel + '_prior_consent_enabled']) {
                        if (typeof ginger_cookie === 'undefined' || ginger_cookie === 'Y') {
                            return true;
                        }
                    } else {
                        if (ginger_cookie === 'Y') {
                            return true;
                        }
                    }

                    return false;

                }

                /**
                 * Cookie Notice
                 */
                if (options.gdpr.cookie_notice_integration_enabled && typeof cnArgs !== 'undefined') {

                    var cn_cookie = Cookies.get(cnArgs.cookieName);

                    if (options.gdpr[pixel + '_prior_consent_enabled']) {
                        if (typeof cn_cookie === 'undefined' || cn_cookie === 'true') {
                            return true;
                        }
                    } else {
                        if (cn_cookie === 'true') {
                            return true;
                        }
                    }

                    return false;

                }

                /**
                 * Cookie Law Info
                 */
                if (options.gdpr.cookie_law_info_integration_enabled) {

                    var cli_cookie = Cookies.get('viewed_cookie_policy');

                    if (options.gdpr[pixel + '_prior_consent_enabled']) {
                        if (typeof cli_cookie === 'undefined' || cli_cookie === 'yes') {
                            return true;
                        }
                    } else {
                        if (cli_cookie === 'yes') {
                            return true;
                        }
                    }

                    return false;

                }

                return true;

            },

            setupGdprCallbacks: function () {

                /**
                 * Cookiebot
                 */
                if (options.gdpr.cookiebot_integration_enabled && typeof Cookiebot !== 'undefined') {

                    Cookiebot.onaccept = function () {

                        if (Cookiebot.consent[options.gdpr.cookiebot_facebook_consent_category]) {
                            Facebook.loadPixel();
                        }

                        if (Cookiebot.consent[options.gdpr.cookiebot_analytics_consent_category]) {
                            Analytics.loadPixel();
                        }

                        if (Cookiebot.consent[options.gdpr.cookiebot_google_ads_consent_category]) {
                            GAds.loadPixel();
                        }

                        if (Cookiebot.consent[options.gdpr.cookiebot_pinterest_consent_category]) {
                            Pinterest.loadPixel();
                        }

                        if (Cookiebot.consent[options.gdpr.cookiebot_bing_consent_category]) {
                            Bing.loadPixel();
                        }

                    };

                    Cookiebot.ondecline = function () {
                        Facebook.disable();
                        Analytics.disable();
                        GAds.disable();
                        Pinterest.disable();
                        Bing.disable();
                    };

                }

                /**
                 * Cookie Notice
                 */
                if (options.gdpr.cookie_notice_integration_enabled) {

                    $(document).onFirst('click', '.cn-set-cookie', function () {

                        if ($(this).data('cookie-set') === 'accept') {
                            Facebook.loadPixel();
                            Analytics.loadPixel();
                            GAds.loadPixel();
                            Pinterest.loadPixel();
                            Bing.loadPixel();
                        } else {
                            Facebook.disable();
                            Analytics.disable();
                            GAds.disable();
                            Pinterest.disable();
                            Bing.disable();
                        }

                    });

                    $(document).onFirst('click', '.cn-revoke-cookie', function () {
                        Facebook.disable();
                        Analytics.disable();
                        GAds.disable();
                        Pinterest.disable();
                        Bing.disable();
                    });

                }

                /**
                 * Cookie Law Info
                 */
                if (options.gdpr.cookie_law_info_integration_enabled) {

                    $(document).onFirst('click', '#cookie_action_close_header', function () {
                        Facebook.loadPixel();
                        Analytics.loadPixel();
                        GAds.loadPixel();
                        Pinterest.loadPixel();
                        Bing.loadPixel();
                    });

                    $(document).onFirst('click', '#cookie_action_close_header_reject', function () {
                        Facebook.disable();
                        Analytics.disable();
                        GAds.disable();
                        Pinterest.disable();
                        Bing.disable();
                    });

                }

            }

        };

    }(options);

    var Facebook = function (options) {

        var serverEvents = ["Purchase","InitiateCheckout","CompleteRegistration","hCR","ViewContent","PageView"];
        var serverEventsDynamic = ["AddToCart"];
        var defaultEventTypes = [
            'PageView',
            'ViewContent',
            'Search',
            'AddToCart',
            'AddToWishlist',
            'InitiateCheckout',
            'AddPaymentInfo',
            'Purchase',
            'Lead',

            'Subscribe',
            'CustomizeProduct',
            'FindLocation',
            'StartTrial',
            'SubmitApplication',
            'Schedule',
            'Contact',
            'Donate'
        ];

        var initialized = false;

        function fireEvent(name, allData) {

            var data = allData.params;
            var actionType = defaultEventTypes.includes(name) ? 'trackSingle' : 'trackSingleCustom';

            var params = {};
            Utils.copyProperties(data, params);

            Utils.copyProperties(options.commonEventParams, params);
            Utils.copyProperties(Utils.getRequestParams(), params);


            var isApiDisabled = options.gdpr.all_disabled_by_api ||
                options.gdpr.facebook_disabled_by_api ||
                options.gdpr.cookiebot_integration_enabled ||
                options.gdpr.ginger_integration_enabled ||
                options.gdpr.cookie_notice_integration_enabled ||
                options.gdpr.cookie_law_info_integration_enabled;

            // send event from server if they was bloc by gdpr or need send with delay
            if( serverEvents.includes(name) && isApiDisabled || allData.delay > 0 || serverEventsDynamic.includes(name)){

                var json = {
                    action: 'pys_api_event',
                    pixel: 'facebook',
                    event: name,
                    data:data
                };
                jQuery.ajax( {
                    type: 'POST',
                    url: options.ajaxUrl,
                    data: json,
                    success: function(){},
                });
            }

            if("hCR" === name) {
                return;
            }

            if (options.debug) {
                console.log('[Facebook] ' + name, params);
            }

            if(serverEvents.includes(name) || serverEventsDynamic.includes(name)) { // Deduplicate Pixel and Server-Side Events for Purchase event
                if(allData.isFdpa) {
                    fireAllFbq(actionType, name, params,{eventID:params.eventID},options.facebook.dpaPixelId);
                } else {

                    fireAllFbq(actionType, name, params,{eventID:params.eventID});
                }

            } else {
                if(allData.isFdpa) {
                    fireAllFbq(actionType, name, params,undefined,options.facebook.dpaPixelId);
                } else {

                    fireAllFbq(actionType, name, params);
                }
            }
        }

        function fireAllFbq(actionType, name, params,args,customPixel) {
            if(customPixel !== undefined && customPixel !== "") {
                fbq(actionType, customPixel, name, params,args);
            } else {
                options.facebook.pixelIds.forEach(function (pixelId) {
                    fbq(actionType,pixelId, name, params,args);
                });
            }
        }

        /**
         * Public API
         */
        return {

            isEnabled: function () {
                return options.hasOwnProperty('facebook');
            },

            disable: function () {
                initialized = false;
            },

            /**
             * Load pixel's JS
             */
            loadPixel: function () {

                if (initialized || !this.isEnabled() || !Utils.consentGiven('facebook')) {
                    return;
                }

                ! function (f, b, e, v, n, t, s) {
                    if (f.fbq) return;
                    n = f.fbq = function () {
                        n.callMethod ?
                            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                    };
                    if (!f._fbq) f._fbq = n;
                    n.push = n;
                    n.loaded = !0;
                    n.version = '2.0';
                    n.agent = 'dvpixelyoursite';
                    n.queue = [];
                    t = b.createElement(e);
                    t.async = !0;
                    t.src = v;
                    s = b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t, s)
                }(window,
                    document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

                // initialize pixel
                options.facebook.pixelIds.forEach(function (pixelId) {

                    if (options.facebook.removeMetadata) {
                        fbq('set', 'autoConfig', false, pixelId);
                    }
                    if(options.facebook.advancedMatching.length === 0) {
                        fbq('init', pixelId);
                    } else {
                        fbq('init', pixelId, options.facebook.advancedMatching);
                    }
                });

                // init pixel for fdpa
                if(options.facebook.dpaPixelId !== "") {
                    if(options.facebook.advancedMatching.length === 0) {
                        fbq('init', options.facebook.dpaPixelId);
                    } else {
                        fbq('init', options.facebook.dpaPixelId, options.facebook.advancedMatching);
                    }
                }

                initialized = true;

                Utils.fireStaticEvents('facebook');

            },

            fireEvent: function (name, data) {

                if (!initialized || !this.isEnabled()) {
                    return false;
                }

                data.delay = data.delay || 0;
                data.params = data.params || {};

                if (data.delay === 0) {

                    fireEvent(name, data);

                } else {

                    setTimeout(function (name, params) {
                        fireEvent(name, params);
                    }, data.delay * 1000, name, data);

                }

                return true;

            },

            onAdSenseEvent: function () {

                if (initialized && this.isEnabled()) {
                    if(options.facebook.adSenseEventEnabled) {
                        this.fireEvent('AdSense', {
                            params: Utils.copyProperties(options.facebook.contentParams, {})
                        });
                    }


                    $.each(options.dynamicEventsTriggers, function (triggerType, events) {
                        $.each(events, function (eventId, triggers) {
                            switch (triggerType) {
                                case 'ad_sense_click':
                                    Utils.fireDynamicEvent(eventId);
                                    break;
                            }
                        });
                    });
                }

            },

            onClickEvent: function (params) {

                if (initialized && this.isEnabled() && options.facebook.clickEventEnabled) {
                    this.fireEvent('ClickEvent', {
                        params: Utils.copyProperties(options.facebook.contentParams, params)
                    });
                }

            },

            onWatchVideo: function (params) {

                if (initialized && this.isEnabled()) {
                    if(options.facebook.watchVideoEnabled) {
                        this.fireEvent('WatchVideo', {
                            params: Utils.copyProperties(options.facebook.contentParams, params)
                        });
                    }
                    if(params.event_trigger == "play") {
                        $.each(options.dynamicEventsTriggers, function (triggerType, events) {
                            $.each(events, function (eventId, triggers) {
                                switch (triggerType) {
                                    case 'video_play':
                                        Utils.fireDynamicEvent(eventId);
                                        break;
                                }

                            });
                        });
                    }

                }

            },

            onCommentEvent: function () {

                if (initialized && this.isEnabled() && options.facebook.commentEventEnabled) {

                    this.fireEvent('Comment', {
                        params: Utils.copyProperties(options.facebook.contentParams, {})
                    });

                }

            },

            onFormEvent: function (params) {

                if (initialized && this.isEnabled() && options.facebook.formEventEnabled) {

                    this.fireEvent('Form', {
                        params: Utils.copyProperties(options.facebook.contentParams, params)
                    });

                }

            },

            onDownloadEvent: function (params) {

                if (initialized && this.isEnabled() && options.facebook.downloadEnabled) {

                    this.fireEvent('Download', {
                        params: Utils.copyProperties(options.facebook.contentParams, params)
                    });

                }

            },

            onWooAddToCartOnButtonEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('facebook')) {

                        this.fireEvent('AddToCart', {
                            params: Utils.copyProperties(window.pysWooProductData[product_id]['facebook'], {})
                        });

                    }
                }

            },

            onWooAddToCartOnSingleEvent: function (product_id, qty, is_variable, is_external, $form) {

                window.pysWooProductData = window.pysWooProductData || [];

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('facebook')) {

                        if (is_variable && !options.facebook.wooVariableAsSimple) {
                            product_id = parseInt($form.find('input[name="variation_id"]').val());
                        }

                        var params = Utils.copyProperties(window.pysWooProductData[product_id]['facebook'], {});

                        // maybe customize value option
                        if (options.woo.addToCartOnButtonValueEnabled && options.woo.addToCartOnButtonValueOption !== 'global') {
                            params.value = params.value * qty;
                        }

                        // only when non Facebook for WooCommerce logic used
                        if (params.hasOwnProperty('contents')) {
                            params.contents[0].quantity = qty;
                        }

                        var event_name = is_external ? options.woo.affiliateEventName : 'AddToCart';

                        this.fireEvent(event_name, {
                            params: params
                        });

                    }
                }

            },

            onWooRemoveFromCartEvent: function (cart_item_hash) {

                window.pysWooRemoveFromCartData = window.pysWooRemoveFromCartData || [];

                if (window.pysWooRemoveFromCartData[cart_item_hash].hasOwnProperty('facebook')) {

                    this.fireEvent('RemoveFromCart', {
                        params: Utils.copyProperties(window.pysWooRemoveFromCartData[cart_item_hash]['facebook'], {})
                    });

                }

            },

            onWooAffiliateEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('facebook')) {

                        this.fireEvent(options.woo.affiliateEventName, {
                            params: Utils.copyProperties(window.pysWooProductData[product_id]['facebook'], {})
                        });

                    }
                }

            },

            onWooPayPalEvent: function () {

                window.pysWooPayPalData = window.pysWooPayPalData || [];

                if (window.pysWooPayPalData.hasOwnProperty('facebook')) {
                    this.fireEvent(options.woo.paypalEventName, {
                        params: Utils.copyProperties(window.pysWooPayPalData['facebook'], options.facebook.contentParams)
                    });
                }

            },

            onEddAddToCartOnButtonEvent: function (download_id, price_index, qty) {

                if (window.pysEddProductData.hasOwnProperty(download_id)) {

                    var index;

                    if (price_index) {
                        index = download_id + '_' + price_index;
                    } else {
                        index = download_id;
                    }

                    if (window.pysEddProductData[download_id].hasOwnProperty(index)) {
                        if (window.pysEddProductData[download_id][index].hasOwnProperty('facebook')) {

                            var params = Utils.copyProperties(window.pysEddProductData[download_id][index]['facebook'], {});

                            // maybe customize value option
                            if (options.edd.addToCartOnButtonValueEnabled && options.edd.addToCartOnButtonValueOption !== 'global') {
                                params.value = params.value * qty;
                            }

                            // update contents qty param
                            var contents = JSON.parse(params.contents);
                            contents[0].quantity = qty;
                            params.contents = JSON.stringify(contents);

                            this.fireEvent('AddToCart', {
                                params: params
                            });

                        }
                    }

                }

            },

            onEddRemoveFromCartEvent: function (item) {

                if (item.hasOwnProperty('facebook')) {

                    this.fireEvent('RemoveFromCart', {
                        params: Utils.copyProperties(item['facebook'], {})
                    });

                }

            }

        };

    }(options);

    var Analytics = function (options) {

        var initialized = false;

        /**
         * Fires event
         *
         * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/sending-data
         * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/events
         * @link: https://developers.google.com/gtagjs/reference/event
         * @link: https://developers.google.com/gtagjs/reference/parameter
         *
         * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/custom-dims-mets
         *
         * @param name
         * @param data
         */
        function fireEvent(name, data) {

            var eventParams = Utils.copyProperties(data, {});
            var requestParams = Utils.getRequestParams();

            Utils.copyProperties(requestParams, eventParams);

            var _fireEvent = function (tracking_id) {

                var params = Utils.copyProperties(eventParams, { send_to: tracking_id });

                if (options.debug) {
                    console.log('[Google Analytics #' + tracking_id + '] ' + name, params);
                }

                gtag('event', name, params);

            };

            options.ga.trackingIds.forEach(function (tracking_id) {
                _fireEvent(tracking_id);
            });

        }

        function normalizeEventName(eventName) {

            var matches = {
                ViewContent: 'view_item',
                AddToCart: 'add_to_cart',
                AddToWishList: 'add_to_wishlist',
                InitiateCheckout: 'begin_checkout',
                Purchase: 'purchase',
                Lead: 'generate_lead',
                CompleteRegistration: 'sign_up',
                AddPaymentInfo: 'set_checkout_option'
            };

            return matches.hasOwnProperty(eventName) ? matches[eventName] : eventName;

        }

        /**
         * Public API
         */
        return {

            isEnabled: function () {
                return options.hasOwnProperty('ga');
            },

            disable: function () {
                initialized = false;
            },

            loadPixel: function () {

                if (initialized || !this.isEnabled() || !Utils.consentGiven('analytics')) {
                    return;
                }

                Utils.loadGoogleTag(options.ga.trackingIds[0]);

                var cd = {
                    'dimension1': 'event_hour',
                    'dimension2': 'event_day',
                    'dimension3': 'event_month'
                };

                // configure Dynamic Remarketing CDs
                if (options.ga.retargetingLogic === 'ecomm') {
                    cd.dimension4 = 'ecomm_prodid';
                    cd.dimension5 = 'ecomm_pagetype';
                    cd.dimension6 = 'ecomm_totalvalue';
                } else {
                    cd.dimension4 = 'dynx_itemid';
                    cd.dimension5 = 'dynx_pagetype';
                    cd.dimension6 = 'dynx_totalvalue';
                }

                var config = {
                    'link_attribution': options.ga.enhanceLinkAttr,
                    'anonymize_ip': options.ga.anonimizeIP,
                    'custom_map': cd
                };

                // Cross-Domain tracking
                if (options.ga.crossDomainEnabled) {
                    config.linker = {
                        accept_incoming: options.ga.crossDomainAcceptIncoming,
                        domains: options.ga.crossDomainDomains
                    };
                }

                // configure tracking ids
                options.ga.trackingIds.forEach(function (trackingId) {
                    gtag('config', trackingId, config);
                });

                initialized = true;

                Utils.fireStaticEvents('ga');
                $( document).trigger( "analytics_initialized")
            },

            fireEvent: function (name, data) {

                if (!initialized || !this.isEnabled()) {
                    return false;
                }

                data.delay = data.delay || 0;
                data.params = data.params || {};

                if (data.delay === 0) {

                    fireEvent(name, data.params);

                } else {

                    setTimeout(function (name, params) {
                        fireEvent(name, params);
                    }, data.delay * 1000, name, data.params);

                }

                return true;

            },

            onAdSenseEvent: function () {
                // not supported
            },

            onClickEvent: function (action, params) {

                if (initialized && this.isEnabled() && options.ga.clickEventEnabled) {

                    this.fireEvent(params.link_type, {
                        params: {
                            event_category: 'ClickEvent',
                            event_label: action,
                            non_interaction: options.ga.clickEventNonInteractive
                        }
                    });

                }

            },

            onWatchVideo: function (params) {

                if (initialized && this.isEnabled() && options.ga.watchVideoEnabled) {

                    this.fireEvent(params.event_trigger, {
                        params: {
                            event_category: 'WatchVideo',
                            event_label: params.video_title,
                            non_interaction: options.ga.watchVideoEventNonInteractive
                        }
                    });

                }

            },

            onCommentEvent: function () {

                if (initialized && this.isEnabled() && options.ga.commentEventEnabled) {

                    this.fireEvent(pysOptions.postType + ' comment', {
                        params: {
                            event_category: 'Comment',
                            event_label: document.location.href,
                            non_interaction: options.ga.commentEventNonInteractive
                        }
                    });

                }

            },

            onFormEvent: function (params) {

                if (initialized && this.isEnabled() && options.ga.formEventEnabled) {

                    var action = {
                        class: (typeof params.form_class != 'undefined') ? 'class: ' + params.form_class : '',
                        id: (typeof params.form_id != 'undefined') ? 'id: ' + params.form_id : ''
                    };

                    this.fireEvent(action.class + ' ' + action.id, {
                        params: {
                            event_category: 'Form',
                            event_label: params.form_submit_label,
                            non_interaction: options.ga.formEventNonInteractive
                        }
                    });

                }

            },

            onDownloadEvent: function (params) {

                if (initialized && this.isEnabled() && options.ga.downloadEnabled) {

                    this.fireEvent(params.download_url, {
                        params: {
                            event_category: 'Download',
                            event_label: params.download_name,
                            non_interaction: options.ga.downloadEventNonInteractive
                        }
                    });

                }

            },

            onWooAddToCartOnButtonEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('ga')) {

                        this.fireEvent('add_to_cart', {
                            params: window.pysWooProductData[product_id]['ga']
                        });

                    }
                }

            },

            onWooAddToCartOnSingleEvent: function (product_id, qty, is_variable, is_external, $form) {

                window.pysWooProductData = window.pysWooProductData || [];

                if (is_variable) {
                    product_id = parseInt($form.find('input[name="variation_id"]').val());
                }

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('ga')) {

                        var params = Utils.copyProperties(window.pysWooProductData[product_id]['ga'], {});

                        // maybe customize value option
                        if (options.woo.addToCartOnButtonValueEnabled && options.woo.addToCartOnButtonValueOption !== 'global') {
                            params.items[0].price = params.items[0].price * qty;
                        }

                        // update items qty param
                        params.items[0].quantity = qty;

                        var eventName = is_external ? options.woo.affiliateEventName : 'add_to_cart';
                        eventName = normalizeEventName(eventName);

                        this.fireEvent(eventName, {
                            params: params
                        });

                    }
                }

            },

            onWooCheckoutProgressStep: function (step) {

                window.pysWooCheckoutProgress = window.pysWooCheckoutProgress || [];
                if (window.pysWooCheckoutProgress.hasOwnProperty(step)) {

                    this.fireEvent('checkout_progress', {
                        params: Utils.copyProperties(window.pysWooCheckoutProgress[step].data, {})
                    });

                }

            },

            onWooSelectContent: function (params) {
                this.fireEvent('select_content', {
                    params: params
                });
            },

            onWooRemoveFromCartEvent: function (cart_item_hash) {

                window.pysWooRemoveFromCartData = window.pysWooRemoveFromCartData || [];

                if (window.pysWooRemoveFromCartData[cart_item_hash].hasOwnProperty('ga')) {

                    this.fireEvent('remove_from_cart', {
                        params: Utils.copyProperties(window.pysWooRemoveFromCartData[cart_item_hash]['ga'], {})
                    });

                }

            },

            onWooAffiliateEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('ga')) {

                        var eventName = normalizeEventName(options.woo.affiliateEventName);

                        this.fireEvent(eventName, {
                            params: window.pysWooProductData[product_id]['ga']
                        });

                    }
                }

            },

            onWooPayPalEvent: function () {

                eventName = normalizeEventName(options.woo.paypalEventName);

                window.pysWooPayPalData = window.pysWooPayPalData || [];

                if (window.pysWooPayPalData.hasOwnProperty('ga')) {
                    this.fireEvent(eventName, {
                        params: Utils.copyProperties(window.pysWooPayPalData['ga'], {})
                    });
                }

            },

            onEddAddToCartOnButtonEvent: function (download_id, price_index, qty) {

                if (window.pysEddProductData.hasOwnProperty(download_id)) {

                    var index;

                    if (price_index) {
                        index = download_id + '_' + price_index;
                    } else {
                        index = download_id;
                    }

                    if (window.pysEddProductData[download_id].hasOwnProperty(index)) {
                        if (window.pysEddProductData[download_id][index].hasOwnProperty('ga')) {

                            var params = Utils.copyProperties(window.pysEddProductData[download_id][index]['ga'], {});

                            // update items qty param
                            params.items[0].quantity = qty;

                            this.fireEvent('add_to_cart', {
                                params: params
                            });

                        }
                    }

                }

            },

            onEddRemoveFromCartEvent: function (item) {

                if (item.hasOwnProperty('ga')) {

                    this.fireEvent('remove_from_cart', {
                        params: Utils.copyProperties(item['ga'], {})
                    });

                }

            }

        };

    }(options);

    var GAds = function (options) {

        var initialized = false;

        /**
         * Fires event
         *
         * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/sending-data
         * @link: https://developers.google.com/analytics/devguides/collection/gtagjs/events
         * @link: https://developers.google.com/gtagjs/reference/event
         * @link: https://developers.google.com/gtagjs/reference/parameter
         */
        function fireEvent(name, data) {
            var _params = data.params;
            var ids = data.ids;
            var conversion_labels = data.conversion_labels;

            var _fireEvent = function (conversion_id,event_name) {

                params = Utils.copyProperties(_params, { send_to: conversion_id });
                if("conversion" === event_name) {
                    delete params.items;
                }
                if (options.debug) {
                    console.log('[Google Ads #' + conversion_id + '] ' + event_name, params);
                }

                gtag('event', event_name, params);

            };

            if(conversion_labels.length > 0) {  // if custom event have conversion_label
                conversion_labels.forEach(function (conversion_id) {
                    _fireEvent(conversion_id,name);
                });
            } else { // if normal event have conversion_label or custom without conversion_label

                options.google_ads.conversion_ids.forEach(function (conversion_id) { // send main event
                    _fireEvent(conversion_id,name);
                });

                if (ids.length) {
                    ids.forEach(function (conversion_id) {  // send conversion event next to main(not use for custom events)
                        _fireEvent(conversion_id,"conversion");
                    });
                }
            }
        }

        function normalizeEventName(eventName) {

            var matches = {
                ViewContent: 'view_item',
                AddToCart: 'add_to_cart',
                AddToWishList: 'add_to_wishlist',
                InitiateCheckout: 'begin_checkout',
                Purchase: 'purchase',
                Lead: 'generate_lead',
                CompleteRegistration: 'sign_up',
                AddPaymentInfo: 'set_checkout_option'
            };

            return matches.hasOwnProperty(eventName) ? matches[eventName] : eventName;

        }

        /**
         * Public API
         */
        return {

            isEnabled: function () {
                return options.hasOwnProperty('google_ads');
            },

            disable: function () {
                initialized = false;
            },

            loadPixel: function () {

                if (initialized || !this.isEnabled() || !Utils.consentGiven('google_ads')) {
                    return;
                }

                Utils.loadGoogleTag(options.google_ads.conversion_ids[0]);

                // configure conversion ids
                options.google_ads.conversion_ids.forEach(function (conversion_id) {
                    gtag('config', conversion_id);
                });

                initialized = true;

                Utils.fireStaticEvents('google_ads');

            },

            fireEvent: function (name, data) {

                if (!initialized || !this.isEnabled()) {
                    return false;
                }

                data.delay = data.delay || 0;
                data.params = data.params || {};
                data.ids = data.ids || [];
                data.conversion_labels = data.conversion_labels || [];

                if (data.delay === 0) {
                    fireEvent(name, data);
                } else {
                    setTimeout(function (name, data) {
                        fireEvent(name, data);
                    }, data.delay * 1000, name, data);
                }

                return true;

            },

            onAdSenseEvent: function () {
                // not supported
            },

            onClickEvent: function (action, params) {
                //disabled
            },

            onWatchVideo: function (params) {

                if (initialized && this.isEnabled() && options.google_ads.watchVideoEnabled) {

                    this.fireEvent(params.event_trigger, {
                        params: {
                            event_category: 'WatchVideo',
                            event_label: params.video_title
                        }
                    });

                }

            },

            onCommentEvent: function () {

                if (initialized && this.isEnabled() && options.google_ads.commentEventEnabled) {

                    this.fireEvent(pysOptions.postType + ' comment', {
                        params: {
                            event_category: 'Comment',
                            event_label: document.location.href
                        }
                    });

                }

            },

            onFormEvent: function (params) {

                if (initialized && this.isEnabled() && options.google_ads.formEventEnabled) {

                    var action = {
                        class: (typeof params.form_class != 'undefined') ? 'class: ' + params.form_class : '',
                        id: (typeof params.form_id != 'undefined') ? 'id: ' + params.form_id : ''
                    };

                    this.fireEvent(action.class + ' ' + action.id, {
                        params: {
                            event_category: 'Form',
                            event_label: params.form_submit_label
                        }
                    });

                }

            },

            onDownloadEvent: function (params) {

                if (initialized && this.isEnabled() && options.google_ads.downloadEnabled) {

                    this.fireEvent(params.download_url, {
                        params: {
                            event_category: 'Download',
                            event_label: params.download_name
                        }
                    });

                }

            },

            onWooAddToCartOnButtonEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('google_ads')) {

                        this.fireEvent('add_to_cart', {
                            params: window.pysWooProductData[product_id]['google_ads']['params'],
                            ids: window.pysWooProductData[product_id]['google_ads']['ids'],
                            conversion_labels: window.pysWooProductData[product_id]['google_ads']['conversion_labels']
                        });

                    }
                }

            },

            onWooAddToCartOnSingleEvent: function (product_id, qty, is_variable, is_external, $form) {

                window.pysWooProductData = window.pysWooProductData || [];

                if (is_variable) {
                    product_id = parseInt($form.find('input[name="variation_id"]').val());
                }
                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('google_ads')) {

                        var params = Utils.copyProperties(window.pysWooProductData[product_id]['google_ads']["params"], {});
                        var ids = window.pysWooProductData[product_id]['google_ads']["ids"];
                        var conversion_labels = window.pysWooProductData[product_id]['google_ads']["conversion_labels"];
                        // maybe customize value option
                        if (options.woo.addToCartOnButtonValueEnabled && options.woo.addToCartOnButtonValueOption !== 'global') {
                            params.items[0].price = params.items[0].price * qty;
                        }

                        // update items qty param
                        params.items[0].quantity = qty;

                        var eventName = is_external ? options.woo.affiliateEventName : 'add_to_cart';
                        eventName = normalizeEventName(eventName);

                        this.fireEvent(eventName, {
                            params: params,
                            ids:ids,
                            conversion_labels:conversion_labels
                        });

                    }
                }

            },

            onWooRemoveFromCartEvent: function (cart_item_hash) {

                window.pysWooRemoveFromCartData = window.pysWooRemoveFromCartData || [];

                if (window.pysWooRemoveFromCartData[cart_item_hash].hasOwnProperty('google_ads')) {

                    this.fireEvent('remove_from_cart', {
                        params: Utils.copyProperties(window.pysWooRemoveFromCartData[cart_item_hash]['google_ads'], {})
                    });

                }

            },

            onWooAffiliateEvent: function (product_id) {

                if (window.pysWooProductData.hasOwnProperty(product_id)) {
                    if (window.pysWooProductData[product_id].hasOwnProperty('google_ads')) {

                        var eventName = normalizeEventName(options.woo.affiliateEventName);

                        this.fireEvent(eventName, {
                            params: window.pysWooProductData[product_id]['google_ads']
                        });

                    }
                }

            },

            onWooPayPalEvent: function () {

                eventName = normalizeEventName(options.woo.paypalEventName);

                window.pysWooPayPalData = window.pysWooPayPalData || [];

                if (window.pysWooPayPalData.hasOwnProperty('google_ads')) {
                    this.fireEvent(eventName, {
                        params: Utils.copyProperties(window.pysWooPayPalData['google_ads'], {})
                    });
                }

            },

            onEddAddToCartOnButtonEvent: function (download_id, price_index, qty) {

                if (window.pysEddProductData.hasOwnProperty(download_id)) {

                    var index;

                    if (price_index) {
                        index = download_id + '_' + price_index;
                    } else {
                        index = download_id;
                    }

                    if (window.pysEddProductData[download_id].hasOwnProperty(index)) {
                        if (window.pysEddProductData[download_id][index].hasOwnProperty('google_ads')) {

                            var params = Utils.copyProperties(window.pysEddProductData[download_id][index]['google_ads']['params'], {});
                            var ids = window.pysEddProductData[download_id][index]['google_ads']['ids'];
                            var conversion_labels = window.pysEddProductData[download_id][index]['google_ads']['conversion_labels'];
                            // update items qty param
                            params.items[0].quantity = qty;

                            this.fireEvent('add_to_cart', {
                                params: params,
                                ids: ids,
                                conversion_labels: conversion_labels
                            });

                        }
                    }

                }

            },

            onEddRemoveFromCartEvent: function (item) {

                if (item.hasOwnProperty('google_ads')) {

                    this.fireEvent('remove_from_cart', {
                        params: Utils.copyProperties(item['google_ads'], {})
                    });

                }

            }

        };

    }(options);

    window.pys = window.pys || {};
    window.pys.Facebook = Facebook;
    window.pys.Analytics = Analytics;
    window.pys.GAds = GAds;
    window.pys.Utils = Utils;

    $(document).ready(function () {



        var Pinterest = Utils.setupPinterestObject();
        var Bing = Utils.setupBingObject();

        Utils.manageCookies();
        Utils.initializeRequestParams();
        Utils.setupGdprCallbacks();

        // setup Click Event
        if (options.clickEventEnabled) {

            $(document).onFirst('click', 'a, button, input[type="button"], input[type="submit"]', function (e) {

                if (!e.hasOwnProperty('originalEvent')) {
                    return;
                };

                var $elem = $(this),
                    params = {},
                    ga_action = 'Button',
                    gads_action = 'Button',
                    bing_action = 'Button';


                if ($elem.hasClass('pys_block')) {
                    return; // avoiding fake double clicks from Affiliate event
                }

                if ($elem.is('a')) {

                    var href = $elem.attr('href');

                    // fixes #112
                    if (typeof href !== "string") {
                        return;
                    }

                    href = href.trim();

                    if($elem.hasClass("add_to_cart_button")) { // add_to_cart_button send params like button. Maybe need a global solution
                        params.link_type = 'Button';
                        params.tag_text = $elem.text();

                        ga_action = $elem.text();
                        gads_action = $elem.text();
                        bing_action = $elem.text();
                    } else if (href.startsWith('tel:')) {// privacy issue

                        params.link_type = 'Tel';
                        params.tag_text = '(phone number hidden)';

                        ga_action = '(phone number hidden)';
                        gads_action = '(phone number hidden)';
                        bing_action = '(phone number hidden)';

                    } else if (href.startsWith('mailto:')) {

                        params.link_type = 'Email';
                        params.tag_text = '(email address hidden)';

                        ga_action = '(email address hidden)';
                        gads_action = '(email address hidden)';
                        bing_action = '(email address hidden)';

                    } else if (href.startsWith('http')) {

                        // link type
                        var host = $elem.context != undefined ? $elem.context.host : $elem[0].host;

                        if (document.location.host == host) {
                            params.link_type = 'Internal Link';
                        } else {
                            params.link_type = 'Outbound Link';
                        };

                        params.tag_text = $elem.text();
                        ga_action = href;
                        gads_action = href;
                        bing_action = href;

                        params.URL = href;

                    }


                } else if ($elem.is('button')) {
                    params.link_type = 'Button';
                    params.tag_text = $elem.text();

                    ga_action = $elem.text(),
                        gads_action = $elem.text(),
                        bing_action = $elem.text();
                } else if ($elem.is('input[type="button"]')) {
                    params.link_type = 'input.button';
                    params.tag_text = $elem.val();

                    ga_action = $elem.val(),
                        gads_action = $elem.val(),
                        bing_action = $elem.val();
                } else if ($elem.is('input[type="submit"]')) {
                    params.link_type = 'input.submit';
                    params.tag_text = $elem.val();

                    ga_action = $elem.val(),
                        gads_action = $elem.val(),
                        bing_action = $elem.val();
                } else {
                    return;
                }

                params.tag_text = Utils.filterEmails(params.tag_text);

                Facebook.onClickEvent(params);
                Analytics.onClickEvent(ga_action, params);
                GAds.onClickEvent(gads_action, params);
                Pinterest.onClickEvent(params);
                Bing.onClickEvent(bing_action, params);

            });

        }

        // setup AdSense Event
        if (options.adSenseEventEnabled) {

            var isOverGoogleAd = false;

            $(document)
                .on('mouseover', 'ins > ins > iframe', function () {
                    isOverGoogleAd = true;
                })
                .on('mouseout', 'iframe', function () {
                    isOverGoogleAd = false;
                });

            $(window)
                .blur(function () {
                    if (isOverGoogleAd) {
                        Facebook.onAdSenseEvent();
                        Analytics.onAdSenseEvent();
                        GAds.onAdSenseEvent();
                        Pinterest.onAdSenseEvent();
                        Bing.onAdSenseEvent();
                    }
                })
                .focus();

        }

        // setup Dynamic events
        $.each(options.dynamicEventsTriggers, function (triggerType, events) {

            $.each(events, function (eventId, triggers) {

                switch (triggerType) {
                    case 'url_click':
                        //@see: Utils.setupURLClickEvents()
                        break;

                    case 'css_click':
                        Utils.setupCSSClickEvents(eventId, triggers);
                        break;

                    case 'css_mouseover':
                        Utils.setupMouseOverClickEvents(eventId, triggers);
                        break;

                    case 'scroll_pos':
                        Utils.setupScrollPosEvents(eventId, triggers);
                        break;
                    case 'comment':
                        Utils.setupCommentEvents(eventId, triggers);
                        break;
                }

            });

        });

        // setup WooCommerce events
        if (options.woo.enabled) {

            // WooCommerce AddToCart
            if (options.woo.addToCartOnButtonEnabled) {

                // Loop, any kind of "simple" product, except external
                $('.add_to_cart_button:not(.product_type_variable)').click(function (e) {

                    var product_id = $(this).data('product_id');

                    if (typeof product_id !== 'undefined') {
                        Facebook.onWooAddToCartOnButtonEvent(product_id);
                        Analytics.onWooAddToCartOnButtonEvent(product_id);
                        GAds.onWooAddToCartOnButtonEvent(product_id);
                        Pinterest.onWooAddToCartOnButtonEvent(product_id);
                        Bing.onWooAddToCartOnButtonEvent(product_id);
                    }

                });

                // Single Product
                $('.single_add_to_cart_button').click(function (e) {

                    var $button = $(this);

                    if ($button.hasClass('disabled')) {
                        return;
                    }

                    var $form = $button.closest('form');

                    var is_variable = false;
                    var is_external = false;

                    if ($form.length === 0) {
                        is_external = true;
                    } else if ($form.hasClass('variations_form')) {
                        is_variable = true;
                    }

                    var product_id;
                    var qty;

                    if (is_variable) {
                        product_id = parseInt($form.find('*[name="add-to-cart"]').val());
                        var qtyTag = $form.find('input[name="quantity"]');
                        if(qtyTag.length <= 0) {
                            qtyTag = $form.find('select[name="quantity"]');
                        }
                        qty = parseInt(qtyTag.val());
                    } else if (is_external) {
                        product_id = options.woo.singleProductId;
                        qty = 1;
                    } else {
                        product_id = parseInt($form.find('*[name="add-to-cart"]').val());
                        var qtyTag = $form.find('input[name="quantity"]');
                        if(qtyTag.length <= 0) {
                            qtyTag = $form.find('select[name="quantity"]');
                        }
                        qty = parseInt(qtyTag.val());
                    }

                    Facebook.onWooAddToCartOnSingleEvent(product_id, qty, is_variable, is_external, $form);
                    Analytics.onWooAddToCartOnSingleEvent(product_id, qty, is_variable, is_external, $form);
                    GAds.onWooAddToCartOnSingleEvent(product_id, qty, is_variable, is_external, $form);
                    Pinterest.onWooAddToCartOnSingleEvent(product_id, qty, is_variable, is_external, $form);
                    Bing.onWooAddToCartOnSingleEvent(product_id, qty, is_variable, is_external, $form);

                });

            }

            // WooCommerce Affiliate
            if (options.woo.affiliateEnabled) {

                // Loop, external
                $('.product_type_external').click(function (e) {

                    var product_id = $(this).data('product_id');

                    if (typeof product_id !== 'undefined') {
                        Facebook.onWooAffiliateEvent(product_id);
                        Analytics.onWooAffiliateEvent(product_id);
                        GAds.onWooAffiliateEvent(product_id);
                        Pinterest.onWooAffiliateEvent(product_id);
                        Bing.onWooAffiliateEvent(product_id);
                    }

                });

            }

            // WooCommerce RemoveFromCart
            if (options.woo.removeFromCartEnabled) {

                $('body').on('click', options.woo.removeFromCartSelector, function (e) {

                    var $a = $(e.currentTarget),
                        href = $a.attr('href');

                    // extract cart item hash from remove button URL
                    var regex = new RegExp("[\\?&]remove_item=([^&#]*)"),
                        results = regex.exec(href);

                    if (results !== null) {

                        var item_hash = results[1];
                        window.pysWooRemoveFromCartData = window.pysWooRemoveFromCartData || [];

                        if (window.pysWooRemoveFromCartData.hasOwnProperty(item_hash)) {
                            Facebook.onWooRemoveFromCartEvent(item_hash);
                            Analytics.onWooRemoveFromCartEvent(item_hash);
                            GAds.onWooRemoveFromCartEvent(item_hash);
                            Pinterest.onWooRemoveFromCartEvent(item_hash);
                            Bing.onWooRemoveFromCartEvent(item_hash);
                        }

                    }

                });

            }

            // WooCommerce PayPal
            if (options.woo.payPalEnabled) {

                // Non-default binding used to avoid situations when some code in external js
                // stopping events propagation, eg. returns false, and our handler will never called
                $(document).onFirst('submit click', '#place_order', function (e) {

                    var method = $('form[name="checkout"] input[name="payment_method"]:checked').val();

                    if (method !== 'paypal') {
                        return;
                    }

                    Facebook.onWooPayPalEvent();
                    Analytics.onWooPayPalEvent();
                    GAds.onWooPayPalEvent();
                    Pinterest.onWooPayPalEvent();
                    Bing.onWooPayPalEvent();

                });

            }

            // WooCommerce checkout progress
            if (options.woo.checkoutProgressEnabled) {

                if(window.pysWooCheckoutProgress.hasOwnProperty("first_name")) {

                    $(document).on("change",".woocommerce-validated #billing_first_name",function () {
                        Analytics.onWooCheckoutProgressStep("first_name");
                    });
                }
                if(window.pysWooCheckoutProgress.hasOwnProperty("last_name")) {

                    $(document).on("change",".woocommerce-validated #billing_last_name",function () {
                        Analytics.onWooCheckoutProgressStep("last_name");
                    });
                }

                if(window.pysWooCheckoutProgress.hasOwnProperty("email")) {

                    $(document).on("change",".woocommerce-validated #billing_email",function () {
                        Analytics.onWooCheckoutProgressStep("email");
                    });
                }
                if(window.pysWooCheckoutProgress.hasOwnProperty("place_order")) {
                    $(document).onFirst('submit click', '#place_order', function () {
                        Analytics.onWooCheckoutProgressStep("place_order");
                    });
                }
            }


            // WooCommerce
            if(options.woo.selectContentEnabled) {
                $('.product.type-product a.woocommerce-loop-product__link').onFirst('click', function (evt) {
                    var productId = $(this).parent().find("a.add_to_cart_button").attr("data-product_id");
                    var param = window.pysWooSelectContentData[productId];
                    Analytics.onWooSelectContent(param);
                });
            }
        }

        // setup EDD events
        if (options.edd.enabled) {

            // EDD AddToCart
            if (options.edd.addToCartOnButtonEnabled) {

                $('form.edd_download_purchase_form .edd-add-to-cart').click(function (e) {

                    var $button = $(this);
                    var $form = $button.closest('form');
                    var variable_price = $button.data('variablePrice'); // yes/no
                    var price_mode = $button.data('priceMode'); // single/multi
                    var ids = [];
                    var quantities = [];
                    var qty;
                    var id;

                    if (variable_price === 'yes' && price_mode === 'multi') {

                        id = $form.find('input[name="download_id"]').val();

                        // get selected variants
                        $.each($form.find('input[name="edd_options[price_id][]"]:checked'), function (i, el) {
                            ids.push(id + '_' + $(el).val());
                        });

                        // get qty for selected variants
                        $.each(ids, function (i, variant_id) {

                            var variant_index = variant_id.split('_', 2);
                            qty = $form.find('input[name="edd_download_quantity_' + variant_index[1] + '"]').val();

                            if (typeof qty !== 'undefined') {
                                quantities.push(qty);
                            } else {
                                quantities.push(1);
                            }

                        });

                    } else if (variable_price === 'yes' && price_mode === 'single') {

                        id = $form.find('input[name="download_id"]').val();
                        ids.push(id + '_' + $form.find('input[name="edd_options[price_id][]"]:checked').val());

                        qty = $form.find('input[name="edd_download_quantity"]').val();

                        if (typeof qty !== 'undefined') {
                            quantities.push(qty);
                        } else {
                            quantities.push(1);
                        }

                    } else {

                        ids.push($button.data('downloadId'));

                        qty = $form.find('input[name="edd_download_quantity"]').val();

                        if (typeof qty !== 'undefined') {
                            quantities.push(qty);
                        } else {
                            quantities.push(1);
                        }


                    }

                    // fire event for each download/variant
                    $.each(ids, function (i, download_id) {

                        var q = parseInt(quantities[i]);
                        var variant_index = download_id.toString().split('_', 2);
                        var price_index;

                        if (variant_index.length === 2) {
                            download_id = variant_index[0];
                            price_index = variant_index[1];
                        }

                        Facebook.onEddAddToCartOnButtonEvent(download_id, price_index, q);
                        Analytics.onEddAddToCartOnButtonEvent(download_id, price_index, q);
                        GAds.onEddAddToCartOnButtonEvent(download_id, price_index, q);
                        Pinterest.onEddAddToCartOnButtonEvent(download_id, price_index, q);
                        Bing.onEddAddToCartOnButtonEvent(download_id, price_index, q);

                    });

                });

            }

            // EDD RemoveFromCart
            if (options.edd.removeFromCartEnabled) {

                $('form#edd_checkout_cart_form .edd_cart_remove_item_btn').click(function (e) {

                    var href = $(this).attr('href');
                    var key = href.substring(href.indexOf('=') + 1).charAt(0);

                    window.pysEddRemoveFromCartData = window.pysEddRemoveFromCartData || [];

                    if (window.pysEddRemoveFromCartData[key]) {

                        var item = window.pysEddRemoveFromCartData[key];

                        Facebook.onEddRemoveFromCartEvent(item);
                        Analytics.onEddRemoveFromCartEvent(item);
                        GAds.onEddRemoveFromCartEvent(item);
                        Pinterest.onEddRemoveFromCartEvent(item);
                        Bing.onEddRemoveFromCartEvent(item);

                    }

                });

            }

        }

        Utils.setupURLClickEvents();

        // setup Comment Event
        if (options.commentEventEnabled) {

            $('form.comment-form').submit(function () {

                Facebook.onCommentEvent();
                Analytics.onCommentEvent();
                GAds.onCommentEvent();
                Pinterest.onCommentEvent();
                Bing.onCommentEvent();

            });

        }

        // setup Form Event
        if (options.formEventEnabled) {

            $(document).onFirst('submit', 'form', function (e) {

                var $form = $(this);

                // exclude WP forms
                if ($form.hasClass('comment-form') || $form.hasClass('search-form') || $form.attr('id') === 'adminbarsearch') {
                    return;
                }

                // exclude Woo forms
                if ($form.hasClass('woocommerce-product-search') || $form.hasClass('cart') || $form.hasClass('woocommerce-cart-form') ||
                    $form.hasClass('woocommerce-shipping-calculator') || $form.hasClass('checkout') || $form.hasClass('checkout_coupon')) {
                    return;
                }

                // exclude EDD forms
                if ($form.hasClass('edd_form') || $form.hasClass('edd_download_purchase_form')) {
                    return;
                }

                var params = {
                    form_id: $form.attr('id'),
                    form_class: $form.attr('class'),
                    form_submit_label: $form.find('[type="submit"]').is('input') ?
                        $form.find('[type="submit"]').val() : $form.find('[type="submit"]').text()
                };

                Facebook.onFormEvent(params);
                Analytics.onFormEvent(params);
                GAds.onFormEvent(params);
                Pinterest.onFormEvent(params);
                Bing.onFormEvent(params);

            });

            // Ninja Forms
            $(document).onFirst('nfFormSubmitResponse', function (e, data) {

                var params = {
                    form_id: data.response.data.form_id,
                    form_title: data.response.data.settings.title
                };

                Facebook.onFormEvent(params);
                Analytics.onFormEvent(params);
                GAds.onFormEvent(params);
                Pinterest.onFormEvent(params);
                Bing.onFormEvent(params);

            });

        }

        // setup DownloadDocs event
        if (options.downloadEventEnabled && options.downloadExtensions.length > 0) {

            $('body').click(function (event) {

                var el = event.srcElement || event.target;

                /* Loop up the DOM tree through parent elements if clicked element is not a link (eg: an image inside a link) */
                while (el && (typeof el.tagName === 'undefined' || el.tagName.toLowerCase() !== 'a' || !el.href)) {
                    el = el.parentNode;
                }

                if (el && el.href) {

                    var extension = Utils.getLinkExtension(el.href);
                    var track_download = false;

                    if (extension.length > 0) {

                        for (i = 0, len = options.downloadExtensions.length; i < len; ++i) {
                            if (options.downloadExtensions[i] === extension) {
                                track_download = true;
                                break;
                            }
                        }

                    }

                    if (track_download) {

                        var params = {
                            download_url: el.href,
                            download_type: extension,
                            download_name: Utils.getLinkFilename(el.href)
                        };

                        Facebook.onDownloadEvent(params);
                        Analytics.onDownloadEvent(params);
                        GAds.onDownloadEvent(params);
                        Pinterest.onDownloadEvent(params);
                        Bing.onDownloadEvent(params);

                    }

                }

            });

        }

        // load pixel APIs
        Utils.loadPixels();

    });

    // load WatchVideo event APIs
    if (options.watchVideoEnabled) {
        Utils.initYouTubeAPI();
        Utils.initVimeoAPI();
    }



}(jQuery, pysOptions);

