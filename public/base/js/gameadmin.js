/**
 * Created by misszhou on 2016/5/17.
 */
var GameAdmin = function(id, openid){
    //活动ID
    this.activity_id = id;
    this.openid = openid;
    this.poststart = false;
    this.urls = {};

    this.defaults = {};
    this.defaults.dtime = 1250;
    this.defaults.SUCESS_CODE = 200;
    this.defaults.FAILURE_CODE = 400;
    this.defaults.SERVER_ERROR = 500;
    this.defaults.NO_PERMISSION = 401;
    this.defaults.PAGE_NUMS = 10;
    this.defaults.PAGE_MAX_NUMS = 50;

    this.init();
};

/**
 * 弹框提示
 * @param time
 * @param html
 * @param type
 * @private
 */
GameAdmin.prototype._alert = function(html, type, time){
    type = type || "1";
    var html2='<div class="GameMsg">\
				<div>\
				'+html+'\
				</div>\
			</div>\
			<div class="GameMsgBg"></div>';
    switch(type){
        case "1"://时间自动关闭
            if($(".GameMsg").length!=0){
                $(".GameMsg").show().find("div").html(html);
            }else{
                $("body").append(html2);
            }
            closefn(time);
            break;
        default:
    }
    function closefn(time){
        time=time?time:1250;
        setTimeout(function(){
            $(".GameMsg,.GameMsgBg").remove();
        },time)
    }
};
GameAdmin.prototype.init = function(){
    // post请求数据是否开始
    this.poststart = false;

    // 添加埋点
    this.urls.buriedpoint = '/api/buriedpoint';// 埋点
    this.urls.draw = '/api/draw';// 抽奖
    this.urls.rankinglist = '/api/rankinglist';// 获取排行榜
    this.urls.createranking = '/api/createranking';// 添加排行榜
    this.urls.awardslist = '/api/awardslist';// 我的奖品列表
    this.urls.awardsdetail = '/api/awardsdetail';// 奖品详细信息
    this.urls.getpartake = '/api/getpartake';// 获取活动参与人数
    this.urls.getfirst = '/api/first';// 根据活动ID获取最好的成绩
    this.urls.myresult = '/api/myresult';// 获取我的最佳成绩
    this.urls.createpricecollect = '/api/createpricecollect';// 添加兑奖码收藏
    this.urls.mydrawnumber = '/api/mydrawnumber';// 我的抽奖次数
};
GameAdmin.prototype.mydrawnumber = function(data, callback){
    // 我的抽奖次数
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'activity_id' : this.activity_id,
        'openid' : this.openid
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.mydrawnumber, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.awardsdetail = function(data, callback){
    // 奖品详细信息
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'activity_id' : this.activity_id,
        'awards_id' : data.awards_id
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.awardsdetail, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.createpricecollect = function(data, callback){
    // 添加兑奖码收藏
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'openid' : this.openid,
        'prize_id' : data.prize_id
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.createpricecollect, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.myresult = function(data, callback){
    // 获取我的最佳成绩
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'openid' : this.openid,
        'id' : this.activity_id,// 活动ID
        'type' : 'time' // 【score|time】
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.myresult, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.getfirst = function(data, callback){
    // 根据活动ID获取最好的成绩
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'id' : this.activity_id,
        'type' : 'time' // 【score|time】
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.getfirst, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.getpartake = function(data, callback){
    // 获取活动参与人数
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'activity_id' : this.activity_id
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.getpartake, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.rankinglist = function(data, callback){
    // 获取排行榜
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'id' : this.activity_id,
        'type' : 'time' // 【score|time】
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.rankinglist, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.createranking = function(data, callback){
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'openid' : this.openid,
        'activity_id' : this.activity_id,
        'record_time' : data.record_time,
        'record_score' : data.record_score
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    // 创建排行榜
    $.post(this.urls.createranking, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            console.log($data);
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.myPrize = function(data, callback){
    // 我的奖品
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'openid' : this.openid,
        'activity_id' : this.activity_id
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.awardslist, _data, function($data){
        _this.poststart = false;
        if($data.status == _this.defaults.SUCESS_CODE){
            var award = [];

            $.each($data.data, function(key,item){
                award.push({
                    Prizeid : item.awards_id,
                    PrizeName : item.award_desc,
                    PrizeText : item.award_name,
                    PrizeTime : item.award_time,
                    PrizeStatus : item.status_str,
                    PrizeCode : item.coupon_code
                });
            });

            var metmsg={
                data:award,
                status:$data.status,
                msg:$data.msg
            };
    //				Prizeid:2,//奖品id
    //				PrizeName:"一等奖",//奖品名称
    //				PrizeText:"价值50元礼品",//奖品名称
    //				PrizeTime:"2015.05.02至2015.06.02",//有效时间
    //				PrizeStatus:"未兑奖",//领取状态

            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback(metmsg);
            }
        }else{
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.draw = function(data, callback){
    this.postPartake();

    //用户抽奖
    var _this = this;
    var _data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'openid' : this.openid,
        'score' : data.score,
        'activity_id' : this.activity_id
    };
    if(_this.poststart != false){
        // 已经开始了一个post请求，必须等到post完成之后再发送请求
        return ;
    }
    _this.poststart = true;
    $.post(this.urls.draw, _data, function($data){
        _this.poststart = false;
        var data = {};
        if($data.status == _this.defaults.SUCESS_CODE){
            var option = $data.data;
            data = {
                Resuletype:(option.status==2?1:0),//0=未中奖  1=中奖  2=次数用完了
                Resuleid:(option.status==2?option.awardInfo.id:0),//奖品id
                ResuleFrequency:option.today_sy_count,//今日剩余次数
                ResuleLimitDrawTimes:option.more_is_limit_draw_times,//总体是否限制
                ResuleTotalTimes:option.total_sy_count,//总体剩余次数
                Resulenumber:option.partakeNum,//参与人数
                ResuleName:(option.status==2?option.awardInfo.award_desc:''),//奖品等级
                ResuleText:(option.status==2?option.awardInfo.award_name:''),//奖品名称
                ResuleUrl:"http://img-staging.liweijia.com/liweijia/wap/weixinActivity/images/gift.png",//奖品图片
            };

            var metmsg={
                data:data,
                status:$data.status,
                msg:$data.msg
            };

            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback(metmsg);
            }
        }else{            
            _this._alert($data.msg);
            callback($data);
        }
    });
};
GameAdmin.prototype.postView = function(){
    // 记录浏览-埋点
    this.postMaiDian('view', function(d){});
};
GameAdmin.prototype.postPartake = function(){
    // 记录参与人数-埋点
    this.postMaiDian('partake', function(d){});
};
GameAdmin.prototype.postAward = function(){
    // 记录获奖-埋点
    this.postMaiDian('award', function(d){});
};
GameAdmin.prototype.postConvert = function(){
    // 记录兑奖-埋点
    this.postMaiDian('convert', function(d){});
};
GameAdmin.prototype.postShare = function(){
    // 记录分享-埋点
    this.postMaiDian('share', function(d){});
};
GameAdmin.prototype.postMaiDian = function(topic, callback){
    // 记录--埋点
    var _this = this;
    var data = {
        '_token' : $('meta[name="_token"]').attr('content'),
        'topic' : topic,
        'openid' : this.openid,
        'id' : this.activity_id
    };
    $.post(this.urls.buriedpoint, data, function($data){
        if($data.status == _this.defaults.SUCESS_CODE){
            if(typeof callback != 'undefined' && callback instanceof Function) {
                callback($data);
            }
        }else{
            callback($data);
        }
    }, 'json');
};