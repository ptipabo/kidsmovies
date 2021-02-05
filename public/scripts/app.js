let iframeContainer = document.getElementById('iframeContainer')
let videoNavBar = document.getElementById('videoNavBar')

//Quand la souris se trouve sur l'iframe...
iframeContainer.addEventListener("mouseover", function(){
    //Si la souris bouge...
    iframeContainer.onmousemove = function(){
        //On initialise un compteur
        let timeout
        //On récupère la barre de navigation des vidéos
        let videoNavBar = document.getElementById('videoNavBar')
        console.log('The mouse is moving')
        //On l'affiche
        videoNavBar.removeAttribute('class')
        //On réinitialise le compteur
        clearTimeout(timeout);
        //On redémarre le compteur
        timeout = setTimeout(function(){
            //Quand le compteur atteint le temps souhaité, on masque la barre de navigation
            videoNavBar.setAttribute('class','hide')
        }, 3000);
    }
}

iframeContainer.addEventListener("mouseleave", function() {
    videoNavBar.setAttribute('class','hide')
});