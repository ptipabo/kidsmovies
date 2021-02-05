/**
 * Permet de créer une balise html avec le contenu et les paramètres souhaités
 * 
 * @param {string} tagName 
 * @param {[string]} tagParams 
 * @param {[*]} paramsValues 
 */
export function addElement(tagName, tagParams = [], paramsValues = []){
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
 * Permet de retirer un élément de la page html
 */
export function removeElement(elementId) {
    let element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}