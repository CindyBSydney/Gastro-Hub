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




// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})




const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})





if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}


window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})

const sunIcon = document.getElementById('sun-icon');
const moonIcon = document.getElementById('moon-icon');
const themeIconContainer = document.getElementById('theme-icon-container');

var tableCells = document.querySelectorAll("#content main .table-data .order table td, #content main .table-data .order table th");

const switchMode = document.getElementById('switch-mode');

// Read the theme from the cookie on page load
const theme = getCookie('theme');
if (theme === 'dark') {
  switchMode.checked = true;
  document.body.classList.add('dark');
  sunIcon.style.display = 'none';
  moonIcon.style.display = 'inline-block';
  themeIconContainer.style.backgroundColor = '#fff';
  tableCells.forEach(function(cell) {
    cell.style.borderRightColor = "white";
    cell.style.borderTopColor = "white";
  });
} else {
  switchMode.checked = false;
  document.body.classList.remove('dark');
  sunIcon.style.display = 'inline-block';
  moonIcon.style.display = 'none';
  themeIconContainer.style.backgroundColor = '#000';
  tableCells.forEach(function(cell) {
    cell.style.borderRightColor = "black";
    cell.style.borderTopColor = "black";
  });
}

switchMode.addEventListener('change', function () {
  if (this.checked) {
    setCookie('theme', 'dark', 365);
    document.body.classList.add('dark');
    sunIcon.style.display = 'none';
    moonIcon.style.display = 'inline-block';
    themeIconContainer.style.backgroundColor = '#fff';
    tableCells.forEach(function(cell) {
      cell.style.borderRightColor = "white";
      cell.style.borderTopColor = "white";
    });
  } else {
    setCookie('theme', 'light', 365);
    document.body.classList.remove('dark');
    sunIcon.style.display = 'inline-block';
    moonIcon.style.display = 'none';
    themeIconContainer.style.backgroundColor = '#000';
    tableCells.forEach(function(cell) {
      cell.style.borderRightColor = "black";
      cell.style.borderTopColor = "black";
    });
  }
});

// Helper function to set a cookie
function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
}

// Helper function to get the value of a cookie
function getCookie(name) {
  const cookieArr = document.cookie.split(';');
  for (let i = 0; i < cookieArr.length; i++) {
    const cookiePair = cookieArr[i].split('=');
    if (name === cookiePair[0].trim()) {
      return cookiePair[1];
    }
  }
  return null;
}
