<link rel="stylesheet" href="<?php echo base_url()."theme/css/leaflet.css" ?>" />
  <style>
  #worldmap{
	height:440px;
	width:width:900px;
    background:white;
  }
.info {
	font-family: 'NexaLight';font-size: 0.8rem;
	padding: 3px 4px;
	/*font: 14px/16px Verdana, Geneva, sans-serif;*/
	background: white;j
	background: rgba(255,255,255,0.8);
	box-shadow: 0 0 5px rgba(0,0,0,0.2);
	border-radius: 5px;
	width:250px;
}
.info h4 {
	/*font-family: Verdana, Geneva, sans-serif;*/
	/*margin: 0 0 5px;*/
	color: #a34e25;
	font-size:15px;
}
.legend {
	line-height: 18px;
	color: #555;
	width: auto !important;
}
.legend i {
		width: 18px;
		height: 18px;
		float: left;
		margin-right: 8px;
		opacity: 0.7;
}
.leaflet-control-zoom-in{color:#ed7d28 !important;}
.leaflet-control-zoom-out.leaflet-disabled{color:#bbb !important;}
.leaflet-control-zoom-out{color:#ed7d28 !important;}
</style>	  
  
  <div id="worldmap"></div>
  <script>
    // Copyright (c) 2013 Ryan Clark
    // https://gist.github.com/rclark/5779673
    L.TopoJSON = L.GeoJSON.extend({
      addData: function(jsonData) {    
        if (jsonData.type === "Topology") {
          for (key in jsonData.objects) {
            geojson = topojson.feature(jsonData, jsonData.objects[key]);
            L.GeoJSON.prototype.addData.call(this, geojson);
          }
        }    
        else {
          L.GeoJSON.prototype.addData.call(this, jsonData);
        }
      }  
    });
  </script>
  <script>

(function(){

    'use strict'

    var map = L.map('worldmap',{maxZoom:10,minZoom:4}),
      topoLayer = new L.TopoJSON(),
      colorScale = chroma
        .scale(['#f3a542', '#893101'])
        .domain([0,1]);
	
    map.setView([20.5937, 78.9629], 4);
	
        // control that shows state info on hover
        var info = L.control({position: 'topright'});
        info.onAdd = function (map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };
        // method that we will use to update the control based on feature           properties passed
        info.update = function (props) {
            var infoline = "Households with source of drinking water Within premises (%), Total";
            this._div.innerHTML = '<h4>' + infoline + '</h4>';
        };
        info.addTo(map);

	
	
        // LEGEND
        var legend = L.control({position: 'bottomleft'});
        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'info legend');
            var grades = [0, 10, 20, 50, 100, 200, 500, 1000];
            var grades1 = ['0-2','3-21','22-39','40-57','58-76'];
            var labels = [];

            // loop through our density intervals and generate a label with a colored square for each interval
            for (var i = 0; i < grades.length; i++) {
                var nf1 = '';
                if (i == (grades.length - 1)) {
                    nf1 = nFormatter(grades[i]) + '+';
                } else {
                    nf1 = nFormatter(grades[i]) + '-' + nFormatter(grades[i + 1]);
                }
                div.innerHTML += '<div>';
                div.innerHTML += '<i style="background:' + getColor(grades1[i]) + '"></i>';
                div.innerHTML += nf1;
                div.innerHTML += '</div>';
            }
            return div;
        };
        legend.addTo(map);
	
	$.getJSON('<?php echo base_url()."topojson/india.topo.json"; ?>').done(addTopoData);

    function addTopoData(topoData){
      topoLayer.addData(topoData);
      topoLayer.addTo(map);
      topoLayer.eachLayer(handleLayer);
    }

    function handleLayer(layer){
		var map_array ={"35":"60.6","34":"77.40000000000001","33":"34.9","32":"77.7","31":"83.7","30":"79.7","29":"44.5","28":"43.2","27":"59.4","26":"52.6","25":"76.40000000000001","24":"64","23":"23.9","22":"19","21":"22.4","20":"23.2","19":"38.6","18":"54.8","17":"24.1","16":"37.1","15":"31.2","14":"15.5","13":"29.3","12":"41.1","11":"52.6","10":"50.1","9":"51.9","8":"35","7":"78.40000000000001","6":"66.5","5":"58.3","4":"86.09999999999999","3":"85.90000000000001","2":"55.5","1":"48.2"};
		var state_code=parseInt(layer.feature.properties.STATE_CODE);
		var fillColor=getColor2(map_array[state_code]);
          
        layer.setStyle({
          fillColor : fillColor,
          fillOpacity: 1,
          color:'#555',
          weight:1,
          opacity:.5
        });

        layer.on({
          mouseover : enterLayer,
          mouseout: leaveLayer,
          click: zoomToFeature
        });
    }
	
    function enterLayer(e){
		this.bindPopup(this.feature.properties.STATE_CODE, {zIndexOffset:1000,maxWidth:600,autoPan: false,closeButton: false, offset: L.point(0, -20)});
		this.openPopup();

		var a_key=$('input[name="analytics-indicator"]').val();
		var url='<?php echo base_url()."survey/analytics/graph/".$survey_id; ?>';
		
		$.ajax({
			url: url+"/chart/"+a_key, // url where to submit the request
			type : "POST", // type of action POST || GET
			success : function(result) {
				var popup = e.target.getPopup();
				//console.log(popup.css("z-index"));
				popup.setContent('');
                popup.setContent(result);
                popup.update();		
				
                $("#analytics-frame").find("script").each(function(i) {
                    eval($(this).text());
					//drawChart1();
                });
				
			},
			error: function(xhr, resp, text) {
				console.log(xhr, resp, text);
			}
		});

		this.bringToFront();
			this.setStyle({
			weight:2,
			opacity: 1
		});
    }

    function leaveLayer(e){
		var popup = e.target.getPopup();
		popup.setContent('');
		popup.update();				
		this.closePopup();

		this.bringToBack();
			this.setStyle({
			weight:1,
			opacity:.5
		});
    }
	function zoomToFeature(e) {
		var map_array ={"35":"60.6","34":"77.40000000000001","33":"34.9","32":"77.7","31":"83.7","30":"79.7","29":"44.5","28":"43.2","27":"59.4","26":"52.6","25":"76.40000000000001","24":"64","23":"23.9","22":"19","21":"22.4","20":"23.2","19":"38.6","18":"54.8","17":"24.1","16":"37.1","15":"31.2","14":"15.5","13":"29.3","12":"41.1","11":"52.6","10":"50.1","9":"51.9","8":"35","7":"78.40000000000001","6":"66.5","5":"58.3","4":"86.09999999999999","3":"85.90000000000001","2":"55.5","1":"48.2"};
		var state_code=parseInt(e.target.feature.properties.STATE_CODE);
		if(map_array.hasOwnProperty(state_code)){
			console.log("Data exist");
			setState(state_code);
		}else{
			alert("Data Not Exists!!");
			console.log("Data not exist");
		}
	}
	function getColor(d) {
            var col = '';
			if(d=='0-2'){col='#f3a542'}
			if(d=='3-21'){col='#ea9232'}
			if(d=='22-39'){col='#d66100'}
			if(d=='40-57'){col='#bc5603'}
			if(d=='58-76'){col='#893101'}           
			return col;
        }

        function getColor2(d) {
            var d = Math.round(d);
			//            alert(d);
			return d > 76 ? '#893101' : 
			d > 57 ? '#bc5603' : 
			d > 39 ? '#d66100' : 
			d > 21 ? '#ea9232' : 
			d >= 2 ? '#f3a542' : 
			'#f4d8b6';        
		}
	function nFormatter(num) {
		 if (num >= 1000000000) {
			return (num / 1000000000).toFixed(1).replace(/\.0$/, '') + 'G';
		 }
		 if (num >= 1000000) {
			return (num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
		 }
		 if (num >= 1000) {
			return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
		 }
		 return num;
	}	
}());
  </script>
