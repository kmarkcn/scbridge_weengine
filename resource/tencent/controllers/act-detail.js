var FCAPP = FCAPP || {};
FCAPP.ACTDetail = FCAPP.ACTDetail
		|| {
			CONFIG : {
				Error : {
					'network' : "您的网络不给力哦，请稍后再尝试",
					'-100' : '您太长时间没有操作，为了帐号安全请点击确定后重新提交',
					'-9972' : "抱歉，您的评论包含敏感词，请修改后重新发布"
				},
				Server : 'http://cgi.trade.qq.com/cgi-bin/common/comm_ugc.fcg',
				ServerEnroll : 'http://cgi.trade.qq.com/cgi-bin/common/enroll.fcg'
			},
			RUNTIME : {
				rOffset : 0,
				rPageSize : 5,
				rTotal : -1,
				drag : {
					sTop : 0
				}
			},
			init : function() {
				if (!window.gQuery && !gQuery.id) {
					setTimeout(arguments.callee, 200);
					return;
				}
				ACTDetail.initElements();
				ACTDetail.initEvents();
				ACTDetail.loadACTDetailData();
				FCAPP.Common.hideToolbar();
			},
			initElements : function() {
				var R = ACTDetail.RUNTIME;
				if (!R.template) {
					R.container = $('#container');
					R.template = FCAPP.Common.escTpl($('#template').html());
					R.listTpl = FCAPP.Common.escTpl($('#listTpl').html());
					R.popTips = $('div.pop_tips');
					R.navBar = $("#navBar");
					R.titleBar = $("#titleBar");
					R.btnBack = $("#btnBack");
					R.pannelTip = $("#pannelTip");
					R.pannelTitle = $("#pannelTitle");
					R.pannelSubt = $("#pannelSubt");
					R.pannelSubt1 = $("#pannelSubt1");
					R.btnJoin = $("#btnJoin");
					R.btnJoinTitle = $("#btnJoinT");
					R.tfReply = $("#tfReply");
					R.replyBox = $("#replyBox");
					R.btnReply = $("#btnReply");
					var from = window.gQuery && gQuery.from ? gQuery.from : '';
					R.navBarHidden = (from.length == 0);
				}
			},
			initEvents : function() {
				var R = ACTDetail.RUNTIME;
				$(window).resize(function() {
					ACTDetail.resizeLayout();
				});
				R.btnBack.bind("click", function() {
					if (window.gQuery && gQuery.actid)
						delete gQuery.actid;
					if (window.gQuery && gQuery.from)
						delete gQuery.from;
					FCAPP.Common.jumpTo("act-list.html", {}, true);
				});
				if (R.navBarHidden) {
					R.navBar.hide();
					R.container.css("padding-top", "0");
				} else {
					R.navBar.show();
					R.container.css("padding-top", "42px");
					document.body.addEventListener("touchmove",
							ACTDetail.scrollEvent, false);
					$(document).on("scroll", ACTDetail.scrollEvent);
				}
			},
			scrollEvent : function() {
				var R = ACTDetail.RUNTIME;
				var sTop = document.body.scrollTop, sHeight = document.body.scrollHeight, cHeight = document.body.clientHeight;
				if (sTop > R.drag.sTop) {
					R.drag.sTop = sTop;
					if (sTop > 44)
						R.navBar.hide();
				} else if (sTop < R.drag.sTop) {
					R.drag.sTop = sTop;
					if (sTop < sHeight && sTop + cHeight < sHeight)
						R.navBar.show();
				}
			},
			loadACTDetailData : function() {
				window.renderStaticData = ACTDetail.renderStaticData;
				var C = ACTDetail.CONFIG, datafile = window.gQuery
						&& gQuery.actid ? gQuery.actid + '.' : '', dt = new Date();
				datafile = datafile.replace(/[<>\'\"\/\\&#\?\s\r\n]+/gi, '');
				datafile += 'act-detail.js?';
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
			renderStaticData : function(data) {
				var R = ACTDetail.RUNTIME;
				R.stData = data;
				window.updateShareData = ACTDetail.updateShareData;
				FCAPP.Common
						.loadShareData(window.gQuery && gQuery.id ? gQuery.id
								: '');
				if (data.actType == -1 || data.status != 0) {
					R.cgiData = {
						ret : 0
					};
					ACTDetail.renderData();
				} else {
					ACTDetail.loadACTJoinState();
				}
			},
			loadACTJoinState : function() {
				window.ACTJoinStateResult = ACTDetail.ACTJoinStateResult;
				var C = ACTDetail.CONFIG;
				var data = {
					appid : window.gQuery && gQuery.appid ? gQuery.appid
							: "test",
					wticket : window.gQuery && gQuery.wticket ? gQuery.wticket
							: "test",
					bizid : window.gQuery && gQuery.actid ? gQuery.actid : '',
					cmd : 'exist',
					callback : 'ACTJoinStateResult',
					biztype : "activity"
				};
				$.ajax( {
					url : C.ServerEnroll + "?" + $.param(data) + "&ts="
							+ Math.random(),
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
			ACTJoinStateResult : function(data) {
				if (ACTDetail.validCGIData(data) == false) {
					return;
				}
				var R = ACTDetail.RUNTIME;
				R.cgiData = data;
				if (typeof (R.stData) != 'undefined'
						&& Object.keys(R.stData).length > 0) {
					ACTDetail.renderData();
				}
			},
			renderData : function() {
				var R = ACTDetail.RUNTIME, data = R.stData, id = window.gQuery
						&& gQuery.id ? gQuery.id : '';
				FCAPP.Common.hideLoading();
				data.id = id;
				data.rules = ACTDetail.getRules();
				var tmplHtml = $.template(R.template, {
					data : data
				}), pannel = ACTDetail.buildStatPannel(data);
				R.container.append(tmplHtml);
				R.titleBar.html(data.actName);
				if (pannel != null) {
					pannel.insertAfter($("#actTop"));
					pannel.show();
				}
				if (!R.navBarHidden) {
					$("textarea").unbind("focus", ACTDetail.absNavBar);
					$("textarea").bind("focus", ACTDetail.absNavBar);
					$("textarea").unbind("blur", ACTDetail.fixedNavBar);
					$("textarea").bind("blur", ACTDetail.fixedNavBar);
				}
				ACTDetail.loadReview(0);
			},
			loadMoreReview : function() {
				var R = ACTDetail.RUNTIME;
				ACTDetail.loadReview(R.rOffset);
			},
			loadReview : function(offset) {
				var C = ACTDetail.CONFIG, R = ACTDetail.RUNTIME, btnMore = $("#btnMore"), actid = R.stData.actid;
				if (offset < 0 || (offset >= R.rTotal && R.rTotal >= 0)
						|| typeof actid == "undefined") {
					return;
				}
				window.ReviewResult = ACTDetail.ReviewResult;
				var data = {
					appid : window.gQuery && gQuery.appid ? gQuery.appid
							: 'test001',
					wticket : window.gQuery && gQuery.wticket ? gQuery.wticket
							: 'test',
					openid : window.gQuery && gQuery.openid ? gQuery.openid
							: 'test111',
					cmd : 'getlist',
					topicid : actid,
					commentstart : offset,
					commentsize : R.rPageSize,
					callback : 'ReviewResult'
				};
				$.ajax( {
					url : C.Server + "?" + $.param(data) + "&ts="
							+ Math.random(),
					dataType : 'jsonp',
					error : function() {
						btnMore.html("更多");
						FCAPP.Common.msg(true, {
							noscroll : "true",
							msg : C.Error['network']
						});
					}
				});
				btnMore.html("正在加载...");
			},
			ReviewResult : function(data) {
				var R = ACTDetail.RUNTIME, id = window.gQuery && gQuery.id ? gQuery.id
						: '', tpl = R.listTpl, btnMore = $('#btnMore');
				data.id = id;
				btnMore.html("更多");
				if (ACTDetail.validCGIData(data) == false) {
					return;
				}
				R.rOffset += data.comment.length;
				R.rTotal = data.commenttotal;
				ACTDetail.switchBtnLike(parseInt(data.likeone) > 0,
						data.likeall);
				$("#cComment").text("(" + R.rTotal + "条)");
				if (data.comment.length > 0) {
					var tplHtml = $.template(tpl, {
						items : data.comment
					});
					$("#commentList").append(tplHtml);
				}
				if (R.rOffset < R.rTotal) {
					btnMore.show();
				} else {
					btnMore.hide();
				}
			},
			commentAction : function(cid) {
				var C = ACTDetail.CONFIG, R = ACTDetail.RUNTIME, actid = R.stData.actid;
				if (typeof actid == "undefined") {
					return;
				}
				var isComment = (typeof cid == "undefined" || cid == null), content = (isComment ? $(
						"#tfComment").val()
						: R.tfReply.val()).trim();
				if (content.length == 0) {
					FCAPP.Common.msg(true, {
						noscroll : "true",
						msg : '您还未填写内容，请填写后发布'
					});
					return;
				}
				var data = {
					appid : window.gQuery && gQuery.appid ? gQuery.appid
							: 'test001',
					wticket : window.gQuery && gQuery.wticket ? gQuery.wticket
							: 'test',
					openid : window.gQuery && gQuery.openid ? gQuery.openid
							: 'test111',
					topicid : actid,
					content : content
				};
				if (isComment) {
					data.cmd = "addcomment";
					data.callback = "CommentResult";
					window.CommentResult = ACTDetail.CommentResult;
				} else {
					data.commentid = cid;
					data.cmd = "addreply";
					data.callback = "ReplyResult";
					window.ReplyResult = ACTDetail.ReplyResult;
				}
				$.ajax( {
					url : C.Server + "?" + $.param(data) + "&ts="
							+ Math.random(),
					dataType : 'jsonp',
					error : function() {
						FCAPP.Common.hideLoading();
						FCAPP.Common.msg(true, {
							noscroll : "true",
							msg : C.Error['network']
						});
					}
				});
				FCAPP.Common.showLoading(true);
			},
			CommentResult : function(data) {
				if (ACTDetail.crResult(data)) {
					var tfComment = $("#tfComment");
					tfComment.val("");
					tfComment.trigger("change");
					tfComment.trigger("blur");
				}
			},
			ReplyResult : function(data) {
				if (ACTDetail.crResult(data)) {
					ACTDetail.hideReplyBox();
				}
			},
			crResult : function(data) {
				FCAPP.Common.hideLoading();
				var ret = ACTDetail.validCGIData(data);
				if (ret) {
					var R = ACTDetail.RUNTIME, tpl = R.listTpl;
					R.rOffset += 1;
					R.rTotal += 1;
					$("#cComment").text("(" + R.rTotal + ")");
					var tplHtml = $.template(tpl, {
						items : [ data ]
					});
					$("#commentList").prepend(tplHtml);
				}
				return ret;
			},
			deleteCommentAction : function(cid) {
				var C = ACTDetail.CONFIG, R = ACTDetail.RUNTIME, actid = R.stData.actid;
				if (typeof actid == "undefined") {
					return;
				}
				var opts = {
					noscroll : "true",
					msg : "确定要删除这个评论么？",
					no : function() {
					},
					ok : function() {
						window.deleteCommentResult = ACTDetail.deleteCommentResult;
						R.deletingCID = cid;
						var data = {
							appid : window.gQuery && gQuery.appid ? gQuery.appid
									: 'test001',
							wticket : window.gQuery && gQuery.wticket ? gQuery.wticket
									: 'test',
							openid : window.gQuery && gQuery.openid ? gQuery.openid
									: 'test111',
							cmd : "delcomment",
							topicid : actid,
							commentid : R.deletingCID,
							callback : 'deleteCommentResult'
						};
						$.ajax( {
							url : C.Server + "?" + $.param(data) + "&ts="
									+ Math.random(),
							dataType : 'jsonp',
							error : function() {
								FCAPP.Common.hideLoading();
								FCAPP.Common.msg(true, {
									noscroll : "true",
									msg : C.Error['network']
								});
							}
						});
						FCAPP.Common.showLoading(true);
					}
				}
				FCAPP.Common.msg(true, opts);
			},
			deleteCommentResult : function(data) {
				FCAPP.Common.hideLoading();
				if (ACTDetail.validCGIData(data) == false) {
					return;
				}
				var R = ACTDetail.RUNTIME, id = window.gQuery && gQuery.id ? gQuery.id
						: '';
				data.id = id;
				R.rOffset -= 1;
				R.rTotal -= 1;
				$("#cComment").text("(" + R.rTotal + ")");
				$("#" + R.deletingCID).remove();
				delete R.deletingCID;
			},
			likeAction : function(actid) {
				var cmd = "addlike";
				if ($("#like").hasClass("praise_on")) {
					cmd = "dellike";
				}
				var C = ACTDetail.CONFIG;
				window.LikeResult = ACTDetail.LikeResult;
				var data = {
					appid : window.gQuery && gQuery.appid ? gQuery.appid
							: 'test001',
					wticket : window.gQuery && gQuery.wticket ? gQuery.wticket
							: 'test',
					openid : window.gQuery && gQuery.openid ? gQuery.openid
							: 'test111',
					cmd : cmd,
					topicid : actid,
					callback : 'LikeResult'
				};
				$.ajax( {
					url : C.Server + "?" + $.param(data) + "&ts="
							+ Math.random(),
					dataType : 'jsonp',
					error : function() {
						FCAPP.Common.hideLoading();
						FCAPP.Common.msg(true, {
							noscroll : "true",
							msg : C.Error['network']
						});
					}
				});
				FCAPP.Common.showLoading(true);
			},
			LikeResult : function(data) {
				FCAPP.Common.hideLoading();
				if (ACTDetail.validCGIData(data) == false) {
					return;
				}
				ACTDetail.switchBtnLike(parseInt(data.likeone) > 0,
						data.likeall)
			},
			updateShareData : function(data) {
				var R = ACTDetail.RUNTIME;
				data["act-detail"] = {
					link : 'http://trade.qq.com/fangchan/act-detail.html?'
							+ $.param(gQuery),
					desc : R.stData.actName
				}
				FCAPP.Common.updateShareData(data);
			},
			showReplyBox : function(cid) {
				var R = ACTDetail.RUNTIME, li = $("#" + cid);
				R.tfReply.attr("placeholder", "回复" + li.attr("nickname") + ":");
				R.tfReply.val("");
				R.tfReply.trigger("change");
				R.btnReply.attr("cid", cid);
				R.replyBox.appendTo(li);
				R.replyBox.css("display", "");
				R.tfReply[0].focus();
				$("#commentBox").css("display", "none");
			},
			hideReplyBox : function() {
				var R = ACTDetail.RUNTIME;
				R.tfReply.attr("placeholder", "");
				R.tfReply.val("");
				R.tfReply.trigger("change");
				R.btnReply.removeAttr("cid");
				R.replyBox.appendTo($(document.body));
				R.replyBox.css("display", "none");
				$("#btnRClear").hide();
				$("#commentBox").css("display", "");
			},
			showContack : function(contact) {
				window.location.href = "tel:" + contact.phones[0];
			},
			buildStatPannel : function(data) {
				var R = ACTDetail.RUNTIME, ret = R.pannelTip;
				if (data.actType == -1) {
					if (data.rules.status == -1) {
						ret = null;
					} else if (data.rules.status == 0) {
						ret = null;
					} else if (data.rules.status == 1) {
						R.pannelTitle.attr("class", "ico_smile");
						R.pannelTitle.text("活动已成功结束!");
						R.pannelSubt.text("请关注我们的微信");
						R.pannelSubt1.text("留意其他活动信息");
					}
				} else if (data.actType == 0) {
					if (data.rules.status == -1) {
						ret = null;
					} else if (data.rules.status == 0) {
						R.btnJoinTitle.html("立即电话报名");
						ret = R.btnJoin;
						ret.unbind("click");
						ret.bind("click", function() {
							ACTDetail.showContack(data.contact);
						});
					} else if (data.rules.status == 1) {
						R.pannelTitle.attr("class", "ico_smile");
						R.pannelTitle.text("本次活动报名已结束");
						R.pannelSubt.text("请关注我们的微信");
						R.pannelSubt1.text("留意其他活动信息");
					}
				} else if (data.actType == 1) {
					if (data.rules.status == -1) {
						ret = null;
					} else if (data.rules.status == 0) {
						if (data.rules.joined == 0) {
							R.btnJoinTitle.html("我要报名");
							ret = R.btnJoin;
							ret.unbind("click");
							ret.bind("click", function() {
								ACTDetail.goJoinPage(data.actid);
							});
						} else if (data.rules.joined == 1) {
							R.pannelTitle.attr("class", "ico_success");
							R.pannelTitle.text("您已经报名成功！");
							R.pannelSubt.text("工作人员将以短信或电话的方式");
							R.pannelSubt1.text("确认您的报名信息");
						}
					} else if (data.rules.status == 1) {
						R.pannelTitle.attr("class", "ico_smile");
						R.pannelTitle.text("本次活动报名已结束");
						R.pannelSubt.text("请关注我们的微信");
						R.pannelSubt1.text("留意其他活动信息");
					}
				}
				return ret;
			},
			getRules : function() {
				var R = ACTDetail.RUNTIME;
				var rule = {
					joined : false,
					nummin : 1,
					nummax : 1
				};
				for ( var i = 0, n = R.stData.FsRule.length; i < n; i++) {
					var r = R.stData.FsRule[i];
					if (r.type == 0) {
						rule.enrollbt = r.rule.enrollbt;
						rule.enrollet = r.rule.enrollet;
						var d = moment().startOf('day'), d1 = moment(r.rule.enrollbt), d2 = moment(r.rule.enrollet);
						if (d < d1) {
							rule.status = -1;
						} else if (d >= d1 && d <= d2) {
							rule.status = 0;
						} else if (d > d2) {
							rule.status = 1;
						}
					} else if (r.type == 1) {
						rule.nummax = r.rule.nummax;
						rule.nummin = r.rule.nummin;
					} else if (r.type == 2) {
						rule.totalmax = r.rule.totalmax;
						rule.totalmin = r.rule.totalmin;
					} else if (r.type == 3) {
						rule.enrollmax = r.rule.enrollmax;
						rule.joined = (R.cgiData.exist >= r.rule.enrollmax);
					} else if (r.type == 4) {
						rule.totalmaxoneday = r.rule.totalmaxoneday;
						rule.totalminoneday = r.rule.totalminoneday;
					} else if (r.type == 5) {
						rule.group = r.rule.group;
					}
				}
				return rule;
			},
			switchIndex : function(more) {
				var p = $(more).parent();
				if (p.hasClass("box_up")) {
					p.removeClass("box_up");
					more.innerHTML = "<span>收起</span>";
				} else {
					p.addClass("box_up");
					more.innerHTML = "<span>更多</span>";
				}
			},
			switchBtnLike : function(liked, likeNum) {
				var btnLike = $("#like");
				if (liked == false) {
					btnLike.removeClass("praise_on");
				} else {
					btnLike.addClass("praise_on");
				}
				$("#cLike").text(likeNum);
			},
			createFrag4HTML : function(htmlStr) {
				var frag = document.createDocumentFragment(), temp = document
						.createElement('div');
				temp.innerHTML = htmlStr;
				while (temp.firstChild) {
					frag.appendChild(temp.firstChild);
				}
				return frag;
			},
			dateDiff : function(publishTime) {
				var myDate = new Date(publishTime * 1000), nowtime = new Date();
				var second = 1000;
				var minutes = second * 60;
				var hours = minutes * 60;
				var days = hours * 24;
				var months = days * 30;
				var years = days * 365;
				var longtime = nowtime.getTime() - myDate.getTime();
				if (longtime > years) {
					return (Math.floor(longtime / years) + "年前");
				} else if (longtime > months) {
					return (Math.floor(longtime / months) + "个月前");
				} else if (longtime > days) {
					return (Math.floor(longtime / days) + "天前");
				} else if (longtime > hours) {
					return (Math.floor(longtime / hours) + "小时前");
				} else if (longtime > minutes) {
					return (Math.floor(longtime / minutes) + "分钟前");
				} else if (longtime > second) {
					return (Math.floor(longtime / second) + "秒前");
				} else {
					return ("1秒前");
				}
			},
			fixedNavBar : function() {
				var R = ACTDetail.RUNTIME;
				R.navBar.hide()
				R.navBar.css("position", "fixed");
			},
			absNavBar : function() {
				var R = ACTDetail.RUNTIME;
				R.navBar.css("position", "absolute");
			},
			resizeLayout : function() {
				var R = ACTDetail.RUNTIME;
				FCAPP.Common.resizeLayout(R.popTips);
				ACTDetail.resizeInputBox($("#tfComment")[0]);
				ACTDetail.resizeInputBox($("#tfReply")[0]);
			},
			resizeInputBox : function(elment) {
				if (typeof elment != "undefined") {
					var resize = function() {
						var inputBox = $(elment);
						inputBox.css("height", "auto");
						inputBox.css("height", (elment.scrollHeight - 16)
								+ 'px')
					}
					ACTDetail.checkMaxLen(elment);
					setTimeout(resize, 0);
				}
			},
			checkMaxLen : function(textInput) {
				var area = $(textInput);
				var max = parseInt(area.attr("maxlength"), 10);
				if (max > 0) {
					if (area.val().length > max) {
						area.val(area.val().substr(0, max));
					}
				}
			},
			validCGIData : function(data) {
				var C = ACTDetail.CONFIG, success = (data.ret == 0);
				if (success == false) {
					var message = C.Error[data.ret];
					if (typeof (message) == 'undefined') {
						var len = 5, m = data.msg.indexOf("iRet:"), n = data.msg
								.indexOf("||"), iRet = 'unknow';
						if (m < 0) {
							m = data.msg.indexOf("ret:");
							len = 4;
						}
						if (m >= 0 && n >= 0 && n > m) {
							iRet = data.msg.substr(m + len, n - m - len);
						}
						message = C.Error[iRet];
						if (typeof (message) == 'undefined') {
							message = data.msg;
						}
					}
					var opts = {
						msg : message
					};
					if (data.ret == -100) {
						opts.ok = function() {
							ACTDetail.refreshMe();
						};
					}
					opts.noscroll = "true";
					FCAPP.Common.msg(true, opts);
				}
				return success;
			},
			refreshMe : function() {
				var url = "http://trade.qq.com/fangchan/act-detail.html";
				FCAPP.Common.jumpWithAuth(url, null);
			},
			goJoinPage : function(id) {
				id = id || '';
				FCAPP.Common.jumpTo('act-join.html', {
					refer : "act-detail.html"
				}, true);
			}
		};
var ACTDetail = FCAPP.ACTDetail;
$(document).ready(ACTDetail.init);