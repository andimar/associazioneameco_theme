$(document).ready(function() {
				
	$.cookiesDirective({
			privacyPolicyUri: '/cookies',
			cookieScripts: 'Google Analytics ', 
			linkColor: '#ffffff'
		});			
											 
	$('.tabs:not(:first)').hide();	/*nasconde tutti gli elementi tranne il primo*/
	
	$('#tabs li').click(function(e){    /*al click esegue la funzione*/
		$('.tabs').hide();								/*nasconde i div*/
		$('#tabs li').removeClass	('active');		/*rimuove la classe active*/							 
		$(this).addClass('active');	            /*e la aggiunge all'elemento selezionato*/
		var clicked = $(this).find('a:first').attr('href'); /*setto la variabile che trova l'elemento con attributo href*/
		$('#tabs ' + clicked).show(); /*mostra il div corrispondente all'href*/
		e.preventDefault();/*blocca l'azione di default del browser*/
		})
	.eq(0).addClass('active'); /* aggiunge al primo elemento (di indice 0) la classe active */
	
	
	
	$('.box-cd:not(:first)').hide();	/*nasconde tutti gli elementi tranne il primo*/
	
	$('#archivio-cd li').click(function(e){    /*al click esegue la funzione*/
		$('.box-cd').hide();								/*nasconde i div*/
		$('#archivio-cd li').removeClass	('active');		/*rimuove la classe active*/							 
		$(this).addClass('active');	            /*e la aggiunge all'elemento selezionato*/
		var clicked = $(this).find('a:first').attr('href'); /*setto la variabile che trova l'elemento con attributo href*/
		$('#archivio-cd ' + clicked).show(); /*mostra il div corrispondente all'href*/
		e.preventDefault();/*blocca l'azione di default del browser*/
		})
	.eq(0).addClass('active'); /* aggiunge al primo elemento (di indice 0) la classe active */
	
	
	$('li:nth-child(odd)').addClass('odd');
	$('li:nth-child(even)').addClass('even'); 
	$('li:first-child').addClass('first');
	$('li:last-child').addClass('last');
	$('.accordion > div:first-child').addClass('first');
	$('.accordion > div:last-child').addClass('last');	
	$('.accordion > li:first-child').addClass('first');
	$('.accordion > div:last-child').addClass('last');	
	
	
	
});