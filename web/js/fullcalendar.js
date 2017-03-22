(function($) {


var fc = $.fullCalendar = {};
var views = fc.views = {};


/* Defaults
-----------------------------------------------------------------------------*/

var defaults = {

	// display
	defaultView: 'month',
	aspectRatio: 1.35,
	allDayDefault: true,
	
	// time formats
	timeFormat: 'h(:mm)t', // for events
	titleFormat: {
		month: 'MMMM yyyy',
		week: "MMM d[ yyyy]{ '&#8212;'[ MMM] d yyyy}",
		day: 'dddd, MMM d, yyyy'
	},
	columnFormat: {
		month: 'ddd',
		week: 'ddd M/d',
		day: 'dddd M/d'
	},
	
	// locale
	firstDay: 1,
	monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Deciembre'],
	dayNamesShort: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
	
};

// function for adding/overriding defaults
var setDefaults = fc.setDefaults = function(d) {
	$.extend(true, defaults, d);
}



/* .fullCalendar jQuery function
-----------------------------------------------------------------------------*/

$.fn.fullCalendar = function(options) {

	// pluck the 'events' and 'eventSources' options
	var eventSources = options.eventSources || [];
	delete options.eventSources;
	if (options.events) {
		eventSources.push(options.events);
		delete options.event;
	}
	
	// first event source reserved for 'sticky' events
	eventSources.unshift([]);
	
	// initialize options
	options = $.extend(true, {},
		defaults,
		options
	);
	
	this.each(function() {
	
	
		/* Instance Initialization
		-----------------------------------------------------------------------------*/
		
		// element
		var _element = this,
			element = $(this).addClass('fc'),
			content = $("<div class='fc-content'/>").appendTo(this);
		
		// view managing
		var date = new Date(),
			viewName, view, // the current view
			prevView,
			viewInstances = {};
		
		/* View Rendering
		-----------------------------------------------------------------------------*/
		
		function changeView(v) {
			if (v != viewName) {
				prevView = view;
				if (viewInstances[v]) {
					(view = viewInstances[v]).element.show();
				}else{
					view = viewInstances[v] = $.fullCalendar.views[v](
						$("<div class='fc-view fc-view-" + v + "'/>").appendTo(content),
						options);
				}
				if (prevView && prevView.eventsChanged) {
					// if previous view's events have been changed, mark future views' events as dirty
					eventsDirtyExcept(prevView);
					prevView.eventsChanged = false;
				}
				header.find('div.fc-button-' + viewName).removeClass('fc-state-active');
				header.find('div.fc-button-' + v).addClass('fc-state-active');
				view.name = viewName = v;
				render();
				if (prevView) {
					// hide the old element AFTER the new has been rendered, preserves scrollbars
					prevView.element.hide();
				}
			}
		}
		
		function render(inc) {
			if (_element.offsetWidth !== 0) { // visible on the screen
				if (inc || !view.date || +view.date != +date) { // !view.date means it hasn't been rendered yet
					ignoreWindowResizes = true;
					view.render(date, inc || 0, function(callback) {
						// dont refetch if new view contains the same events (or a subset)
						if (!eventStart || view.visStart < eventStart || view.visEnd > eventEnd) {
							fetchEvents(callback);
						}else{
							callback(events); // no refetching
						}
					});
					ignoreWindowResizes = false;
					view.date = cloneDate(date);
				}
				else if (view.sizeDirty) {
					view.updateSize();
					view.rerenderEvents();
				}
				else if (view.eventsDirty) {
					// ensure events are rerendered if another view messed with them
					// pass in 'events' b/c event might have been added/removed
					view.clearEvents();
					view.renderEvents(events);
				}
				if (header) {
					// update title text
					header.find('h2.fc-header-title').html(view.title);
				}
				view.sizeDirty = false;
				view.eventsDirty = false;
				view.trigger('viewDisplay', _element);
			}
		}
		
		// marks other views' events as dirty
		function eventsDirtyExcept(exceptView) {
			$.each(viewInstances, function() {
				if (this != exceptView) {
					this.eventsDirty = true;
				}
			});
		}
		
		// marks other views' sizes as dirty
		function sizesDirtyExcept(exceptView) {
			$.each(viewInstances, function() {
				if (this != exceptView) {
					this.sizeDirty = true;
				}
			});
		}
		
		// called when any event objects have been added/removed/changed, rerenders
		function eventsChanged() {
			view.clearEvents();
			view.renderEvents(events);
			eventsDirtyExcept(view);
		}
		
		
		
		/* Event Sources and Fetching
		-----------------------------------------------------------------------------*/
		
		var events = [],
			eventStart, eventEnd;
		
		// Fetch from ALL sources. Clear 'events' array and populate
		function fetchEvents(callback) {
			events = [];
			eventStart = cloneDate(view.visStart);
			eventEnd = cloneDate(view.visEnd);
			var queued = eventSources.length,
				sourceDone = function() {
					if (--queued == 0) {
						if (callback) {
							callback(events);
						}
					}
				}, i=0;
			for (; i<eventSources.length; i++) {
				fetchEventSource(eventSources[i], sourceDone);
			}
		}
		
		// Fetch from a particular source. Append to the 'events' array
		function fetchEventSource(src, callback) {
			var prevViewName = view.name,
				prevDate = cloneDate(date),
				reportEvents = function(a) {
					if (prevViewName == view.name && +prevDate == +date) { // protects from fast switching
						for (var i=0; i<a.length; i++) {
							normalizeEvent(a[i], options);
							a[i].source = src;
						}
						events = events.concat(a);
						if (callback) {
							callback(a);
						}
					}
				},
				reportEventsAndPop = function(a) {
					reportEvents(a);
					header.find('.loading').hide();
				};
			if (typeof src == 'string') {
				var params = {};
				params['start'] = Math.round(eventStart.getTime() / 1000);
				params['end'] = Math.round(eventEnd.getTime() / 1000);
				params['_'] = (new Date()).getTime();
				header.find('.loading').show();
				$.getJSON(src, params, reportEventsAndPop);
			}
			else {
				reportEvents(src); // src is an array
			}
		}
		
		
		var publicMethods = {
		
			render: render,
			changeView: changeView,
			
			prev: function() {
				render(-1);
			},
			
			next: function() {
				render(1);
			},
			
			
			renderEvent: function(event, stick) { // render a new event
				normalizeEvent(event, options);
				if (!event.source) {
					if (stick) {
						(event.source = eventSources[0]).push(event);
					}
					events.push(event);
				}
				eventsChanged();
			},
			
			removeEvents: function(filter) {
				if (!filter) { // remove all
					events = [];
					// clear all array sources
					for (var i=0; i<eventSources.length; i++) {
						if (typeof eventSources[i] == 'object') {
							eventSources[i] = [];
						}
					}
				}else{
					if (!$.isFunction(filter)) { // an event ID
						var id = filter + '';
						filter = function(e) {
							return e._id == id;
						};
					}
					events = $.grep(events, filter, true);
					// remove events from array sources
					for (var i=0; i<eventSources.length; i++) {
						if (typeof eventSources[i] == 'object') {
							eventSources[i] = $.grep(eventSources[i], filter, true);
						}
					}
				}
				eventsChanged();
			},
			
			clientEvents: function(filter) {
				if ($.isFunction(filter)) {
					return $.grep(events, filter);
				}
				else if (filter) { // an event ID
					filter += '';
					return $.grep(events, function(e) {
						return e._id == filter;
					});
				}
				return events; // else, return all
			},
			
			rerenderEvents: function() {
				view.rerenderEvents(); 
			},
			
			addEventSource: function(source) {
				eventSources.push(source);
				fetchEventSource(source, function() {
					eventsChanged();
				});
			},
		
			removeEventSource: function(source) {
				eventSources = $.grep(eventSources, function(src) {
					return src != source;
				});
				eventsChanged();
			},
			
			refetchEvents: function() {
				fetchEvents(eventsChanged);
			}
			
		};
		
		$.data(this, 'fullCalendar', publicMethods);
		
		var header;
		header = $("<div class='fc-header'/>")
			.append("<h2 class='fc-header-title'/>")
			.append($('<div class="fc-button-next">&#9658;</div>').click(publicMethods['next']))
			.append($('<div class="fc-button-prev">&#9668;</div>').click(publicMethods['prev']))
			.append('<div class="loading" style="display:none"><img src="/apostrophePlugin/images/a-icon-loader.gif" /></div>')
			.prependTo(element);

		// let's begin...
		changeView(options.defaultView);
	
	});
	
	return this;
	
};


var fakeID = 0;

function normalizeEvent(event, options) {
	event._id = event._id || (event.id == undefined ? '_fc' + fakeID++ : event.id + '');
	if (event.date) {
		if (!event.start) {
			event.start = event.date;
		}
		delete event.date;
	}
	event._start = cloneDate(event.start = parseDate(event.start));
	event.end = event._end = null;
	event._end = event.end ? cloneDate(event.end) : null;
  event.allDay = options.allDayDefault;
}

views.month = function(element, options) {
	return new Grid(element, options, {
		render: function(date, delta, fetchEvents) {
			if (delta) {
				addMonths(date, delta);
				date.setDate(1);
			}
			var start = this.start = cloneDate(date, true);
			start.setDate(1);
			this.title = formatDates(
				start,
				addDays(cloneDate(this.end = addMonths(cloneDate(start), 1)), -1),
				strProp(options.titleFormat, 'month'),
				options
			);
			addDays(this.visStart = cloneDate(start), -((start.getDay() - options.firstDay + 7) % 7));
			addDays(this.visEnd = cloneDate(this.end), (7 - this.visEnd.getDay() + options.firstDay) % 7);
			var rowCnt = Math.round((this.visEnd - this.visStart) / (DAY_MS * 7));
			this.renderGrid(rowCnt, 7, strProp(options.columnFormat, 'month'), true, fetchEvents);
		}
	});
}

// rendering bugs

var tdTopBug, trTopBug, tbodyTopBug,
	tdHeightBug,
	rtlLeftDiff;


function Grid(element, options, methods) {
	
	var firstDay,
		rtl, dis, dit,  // day index sign / translate
		rowCnt, colCnt,
		colWidth,
		thead, tbody,
		cachedSegs, //...
		
	// initialize superclass
	view = $.extend(this, viewMethods, methods, {
		renderGrid: renderGrid,
		renderEvents: renderEvents,
		rerenderEvents: rerenderEvents,
		updateSize: updateSize,
		defaultEventEnd: function(event) { // calculates an end if event doesnt have one, mostly for resizing
			return cloneDate(event.start);
		},
		visEventEnd: function(event) { // returns exclusive 'visible' end, for rendering
			if (event.end) {
				var end = cloneDate(event.end);
				return (event.allDay || end.getHours() || end.getMinutes()) ? addDays(end, 1) : end;
			}else{
				return addDays(cloneDate(event.start), 1);
			}
		}
	});
	view.init(element, options);
	
	
	
	element.addClass('fc-grid').css('position', 'relative');
	if (element.disableSelection) {
		element.disableSelection();
	}

	function renderGrid(r, c, colFormat, showNumbers, fetchEvents) {
		rowCnt = r;
		colCnt = c;
		
		var month = view.start.getMonth(),
			today = clearTime(new Date()),
			s, i, j, d = cloneDate(view.visStart);
		
		// update option-derived variables
		firstDay = options.firstDay;
		dis = 1;
		dit = 0;
		
		if (!tbody) { // first time, build all cells from scratch
		
			var table = $("<table/>").appendTo(element);
			
			s = "<thead><tr>";
			for (i=0; i<colCnt; i++) {
				s += '<th ' +	(i==dit ? 'class="fc-leftmost"' : '') +	'>' + formatDate(d, colFormat, options) + '</th>';
				addDays(d, 1);
			}
			thead = $(s + "</tr></thead>").appendTo(table);
			
			s = "<tbody>";
			d = cloneDate(view.visStart);
			for (i=0; i<rowCnt; i++) {
				s += "<tr class='fc-week" + i + "'>";
				for (j=0; j<colCnt; j++) {
					s += '<td class="fc-day' + (i*colCnt+j) +
						(j==dit ? ' fc-leftmost' : '') +
						(rowCnt>1 && d.getMonth() != month ? ' fc-other-month' : '') +
						(+d == +today ?
						' fc-state-highlight' :
						' ') + '">' +
						(showNumbers ? "<div class='fc-day-number'>" + d.getDate() + "</div>" : '') +
						"<div class='fc-day-content'><div>&nbsp;</div></div></td>";
					addDays(d, 1);
				}
				s += "</tr>";
			}
			tbody = $(s + "</tbody>").appendTo(table);
		
		}else{ // NOT first time, reuse as many cells as possible
		
			view.clearEvents();
		
			var prevRowCnt = tbody.find('tr').length;
			if (rowCnt < prevRowCnt) {
				tbody.find('tr:gt(' + (rowCnt-1) + ')').remove(); // remove extra rows
			}
			else if (rowCnt > prevRowCnt) { // needs to create new rows...
				s = '';
				for (i=prevRowCnt; i<rowCnt; i++) {
					s += "<tr class='fc-week" + i + "'>";
					for (j=0; j<colCnt; j++) {
						s += "<td class='fc-" +
							dayIDs[d.getDay()] + ' ' + // needs to be first
							'fc-state-default fc-new fc-day' + (i*colCnt+j) +
							(j==dit ? ' fc-leftmost' : '') + "'>" +
							(showNumbers ? "<div class='fc-day-number'></div>" : '') +
							"<div class='fc-day-content'><div>&nbsp;</div></div>" +
							"</td>";
						addDays(d, 1);
					}
					s += "</tr>";
				}
				tbody.append(s);
			}
			
			// re-label and re-class existing cells
			d = cloneDate(view.visStart);
			tbody.find('td').each(function() {
				var td = $(this);
				td.find('div.fc-day-number').text(d.getDate());
				addDays(d, 1);
			});
			
		
		}
		
		updateSize();
		fetchEvents(renderEvents);
	
	};
	
	
	
	function updateSize() {
	
		var height = Math.round(element.width() / options.aspectRatio),
			leftTDs = tbody.find('tr td:first-child'),
			tbodyHeight = height - thead.height(),
			rowHeight1, rowHeight2;
		
		rowHeight1 = Math.floor(tbodyHeight / rowCnt);
		rowHeight2 = tbodyHeight - rowHeight1*(rowCnt-1);

		setOuterHeight(leftTDs.slice(0, -1), rowHeight1);
		setOuterHeight(leftTDs.slice(-1), rowHeight2);
		
		setOuterWidth(
			thead.find('th').slice(0, -1),
			colWidth = Math.floor(element.width() / colCnt)
		);
	}
	
	
	
	/* Event Rendering
	-----------------------------------------------------------------------------*/
	
	
	function renderEvents(events) {
		view.reportEvents(events);
		renderSegs(cachedSegs = compileSegs(events));
	}
	
	
	function rerenderEvents(skipCompile) {
		view.clearEvents();
		if (skipCompile) {
			renderSegs(cachedSegs);
		}else{
			renderEvents(view.cachedEvents);
		}
	}
	
	
	function compileSegs(events) {
		var d1 = cloneDate(view.visStart);
		var d2 = addDays(cloneDate(d1), colCnt);
		var rows = [];
		for (var i=0; i<rowCnt; i++) {
			rows.push(stackSegs(view.sliceSegs(events, d1, d2)));
			addDays(d1, 7);
			addDays(d2, 7);
		}
		return rows;
	}
	
	
	function renderSegs(segRows) {
		var i, len = segRows.length, levels,
			tr, td,
			innerDiv,
			top,
			weekHeight,
			j, segs,
			levelHeight,
			k, seg,
			event,
			eventClasses,
			startElm, endElm,
			left1, left2,
			eventElement, eventAnchor,
			triggerRes;
		for (i=0; i<len; i++) {
			levels = segRows[i];
			tr = tbody.find('tr:eq('+i+')');
			td = tr.find('td:first');
			innerDiv = td.find('div.fc-day-content div').css('position', 'relative');
			top = innerDiv.position().top;
			if (tdTopBug) {
				top -= td.position().top;
			}
			if (trTopBug) {
				top += tr.position().top;
			}
			if (tbodyTopBug) {
				top += tbody.position().top;
			}
			weekHeight = 0;
			for (j=0; j<levels.length; j++) {
				segs = levels[j];
				levelHeight = 0;
				for (k=0; k<segs.length; k++) {
					seg = segs[k];
					event = seg.event;
					eventClasses = event.className;
					if (typeof eventClasses == 'object') { // an array
						eventClasses = eventClasses.slice(0);
					}
					else if (typeof eventClasses == 'string') {
						eventClasses = eventClasses.split(' ');
					}
					else {
						eventClasses = [];
					}
					eventClasses.push('fc-event', 'fc-event-hori');
					startElm = seg.isStart ?
						tr.find('td:eq('+((seg.start.getDay()-firstDay+colCnt)%colCnt)+') div.fc-day-content div') :
						tbody;
					endElm = seg.isEnd ?
						tr.find('td:eq('+((seg.end.getDay()-firstDay+colCnt-1)%colCnt)+') div.fc-day-content div') :
						tbody;
					left1 = startElm.position().left;
					left2 = endElm.position().left + endElm.width();
					if (seg.isStart) {
						eventClasses.push('fc-corner-left');
					}
					if (seg.isEnd) {
						eventClasses.push('fc-corner-right');
					}
					eventElement = $("<div class='" + eventClasses.join(' ') + "'/>")
						.append(eventAnchor = $("<a/>")
							.append(event.allDay || !seg.isStart ? null :
								$("<span class='fc-event-time'/>")
									.html(formatDates(event.start, event.end, options.timeFormat, options)))
							.append($("<span class='fc-event-title'/>")
								.html(event.title)));
					if (event.url) {
						eventAnchor.attr('href', event.url);
					}
					triggerRes = view.trigger('eventRender', event, event, eventElement);
					if (triggerRes !== false) {
						if (triggerRes && typeof triggerRes != 'boolean') {
							eventElement = $(triggerRes);
						}
						eventElement
							.css({
								position: 'absolute',
								top: top,
								left: left1 + (rtlLeftDiff||0),
								zIndex: 2
							})
							.appendTo(element);
						setOuterWidth(eventElement, left2-left1, true);
						view.reportEventElement(event, eventElement);
						levelHeight = Math.max(levelHeight, eventElement.outerHeight(true));
					}
				}
				weekHeight += levelHeight;
				top += levelHeight;
			}
			innerDiv.height(weekHeight);
		}
	}
	

};


/* Methods & Utilities for All Views
-----------------------------------------------------------------------------*/

var viewMethods = {

	init: function(element, options) {
		this.element = element;
		this.options = options;
		this.cachedEvents = [];
		this.eventsByID = {};
		this.eventElements = [];
		this.eventElementsByID = {};
	},
	
	
	
	// triggers an event handler, always append view as last arg
	
	trigger: function(name, thisObj) {
		if (this.options[name]) {
			return this.options[name].apply(thisObj || this, Array.prototype.slice.call(arguments, 2).concat([this]));
		}
	},
	
	
	
	// returns a Date object for an event's end
	
	eventEnd: function(event) {
		return event.end || this.defaultEventEnd(event);
	},
	
	
	
	// report when view receives new events
	
	reportEvents: function(events) { // events are already normalized at this point
		var i, len=events.length, event,
			eventsByID = this.eventsByID = {},
			cachedEvents = this.cachedEvents = [];
		for (i=0; i<len; i++) {
			event = events[i];
			if (eventsByID[event._id]) {
				eventsByID[event._id].push(event);
			}else{
				eventsByID[event._id] = [event];
			}
			cachedEvents.push(event);
		}
	},
	
	
	
	// report when view creates an element for an event

	reportEventElement: function(event, element) {
		this.eventElements.push(element);
		var eventElementsByID = this.eventElementsByID;
		if (eventElementsByID[event._id]) {
			eventElementsByID[event._id].push(element);
		}else{
			eventElementsByID[event._id] = [element];
		}
	},
	
	
	
	// event element manipulation
	
	clearEvents: function() { // only remove ELEMENTS
		$.each(this.eventElements, function() {
			this.remove();
		});
		this.eventElements = [];
		this.eventElementsByID = {};
	},
	
	showEvents: function(event, exceptElement) {
		this._eee(event, exceptElement, 'show');
	},
	
	hideEvents: function(event, exceptElement) {
		this._eee(event, exceptElement, 'hide');
	},
	
	_eee: function(event, exceptElement, funcName) { // event-element-each
		var elements = this.eventElementsByID[event._id],
			i, len = elements.length;
		for (i=0; i<len; i++) {
			if (elements[i] != exceptElement) {
				elements[i][funcName]();
			}
		}
	},
	
	
	


	
	
	// event rendering utilities
	
	sliceSegs: function(events, start, end) {
		var segs = [],
			i, len=events.length, event,
			eventStart, eventEnd,
			segStart, segEnd,
			isStart, isEnd;
		for (i=0; i<len; i++) {
			event = events[i];
			eventStart = event.start;
			eventEnd = this.visEventEnd(event);
			if (eventEnd > start && eventStart < end) {
				if (eventStart < start) {
					segStart = cloneDate(start);
					isStart = false;
				}else{
					segStart = eventStart;
					isStart = true;
				}
				if (eventEnd > end) {
					segEnd = cloneDate(end);
					isEnd = false;
				}else{
					segEnd = eventEnd;
					isEnd = true;
				}
				segs.push({
					event: event,
					start: segStart,
					end: segEnd,
					isStart: isStart,
					isEnd: isEnd,
					msLength: segEnd - segStart
				});
			}
		}
		return segs.sort(segCmp);
	}

};


// more event rendering utilities

function stackSegs(segs) {
	var levels = [],
		i, len = segs.length, seg,
		j, collide, k;
	for (i=0; i<len; i++) {
		seg = segs[i];
		j = 0; // the level index where seg should belong
		while (true) {
			collide = false;
			if (levels[j]) {
				for (k=0; k<levels[j].length; k++) {
					if (segsCollide(levels[j][k], seg)) {
						collide = true;
						break;
					}
				}
			}
			if (collide) {
				j++;
			}else{
				break;
			}
		}
		if (levels[j]) {
			levels[j].push(seg);
		}else{
			levels[j] = [seg];
		}
		//seg.after = 0;
	}
	return levels;
}

function segCmp(a, b) {
	return  (b.msLength - a.msLength) * 100 + (a.event.start - b.event.start);
}

function segsCollide(seg1, seg2) {
	return seg1.end > seg2.start && seg1.start < seg2.end;
}


/* Date Math
-----------------------------------------------------------------------------*/

var DAY_MS = 86400000,
	HOUR_MS = 3600000;

function addYears(d, n, keepTime) {
	d.setFullYear(d.getFullYear() + n);
	if (!keepTime) {
		clearTime(d);
	}
	return d;
}

function addMonths(d, n, keepTime) { // prevents day overflow/underflow
	if (+d) { // prevent infinite looping on invalid dates
		var m = d.getMonth() + n,
			check = cloneDate(d);
		check.setDate(1);
		check.setMonth(m);
		d.setMonth(m);
		if (!keepTime) {
			clearTime(d);
		}
		while (d.getMonth() != check.getMonth()) {
			d.setDate(d.getDate() + (d < check ? 1 : -1));
		}
	}
	return d;
}

function addDays(d, n, keepTime) { // deals with daylight savings
	if (+d) { // prevent infinite looping on invalid dates
		var dd = d.getDate() + n,
			check = cloneDate(d);
		check.setHours(12); // set to middle of day
		check.setDate(dd);
		d.setDate(dd);
		if (!keepTime) {
			clearTime(d);
		}
		while (d.getDate() != check.getDate()) {
			d.setTime(+d + (d < check ? 1 : -1) * HOUR_MS);
		}
	}
	return d;
}

function addMinutes(d, n) {
	d.setMinutes(d.getMinutes() + n);
	return d;
}

function clearTime(d) {
	d.setHours(0);
	d.setMinutes(0);
	d.setSeconds(0); 
	d.setMilliseconds(0);
	return d;
}

function cloneDate(d, dontKeepTime) {
	if (dontKeepTime) {
		return clearTime(new Date(+d));
	}
	return new Date(+d);
}



/* Date Parsing
-----------------------------------------------------------------------------*/

var parseDate = fc.parseDate = function(s) {
	if (typeof s == 'string') { // a UNIX timestamp
		return new Date(parseInt(s) * 1000);
	}
	return null;
}


/* Date Formatting
-----------------------------------------------------------------------------*/

var formatDate = fc.formatDate = function(date, format, options) {
	return formatDates(date, null, format, options);
}

var formatDates = fc.formatDates = function(date1, date2, format, options) {
	options = options || defaults;
	var date = date1,
		otherDate = date2,
		i, len = format.length, c,
		i2, formatter,
		res = '';
	for (i=0; i<len; i++) {
		c = format.charAt(i);
		if (c == "'") {
			for (i2=i+1; i2<len; i2++) {
				if (format.charAt(i2) == "'") {
					if (date) {
						if (i2 == i+1) {
							res += "'";
						}else{
							res += format.substring(i+1, i2);
						}
						i = i2;
					}
					break;
				}
			}
		}
		else if (c == '(') {
			for (i2=i+1; i2<len; i2++) {
				if (format.charAt(i2) == ')') {
					var subres = formatDate(date, format.substring(i+1, i2), options);
					if (parseInt(subres.replace(/\D/, ''))) {
						res += subres;
					}
					i = i2;
					break;
				}
			}
		}
		else if (c == '[') {
			for (i2=i+1; i2<len; i2++) {
				if (format.charAt(i2) == ']') {
					var subformat = format.substring(i+1, i2);
					var subres = formatDate(date, subformat, options);
					if (subres != formatDate(otherDate, subformat, options)) {
						res += subres;
					}
					i = i2;
					break;
				}
			}
		}
		else if (c == '{') {
			date = date2;
			otherDate = date1;
		}
		else if (c == '}') {
			date = date1;
			otherDate = date2;
		}
		else {
			for (i2=len; i2>i; i2--) {
				if (formatter = dateFormatters[format.substring(i, i2)]) {
					if (date) {
						res += formatter(date, options);
					}
					i = i2 - 1;
					break;
				}
			}
			if (i2 == i) {
				if (date) {
					res += c;
				}
			}
		}
	}
	return res;
}

var dateFormatters = {
	s	: function(d)	{ return d.getSeconds() },
	ss	: function(d)	{ return zeroPad(d.getSeconds()) },
	m	: function(d)	{ return d.getMinutes() },
	mm	: function(d)	{ return zeroPad(d.getMinutes()) },
	h	: function(d)	{ return d.getHours() % 12 || 12 },
	hh	: function(d)	{ return zeroPad(d.getHours() % 12 || 12) },
	H	: function(d)	{ return d.getHours() },
	HH	: function(d)	{ return zeroPad(d.getHours()) },
	d	: function(d)	{ return d.getDate() },
	dd	: function(d)	{ return zeroPad(d.getDate()) },
	ddd	: function(d,o)	{ return o.dayNamesShort[d.getDay()] },
	dddd: function(d,o)	{ return o.dayNames[d.getDay()] },
	M	: function(d)	{ return d.getMonth() + 1 },
	MM	: function(d)	{ return zeroPad(d.getMonth() + 1) },
	MMM	: function(d,o)	{ return o.monthNamesShort[d.getMonth()] },
	MMMM: function(d,o)	{ return o.monthNames[d.getMonth()] },
	yy	: function(d)	{ return (d.getFullYear()+'').substring(2) },
	yyyy: function(d)	{ return d.getFullYear() },
	t	: function(d)	{ return d.getHours() < 12 ? 'a' : 'p' },
	tt	: function(d)	{ return d.getHours() < 12 ? 'am' : 'pm' },
	T	: function(d)	{ return d.getHours() < 12 ? 'A' : 'P' },
	TT	: function(d)	{ return d.getHours() < 12 ? 'AM' : 'PM' },
	u	: function(d)	{ return formatDate(d, "yyyy-MM-dd'T'HH:mm:ss'Z'") },
	S	: function(d)	{
		var date = d.getDate();
		if (date > 10 && date < 20) return 'th';
		return ['st', 'nd', 'rd'][date%10-1] || 'th';
	}
};



/* Element Dimensions
-----------------------------------------------------------------------------*/

function setOuterWidth(element, width, includeMargins) {
	element.each(function() {
		var e = $(this);
		var w = width - (
			(parseInt(e.css('border-left-width')) || 0) +
			(parseInt(e.css('padding-left')) || 0) +
			(parseInt(e.css('padding-right')) || 0) +
			(parseInt(e.css('border-right-width')) || 0));
		if (includeMargins) {
			w -=
				(parseInt(e.css('margin-left')) || 0) +
				(parseInt(e.css('margin-right')) || 0);
		}
		e.width(w);
	});
}

function setOuterHeight(element, height, includeMargins) {
	element.each(function() {
		var e = $(this);
		var h = height - (
			(parseInt(e.css('border-top-width')) || 0) +
			(parseInt(e.css('padding-top')) || 0) +
			(parseInt(e.css('padding-bottom')) || 0) +
			(parseInt(e.css('border-bottom-width')) || 0));
		if (includeMargins) {
			h -=
				(parseInt(e.css('margin-top')) || 0) +
				(parseInt(e.css('margin-bottom')) || 0);
		}
		e.height(h);
	});
}






/* Misc Utils
-----------------------------------------------------------------------------*/

var undefined,
	dayIDs = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

function zeroPad(n) {
	return (n < 10 ? '0' : '') + n;
}

function strProp(s, prop) {
	return typeof s == 'string' ? s : s[prop];
}


})(jQuery);
