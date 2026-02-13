var map;
var MY_MAPTYPE_ID = 'custom_style';

function initialize() {
  var featureOpts = [
  {
        stylers: [
          { hue: '#ffd24f' },
          { saturation: -70 },
          { lightness: 25 },
          { weight: 0.8 }
        ]
      },
    {
      featureType: 'water',
      stylers: [
        { color: '#336699' }
      ]
    }, 
    {
      featureType: "all",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
    }
  ];
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      var zm = 5;
      var l = -122.8761927;
    } else {
      var zm = 7;
      var l = -120.8761927
    }
  var mapOptions = {
      zoom: zm,
      center: new google.maps.LatLng(37.4958352,l),
      scrollwheel: false,
      mapTypeControlOptions: {
        mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
      },
      mapTypeControl: false,
      mapTypeId: MY_MAPTYPE_ID
    };
  map = new google.maps.Map(document.getElementById('googlemaps'), mapOptions);
  
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(input);

  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    markers = [];

    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
   })


  var kmlLayer = new google.maps.KmlLayer({
    url: 'https://www.jenjilpackaging.com/case-studies-6.kml',
    preserveViewport: true,
    suppressInfoWindows: false,
    map: map
  });
  var styledMapOptions = {  };
  var customMapType = new google.maps.StyledMapType(featureOpts);
  map.mapTypes.set(MY_MAPTYPE_ID, customMapType);
}
function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCXI3fQ-_Fs2mlvDXtiJySJWgLZf6dNBSE&libraries=places&' + 'callback=initialize';
  document.body.appendChild(script);
}
window.onload = loadScript;