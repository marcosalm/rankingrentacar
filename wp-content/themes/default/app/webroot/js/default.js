/**
 * Ranking - Javascript
 */
 jQuery(document).ready(function($) {

	// Resolve conflitos entre jQuery UI e Bootstrap
	var bootstrapTooltip = $.fn.tooltip.noConflict();
	$.fn.bootstrapTl     = bootstrapTooltip;
	var datepicker       = $.fn.datepicker.noConflict();
	$.fn.bootstrapDP     = datepicker;

	$('form').validator({
		attr : 'data-title',
		hasDefault : true
	});

	$(document).tooltip();

	$('.ddd').mask('(99)');
	$('.tel').mask('99999-9999');
	
	$('.phone').focusout(function(){
    var phone, element;
    element = $(this);
    element.unmask();
    phone = element.val().replace(/\D/g, '');
    if(phone.length > 10) {
        element.mask("(99) 99999-999?9");
    } else {
        element.mask("(99) 9999-9999?9");
    }
}).trigger('focusout');
 
	$('.hora').mask('99:99');
	$('.cpf').mask('999.999.999-99');

	$('.selectyze').Selectyze({
		theme : 'firefox'
	});
	$('.selectyze1').Selectyze({
		theme : 'firefox1'
	});

	$('.calendario input[type=text]').bootstrapDP({
		language : 'pt-BR',
		format : 'dd/mm/yyyy',
		startDate : new Date()
	}).on('changeDate', function() {
		try {
			if ( $('#retirada_data').val() != "" && $('#devolucao_data').val() != "" ) {
				var ini = $('#retirada_data').val().split('/');
				var ini_date = new Date(ini[2], ini[1], ini[0]);
				var fim = $('#devolucao_data').val().split('/');
				var fim_date = new Date(fim[2], fim[1], fim[0]);
				if ( ini_date > fim_date) {
					alert("A data de retirada deve ser inferior a data de devolução");
					$('#retirada_data').val('');
					$('#devolucao_data').val('');
					$('#retirada_data').focus();
				}
			}
		} catch(e) {}

		$(this).bootstrapDP('hide');
	});

	$('.slide-dstk').destaque({
		btn : '.bt-dstk',
		curr : '.active',
		onStart : function(first) {
			$('.descricao-dstk li').removeClass('active').eq(first).addClass('active');
		},
		onChange : function(current) {
			$('.descricao-dstk li').removeClass('active').eq(current).addClass('active');
		}
	});

	var grupo;
	var veiculo;
	$('a.active', '.carros').on('click', function(e, data) {
		e.preventDefault();

		var $me           = $(this).parents('ul');
		var id            = $(this).attr('rel');
		var $ajaxBox      = $('.ajax-box-veiculos');
		var $ajaxBoxInner = $('.box-selecao-veiculos');
		var $ajaxBoxSeta  = $('.seta-box', $ajaxBoxInner);
		var $form         = $(this).parents('form');
		var $li           = $('li', $form);
		var $parentLi     = $(this).parents('li');
		grupo             = id;
		veiculo           = (typeof(data) === "object") ? data.veiculo : false;

		$ajaxBoxInner.hide();
		$ajaxBox.hide();
		$ajaxBox.find('li').remove();
		$ajaxBoxSeta.css('left', $parentLi.position().left);

		$ajaxBox.css({
			'width' : 700,
			'height' : 'auto',
			'z-index' : 9999
		});

		$.post(base_url + 'ajax/reserva/veiculos', { id : id }, function(data) {
			if (data) {
				var $ul = $('ul', $ajaxBox);

				for (i = 0; i < data.length; i++) {
					var img  = $('<img />').attr('src', data[i].image);
					var span = $('<span />').text(data[i].text);
					var a    = $('<a />').attr('href', 'javascript:;').attr('rel', data[i].ID);
					var li   = $('<li />');
					a.append(img);
					a.append(span);
					li.append(a);
					$ul.append(li);
				}

				$ajaxBox.insertAfter($me);

				if (veiculo) {
					$ajaxBoxInner.find('li a[rel=' + veiculo + ']').parent().addClass('active');
				}

				$ajaxBoxInner.show();
				$ajaxBox.attr('rel', id);
				$ajaxBox.show();
			}
		}, 'json');
	});

	$('.box-selecao-veiculos').on('click', 'a', function(e) {
		var veiculo = $(this).attr('rel');

		$('input[name=veiculo]').val(veiculo);
		$('input[name=grupo]').val(grupo);

		if (veiculo && grupo) {
			$('form').submit();
		}

		//alert("Veículo selecionado. Para prosseguir, favor clicar no botão continuar");
	});

	/*$(document).click(function() {
		var $ajaxBox = $('.ajax-box-veiculos');
		if ( $ajaxBox.is(':visible') ) {
			$ajaxBox.hide();
		}
	});*/
			
	$('form').submit(function(e) { 
		var msg = [];

		var email   = $(this).find('input[name=email]');
		if ( email.size() > 0 && ((email.val().indexOf("@") < -1) || (email.val().indexOf('.') < 7) ) ) {
			msg.push("- O Campo e-mail deve ser válido");
		}

		var cpfcnpj = $(this).find('input[name=cpfcnpj]');
		if ( cpfcnpj.size() > 0 && ( cpfcnpj.val() == "" || !isCpf( cpfcnpj.val() ) ) ) {
			msg.push("- O Campo CPF deve ser válido");
		}

		try {
			var horaR    = $(this).find('input[name=retirada\\_hora]');
			var horaD    = $(this).find('input[name=devolucao\\_hora]');
			var ini      = $('#retirada_data').val().split('/');
			var ini_date = new Date(ini[2], ini[1], ini[0]);
			var fim      = $('#devolucao_data').val().split('/');
			var fim_date = new Date(fim[2], fim[1], fim[0]);

			if (horaR.size() > 0 && horaD.size() > 0) {
				var horaRV = horaR.val().replace(/[^0-9]/ig, '');
				var horaDV = horaD.val().replace(/[^0-9]/ig, '');
				if ( horaRV > horaDV && (ini_date.getDate() == fim_date.getDate()) ) {
					msg.push("A hora de retirada deve ser inferior a hora de devolução");
				}
			}

			if ( !isHour( horaR.val() ) ) {
				msg.push("A hora de retirada deve ser válida");
			}		

			if ( !isHour( horaD.val() ) ) {
				msg.push("A hora de devolução deve ser válida");
			}
		} catch(e) {}

		if (msg.length > 0) { 
			e.preventDefault(); 
			alert(msg.join("\n"));
			msg = [];
		}
	});

	var $navbarC = $('.row.tp-maior');
	var $navbarS = $('.row.tp-menor');
	var navbarH  = $navbarC.height();
	$(window).scroll(function(e) {
		var scroll = $(this).scrollTop();
		if (scroll > navbarH) {
			if ( $navbarC.is(':visible') && !$navbarS.is(':visible') ) {
				$navbarC.fadeOut();
				$navbarS.show();
			}
		}
		else {
			if ( !$navbarC.is(':visible') && $navbarS.is(':visible') ) { 
				$navbarS.fadeOut();
				$navbarC.show();
			}
		}
	});

});