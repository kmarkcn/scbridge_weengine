/**
 * 微生活_行业_通用
 * @requrie wei_webapp_v2_common.js
 * @author luan luan
 */

_onPageLoaded(function(){
	//顶部搜索
	var ts = _q('.topSearch'); 
	if (ts){
		var ipt = _q('div p input[type=text]', ts),
			p = ipt.parentNode,
			d = p.parentNode,
			indent = parseInt( MData(ts, 'indent') );
		d.addEventListener('click', function(e){
			if (e.target.nodeName.toLowerCase() == 'div')
				ipt.focus();
		}, false);
		p.addEventListener('click', function(e){
			ipt.focus();
		}, false);
		ipt.addEventListener('focus', function(e){
			_addClass(ts, 'focus');
			
			fixIOS(e);
		});
		ipt.addEventListener('blur', function(e){
			_removeClass(ts, 'focus');
			
			fixIOS(e);
		});
		document.addEventListener('touchmove', function(e){
			var tgt = e.target,
				needBlur = true;
			while (tgt.parentNode){
				if (tgt.className.indexOf('topSearch')>-1){
					needBlur = false;
					break;
				}
				tgt = tgt.parentNode;
			}
			if (needBlur){
				_q('.topSearch input[type=text]').blur();
				fixIOS();
			}
		});
		
		function fixIOS(e){
			if (!_env.ios) return;
			if (e && e.type && e.type == 'focus'){
				window.ts_itv1 = setInterval(function(){
					_forEach('.topSearch', function(tsObj){
						tsObj.style.position = 'absolute';
						tsObj.style.top = _q('body').scrollTop + 'px';
					});
				}, 50);
			}else{
				clearInterval(window.ts_itv1);
				_forEach('.topSearch', function(tsObj){
					tsObj.style.position = 'fixed';
					tsObj.style.top = 0;
				});
			}
		}
	}
	
	//浮动
	_fixedStyleHook(true);
	
	//一些尺寸
	_resizeHandler();
	window.addEventListener('resize', _resizeHandler);
});

function _resizeHandler(e){
	if (_env.ios){ //ios在页面上下滑动时也会触发
		if (!'_oldPW1' in window){
			window._oldPW1 = window.innerWidth;
		}
		if ( window._oldPW1 == window.innerWidth ){
			return;
		}else{
			window._oldPW1 = window.innerWidth;
		}
	}
	
	//页面宽度
	var pw = window.innerWidth, 
		bdy = _q('body'),
		w1 = pw - parseInt(_getRealStyle(bdy, 'paddingLeft')) - parseInt(_getRealStyle(bdy, 'paddingRight'));
	bdy.style.width = w1 + 'px';
	bdy = null;
	
	//顶部搜索
	var ts = _q('.topSearch'); 
	if (ts){
		var ipt = _q('div p input[type=text]', ts),
			indent = parseInt( MData(ts, 'indent') );
		
		ts.style.width = pw + 'px';
		ipt.style.width = (window.innerWidth - indent)+'px';
	}
}
