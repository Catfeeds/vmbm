
var areadata = function(o)
{
	var _cmbProvince=o._cmbProvince,//省
		_cmbCity=o._cmbCity,//市
		_cmbArea=o._cmbArea,//县
		defaultProvince=o.defaultProvince,//默认省
		defaultCity=o.defaultCity,//默认市
		defaultArea=o.defaultArea,//默认市
		cmbProvince = document.getElementById(_cmbProvince),
		cmbCity = document.getElementById(_cmbCity),
		cmbArea = document.getElementById(_cmbArea),
		provinceList = [],
		xmlHttp = null;
	
	function cmbSelect(cmb, str)
	{
		for(var i=0; i<cmb.options.length; i++)
		{
			if(cmb.options[i].value == str)
			{
				cmb.selectedIndex = i;
				return;
			}
		}
	}
	function cmbAddOption(cmb, str, obj)
	{
		var option = document.createElement("OPTION");
		cmb.options.add(option);
		option.innerHTML = str;
		option.value = obj.id;
		option.obj = obj;
	}
	
	function changeCity()
	{
		if(cmbArea==undefined){return false;}
		cmbArea.options.length = 0;
		if(cmbCity.selectedIndex == -1)return;
		var item = cmbCity.options[cmbCity.selectedIndex].obj;
		for(var i=0; i<provinceList.length; i++)
		{
			if(provinceList[i].pid==item.id){
				if(provinceList[i].name=="市辖区"||provinceList[i].name=="市辖县"||provinceList[i].name=="县"){
				}else{
					cmbAddOption(cmbArea, provinceList[i].name, provinceList[i]);
				}
				
			}
			
		}
		cmbSelect(cmbArea, defaultArea);
	}
	function changeProvince()
	{
		if(cmbCity==undefined){return false;}
		cmbCity.options.length = 0;
		cmbCity.onchange = null;
		if(cmbProvince.selectedIndex == -1)return;
		var item = cmbProvince.options[cmbProvince.selectedIndex].obj;
		for(var i=0; i<provinceList.length; i++)
		{
			if(provinceList[i].pid==item.id){
				//if(provinceList[i].name=="市辖区"||provinceList[i].name=="市辖县"||provinceList[i].name=="县"){return false;}
				cmbAddOption(cmbCity, provinceList[i].name, provinceList[i]);
			}
		}
		cmbSelect(cmbCity, defaultCity);
		changeCity();
		cmbCity.onchange = changeCity;
	}
	
	function initAreaData() {
	    try {
	        xmlHttp = new XMLHttpRequest();
	    } catch (e) {
	        try {
	            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
	        } catch (e) {
	            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	    }
		if (xmlHttp == null) {
			alert("浏览器不支持");
			return;
		}
		var url = "/base/js/areadata.js";
		xmlHttp.onreadystatechange = stateChanged;
		xmlHttp.open("GET", url, true);
		xmlHttp.send();
	}
	
	function stateChanged (){
		if (xmlHttp.readyState == 4) {
			provinceList = eval("("+xmlHttp.responseText+")");
			for(var i=0; i<provinceList.length; i++)
			{
				if(cmbProvince==undefined){return false;}
				if(provinceList[i].pid==0){
					cmbAddOption(cmbProvince, provinceList[i].name, provinceList[i]);
				}		
			}
			cmbSelect(cmbProvince, defaultProvince);
			changeProvince();
			cmbProvince.onchange = changeProvince;
		}
	}
	initAreaData();
}
