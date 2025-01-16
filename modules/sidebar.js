const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});

// document.getElementById('calendar-btn').addEventListener('click', function(event) {
//     event.preventDefault(); // Prevent default link action

//     // Use fetch to load the calendar content
//     fetch('index.php')
//         .then(response => response.text())
//         .then(data => {
//             document.getElementById('content-container').innerHTML = data;
//         })
//         .catch(error => console.error('Error loading calendar:', error));
// });


