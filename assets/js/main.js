/* BlogWings theme UI: header, mobile nav, dropdowns, search overlay, dark mode. */
( function () {
	var root = document.documentElement;
	var header = document.querySelector( '[data-bwt-header]' );

	// Scrolled state for the glass header.
	if ( header ) {
		var onScroll = function () { header.classList.toggle( 'is-scrolled', window.scrollY > 8 ); };
		onScroll();
		window.addEventListener( 'scroll', onScroll, { passive: true } );
	}

	// Mobile menu.
	var burger = document.querySelector( '[data-bwt-burger]' );
	if ( burger ) {
		burger.addEventListener( 'click', function () {
			var open = document.body.classList.toggle( 'bwt-nav-open' );
			burger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	}

	// Dropdown toggles (touch + keyboard).
	document.querySelectorAll( '.bwt-drop__toggle' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			var li = btn.closest( 'li' );
			var open = ! li.classList.contains( 'is-open' );
			document.querySelectorAll( '.bwt-menu > li.is-open' ).forEach( function ( o ) {
				if ( o !== li ) { o.classList.remove( 'is-open' ); o.querySelector( '.bwt-drop__toggle' ).setAttribute( 'aria-expanded', 'false' ); }
			} );
			li.classList.toggle( 'is-open', open );
			btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		} );
	} );
	document.addEventListener( 'click', function ( e ) {
		if ( ! e.target.closest( '.bwt-menu' ) ) {
			document.querySelectorAll( '.bwt-menu > li.is-open' ).forEach( function ( o ) { o.classList.remove( 'is-open' ); } );
		}
	} );

	// Search overlay.
	var lay = document.querySelector( '[data-bwt-search]' );
	function openSearch() {
		if ( ! lay ) { return; }
		lay.hidden = false;
		requestAnimationFrame( function () { lay.classList.add( 'is-open' ); } );
		var input = lay.querySelector( 'input[type=search]' );
		if ( input ) { setTimeout( function () { input.focus(); }, 50 ); }
	}
	function closeSearch() {
		if ( ! lay || lay.hidden ) { return; }
		lay.classList.remove( 'is-open' );
		setTimeout( function () { lay.hidden = true; }, 180 );
	}
	document.querySelectorAll( '[data-bwt-search-open]' ).forEach( function ( b ) { b.addEventListener( 'click', openSearch ); } );
	if ( lay ) {
		lay.addEventListener( 'click', function ( e ) { if ( e.target === lay ) { closeSearch(); } } );
	}
	document.addEventListener( 'keydown', function ( e ) {
		if ( e.key === 'Escape' ) { closeSearch(); document.body.classList.remove( 'bwt-nav-open' ); }
		if ( ( e.metaKey || e.ctrlKey ) && e.key.toLowerCase() === 'k' ) { e.preventDefault(); openSearch(); }
	} );

	// Dark mode.
	var toggle = document.querySelector( '[data-bwt-theme-toggle]' );
	if ( toggle ) {
		toggle.addEventListener( 'click', function () {
			var current = root.getAttribute( 'data-theme' ) || ( window.matchMedia( '(prefers-color-scheme: dark)' ).matches ? 'dark' : 'light' );
			var next = current === 'dark' ? 'light' : 'dark';
			root.setAttribute( 'data-theme', next );
			try { localStorage.setItem( 'bwt-mode', next ); } catch ( err ) {}
		} );
	}
} )();
