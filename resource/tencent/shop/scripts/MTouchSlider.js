/**
 * MTouchSlider
 * @author tonylua@sina.com
 */
var MTouchLoopSlider = (function(){
	var _vendor = (/webkit/i).test(navigator.appVersion) ? "webkit": (/firefox/i).test(navigator.userAgent) ? "Moz": "opera" in window ? "O": (/MSIE/i).test(navigator.userAgent) ? "ms": "",
		_has3d = "WebKitCSSMatrix" in window && "m11" in new WebKitCSSMatrix(),
		_trnOpen = "translate" + (_has3d ? "3d(": "("),
		_trnClose = _has3d ? ",0)": ")",
		console = window.console || {log: function(){}},
		MData = window.MData || (function(){ function line2Upper(str){ var re = new RegExp('\\-([a-z])','g'); if ( !re.test(str) ) return str; return str.toLowerCase().replace( re, RegExp.$1.toUpperCase() ); } function upper2Line(str){ return str.replace(/([A-Z])/g, '-$1').toLowerCase(); } function setD(ele, k, v){ ele.setAttribute('data-'+upper2Line(k), v); } function getD(ele, k){ var attr = ele.getAttribute('data-'+upper2Line(k)); return attr||undefined; } return function(ele, k, v) { if (arguments.length>2){ try { ele.dataset[ line2Upper(k) ] = v; } catch(ex) { setD(ele, k, v); } }else{ try { return ele.dataset[ line2Upper(k) ]; } catch(ex) { return getD(ele, k); } } }; }()),
		_forEach = window._forEach || function(arr, callback) { if (typeof arr === 'string'){ try{arr = _qAll(arr);}catch(ex){console.log(ex);return;} } Array.prototype.forEach.call(arr, callback); },
		_q = window._q || function(s, context){if (context && typeof context === 'string'){ try{context = _q(context);}catch(ex){console.log(ex);return;} } return (context||document).querySelector(s);},
		 _qAll = window._qAll || function(s, context){if (context && typeof context === 'string'){ try{context = _q(context);}catch(ex){console.log(ex);return;} } return (context||document).querySelectorAll(s);},
		 _qConcat = window._qConcat || function(){ var i=0, leng = arguments.length, arr=[]; for (;i<leng;i++){ var arg = arguments[i]; if (typeof arg === 'string') arg = _qAll(arg); else if ('nodeType' in arg && arg.nodeType === 1) arg = [arg]; _forEach(arg, function(aitem){ arr.push(aitem); }); } return arr; },
		_delegate = window._delegate || function(){
 var func = arguments[0], thisObj = arguments[1], params = Array.prototype.slice.call(arguments, 2); if (params.length == 1 && params[0] instanceof Array) params = params[0]; return function(){ var nowArgs = [], i = 0, lng = arguments.length; for(;i<lng;i++) nowArgs[i] = arguments[i]; nowArgs = nowArgs.concat(params); func.apply(thisObj, nowArgs); }; },
		_move = function(dom, value, tweenMode){
			var s = tweenMode ? 6.18 * 4 * .01 : 0;
			dom.style[_vendor + 'TransitionDuration'] = s + 's';
            dom.style[_vendor + 'Transform'] = _trnOpen + value + 'px,0' + _trnClose;
		},
		_time = function(){
			return (new Date).getTime();
		};
	var T = function(config){
		var _defaultConfig = {
			outerDom: '.tloopslider',
			innerDom: '.tinner',
			itemDom: 'section',
			/*callback: null,*/
			autoplay: true,
			autotimeout: 5000
		};
		for (var k in _defaultConfig)
			if (!(k in config))
				config[k] = _defaultConfig[k];
		
		this._config = config;
		this._outer = _q(config.outerDom);
		this._inner = _q(config.innerDom, this._outer);
		this._items = _qAll(config.itemDom, this._inner);
		this._autoItv = null;
		
		if (this._items.length < 2) return;
		
		this.setWidth(this._outer.clientWidth);
		
		this._events = {
			ts: _delegate(this._ets, this),
			tm: _delegate(this._etm, this),
			te: _delegate(this._ete, this)
		};
		
		var idx = ('defaultIndex' in config) 
			? (typeof config.defaultIndex != 'undefined')
				? parseInt(config.defaultIndex) 
				: 0
			: 0;
		this._default = idx;
		
		this._range = this._getRange(idx);
		this._render();
		this._inner.addEventListener('touchstart', this._events.ts);
	};
	T.prototype = {
		/*public*/
		setWidth: function(value){
			this._w = value;			
			var w1 = this._w;
			this._outer.style.width = w1 + 'px';
			this._inner.style.width = 3 * w1 + 'px';
			_forEach( this._items, function(ele){
				ele.style.width = w1+'px';
			});
		},
		fixHeight: function(){
			this._inner.style.height = this._items[ this._range[1] ].clientHeight + 'px';
		},
		setCurrent: function(idx){
			if (isNaN(idx)) idx=0;
			this._range = this._getRange(idx);
			this._render();
		},
		/*privates*/
		_getRange: function(idx){
			if (isNaN(idx)) idx=0;
			var r = [idx];
			r.unshift( idx==0 ? this._items.length-1 : idx-1 );
			r.push( idx==this._items.length-1 ? 0 : idx+1 );
			return r;
		},
		_render: function(){
			this._disableAuto();
			this._inner.removeEventListener('touchstart', this._events.ts);
			this._inner.removeEventListener('touchmove', this._events.tm);
			this._inner.removeEventListener('touchend', this._events.te);
			this._inner.removeEventListener('touchcancel', this._events.te);
			
			var me = this;
			this._inner.innerHTML = '';
			_forEach(this._range, function(item){
				me._inner.appendChild( me._items[item] );
			});
			_move(this._inner, -this._w, false);
			this.fixHeight();
			
			this._inner.addEventListener('touchstart', this._events.ts);
			this._enableAuto();
		},
		_enableAuto: function(){
			if (!this._config.autoplay) return;
			if (this._autoItv !== null) return;
			var me = this;
			this._autoItv = window.setTimeout(function(){ /*auto*/
				_move(me._inner, -2*me._w, true);
				me._inner.addEventListener('webkitTransitionEnd', function(e){
					e.currentTarget.removeEventListener('webkitTransitionEnd', arguments.callee);
					me._ontransend(2);
				});
				
			}, me._config.autotimeout);
		},
		_disableAuto: function(){
			if (!this._config.autoplay) return;
			window.clearTimeout(this._autoItv);
			this._autoItv = null;
		},
		_ets: function(e){
			//e.preventDefault();
			this._disableAuto();
			this._directionLocked = false;
			var cleft = this._outer.getBoundingClientRect().left,
        		ileft = this._inner.getBoundingClientRect().left;
			this.dinfo_start = {
				time: _time(),
				localX: e.touches[0].clientX - cleft,
				stageX: e.touches[0].clientX,
				stageY: e.touches[0].clientY,
				innerLeft: ileft - cleft
			};
			this._inner.addEventListener('touchmove', this._events.tm);
			this._inner.addEventListener('touchend', this._events.te);
			this._inner.addEventListener('touchcancel', this._events.te);
		},
		_etm: function(e){
			//e.preventDefault();
			var absDistX, 
				absDistY,
				deltaX = e.touches[0].pageX - this.dinfo_start.stageX,
				deltaY = e.touches[0].pageY - this.dinfo_start.stageY;
			if (this._directionLocked === "y") {
                return;
            } else {
                if (this._directionLocked === "x") {
                    e.preventDefault();
                } else {
					absDistX = Math.abs(deltaX);
					absDistY = Math.abs(deltaY);
					if (absDistX < 4) {
						return;
					}
					if (absDistY > absDistX * 0.58) {
						this._directionLocked = "y";
						return;
					} else {
						e.preventDefault();
						this._directionLocked = "x";
					}
				}
            }
			var v = e.touches[0].clientX - this.dinfo_start.stageX + this.dinfo_start.innerLeft;
			_move( this._inner, v, false );
		},
		_ete: function(e){
			e.preventDefault();
			this._inner.removeEventListener('touchmove', this._events.tm);
			this._inner.removeEventListener('touchend', this._events.te);
			this._inner.removeEventListener('touchcancel', this._events.te);
			var cleft = this._outer.getBoundingClientRect().left,
        		ileft = this._inner.getBoundingClientRect().left;
			this.dinfo_end = {
	        	time: _time(),
				innerLeft: ileft - cleft
			};
			var me = this,
				tDis = this.dinfo_end.innerLeft - this.dinfo_start.innerLeft,
				shortDis = Math.abs(tDis) < 5,
				tTime = this.dinfo_end.time - this.dinfo_start.time,
				longTime = tTime > 300,
				toLeft = tDis < 0,
				v = -this._w,
				endIdx = null;
			
			if (!longTime){ /*快速拖动*/
				if (!shortDis){
					v = toLeft ? -2*this._w : 0;
					endIdx = toLeft ? 2 : 0;
				}
			}else{ /*一般拖动*/
				if (Math.abs(tDis) > .5*this._w){
					v = toLeft ? -2*this._w : 0;
					endIdx = toLeft ? 2 : 0;
				}
			}
			
			e.currentTarget.removeEventListener('touchstart', this._events.ts);
			_move( this._inner, v, true );
			
			if (endIdx != null){
				this._inner.addEventListener('webkitTransitionEnd', function(e){
					e.currentTarget.removeEventListener('webkitTransitionEnd', arguments.callee);
					me._ontransend(endIdx);
					e.currentTarget.addEventListener('touchstart', me._events.ts);
				});
			}else{
				e.currentTarget.addEventListener('touchstart', me._events.ts);
			}
		},
		_ontransend: function(idx){
			this._range = this._getRange( this._range[ idx ] );
			this._render();
			if ('callback' in this._config && typeof this._config.callback == 'function'){
				this._config.callback.call(this, this._outer, this._items[ this._range[1] ], this._range[1]);
			}
		}
	};
	return T;
}());

