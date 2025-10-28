( function () {
	function pickMobile( el ) {
		// Only choose once per block instance per page load
		// Check if inline script already made the choice
		if ( ! el._fhMobileChoice ) {
			el._fhMobileChoice = Math.random() < 0.5 ? 'A' : 'B';
		}
		const chosen = el._fhMobileChoice;

		const src =
			chosen === 'A' ? el.dataset.mobileASrc : el.dataset.mobileBSrc;
		const alt =
			chosen === 'A' ? el.dataset.mobileAAlt : el.dataset.mobileBAlt;

		return { src, alt };
	}

	function applyForElement( el, mql ) {
		const img = el.querySelector( '.fm-front-hero__img' );
		if ( ! img ) {
			return;
		}

		if ( mql.matches ) {
			// <= 767px → mobile
			const { src, alt } = pickMobile( el );
			if ( src ) {
				// Only update if different (prevents unnecessary reloads)
				if ( img.src !== src ) {
					img.src = src;
				}
				if ( typeof alt === 'string' ) {
					img.alt = alt;
				}
			}
		} else {
			// >= 768px → desktop
			const src = el.dataset.desktopSrc;
			const alt = el.dataset.desktopAlt || '';
			if ( src ) {
				// Only update if different (prevents unnecessary reloads)
				if ( img.src !== src ) {
					img.src = src;
				}
				img.alt = alt;
			}
		}
	}

	function init() {
		const mql = window.matchMedia( '(max-width: 767px)' );
		const all = document.querySelectorAll( '.fm-front-hero[data-fh]' );

		// Apply initial state for any blocks that weren't handled by inline script
		all.forEach( ( el ) => {
			// If inline script already handled mobile, skip initial apply
			if ( ! ( mql.matches && el._fhInitialIsMobile ) ) {
				applyForElement( el, mql );
			}
		} );

		// Update on viewport changes (debounced)
		let tid;
		const handler = () => {
			clearTimeout( tid );
			tid = setTimeout( () => {
				all.forEach( ( el ) => applyForElement( el, mql ) );
			}, 100 );
		};

		if ( mql.addEventListener ) {
			mql.addEventListener( 'change', handler );
		} else if ( mql.addListener ) {
			mql.addListener( handler );
		}
		window.addEventListener( 'orientationchange', handler, {
			passive: true,
		} );
		window.addEventListener( 'resize', handler, { passive: true } );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
