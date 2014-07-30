var FCAPP = FCAPP || {};
FCAPP.ACTList = FCAPP.ACTList
		|| {
			CONFIG : {
				Error : {
					'network' : "您的网络不给力哦，请稍后再尝试"
				}
			},
			RUNTIME : {},
			init : function() {
				if (!window.gQuery && !gQuery.id) {
					setTimeout(arguments.callee, 200);
					return;
				}
				ACTList.initElements();
				ACTList.initEvents();
				ACTList.loadACTListData();
				FCAPP.Common
						.loadShareData(window.gQuery && gQuery.id ? gQuery.id
								: '');
				FCAPP.Common.hideToolbar();
			},
			initElements : function() {
				var R = ACTList.RUNTIME;
				if (!R.template) {
					R.container = $('#container');
					R.template = FCAPP.Common.escTpl($('#template').html());
					R.popTips = $('div.pop_tips');
				}
			},
			initEvents : function() {
				var R = ACTList.RUNTIME;
				$(window).resize(function() {
					FCAPP.Common.resizeLayout(R.popTips);
				});
			},
			loadACTListData : function() {
				window.renderData = ACTList.renderData;
				var C = ACTList.CONFIG, datafile = window.gQuery && gQuery.fcid ? gQuery.fcid
						+ '.'
						: '', dt = new Date();
				datafile = datafile.replace(/[<>\'\"\/\\&#\?\s\r\n]+/gi, '');
				datafile += 'act-list.js?';
				$.ajax( {
					url : 'static/' + datafile + dt.getDate() + dt.getHours(),
					dataType : 'jsonp',
					error : function() {
						FCAPP.Common.hideLoading();
						FCAPP.Common.msg(true, {
							noscroll : "true",
							msg : C.Error['network']
						});
					}
				});
			},
			renderData : function(data) {
				var R = ACTList.RUNTIME, id = window.gQuery && gQuery.id ? gQuery.id
						: '';
				FCAPP.Common.hideLoading();
				data.id = id;
				R.container.html($.template(R.template, {
					data : data
				}));
			},
			goDetail : function(id) {
				id = id || '';
				FCAPP.Common.jumpTo('act-detail.html', {
					actid : id,
					from : "act-list.html"
				}, true);
			}
		};
var ACTList = FCAPP.ACTList;
$(document).ready(ACTList.init);