/*a adapter for old api version*/
var MTouchSlider = (function(){
	return function(ele, config){
		var t = new MTouchLoopSlider({
			outerDom: ele.id !== '' ? '#'+ele.id : '.'+ele.classList.item(0),
			innerDom: config.barCls,
			itemDom: config.pageCls,
			defaultIndex: config.defaultTab,
			autoplay: parseInt(MData(ele, 'auto-play')),
			autotimeout: parseInt(MData(ele, 'auto-time')),
			callback: function(outer, inner, idx){
				t._curr = idx;
				
				_setDot(idx);
				
				var funcName = MData(ele, 'drag-callback');
				if (funcName.length && (funcName in window) && (typeof window[funcName] == 'function')){
					window[funcName].call(t, outer, inner, idx);
				}
			}
		});
		
		t._curr = t._default;
		t._ilng = t._items.length;
		t._parts = t._items;
		t._ele = t._outer;
		t._bar = t._inner;
		
		var _drawPageDot = function (clr, r){
				var cvs = document.createElement('canvas'),
					ctx = cvs.getContext('2d');
				if (!r) r=4;
				cvs.width = r*2;
				cvs.height = r*2;
				ctx.fillStyle = clr;
				ctx.beginPath();
				ctx.arc(r,r,r,Math.PI*2,0,true);
				ctx.closePath();
				ctx.fill();
				MData(cvs, 'color', clr);
				return cvs;
			},
			_setDot = function(idx){
				_forEach(t._dots, function(a,b,c){
					a.style.opacity = .4;
				});
				if (t._dots[idx])
					t._dots[idx].style.opacity = 1;
			};
		t._dotCtn = ele.querySelector(config.dotsCls || '.sld_dots');
		t._dots = [];
		t._isRelLayout = !!MData(t._dotCtn, 'relativeLayout');
		if ( t._dotCtn && t._isRelLayout ){
			t._dotCtn.style.width = 13*t._ilng + 'px';
			t._dotCtn.style.marginLeft = .5*(t._w-13*t._ilng) + 'px';
		}else{
			t._dotCtn.style.marginLeft = .5*(t._w-13*(t._ilng-1) ) + 'px';
		}
		for (var i=0;i<t._ilng;i++){
			t._parts[i].style.width = t._w+'px';
			if ( MData(t._ele, 'minHeight') )
				t._parts[i].style.minHeight = MData(t._ele, 'minHeight')+'px';
			var cvs = _drawPageDot( MData(t._ele, 'dotColor') );
			t._dots[i] = cvs;
			if (t._dotCtn){
				if ( !t._isRelLayout )
					t._dotCtn.style.left = 13 * i + 'px';
				t._dotCtn.appendChild(cvs);
			}else{
				cvs.style.top = '0';
				cvs.style.left = (13 * i + .5*(t._w-13*(t._ilng-1) )) + 'px';
				t._bar.parentNode.insertAdjacentElement('afterBegin', cvs);
			}
		}
		_setDot(t._default);
		
		return t;
	};
}());