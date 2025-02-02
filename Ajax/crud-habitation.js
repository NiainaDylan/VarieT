function listHabitation(div, retour) {
    console.log("Nombre d'habitations :", retour.length); // Correction ici

    retour.forEach(habitation => {
        var item = document.createElement("div");
        item.classList.add("col-lg-4", "menu-item");
        div.appendChild(item);

        var a = document.createElement("a");
        a.classList.add("glightbox");
        
        var img = document.createElement("img");
        img.src = "assets/img/habitation/" + habitation['photo'];  // Correction ici
        img.classList.add("menu-img", "img-fluid");
        a.appendChild(img);
        item.appendChild(a);

        var h4 = document.createElement("h4");
        h4.textContent = habitation['type_habitation'];
        item.appendChild(h4);

        var p1 = document.createElement("p");
        p1.textContent = habitation['quartier'] + " with " + habitation['nb_chambre'];
        p1.classList.add("ingredients");
        item.appendChild(p1);

        var p2 = document.createElement("p");
        p2.textContent = habitation['loyer'] + " $/day";
        p2.classList.add("price");
        item.appendChild(p2);

        var p3 = document.createElement("p");

        // Bouton Supprimer
        var del = document.createElement("a");
        del.href = "delete-dwelling?id=" + habitation['id_habitation'];
        var trash = document.createElement("i");  // Correction ici
        trash.classList.add("bi", "bi-trash");
        del.appendChild(trash);
        p3.appendChild(del);

        // Bouton Ajouter une photo
        var addPhoto = document.createElement("a");
        addPhoto.href = "add-photo?id=" + habitation['id_habitation'];
        var addIcon = document.createElement("i");  // Correction ici
        addIcon.classList.add("bi", "bi-file-plus-fill");
        addPhoto.appendChild(addIcon);
        p3.appendChild(addPhoto);

        // Bouton Modifier
        var update = document.createElement("a");
        update.href = "update?id=" + habitation['id_habitation'];
        var pencil = document.createElement("i");  // Correction ici
        pencil.classList.add("bi", "bi-pencil-fill");
        update.appendChild(pencil);
        p3.appendChild(update);

        // Bouton Voir les photos
        var listePhoto = document.createElement("a");
        listePhoto.href = "list-photo?id=" + habitation['id_habitation'];
        var photoIcon = document.createElement("i");  // Correction ici
        photoIcon.classList.add("bi", "bi-file-earmark-image-fill");
        listePhoto.appendChild(photoIcon);
        p3.appendChild(listePhoto);

        item.appendChild(p3);
        div.appendChild(item);
    });
}

function displayList() {
    var div = document.getElementById('habitation-list');
    
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/admin-habitation-list", true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                var retour = JSON.parse(xhr.responseText);
                listHabitation(div, retour);
            } else {
                console.error("Erreur XHR :", xhr.status);
            }
        }
    };
    
    xhr.send();
}

// Exécuter au chargement de la page
document.addEventListener("DOMContentLoaded", displayList);
