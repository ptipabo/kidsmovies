export default class DomElement{

    /**
     * Permet de créer une balise html avec le contenu et les paramètres souhaités
     * 
     * @param {string} tagName 
     * @param {[string]} tagParams 
     * @param {[*]} paramsValues 
     */
    addElement(tagName, tagParams = [], paramsValues = []){

        let newElement = document.createElement(tagName)
        if(tagParams.length === paramsValues.length){
            for(let y=0;y<tagParams.length;y++){
                if(tagParams[y] !== ''){
                    newElement[tagParams[y]] = paramsValues[y]
                }
            }
        }else{
            console.log("addElement() => ERROR : the number of parameters doesn't match the number of parameters values !")
        }

        return newElement;
    }

    /**
     * Permet de convertir des minutes en heures
     * 
     * @param {number} timeInMinutes 
     */
    minToHour(timeInMinutes){
        let timeInHours = Math.floor(timeInMinutes/60)
        let minutesLeft = timeInMinutes - (timeInHours*60)

        if(minutesLeft<10){
            minutesLeft = '0'+minutesLeft
        }

        return timeInHours+'h'+minutesLeft
    }

    /*constructor(id){
        this.element = document.getElementById(id)
        this.elementClasses = element.classList.split(' ');
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
    }*/
}