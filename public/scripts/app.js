//import DomElement from './components/DomElement.js'

class DomElement{

    constructor(id){
        this.element = document.getElementById(id)
        this.elementClasses = this.element.className.split(' ');

    }

    getClass(classNumber = null){
        if(classNumber === null){
            return this.elementClasses
        }
        else{
            return this.elementClasses[classNumber]
        }
    }

    addClass(className){
        this.element.classList.add(className)
    }

    removeClass(className){
        this.element.classList.remove(className)
    }
}

function orderBy(orderType){
    
    const byTitle = 'movieByTitle'
    const byDate = 'movieByDate'
    const bySuite = 'movieBySuite'
    const byLength = 'movieByLength'
    
    let elementByTitle = new DomElement('movieByTitle')
    let elementByDate = new DomElement('movieByDate')
    let elementBySuite = new DomElement('movieBySuite')
    let elementByLength = new DomElement('movieByLength')

    let element = new DomElement(orderType)
    let elementClasses = element.getClass()

    //Si l'id de l'élément indiqué en paramètre est "movieByTitle"...
    if(orderType === byTitle){
        //On rend le div "movieByTitle" visible
        element.removeClass('hidden')
    
        //Si c'est le div "movieByDate" qui n'est pas masqué, on le masque
        if(!elementByDate.getClass(1) || elementByDate.getClass(1) !== 'hidden'){
            elementByDate.addClass('hidden')
        }else if(!elementBySuite.getClass(1) || elementBySuite.getClass(1) !== 'hidden'){//Si c'est le div "movieBySuite" qui n'est pas masqué, on le masque
            elementBySuite.addClass('hidden')
        }else if(!elementByLength.getClass(1) || elementByLength.getClass(1) !== 'hidden'){//Si c'est le div "movieByLength" qui n'est pas masqué, on le masque
            elementByLength.addClass('hidden')
        }
    }else if(orderType === byDate){//Si  l'id de l'élément indiqué en paramètre est "movieByDate"...
        //On rend le div "movieByDate" visible
        element.removeClass('hidden')
    
        //Si c'est le div "movieByTitle" qui n'est pas masqué, on le masque
        if(!elementByTitle.getClass(1) && elementByTitle.getClass(1) !== 'hidden'){
            elementByTitle.addClass('hidden')
        }else if(!elementBySuite.getClass(1) && elementBySuite.getClass(1) !== 'hidden'){//Si c'est le div "movieBySuite" qui n'est pas masqué, on le masque
            elementBySuite.addClass('hidden')
        }else if(!elementByLength.getClass(1) && elementByLength.getClass(1) !== 'hidden'){//Si c'est le div "movieByLength" qui n'est pas masqué, on le masque
            elementByLength.addClass('hidden')
        }
    }else if(orderType === bySuite){//Si  l'id de l'élément indiqué en paramètre est "movieBySuite"...
        //On rend le div "movieBySuite" visible
        element.removeClass('hidden')
    
        //Si c'est le div "movieByTitle" qui n'est pas masqué, on le masque
        if(!elementByTitle.getClass(1) && elementByTitle.getClass(1) !== 'hidden'){
            elementByTitle.addClass('hidden')
        }else if(!elementByDate.getClass(1) && elementByDate.getClass(1) !== 'hidden'){//Si c'est le div "movieByDate" qui n'est pas masqué, on le masque
            elementByDate.addClass('hidden')
        }else if(!elementByLength.getClass(1) && elementByLength.getClass(1) !== 'hidden'){//Si c'est le div "movieByLength" qui n'est pas masqué, on le masque
            elementByLength.addClass('hidden')
        }
    }else if(orderType === byLength){//Si  l'id de l'élément indiqué en paramètre est "movieBySuite"...
        //On rend le div "movieBySuite" visible
        element.removeClass('hidden')
    
        //Si c'est le div "movieByTitle" qui n'est pas masqué, on le masque
        if(!elementByTitle.getClass(1) && elementByTitle.getClass(1) !== 'hidden'){
            elementByTitle.addClass('hidden')
        }else if(!elementByDate.getClass(1) && elementByDate.getClass(1) !== 'hidden'){//Si c'est le div "movieByDate" qui n'est pas masqué, on le masque
            elementByDate.addClass('hidden')
        }else if(!elementBySuite.getClass(1) && elementBySuite.getClass(1) !== 'hidden'){//Si c'est le div "movieBySuite" qui n'est pas masqué, on le masque
            elementBySuite.addClass('hidden')
        }
    }
}

function play(videoUrl){
    const divVideo = document.getElementById('videoPlayer')
    const iframe = document.getElementById('videoPlayed')

    iframe.setAttribute('src', videoUrl)
    divVideo.setAttribute('style','z-index:9998')

    divVideo.classList.remove('hidden')
}

function closePlayer(){
    const divVideo = document.getElementById('videoPlayer')
    const iframe = document.getElementById('videoPlayed')

    divVideo.classList.add('hidden')
    divVideo.removeAttribute('style')
    iframe.setAttribute('src', '')
}