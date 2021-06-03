"use strict";

{
	document.getElementsByClassName('menu-1__button')[0].onclick = function() {console.log(true)
		let links = document.getElementsByClassName('menu-1__link');
		let display = 'none';

		if (links[0].style.display !== 'block') {
			display = 'block';
		}

		for (let i in links) {
			try {
				links[i].style.display = display;
			} catch (err) {
				//console.log(err)
			}
		}
	}
}

