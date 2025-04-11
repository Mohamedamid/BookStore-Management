let currentPath = window.location.pathname;

if (currentPath === "/home") {
    document.getElementById("dashboardLink").classList.add("active");
} else if (currentPath === "/user") {
    document.getElementById("usersLink").classList.add("active");
} else if (currentPath === "/role") {
    document.getElementById("rolesLink").classList.add("active");
} else if (currentPath === "/permission") {
    document.getElementById("permissionsLink").classList.add("active");
} else if (currentPath === "/livre") {
    document.getElementById("livresLink").classList.add("active");
} else if (currentPath === "/outil") {
    document.getElementById("outilsLink").classList.add("active");
} else if (currentPath === "/client") {
    document.getElementById("clientsLink").classList.add("active");
} else if (currentPath === "/commande") {
    document.getElementById("commandesLink").classList.add("active");
}
