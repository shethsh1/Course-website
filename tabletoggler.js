function toggletable() {
    var tables = document.getElementById("allTheTables");
    if (tables.style.display === "none") {
        tables.style.display = "block";
        document.getElementById("toggle").innerText="Hide Tables";
    } else {
        tables.style.display = "none";
        document.getElementById("toggle").innerText="Show Tables";
    }
}