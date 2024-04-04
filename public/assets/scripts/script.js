function stabiliserFooter()
{
    if (document.body.scrollHeight <= window.innerHeight) 
    {
        document.querySelector("footer").classList.add("fixed");
        document.querySelector("footer").classList.add("bottom-0");
        document.querySelector("footer").classList.add("w-full");
    }
}

function changerCouleurElements() {
    document.addEventListener("DOMContentLoaded", function() 
    {
        var currentPageUrl = window.location.pathname;
    
        if (currentPageUrl.includes("/connexion") || currentPageUrl.includes("/inscription") || currentPageUrl.includes("/parametres")) 
        {
            var footer = document.querySelector("footer");
        
            if (footer) {
                footer.querySelectorAll("p, a").forEach(function(element) {
                    element.style.color = "white";
                });
            }
        }
    });
}

function fermerPopUp()
{
    var closeButton = document.querySelector('#alert button');

    closeButton.addEventListener('click', function() 
    {
        var alertBox = document.querySelector('#alert');

        if (alertBox) 
            alertBox.parentNode.removeChild(alertBox);
    });
}

function menuHamburger()
{
    var menuToggle = document.getElementById('menu-toggle');

    var menu = document.getElementById('menu');

    menuToggle.addEventListener('click', function() 
    {
        menu.classList.toggle('hidden');
    });
}



function showImagePreview(imageSrc) 
{
    var previewContainer = document.getElementById("imagePreviewContainer");
    var previewImage = document.getElementById("previewImage");

    previewImage.src = imageSrc;
    previewContainer.classList.remove("hidden");
}

function hideImagePreview() 
{
    previewContainer.classList.add("hidden");
}


function zoomerImage() 
{
    var closeButton;

    function hideImagePreview() 
    {
        var previewContainer = document.getElementById("imagePreviewContainer");
        previewContainer.classList.add("hidden");
    }

    var buttons = document.querySelectorAll(".image-preview-button");

    buttons.forEach(function(button) 
    {
        button.addEventListener("click", function() {
            var imageUrl = this.dataset.imageUrl;
            showImagePreview(imageUrl);
        });
    });

    function initCloseButton() 
    {
        closeButton = document.getElementById("closePreviewBtn");
        if (closeButton) 
        {
            closeButton.addEventListener("click", function() {
                hideImagePreview();
            });
        } else 
        {
            setTimeout(initCloseButton, 100);
        }
    }
    initCloseButton();

    var previewContainer = document.getElementById("imagePreviewContainer");
    previewContainer.addEventListener("click", function(event) 
    {
        if (event.target === previewContainer) 
        {
            hideImagePreview();
        }
    });
} 

function toggleEditMode(id) 
{
    var titreSpan = document.getElementById('titre-' + id);
    var titreInput = document.getElementById('input-titre-' + id);
    var dateSpan = document.getElementById('date-' + id);
    var texteParagraph = document.getElementById('texte-' + id);
    var texteTextarea = document.getElementById('textarea-texte-' + id);
    var imageButton = document.getElementById('voir-image-' + id);
    var imageInput = document.getElementById('input-image-' + id);
    var boutonEdition = document.getElementById('bouton-edition-' + id);
    var boutonSauvegarder = document.getElementById('bouton-sauvegarder-' + id);

    if (titreSpan && titreInput && dateSpan && texteParagraph && texteTextarea && imageInput && boutonEdition && boutonSauvegarder) {
        // Toggle the visibility of elements
        titreSpan.classList.toggle('hidden');
        titreInput.classList.toggle('hidden');
        dateSpan.classList.toggle('hidden');
        texteParagraph.classList.toggle('hidden');
        texteTextarea.classList.toggle('hidden');
        imageButton.classList.toggle('hidden');
        imageInput.classList.toggle('hidden');

        // Toggle the visibility of the "Modifier" and "Sauvegarder" buttons
        boutonEdition.classList.toggle('hidden');
        boutonSauvegarder.classList.toggle('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() 
{
    stabiliserFooter();
    zoomerImage();
    menuHamburger();
});

changerCouleurElements();
fermerPopUp();