var slides = document.querySelectorAll('.slide');
var selectors = document.querySelectorAll('.selector');
let currentSlide = 1;

//js image slider manual navigation
var manualNav = function(manual) {

	slides.forEach((slide) => {
		slide.classList.remove('active');

		selectors.forEach((selector) => {
			selector.classList.remove('active');
		})
	})

	slides[manual].classList.add('active');
	selectors[manual].classList.add('active');
}

selectors.forEach((selector, i) => {
	selector.addEventListener("click", () => {
		manualNav(i);
		currentSlide = i;
	});
});

//js image slider auto navigation
var repeat = function(activeClass) {
	let active = document.getElementsByClassName('active');
	let i = 1;

	var repeater = () => {
		setTimeout(function() {

			[...active].forEach((activeSlide) => {
				activeSlide.classList.remove('active');
			})

			slides[i].classList.add('active');
			selectors[i].classList.add('active');
			i++;

			if (slides.length == i) {
				i = 0;
			}
			if (i >= slides.length) {
				return;
			}
			repeater();
		}, 5000);
	}
	repeater();
}
repeat();


// faq
var acc = document.getElementsByClassName('accordion-faq');
var j;
var len = acc.length;
for (j = 0; j < len; j++) {
	acc[j].addEventListener('click', function() {
		this.classList.toggle('active-faq');
		var panel = this.nextElementSibling;
		if(panel.style.maxHeight) {
			panel.style.maxHeight = null;
		} else {
			panel.style.maxHeight = panel.scrollHeight + 'px';
		}
	});
}