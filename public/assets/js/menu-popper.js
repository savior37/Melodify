// Sembunyikan semua dropdown saat awal
var dropdownLists = document.querySelectorAll(".dropdown-list");
for (var i = 0; i < dropdownLists.length; i++) {
    dropdownLists[i].classList.add("hide");
}

// Tambahkan event click ke setiap dropdown di header
var dropdowns = document.querySelector("header").querySelectorAll(".dropdown");
for (var i = 0; i < dropdowns.length; i++) {
    dropdowns[i].addEventListener("click", function (e) {
        var currentDropdown = e.currentTarget.querySelector(".dropdown-list");
        var allDropdowns = e.currentTarget.parentNode.querySelectorAll(".dropdown-list");

        // Sembunyikan semua dropdown kecuali yang diklik
        for (var j = 0; j < allDropdowns.length; j++) {
            if (allDropdowns[j] !== currentDropdown) {
                allDropdowns[j].classList.add("hide");
            }
        }

        // Toggle dropdown yang diklik
        currentDropdown.classList.toggle("hide");
    });
}
var links = document.querySelector("header").querySelectorAll(".nav-item");

for (var i = 0; i < links.length; i++) {
    if (links[i].children[0].href == window.location.href||links[i].children[0].href+"/" == window.location.href) {
        links[i].classList.add("active");
    }
}
