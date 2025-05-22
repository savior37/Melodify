    var dropdowns = document.querySelectorAll(".dropdown-list");
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.add("hide");
    }

    var dropdowns = document.querySelector("header").querySelectorAll(".dropdown");
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].addEventListener("click", function(e) {
            var links = e.currentTarget.parentNode.querySelectorAll(".dropdown-list");
            for (var i = 0; i < links.length; i++) {
                if(e.currentTarget.querySelector(".dropdown-list") !== links[i])
                    links[i].classList.add("hide");
            }
            e.currentTarget.querySelector(".dropdown-list").classList.toggle("hide");
        });
    }

    var links = document.querySelector("header").querySelectorAll(".nav-item");

    for (var i = 0; i < links.length; i++) {
        
    if (links[i].children[0].href == window.location.href || links[i].children[0].href+"/"== window.location.href) 
        {
        links[i].classList.add("active");
        }
}
