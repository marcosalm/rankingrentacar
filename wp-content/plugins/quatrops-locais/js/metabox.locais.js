/**
 * jQuery Ready
 */
jQuery(document).ready(function($) {

	// JQuery UI Tabs
	$('#tabs').tabs();

	// Máscara
	$('.phone').mask('(99) 9999-9999');

	// Validação de campos
	$('#post').validator({
		attr : 'title',
		fail : function() {
			$('.spinner').removeAttr('style');
			$('#publish').removeClass('button-primary-disabled');
		}
	});

	var geocoder = new google.maps.Geocoder();
	var $address = $('#meta-box-local-endereco');
	var $lat     = $('#meta-box-local-latitude');
	var $lng     = $('#meta-box-local-longitude');

	// Endereço > Coordenadas
	$('input[name=addresslatlng]').on('click', function() {
		if ( $address.val() != "" && ($lat.val() == "" || $lat.val() == "") ) {
			geocoder.geocode({ 'address' : $address.val() }, function(results, status) {
				if (google.maps.GeocoderStatus.OK == status) {
					var point = results[0].geometry.location;
					$lat.val( point.lat() );
					$lng.val( point.lng() );
				}
			});
		}
	});

	// Coordenadas > Endereço
	$('input[name=latlngaddress]').on('click', function() {
		if ( ($lat.val() != "" && $lng.val() != "") && $address.val() == "" ) {
			var latlng = new google.maps.LatLng( $lat.val(), $lng.val() );
			geocoder.geocode({ 'latLng' : latlng }, function(results, status) {
				if (google.maps.GeocoderStatus.OK == status) {
					if (results[1]) {
						var place = results[1].formatted_address;
						$address.val(place);
					}
				}
			});
		}
	});
});