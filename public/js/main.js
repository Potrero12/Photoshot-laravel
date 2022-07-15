const url = 'http://photoshot.com.devel/';
window.addEventListener("load", function(){
	
	$('.btn-like').css('cursor', 'pointer');
	$('.btn-dislike').css('cursor', 'pointer');

	// Botón de like
	function like(){
		$('.btn-like').unbind('click').click(function(){
			console.log('like');
			$(this).addClass('btn-dislike').removeClass('btn-like');
			$(this).attr('src', url+'img/colorrojo.png');
			
			$.ajax({
				// para usar el data se debe usar  en el html el data-id="{{$image->id}}"
				url: url+'like/'+$(this).data('id'),
				type: 'GET',
				success: function(response){
					if(response.like){
						console.log('Has dado like a la publicacion');
					}else{
						console.log('Error al dar like');
					}
				}
			});

			dislike();
		});
	}
	like();
	
	// Botón de dislike
	function dislike(){
		$('.btn-dislike').unbind('click').click(function(){
			console.log('dislike');
			$(this).addClass('btn-like').removeClass('btn-dislike');
			$(this).attr('src', url+'img/colorgris.png');
			
			$.ajax({
				url: url+'dislike/'+$(this).data('id'),
				type: 'GET',
				success: function(response){
					if(response.like){
						console.log('Has dado dislike a la publicacion');
					}else{
						console.log('Error al dar dislike');
					}
				}
			});
			
			like();
		});
	}
	dislike();
	
	// BUSCADOR
	$('#buscador').submit(function(e){
		$(this).attr('action',url+'/gente/'+$('#buscador #search').val());
	});
	
});