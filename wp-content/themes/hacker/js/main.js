(function($) {
	'use strict';
	
	/*----------------------------------------------------------------------*/
	/* #Post Rating
	/*----------------------------------------------------------------------*/
	var PostRating = (function() {
		var s,
		settings = {
			$els: $('.js-rating'),
			flag: false
		};
		
		/**
		 * 初始化模块
		 */
		var fire = function() {
			s = settings;
			_bindUIActions();
		};
		
		/**
		 * 绑定UI事件
		 */
		var _bindUIActions = function() {
			var cookies = _getCookie("postRating");

			if( cookies ) {
				s.$els.each(function(index, el) {
					$.each( cookies, function(index, value) {
						if($(el).data('post') == value) {
							$(el).addClass('is-active');
							return false;
						}
					});
				});
			}

			s.$els.on('click', function(event) {
				event.preventDefault();
				var p = $(this).data('post');
				_ratingPost(p, this);
			});
		}
		
		var _ratingPost = function(p, that) {
			var rated = false,
				cookies = _getCookie("postRating");
			if( s.flag ) {
				return;
			}

			if( cookies ) {
				$.each( cookies, function(index, value) {
					if(p == value) {
						rated = true;
					}
				});
			}

			if( rated ) {
				alert(hacker_object.liked_text);
				s.flag = false;
				$(that).addClass('is-active');
				return;
			}

			s.flag = true;
			$.ajax({
				url: hacker_object.ajaxurl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'ajax_rating_post',
					post_id: p,
					nonce: hacker_object.rating_nonce
				},
			})
			.done(function(res) {
				if( res.status == 1 ) {
					$(that).find('.js-count').text(res.count);
					$(that).addClass('is-active');
				}
			})
			.always(function() {
				s.flag = false;
			});
			
		}

		var _getCookie = function(key) {
			var c, s, j, cookies;
		    c = document.cookie.split('; ');
		    cookies = {};

		    for( var i = c.length-1; i>=0; i-- ){
		       s = c[i].split('=');
		       cookies[s[0]] = unescape(s[1]);
		    }
			
			if( cookies["hacker"] ) {
				j = $.parseJSON( cookies['hacker'] );
				if( j[key] )
					return j[key];
				else
					return false;
			} else {
				return false;
			}
		}

		return {
			fire: fire
		}
		
	})();
	PostRating.fire();
	
})(jQuery);