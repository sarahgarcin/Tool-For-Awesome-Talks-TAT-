$(document).ready(function(){
	var $el = $('.damier ul.liste-damier > li');

	// supprimer l'image dans le damier si elle a une légende
	$el.each(function(){
		if($(this).find('figure').attr('data-legend')){
			$(this).prev().remove();
		}
	});

	
	$el.click(function(){
		$el.removeClass('active');
		previewSlide($(this));

	});

	// déplacement avec des flèches
	$(document).keydown(function(e) {
		var $activeEl =  $('.damier ul.liste-damier li.active');
		if($activeEl.length < 1){
			$activeEl = $('.damier ul.liste-damier > li:first-child');
			previewSlide($activeEl);
		}
		
    switch(e.which) {
      case 37: // left
      	// if($activeEl.index() != 0){
					previewSlide($activeEl.prev());
      		$activeEl.removeClass('active');
      	// }

      break;

      case 38: // up
      	var index = ($activeEl.index()-4);
      	// console.log("Key Up: ", index);
      	// $el.eq(index).addClass('active');
      	previewSlide($el.eq(index));
      	$activeEl.removeClass('active');
      	
      break;

      case 39: // right
      	// $activeEl.next().addClass('active');
      	// if($activeEl.index() != $el.length){
      		previewSlide($activeEl.next());
      		$activeEl.removeClass('active');
      	// }
      	
      	
      break;

      case 40: // down
      	var index = ($activeEl.index()+4);
      	// console.log("Key Down: ", index);
      	// console.log($el.eq(index));
      	// $el.eq(index).addClass('active');
      	previewSlide($el.eq(index));
      	$activeEl.removeClass('active');
      	
      break;

      default: return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
	});

	
});



	function previewSlide($this){
		var $el = $('.damier ul.liste-damier > li');
		var $preview = $('.preview .image-wrapper');
		
		$preview.html('');
		$('.preview').removeClass('texte');
		$('.preview').removeClass('image');


		if($this.hasClass('image')){
			$imagePath = $this.find('figure').attr('data-image');
			console.log($imagePath);
			$preview.append('<img src="'+$imagePath+'" alt="">');
			if($this.find('figure').attr('data-legend')){
				$legend = $this.find('figcaption').html();
				$preview.append('<div class="legend">'+	$legend+'</div>');
				setTimeout(function(){
					var legendH = $(".legend").height();
					$('body').find('.preview.image').find('img').css('height', ($(window).height() - 30 - (legendH *2.5)) + 'px');
				}, 100);

			}
			$this.addClass('active');
			$('.preview').addClass('image');
		}
		if($this.hasClass('texte')){
			console.log('this is a text');
			$content = $this.html();
			// console.log($content);
			$preview.html($content);
			$('.preview').addClass('texte');
			$this.addClass('active');

			// transforme les liens cliquables en liens nouvel onglet
			$('.preview .image-wrapper a').each(function(){
				$(this).attr('target', '_blank');
			});	
		}
		if($this.hasClass('video')){
			$videoPath = $this.attr('data-video');
			console.log($videoPath);
			$preview.append('<video controls src="'+$videoPath+'"></video>');
			$this.addClass('active');
		}
		if($this.hasClass('audio')){
			$audioPath = $this.attr('data-audio');
			console.log($audioPath);
			$preview.append('<audio controls src="'+$audioPath+'"></audio>');
			$this.addClass('active');
		}
		if($this.hasClass('pdf')){
			$pdfPath = $this.attr('data-pdf');
			console.log($pdfPath);
			$preview.append('<object data="'+$pdfPath+'" type="application/pdf"><embed src="'+$pdfPath+'" type="application/pdf" /></object>');
			$this.addClass('active');
		}
	}







