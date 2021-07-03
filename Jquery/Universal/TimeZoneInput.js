var TimeZoneInput = function(DOMID, timeZoneRegion, timeZone) {

	this.DOMID = DOMID;
	this.regionDOMID = DOMID + "Region";
	this.timeZoneDOMID = DOMID + "timeZone";
	this.regionDropDownDOMID = DOMID + "RegionDropDown";
	this.zoneDropDownInnerDOMID = DOMID + "timeZoneInner";
	this.zoneDropDownDOMID = DOMID + "timeZoneDropDown";
	this.timeZoneRegion = timeZoneRegion == null ? 'America' : timeZoneRegion;
	this.timeZone = timeZone == null ? 'West Coast Time' : timeZone;
	var timeZoneRegions = ["Africa", "America", "Asia", "Atlantic", "Australia", "Europe", "Indian", "Pacific"];
	var that = this;
	var regionSelectCallback = function(regionSelected) {
		that.timeZoneRegion = regionSelected;
		that.getTimeZones();
	}
	
	this.timeZoneRegionDropDown = new DropDownBox(this.regionDropDownDOMID, timeZoneRegions, timeZoneRegions, this.timeZoneRegion, regionSelectCallback);
	this.timeZoneZoneDropDown = null;
	
};


TimeZoneInput.prototype = {
	
	timeZoneInputClass: "timeZoneInput",
	regionClass: "timeZoneRegion",
	zoneClass: "timeZoneZone",
	innerZoneClass: "timeZoneZoneInner",


	generate: function() {
		var ins = this.timeZoneZoneDropDown != null ? this.timeZoneZoneDropDown.generate() : null;
		var retStr = '<div id="' + this.DOMID + '" class="' + this.timeZoneInputClass + '"><div id="' + this.regionDOMID + '" class="' + this.regionClass + '">';
		retStr += '<span>World Region</span>' + this.timeZoneRegionDropDown.generate() + '</div>';
		retStr += '<div id="' + this.timeZoneDOMID + '" class="' + this.zoneClass + '"><span>Time Zone</span>';
		retStr += '<div id="' + this.zoneDropDownInnerDOMID + '" class="' + this.innerZoneClass + '">' + ins + '</div></div></div>';
		return retStr;
	},
	
	
	bind: function() {
		this.timeZoneRegionDropDown.bind();
		this.getTimeZones();
	},
	
	
	getTimeZones: function() {
		var that = this;
		var callback = function(data) {
			var tz = data.TimeZones, zonesAR = [], idsAR = [];
			var length = $.browser.msie ? tz.length-1 : tz.length;
			for (var i = 0; i < length; i++) {
				idsAR.push(tz[i].id);
				zonesAR.push(tz[i].zo);
			}
			that.timeZoneZoneDropDown = new DropDownBox(that.zoneDropDownDOMID, zonesAR, idsAR, that.timeZone);
			$("#" + that.zoneDropDownInnerDOMID).html(that.timeZoneZoneDropDown.generate());
			that.timeZoneZoneDropDown.bind();
		}
		var loadingImage = new LoadingImage("timeZonesLoading", 25, 25);
		$("#" + that.zoneDropDownInnerDOMID).html(loadingImage.generate());
		var timeZonesRequest = new Request("getTimeZones", {region: this.timeZoneRegion}, {}, false, callback, null);
		timeZonesRequest.getResponse();	
	},
	
	
	getValue: function() {
		if (this.timeZoneZoneDropDown != null)
			return this.timeZoneZoneDropDown.getValue();
		return null;
	}
	
	
};

		