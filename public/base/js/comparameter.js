/**
 * Created by tanqilin on 2016/6/20.
 */
(function(w){
	function classCompar(){
		//基础
 	}
 	classCompar.prototype.templateCheckbox = function(data) {
 		// 参数
 		data = data ? data : {};
 		return "<label class="checkbox-inline i-checks">\
                	<div class="icheckbox_square-green" style="position: relative;">\
                    	<input type="checkbox" value="option1" style="position: absolute; opacity: 0;">\
                    	<ins class="iCheck-helper" ></ins>\
                    </div>\
                    <span>红色</span>\
                    <input type="text" placeholder="红色" class="form-control" style="display:inline-block; width:80px;" />\
            	</label>";
 	};
 	classCompar.prototype.classList = function(first_argument) {
 		// 类型类别
 	};
 	classCompar.prototype.tableThead = function(first_argument) {
 		// 数据表格Thead
 	};
 	classCompar.prototype.tabletbody = function(first_argument) {
 		// 数据表格tbody
 	};
	w.$compar = new classCompar();
})(window);